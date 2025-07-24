<?php
include __DIR__ . "/libs/load.php";
session_cache_limiter('none');

// Safely get filename from URL
$fname = $_GET['name'] ?? '';
$fname = str_replace('..', '', $fname); // prevent ../ attack
$upload_path = __DIR__ . "/uploads/";
$image_path = $upload_path . basename($fname);

// Debug if needed
// echo "Resolved path: " . $image_path;

if (!file_exists($image_path)) {
    die("File not found. Resolved path: " . $image_path);
}

// Detect MIME type
$ext = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
$mime_types = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp',
    'bmp' => 'image/bmp',
    'svg' => 'image/svg+xml'
];

$content_type = $mime_types[$ext] ?? 'application/octet-stream';

// Serve the image
header("Content-Type: $content_type");
header("Content-Length: " . filesize($image_path));
readfile($image_path);




// include __DIR__ . "/libs/load.php";
// session_cache_limiter('none');
// $upload_path = get_config('upload_path');
// $fname = $_GET['name'];
// $image_path = $upload_path . $fname;
// $image_path = str_replace('..', '', $image_path); // Prevent directory traversal attacks
// // Check if the file exists
// if (!file_exists($image_path)) {
//     die("File not found. Resolved path: " . $image_path);
// }

// // Get the file extension and determine the MIME type
// $ext = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
// $mime_types = [
//     'jpg' => 'image/jpeg',
//     'jpeg' => 'image/jpeg',
//     'png' => 'image/png',
//     'gif' => 'image/gif',
//     'webp' => 'image/webp',
//     'bmp' => 'image/bmp',
//     'svg' => 'image/svg+xml'
// ];

// $content_type = $mime_types[$ext] ?? 'application/octet-stream';
// $last_modified_time = filemtime($image_path);
// $etag = '"' . md5_file($image_path) . '"';
// // Set the appropriate headers to serve the image
// header("Content-Type: $content_type");
// header("Content-Length: " . filesize($image_path));
// header('Cache-Control: max-age=' . (60 * 60 * 24 * 365));
// header('Expires: ' . gmdate(DATE_RFC1123, time() + 60 * 60 * 24 * 365));
// header_remove('Pragma');
// echo file_get_contents($image_path);
// // Output the image content
