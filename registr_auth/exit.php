<?php
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
setcookie('user', $user['login'], time() - 36000, "/");
header('Location: get-in.php');
?>