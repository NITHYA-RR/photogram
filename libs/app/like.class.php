<?php
require_once __DIR__ . '/../includes/Session.class.php';
require_once __DIR__ . '/../includes/Database.class.php';
require_once __DIR__ . "/../traits/SQlGetterSetterdata.trait.php";
class Like
{
    public $conn;
    public $table;
    public $id;
    public $data;

    public function __construct(Post $post)
    {
        $userid = Session::getUser()->getID();
        $postid = $post->getID();
        $this->id = md5($userid . "-" . $postid);
        $this->conn = Database::getConnection();
        $this->table = 'likes';
        $this->data = null;

        $query = "SELECT * FROM `likes` WHERE `id` = '$this->id'";
        $result = $this->conn->query($query);

        if ($result->num_rows == 0) {
            // Create like entry if it doesn't exist
            $query_insert = "INSERT INTO `likes` (`id`, `user_id`, `post_id`, `like`, `like_time`)
            VALUES ('$this->id', '$userid', '$postid', 0, now())";
            $result = $this->conn->query($query_insert);
            if (!$result) {
                throw new Exception("Unable to create like entry: " . $this->conn->error);
            }
        }
    }

    public function getLike()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "SELECT `like` FROM `likes` WHERE `id` = '$this->id'";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row['like'];
        } else {
            return 0;
        }
    }

    public function setLike($value)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "UPDATE `likes` SET `like` = '$value' WHERE `id` = '$this->id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function toggleLike()
    {
        $liked = $this->getLike();
        if (boolval($liked) == true) {
            $this->setLike(0);
        } else {
            $this->setLike(1);
        }
    }

    public function isLiked()
    {
        return boolval($this->getLike());
    }
}
