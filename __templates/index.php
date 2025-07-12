<?php
include_once __DIR__ . "/../libs/includes/Session.class.php";
include_once __DIR__ . "/../libs/app/Post.class.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// ✅ Then conditionally load content OR login section
if (Session::isAuthenticated()) {
  Session::load_templates('index/content'); // post form
} else {
  Session::load_templates('index/logins'); // login/register call-to-action
}
// ✅ Always load photos layout (shows posts)
Session::load_templates('index/photos');
