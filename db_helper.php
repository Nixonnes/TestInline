<?php
// URL API
$url_posts = "https://jsonplaceholder.typicode.com/posts/";
$url_comments = "https://jsonplaceholder.typicode.com/comments";
$curl_posts = curl_init($url_posts);
$curl_comments = curl_init($url_comments);
curl_setopt($curl_posts,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_posts, CURLOPT_TIMEOUT, 30);
curl_setopt($curl_comments,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_comments,CURLOPT_TIMEOUT, 30);
$response_posts = curl_exec($curl_posts);
$response_comments = curl_exec($curl_comments);
$posts = json_decode($response_posts, true);
$comments = json_decode($response_comments, true);
