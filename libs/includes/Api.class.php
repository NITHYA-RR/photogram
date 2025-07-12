<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once 'REST.class.php';
// require __DIR__ . 'libs/api/posts/delete.php';
class API extends REST
{
    public $data = "";
    private $current_call;

    public function __construct()
    {
        parent::__construct();                  // Init parent contructor
    }

    /*
    * Public method for access api.
    * This method dynmically call the method based on the query string
    *
    */


    public function processApi()
    {
        $func = strtolower(trim($_REQUEST['request'] ?? ''));
        $namespace = trim($_REQUEST['namespace'] ?? '', '/');

        // Check if method exists in class
        if ((int)method_exists($this, $func) > 0) {
            $this->$func();
            return;
        }

        // Decide path based on presence of namespace
        $basePath = dirname(__DIR__) . '/posts/';
        $dir = $namespace ? $basePath . $namespace : $basePath;
        $file = $dir . '/' . $func . '.php';

        if (file_exists($file)) {
            include $file;

            // Use filename as function name
            $func = basename($file, '.php');

            if (isset(${$func}) && is_callable(${$func})) {
                $this->current_call = Closure::bind(${$func}, $this, get_class($this));
                call_user_func($this->current_call);
            } else {
                $this->response($this->json(['error' => 'function_not_found_in_namespace']), 404);
            }
        } else {
            $this->response($this->json(['error' => 'file_not_found']), 404);
        }
    }


    // public function processApi()
    // {
    //     $func = strtolower(trim($_REQUEST['request'] ?? ''));
    //     $namespace = trim($_REQUEST['namespace'] ?? '', '/');
    //     if ((int)method_exists($this, $func) > 0) {
    //         $this->$func();
    //     } else {
    //         if (!empty($namespace)) {
    //             $dir = dirname(__DIR__) . '/posts/' . $namespace;
    //             $file = $dir . '/' . $func . '.php';

    //             if (file_exists($file)) {
    //                 include $file;

    //                 // Auto-load function based on file name
    //                 $func = basename($file, '.php');

    //                 if (isset(${$func}) && is_callable(${$func})) {
    //                     $this->current_call = Closure::bind(${$func}, $this, get_class($this));
    //                     call_user_func($this->current_call);
    //                 } else {
    //                     $this->response($this->json(['error' => 'function_not_found_in_namespace']), 404);
    //                 }
    //             } else {
    //                 $this->response($this->json(['error' => 'file_not_found']), 404);
    //             }
    //         } else {
    //             $this->response($this->json(['error' => 'namespace_missing']), 404);
    //         }
    //     }
    // }



    // public function processApi()
    // {
    //     $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'] ?? '')));

    //     if ((int)method_exists($this, $func) > 0) {
    //         $this->$func();
    //     } else {
    //         if (isset($_GET['namespace'])) {
    //             $namespace = trim($_GET['namespace'], '/');
    //             $dir = dirname(__DIR__) . '/posts/' . $namespace;
    //             $file = $dir . '/' . $func . '.php';

    //             if (file_exists($file)) {
    //                 include $file;

    //                 // Auto-load function based on filename
    //                 $func = basename($file, '.php');

    //                 if (isset(${$func}) && is_callable(${$func})) {
    //                     $this->current_call = Closure::bind(${$func}, $this, get_class($this));
    //                     call_user_func($this->current_call);
    //                 } else {
    //                     $this->response($this->json(['error' => 'function_not_found_in_namespace']), 404);
    //                 }
    //             } else {
    //                 $this->response($this->json(['error' => 'file_not_found']), 404);
    //             }
    //         } else {
    //             $this->response($this->json(['error' => 'namespace_missing']), 404);
    //         }
    //     }
    // }









    // public function processApi()
    // {
    //     $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'] ?? '')));
    //     if ((int)method_exists($this, $func) > 0) {
    //         $this->$func();
    //     } else {
    //         if (isset($_GET['namespace'])) {
    //             $namespace = trim($_GET['namespace'], '/');
    //             $dir = dirname(__DIR__) . '/posts/' . $namespace;
    //             $file = $dir . '/' . $func . '.php';
    //             $func = basename($file, '.php');
    //             if (file_exists($file)) {
    //                 include $file; // includes the file, which defines $up

    //                 if (isset(${$func}) && is_callable(${$func})) {
    //                     // Example: ${'up'} means $up
    //                     $this->current_call = Closure::bind(${$func}, $this, get_class($this));
    //                     call_user_func($this->current_call);
    //                 } else if (function_exists($func)) {
    //                     $this->current_call = $func;
    //                     call_user_func($this->current_call);
    //                 } else {
    //                     $this->response($this->json(['error' => 'function_not_found_in_namespace']), 404);
    //                 }
    //             } else {
    //                 $this->response($this->json(['error' => 'file_not_found']), 404);
    //             }
    //         } else {
    //             $this->response($this->json(['error' => 'method_not_found!!!']), 404);
    //         }
    //     }
    // }


    // public function processApi()
    // {
    //     $func = strtolower(trim($_REQUEST['rquest'] ?? ''));

    //     if (method_exists($this, $func)) {
    //         $this->$func();
    //         return;
    //     }

    //     if (isset($_GET['namespace'])) {
    //         $namespace = trim($_GET['namespace'], '/');
    //         $dir = __DIR__ . '/libs/api/' . $namespace;
    //         $file = $dir . '/' . $func . '.php';

    //         if (file_exists($file)) {
    //             include $file;

    //             if (isset(${$func}) && is_callable(${$func})) {
    //                 $this->current_call = Closure::bind(${$func}, $this, get_class($this));
    //                 call_user_func($this->current_call);
    //             } else {
    //                 $this->response($this->json(['error' => 'function_not_found']), 500);
    //             }
    //         } else {
    //             $this->response($this->json(['error' => 'file_not_found']), 404);
    //         }
    //     } else {
    //         $this->response($this->json(['error' => 'namespace_missing']), 400);
    //     }
    // }


    // public function processApi()
    // {
    //     $request = strtolower(trim($_REQUEST['rquest'])); //TODO: Check for IDOR here.
    //     // print $request; 
    //     $func = basename($request);
    //     if (!isset($_GET['namespace']) and (int)method_exists($this, $func) > 0) {
    //         $this->$func();
    //     } else {
    //         if (isset($_GET['namespace'])) {
    //             $dir = $_SERVER['DOCUMENT_ROOT'] . '/api' . $_GET['namespace'];

    //             $file = $dir . '/' . $request . '.php';
    //             if (file_exists($file)) {
    //                 include $file;
    //                 $this->current_call = Closure::bind(${$func}, $this, get_class());
    //                 $this->$func(); //dynamically calling the function
    //             } else {
    //                 $this->response($this->json(['error' => 'method_not_found']), 404);
    //             }
    //         } else {
    //             //we can even process functions without namespace here.
    //             $this->response($this->json(['error' => 'method_not_found']), 404);
    //         }
    //     }
    // }

    public function testjson()
    {
        $data = [
            "success" => true,
            "message" => "Hello from test"
        ];
        $this->response($this->json($data), 200);
    }

    public function isAuthenticated()
    {
        return Session::isAuthenticated();
    }

    /**
     * @param $param Http Parameters
     * Checks if all supplied parameters exists
     */
    public function paramsExists($parms = array())
    {
        // print_r($parms);
        // print "<scrip>console.log()</scrip>";

        $exists = true;
        foreach ($parms as $param) {
            if (!array_key_exists($param, $this->_request)) {
                $exists = false;
            }
        }
        return $exists;
    }


    public function isAuthenticatedFor(User $user)
    {
        return Session::getUser()->getEmail() == $user->getEmail();
    }

    public function getUsername()
    {
        return Session::getUser()->getUserAgent();
    }

    public function die($e)
    {
        $data = [
            "error" => $e->getMessage(),
            "type" => "death"
        ];
        $response_code = 400;
        if ($e->getMessage() == "Expired token" || $e->getMessage() == "Unauthorized") {
            $response_code = 403;
        }

        if ($e->getMessage() == "Not found") {
            $response_code = 404;
        }
        $data = $this->json($data);
        $this->response($data, $response_code);
    }

    public function __call($method, $args)
    {
        if (is_callable($this->current_call)) {
            return call_user_func_array($this->current_call, $args);
        } else {
            $error = ['error' => 'methood_not_callable', 'method' => $method];
            $this->response($this->json($error), 404);
        }
    }

    /*************API SPACE START*******************/

    private function test()
    {
        $data = $this->json(getallheaders());
        $this->response($data, 200);
    }

    private function gen_hash()
    {
        $st = microtime(true);
        if (isset($this->_request['pass'])) {
            $cost = (int)$this->_request['cost'];
            $options = [
                "cost" => $cost
            ];
            $hash = password_hash($this->_request['pass'], PASSWORD_BCRYPT, $options);
            $data = [
                "hash" => $hash,
                "info" => password_get_info($hash),
                "val" => $this->_request['pass'],
                "verified" => password_verify($this->_request['pass'], $hash),
                "time_in_ms" => microtime(true) - $st
            ];
            $data = $this->json($data);
            $this->response($data, 200);
        }
    }

    private function verify_hash()
    {
        if (isset($this->_request['pass']) and isset($this->_request['hash'])) {
            $hash = $this->_request['hash'];
            $data = [
                "hash" => $hash,
                "info" => password_get_info($hash),
                "val" => $this->_request['pass'],
                "verified" => password_verify($this->_request['pass'], $hash),
            ];
            $data = $this->json($data);
            $this->response($data, 200);
        }
    }
    /*************API SPACE END*********************/

    /*
    Encode array into JSON
    */
    private function json($data)
    {
        if (is_array($data)) {
            return json_encode($data, JSON_PRETTY_PRINT);
        } else {
            return "{}";
        }
    }
}

function startsWith($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}
