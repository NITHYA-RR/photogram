<?php
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../app/Post.class.php';
require_once __DIR__ . '/../app/like.class.php';

${basename(__FILE__, '.php')} = function () {
    session_start();

    if (!Session::isAuthenticated()) {
        echo json_encode(['message' => 'unauthorized']);
        http_response_code(401);
        exit;
    }

    if (!isset($_POST['id'])) {
        echo json_encode(['message' => 'bad request']);
        http_response_code(400);
        exit;
    }

    $postId = intval($_POST['id']);
    $post = new Post($postId);
    $like = new Like($post);
    $like->toggleLike();

    echo json_encode(['liked' => $like->isLiked()]);
    http_response_code(200);
};

// Call the function if accessed directly
if (basename($_SERVER['SCRIPT_FILENAME'], '.php') === basename(__FILE__, '.php')) {
    (${basename(__FILE__, '.php')})();
}
