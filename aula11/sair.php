<?php
require_once 'funcoes.php';
$_SESSION = array();
if (ini_get('session.use_cookies')) {
    $config = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
}
session_destroy();
header('Location: login.php', true, 303);
exit;
