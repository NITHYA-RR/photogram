<?php
include_once __DIR__ . "/../traits/SQlGetterSetterdata.trait.php";
require_once __DIR__ . '/../includes/Database.class.php';



class Post
{

    private $id;
    private $conn;
    private $table;
    use SQlGetterSetter;
    public static function registerPost($text, $image_tmp)
    {
        if (is_file($image_tmp) and getimagesize($image_tmp) !== false) {
            $author = Session::getUser()->getID();
            $image_name = md5($author . time()) . image_type_to_extension(exif_imagetype($image_tmp));

            // Use absolute path for upload directory
            $upload_dir = __DIR__ . "/../../uploads/";

            // Create the folder if not exists
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }

            // Ensure directory is writable
            if (!is_writable($upload_dir)) {
                chmod($upload_dir, 0777);
            }

            $image_path = $upload_dir . $image_name;

            if (move_uploaded_file($image_tmp, $image_path)) {
                // Use the correct path relative to web root
                $image_url = "/uploads/$image_name";

                // Debug: Log the image path
                error_log("Image saved to: $image_path");
                error_log("Image URL: $image_url");

                $insert_command = "INSERT INTO `post` (`post_text`,`multiple_images`,`image_url`, `like_count`, `owner`, `created_at`)
                VALUES ('$text', 0, '$image_url', 0, '$author', now())";
                $db = Database::getConnection();
                if ($db->query($insert_command)) {
                    $id = mysqli_insert_id($db);
                    return new Post($id);
                } else {
                    throw new Exception("Database error: " . $db->error);
                }
            } else {
                throw new Exception("Failed to move uploaded file to: $image_path");
            }
        } else {
            throw new Exception("Invalid image file");
        }
    }

    public static function getAllPosts()
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM `post`  ORDER BY `created_at` DESC";
        $result = $db->query($query);
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = new Post($row['id']);
        }
        return $posts;
    }

    public static function countAllPosts()
    {
        $db = Database::getConnection();
        $sql = "SELECT COUNT(*) as count FROM `post` ORDER BY `created_at` DESC";
        $result = $db->query($sql);
        return iterator_to_array($result);
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'post';
    }
}
