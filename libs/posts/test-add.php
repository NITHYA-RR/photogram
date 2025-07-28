<?php
header('Content-Type: application/json');

// Simple test response
echo json_encode([
    'success' => true,
    'message' => 'Test endpoint working',
    'post' => [
        'id' => 999,
        'post_text' => 'Test post',
        'image_url' => '/uploads/test.jpg',
        'created_at' => date('Y-m-d H:i:s'),
        'owner' => 1
    ]
]);
