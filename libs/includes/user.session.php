<?php
include_once "Database.class.php";
include_once "User.class.php";
include_once "Session.class.php";

class UserSession
{
    public $token;
    public $conn;
    public $uid;
    public $data;
    public $id;

    public static function authenticate($username, $password)
    {
        $conn = Database::getConnection();

        // Verify user credentials         
        $userId = User::login($username, $password);
        if (!$userId) {
            return false; // Authentication failed         
        }

        // Fetch user details         
        $user = new User($userId);

        // Generate secure session token         
        $ip = $_SERVER['REMOTE_ADDR'];
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $token = md5(rand(0, 9999999) . $ip . $agent . time());

        // Store session in database         
        $login_time = date("Y-m-d H:i:s"); // Current timestamp   
        $sql = "INSERT INTO `session` (`uid`, `token`, `login_time`, `ip`, `user_agent`, `active`)                  
                VALUES ('$user->id', '$token', '$login_time', '$ip', '$agent', '1')";

        if ($conn->query($sql)) {
            Session::set('session_token', $token); // Store token in session             
            return $token;
        } else {
            error_log("SQL Error in authenticate: " . $conn->error);
            return false;
        }
    }


    public static function authorize($token)
    {
        $sees = new UserSession($token);
        $conn = Database::getConnection();

        // Validate input token                     
        $token = $conn->real_escape_string($token);

        // Query to check if the token exists and is active                     
        $sql = "SELECT * FROM session WHERE token = '$token' AND active = 1 LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new User($row['uid']);  // Return the authenticated user object                     
        } else {
            return false;  // Token is invalid or session expired                     
        }
    }


    public function __construct($id)
    {
        $this->conn = Database::getConnection();
        $this->token = $id; // ✅ Use the passed token instead of generating a new one

        $sql = "SELECT * FROM `session` WHERE `token` = '$this->token' LIMIT 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->data = $row;
            $this->uid = $row['uid'];
        } else {
            throw new Exception("Session is invalid.....");
        }
    }


    public static function getUser()
    {
        $token = Session::get('session_token');
        if (!$token) return false;
        $conn = Database::getConnection();
        $sql = "SELECT uid FROM session WHERE token = '$token' AND active = 1 LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return new User($row['uid']);
        } else {
            return false;
        }
    }


    function getUserIP()
    {
        foreach (
            [
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'REMOTE_ADDR'
            ] as $key
        ) {
            if (!empty($_SERVER[$key])) {
                return $_SERVER[$key];
            }
        }
        return 'IP Not Found';
    }

    public static function isValid()
    {
        $token = Session::get('session_token');
        if (!$token) return false;
        $conn = Database::getConnection();
        $token = $conn->real_escape_string($token);
        $sql = "SELECT id FROM session WHERE token = '$token' AND active = 1 LIMIT 1";
        $result = $conn->query($sql);
        return ($result->num_rows > 0);
    }

    public static function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function deactive()
    {
        $token = Session::get('session_token');
        if (!$token) return false;
        $conn = Database::getConnection();
        $token = $conn->real_escape_string($token);
        $sql = "UPDATE session SET active = 0 WHERE token = '$token'";
        return $conn->query($sql);
    }

    public function getEmail()
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "SELECT email FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id); // assuming $this->id is set
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['email'];
        } else {
            throw new Exception("Email not found for user ID: " . $this->id);
        }
    }
    public function getId()
    {
        return $this->uid; // Return the user ID from the session
    }
}
