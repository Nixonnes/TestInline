<?php

namespace App\Classes;

use PDO;

class Db
{
    private static $instance;
    private PDO $connection;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        $db_config = require CONFIG . '/db.php';
        $queries = require CONFIG . '/queries.php';
        $this->createDatabaseIfNotExist($db_config, $queries);
        $this->createTablesIfNotExists($db_config, $queries);
        try {

            $dsn = "mysql:host={$db_config['host']};dbname={$db_config['db_name']}";
            $this->connection = new PDO($dsn, $db_config['username'], $db_config['password'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (\PDOException $e) {
            echo 'Ошибка при создании базы данных: ' . $e->getMessage();
        }
        return $this;
    }

    public function createDatabaseIfNotExist($db_config, $queries): void
    {
        try {
            $dsn = "mysql:host={$db_config['host']}";
            $this->connection = new PDO($dsn, $db_config['username'], $db_config['password'],
                [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            $this->query($queries['db_create']);
        } catch (\PDOException $e) {
            echo 'Ошибка при создании базы данных: ' . $e->getMessage();
        }

    }

    public function createTablesIfNotExists($db_config, $queries): void
    {
        try {
            $dsn = "mysql:host={$db_config['host']};dbname={$db_config['db_name']}";
            $this->connection = new PDO($dsn, $db_config['username'], $db_config['password'],
                [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            $this->query($queries['table_posts_create']);
            $this->query($queries['table_comments_create']);
        } catch (\PDOException $e) {
            echo 'Ошибка при создании таблицы: ' . $e->getMessage();
        }
    }

    public function InsertPostsAndComments(): void
    {
        $i = 0;
        $a = 0;
        $db_config = require CONFIG . '/db.php';
        $this->getConnection();
        require_once ROOT . '/db_helper.php';
        $queries = require CONFIG . '/queries.php';
        try {


            foreach ($posts as $post) {
                $i++;
                $stmt = $this->connection->prepare($queries['insert_posts_table']);
                $stmt->execute([
                    ':user_id' => $post['userId'],
                    ':id' => $post['id'],
                    ':title' => $post['title']
                    , ':body' => $post['body']
                ]);

            }
        } catch (\PDOException $e) {
            echo "Возникла ошибка : {$e->getMessage()}";
        }
        foreach ($comments as $comment) {
            $a++;
            $stmt = $this->connection->prepare($queries['insert_comments_table']);
            $stmt->execute([
                ':post_id' => $comment['postId'],
                ':id' => $comment['id'],
                ':name' => $comment['name'],
                ':email' => $comment['email'],
                ':body' => $comment['body']
            ]);

        }
        echo "Загружено {$i} постов и {$a} комментариев";
    }

    public function query($query, $params = []): void
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
    }

    public function getPostsAndComments()
    {
        $db_config = require CONFIG . '/db.php';
        $queries = require CONFIG . '/queries.php';
        $posts = $this->connection->query($queries['get_posts'])->fetchAll();
        $comments = $this->connection->query($queries['get_comments'])->fetchAll();
        return [$posts, $comments];
    }

    public function searchPostsAndComments(string $query, $queries)
    {
        $stmt = $this->connection->prepare($queries['get_posts_comments']);
        $stmt->execute([
            ':query' => "%{$query}%"
        ]);
        $results = $stmt->fetchAll();
        $groupedResults = [];
        foreach ($results as $row) {
            if (!isset($groupedResults[$row['postId']])) {
                $groupedResults[$row['postId']] = [
                    'title' => $row['title'],
                    'comments' => []
                ];
            }
            $groupedResults[$row['postId']]['comments'][] = $row['commentBody'];
        }
        foreach ($groupedResults as $post) {
            echo "<h1>{$post['title']}</h1>";
            echo '<h2>Комментарии</h2>';
            echo '<ul>';
            foreach ($post['comments'] as $comment) {
                echo '<li>' . nl2br(htmlspecialchars($comment)) . '</li>';
            }
            echo '</ul>';
        }
    }
}



