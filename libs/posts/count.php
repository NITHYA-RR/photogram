<?php
require_once __DIR__ . '/../app/Post.class.php';
header('Content-Type: application/json');

$result = Post::countAllPosts(); // returns [ ['count' => 10] ]
echo json_encode(['count' => $result[0]['count']]);
exit; // ✅ Prevent router from continuing and adding second response
