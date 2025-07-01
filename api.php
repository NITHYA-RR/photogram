<?php
require_once 'libs/includes/Api.class.php';
$api = new API();
try {
    $api->processApi();
} catch (Exception $e) {
    $api->die($e);
}
