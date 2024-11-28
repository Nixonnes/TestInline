<?php
require __DIR__ . '/config/config.php';
require __DIR__ . '/vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use App\Classes\Db;

$db = Db::getInstance();
$db->getConnection();
$db_config = require CONFIG . '/db.php';
$queries = require CONFIG . '/queries.php';
require_once ROOT . '/db_helper.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $db->searchPostsAndComments($query, $queries);


}
