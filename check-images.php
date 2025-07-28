<?php
require_once 'libs/load.php';

echo "Checking existing posts and their image URLs:<br><br>";

$posts = Post::getAllPosts();
foreach ($posts as $post) {
    echo "Post ID: " . $post->getID() . "<br>";
    echo "Image URL: " . $post->getImageUrl() . "<br>";
    echo "Full image path: " . $_SERVER['DOCUMENT_ROOT'] . $post->getImageUrl() . "<br>";
    echo "File exists: " . (file_exists($_SERVER['DOCUMENT_ROOT'] . $post->getImageUrl()) ? 'Yes' : 'No') . "<br>";
    echo "<hr>";
}
