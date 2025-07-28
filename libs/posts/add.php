<?php
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../includes/User.class.php';
require_once __DIR__ . '/../includes/Database.class.php';
require_once __DIR__ . '/../app/Post.class.php';
require_once __DIR__ . '/../traits/SQlGetterSetterdata.trait.php';

// Load config
$__site__config = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Automation/photogramconfig.json');
$__site__config = json_decode($__site__config, true);

function get_config($key, $default = null)
{
    global $__site__config;
    if (isset($__site__config[$key])) {
        return $__site__config[$key];
    } else {
        return $default;
    }
}

${basename(__FILE__, '.php')} = function () {
    session_start();

    if (!Session::isAuthenticated()) {
        echo json_encode(['message' => 'unauthorized']);
        http_response_code(401);
        exit;
    }

    if (!isset($_POST['post_text']) || !isset($_FILES['post_image'])) {
        echo json_encode(['message' => 'bad request']);
        http_response_code(400);
        exit;
    }

    $image_tmp = $_FILES['post_image']['tmp_name'];
    $text = $_POST['post_text'];

    try {
        $post = Post::registerPost($text, $image_tmp);

        if ($post) {
            // Get the post data to return
            $postData = [
                'id' => $post->getID(),
                'post_text' => $post->getPostText(),
                'image_url' => $post->getImageUrl(),
                'created_at' => $post->getCreatedAt(),
                'owner' => $post->getOwner()
            ];

            // Debug: Log the post data
            error_log("Post created with data: " . json_encode($postData));

            echo json_encode(['success' => true, 'post' => $postData]);
            http_response_code(200);
        } else {
            echo json_encode(['message' => 'failed to create post']);
            http_response_code(500);
        }
    } catch (Exception $e) {
        error_log("Post creation error: " . $e->getMessage());
        echo json_encode(['message' => 'Error creating post: ' . $e->getMessage()]);
        http_response_code(500);
    }
};

// Call the function if accessed directly
if (basename($_SERVER['SCRIPT_FILENAME'], '.php') === basename(__FILE__, '.php')) {
    (${basename(__FILE__, '.php')})();
}
