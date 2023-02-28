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
$password2 = filter_var(trim($_POST['password2']), FILTER_SANITIZE_STRING);
$login = htmlentities($login);
$password = htmlentities($password);
$password2 = htmlentities($password2);

require_once "../db.php";
$stmt = mysqli_prepare($mysql_DB, "SELECT * FROM `users` WHERE `login` = ?");
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if(!empty($user)) {
    echo "Данный логин уже используется!";
    exit();
}

if ($password === $password2) {

   function checkPasswordSecurity($password) {
      $length = strlen($password);
      $hasUppercase_Eng = preg_match('/[A-Z]/', $password);
      $hasLowercase_Eng = preg_match('/[a-z]/', $password);
      $hasNumber = preg_match('/[0-9]/', $password);
      $hasSpecialChar = preg_match('/[^a-zA-Z\d]/', $password);

      if ($length < 8) {
         echo "Пароль слишком короткий";
         return false;
      }

      if (!$hasUppercase_Eng || !$hasLowercase_Eng || !$hasNumber || !$hasSpecialChar) {
         echo "Пароль должен содерждать как минимум одну заглавную букву на англ языке, одну строчную на англ языке, одно число и один спец. символ.";
         return false;
      }

      return true;
   }

   if (checkPasswordSecurity($password)) {
      $password = password_hash($password, PASSWORD_BCRYPT);
      $stmt = mysqli_prepare($mysql_DB, "INSERT INTO `users` (`id`, `login`, `password`) VALUES(NULL, ?, ?)");
      mysqli_stmt_bind_param($stmt, "ss", $login, $password);
      mysqli_stmt_execute($stmt);
      mysqli_close($mysql_DB);
      header('Location: ../index.php');
   }

} else {
   echo "Пароли не совпадают";
}
exit();
?>