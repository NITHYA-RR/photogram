<?php
include_once __DIR__ . "/../traits/SQlGetterSetterdata.trait.php";
require_once __DIR__ . '/../includes/Database.class.php';



class Post
{

    private $id;
    private $conn;
    private $table;
    use SQlGetterSetter;

    // public static function registerPost($text, $image_tmp)
    // {
    //     if (!is_file($image_tmp) || getimagesize($image_tmp) === false) {
    //         throw new Exception("❌ Invalid or no image uploaded.");
    //     }

    //     $author = Session::getUser()->getId();
    //     $image_ext = image_type_to_extension(exif_imagetype($image_tmp));
    //     $image_name = md5($author . time()) . $image_ext;

    //     $upload_dir = get_config('upload_path');
    //     $image_path = $upload_dir . $image_name;

    //     // Ensure the directory exists
    //     if (!is_dir($upload_dir)) {
    //         mkdir($upload_dir, 0777, true);
    //     }

    //     if (!move_uploaded_file($image_tmp, $image_path)) {
    //         throw new Exception("❌ Failed to move uploaded image.");
    //     }

    //     $image_url = "/files/" . basename($image_path);
    //     $db = Database::getConnection();

    //     $stmt = $db->prepare("
    //     INSERT INTO `post` (`post_text`, `multiple_images`, `image_url`, `like_count`, `owner`, `created_at`)
    //     VALUES (?, 0, ?, 0, ?, NOW())");

    //     if (!$stmt) {
    //         throw new Exception("❌ Prepare failed: " . $db->error);
    //     }

    //     $stmt->bind_param("sss", $text, $image_url, $author);
    //     if ($stmt->execute()) {
    //         $id = $stmt->insert_id;
    //         return new Post($id);
    //     } else {
    //         throw new Exception("❌ Execute failed: " . $stmt->error);
    //     }
    // }


    public static function registerPost($text, $image_tmp)
    {
        if (is_file($image_tmp) and getimagesize($image_tmp) !== false) {
            $author = Session::getUser()->getID();
            $image_name = md5($author . time()) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = get_config('upload_path') . $image_name;
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image_url = "/files/$image_path";
                $insert_command = "INSERT INTO `post` (`post_text`,`multiple_images`,`image_url`, `like_count`, `owner`, `created_at`)
                VALUES ('$text', 0, '$image_url', 0, '$author', now())";
                $db = Database::getConnection();
                if ($db->query($insert_command)) {
                    $id = mysqli_insert_id($db);
                    return new Post($id);
                } else {
                    return false;
                }
            }
        } else {
            throw new Exception("Image not Registered.");
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
