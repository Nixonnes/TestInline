<?php
return [
    'db_create' => "CREATE DATABASE IF NOT EXISTS {$db_config['db_name']} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci",
    'table_posts_create' => "CREATE TABLE IF NOT EXISTS `posts` (
    user_id  BIGINT ,
    id BIGINT PRIMARY KEY ,
    title VARCHAR(255),
    body TEXT
    )",
    'table_comments_create' => "CREATE TABLE IF NOT EXISTS `comments` (
    postId  BIGINT  ,
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    body TEXT,
    FOREIGN KEY(postId) REFERENCES posts(id)
    )",
    'insert_posts_table' => "INSERT INTO posts(user_id,id,title,body) VALUES(:user_id, :id, :title,:body)",
    'insert_comments_table' => 'INSERT INTO comments(postId,id,name,email,body) VALUES(:post_id, :id, :name, :email, :body)',
    'get_posts' => "SELECT * from posts",
    'get_comments' => 'SELECT * from comments',

    'get_posts_comments' => 'SELECT
    posts.id AS postId,
    posts.title AS title,
    comments.body as commentBody
    from posts
    JOIN comments ON posts.id = comments.postId WHERE LENGTH(:query) >=3 AND comments.body LIKE :query'
];