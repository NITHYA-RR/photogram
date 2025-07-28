<?php
// Test uploads directory
$upload_dir = __DIR__ . "/uploads/";
echo "Upload directory: $upload_dir<br>";
echo "Directory exists: " . (is_dir($upload_dir) ? 'Yes' : 'No') . "<br>";
echo "Directory writable: " . (is_writable($upload_dir) ? 'Yes' : 'No') . "<br>";

// List files in uploads directory
if (is_dir($upload_dir)) {
    echo "Files in uploads directory:<br>";
    $files = scandir($upload_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "- $file<br>";
        }
    }
} else {
    echo "Creating uploads directory...<br>";
    if (mkdir($upload_dir, 0777, true)) {
        echo "Uploads directory created successfully!<br>";
    } else {
        echo "Failed to create uploads directory!<br>";
    }
}
?> 