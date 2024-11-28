<?php

require __DIR__ . '/config/config.php';
require __DIR__ . '/vendor/autoload.php';


$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$db = \App\Classes\Db::getInstance();
$db->getConnection();




$data = $db->getPostsAndComments();
if(count($data[0]) < 1 && count($data[1]) < 1) {
    $db->InsertPostsAndComments();
}

$posts = $data[0];
$comments = $data[1];

require  ROOT. '/views/index.tpl.php';