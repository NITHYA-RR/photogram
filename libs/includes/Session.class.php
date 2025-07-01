<?php
class session
{
    public static function start()
    {
        session_start();
    }

    public static function unset()
    {
        session_unset();
    }

    public static function destroy()
    {
        session_destroy();
    }
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }
    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key, $default = false)
    {
        if (Session::isset($key)) {
            return ($_SESSION[$key]);
        } else {
            return $default;
        }
    }

    //  public static  function grtUser(){
    //     return Session::$user;

    //  }
    public static function load_templates($name)
    {
        static $errorCalled = false; // Prevents infinite loop

        // Corrected path to the templates directory
        $script = $_SERVER['DOCUMENT_ROOT'] . "/__templates/$name.php";
        if (is_file($script)) {
            include $script;
        } else {
            if (!$errorCalled) {
                $errorCalled = true;
                echo "Template '$name' not found. Retrying...";
                Session::load_templates('error'); // Retry with an error template
            } else {
                echo "Template '$name' not found. Error template also missing.";
            }
        }
    }
    public static function renderpage()
    {
        Session::load_templates('master');
    }
    public static function currentScript()
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }
    public static function isAuthenticated()
    {
        if (is_object(Session::getUserSession())) {
            return Session::getUserSession()->isvalid();
        }
        return true;
    }

    public static function getUserSession()
    {
        $token = Session::get('session_token');
        if (!$token) {
            return false; // No session token found
        }

        try {
            return new UserSession($token); // Return the UserSession object
        } catch (Exception $e) {
            error_log("Error in getUserSession: " . $e->getMessage());
            return false;
        }
    }

    public static function isOwnerOf($owner)
    {
        $sess_user = Session::getUser();
        if ($sess_user) {
            if ($sess_user->getEmail() == $owner) {
                return true;
            } else {
                return false;
            }
        } else {
            return false; // No user session found
        }
    }


    public static function ensurelogin()
    {
        if (!Session::isAuthenticated()) {
            Session::set('_redirect', $_SERVER['REQUEST_URI']);
            header("Location: /login.php");
            exit;
        }
    }


    public static function getUser()
    {
        // Retrieve the session token
        $token = self::get('session_token'); // Assuming 'session_token' is stored in the session
        if (!$token) {
            throw new Exception("No session token found. User is not logged in.");
        }

        try {
            // Return the User object or UserSession object
            return new UserSession($token); // Assuming UserSession handles user data
        } catch (Exception $e) {
            error_log("Error in Session::getUser(): " . $e->getMessage());
            return null;
        }
    }
}
