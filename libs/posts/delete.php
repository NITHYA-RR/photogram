<?php
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../app/Post.class.php';
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
    $result = $post->delete();

    if ($result) {
        echo json_encode(['message' => 'success']);
        http_response_code(200);
    } else {
        echo json_encode(['message' => 'delete failed']);
        http_response_code(500);
    }
};
// <-- function ends here

// This part MUST be outside the function!
if (basename($_SERVER['SCRIPT_FILENAME'], '.php') === basename(__FILE__, '.php')) {
    (${basename(__FILE__, '.php')})();
}
