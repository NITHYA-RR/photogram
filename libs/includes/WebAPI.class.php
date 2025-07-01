<?php
class WebAPI {
    public function __construct() // Fixed constructor name
    {
        if (php_sapi_name() == "cli") {
            global $__site_config; // Fixed typo in variable name
            $__site_config_path = "/home/PHPWEBSITE/photogramconfig.json";
            $__site_config = file_get_contents($__site_config_path);
        } elseif (php_sapi_name() == "apache2handler") {
            global $__site_config; // Fixed typo in variable name
            $__site_config_path = dirname(is_link($_SERVER['DOCUMENT_ROOT']) ? readlink($_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT']); // Fixed syntax error
            $__site_config = file_get_contents($__site_config_path);
        }
        Database::getconnection();
    }

    public function initiateSession()
    {
        // Implement session initiation logic here
    }
}