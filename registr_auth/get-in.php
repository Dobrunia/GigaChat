<!DOCTYPE html>
<?php
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="gigachat, мессенджер, гигачат, gigachad"/>
    <meta name="description" content="GigaChat это защищённый браузерный мессенджер для общения, вход/регистрация"/>
    <title>GigaChat браузерный мессенджер - вход</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="wrapper">
        <div class="get-in_window" id="path">
            <div class="container">
                <h1>Вход</h1>
                <form action="./auth.php" method="post">
                    <label>Логин</label>
                    <input class="text-imput" name="login" type="text" autocomplete="username" maxlength="10" required></input>
                    <label>Пароль</label>
                    <input class="text-imput" name="password" type="password" autocomplete="current-password" maxlength="15" required></input>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'];?>">
                    <input class="checkbox-imput" type="checkbox" name="not_my_pc"><span>чужой компьютер</span>
                    <input class="button" type="submit" name="submit" value="Войти">
                </form>
                <section>
                    <a href="./registration.php">Регистрация</a>
                </section>
            </div>
        </div>
    </div>
</body>
</html>