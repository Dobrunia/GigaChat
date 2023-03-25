<?php
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="gigachat, мессенджер, гигачат, gigachad"/>
    <meta name="description" content="GigaChat это защищённый браузерный мессенджер для общения, вход/регистрация"/>
    <title>GigaChat браузерный мессенджер - регистрация</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <section class="wrapper">
        <div class="registration_window">
            <div class="container">
                <h1>Регистрация</h1>
                <form role="form" action="./save_user.php" method="post">
                    <!-- <label>Почта</label>
                    <input class="text-imput" name="email" type="email" maxlength="15" required></input> -->
                    <label>Логин</label>
                    <input class="text-imput" name="login" type="text" autocomplete="username" maxlength="10" required></input>
                    <label>Пароль</label>
                    <input class="text-imput" name="password" type="password" autocomplete="new-password" maxlength="15" required></input>
                    <label>Повторите пароль</label>
                    <input class="text-imput" name="password2" type="password" autocomplete="new-password" maxlength="15" required></input>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'];?>">
                    <input class="checkbox-imput" type="checkbox" name="accept" required><span>я согласен на обработку персональных данных</span>
                    <input class="button" type="submit" name="submit" value="Зарегистрироваться">
                </form>
                <section>
                    <a href="./get-in.php">Уже зарегистрированы? Войти.</a>
                </section>
            </div>
        </div>
    </section>
</body>
</html>