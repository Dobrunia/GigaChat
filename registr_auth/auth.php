<?php
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
session_start();
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
   echo 'Ошибка CSRF-атаки';
   exit();
}

$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
$login = htmlentities($login);
$password = htmlentities($password);
$not_my_pc = $_POST['not_my_pc'];

require_once "../db.php";
$result = $mysql_DB->prepare("SELECT * FROM `users` WHERE `login` = ?");
$result->bind_param("s", $login);
$result->execute();
$user = $result->get_result()->fetch_assoc();

if(empty($user)) {
    echo "Пользователь не найден";
    exit();
}

if (password_verify($password, $user['password'])) {

    if (!$not_my_pc) {
        setcookie('user', $user['login'], time() + 3600, "/");
    }

    setcookie('user', $user['login'], time() + 36000, "/");
    $mysql_DB->close();
    header('Location: ../index.php');
    exit();
} else {
    $mysql_DB->close();
    echo "Неверный логин или пароль";
    // header('Location: ./get-in.php');
    exit();
}
?>