<?php
include 'libs/load.php';

$posts = Post::getAllPosts();
foreach ($posts as $post) {
    // $p = new Post($post['id']);
    print($post['id']);
    $l = new Like($post['id']);
    print($l->getID());
    print("<br>");
}


?>

</pre>