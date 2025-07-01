<?php
include_once __DIR__ . "/../traits/SQlGetterSetterdata.trait.php";

class Post
{

    private $id;
    private $conn;
    private $table;
    use SQlGetterSetter;

    public static function registerPost($text, $image_tmp)
    {
        if (is_file($image_tmp) and getimagesize($image_tmp) !== false) {
            $author = Session::getUser()->getEmail();
            $image_name = md5($author . time()) . image_type_to_extension(exif_imagetype($image_tmp));
            $image_path = get_config('upload_path') . $image_name;
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image_url = "/files/$image_path";
                $insert_command = "INSERT INTO `post` (`post_text`,`multiple_images`,`image_url`, `like_count`, `owner`, `created_at`)
                VALUES ('$text', `0`, '$image_url', '0', '$author', now())";
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
        $query = "SELECT * FROM `post`  ORDER BY `created_at`";
        $result = $db->query($query);
        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = new Post($row['id']);
        }
        return $posts;
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = "post";
    }
}
