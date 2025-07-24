<?php
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../includes/Api.class.php';
require_once __DIR__ . '/../app/Post.class.php';

// https://domain/api/posts/delete
${basename(__FILE__, '.php')} = function () {
    // $this->isAuthenticated() ;
    if ($this->isAuthenticated() and $this->paramsExists('id')) {
        // if ($this->paramsExists('id') ) {
        $p = new Post($this->_request['id']);
        $this->response($this->json([
            'message' => $p->delete()
        ]), 200);
    } else {
        $this->response($this->json([
            'message' => "bad request"
        ]), 400);
    }
};

// ${basename(__FILE__, '.php')} = function () {
//     $data = json_decode(file_get_contents('php://input'), true);

//     if ($this->isAuthenticated() && isset($data['id'])) {
//         $postId = (int)$data['id'];
//         $post = new Post($postId);
//         $result = $post->delete();
//         $this->response($this->json([
//             'message' => $result ? "✅ Post deleted successfully." : "❌ Post not found or already deleted."
//         ]), 200);
//     } else {
//         $this->response($this->json([
//             'message' => "⚠️ Bad request or unauthorized."
//         ]), 400);
//     }
// };