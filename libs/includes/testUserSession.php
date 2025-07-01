<?php

// Test the authenticate method


include_once "Database.class.php";
include_once "User.class.php";
include_once "Session.class.php";
include_once "user.session.php";

$username = $_POST['username'] ?? '';  // fallback for testing
$password = $_POST['password'] ?? '';
$token = UserSession::authenticate($username, $password);

if ($token) {
    $user = UserSession::authorize($token);
}
