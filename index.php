<?php
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
if (!isset($_COOKIE['user'])) {
    header("Location: /registr_auth/get-in.php");
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="gigachat, мессенджер, гигачат, gigachad"/>
    <meta name="description" content="GigaChat это защищённый браузерный мессенджер для общения, вход/регистрация"/>
    <title>GigaChat - браузерный мессенджер</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="main">
        <div class="header">
            <div class="search" id="search_wrapper">
                <input class="search_input" type="text" id="search" placeholder="поиск пользователей">
                <button class="search_btn"></button>
                <div class="search_container"></div>
            </div>
        <div class="log-out"><a href="./registr_auth/exit.php">Выйти</a></div>
    </div>
        <div class="main_wrapper">
            <div class="users">
                <div class="users_slider" id="user"></div>
            </div>
            <div class="chat_wrapper">
                <div class="chat-header">
                    <div class="modif">
                        <span id="companion_name"><span>
                    </div>
                </div>
                <div class="chat">
                    <div class="chat_slider" id="messages">
                    </div>
                </div>
                <form class="send-message" id="chat_form">
                    <input class="textarea" id="message_text" type="text" name="textarea" placeholder="ваше сообщение" required>
                    <input class="message_submit" type="submit" name="submit" value="Отправить">
                </form>
            </div>
        </div>
    </div>
    <script src="./js/script.js" defer></script>
</body>

</html>
