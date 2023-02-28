<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Moscow');
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
require_once "db.php";

$update = htmlentities(filter_var(trim($_GET['update']), FILTER_SANITIZE_STRING));
if (isset($update) && !empty($update)) {//Обновляет сообщения в чате, нужно переделать, чтобы обновлялось если есть изменения БД, а не через setInterval
    $login = isset($_COOKIE['user']) ? htmlentities(filter_var(trim($_COOKIE['user']), FILTER_SANITIZE_STRING)) : null;
    $companion_name = htmlentities(filter_var(trim($_GET['companion_name']), FILTER_SANITIZE_STRING));
    $sql_from = "SELECT * FROM `messages` WHERE (`username` = ?) && (`to` = ?)";
    $sql_to = "SELECT * FROM `messages` WHERE (`username` = ?) && (`to` = ?)";
    $sql = "$sql_to UNION $sql_from  ORDER BY `id`";
    $stmt = $mysql_DB->prepare($sql);
    $stmt->bind_param("ssss", $companion_name, $login, $login, $companion_name);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo '<div class="message">
                    <div class="message_date">' . $row["datetime"] . `$login` . '</div>
                    <div class="message_text ' . (strval($row['username']) == strval($login) ? 'my-message">' : 'friend-message">') . $row["message"] . '</div>
                </div>';
        }

        $result->free();

    } else {
        echo "Ошибка: " . $mysql_DB->error;
    }

    $stmt->close();
    $mysql_DB->close();
}

$companions = htmlentities(filter_var(trim($_GET['companions']), FILTER_SANITIZE_STRING));
if (isset($companions) && !empty($companions)) {//Обновляет список чатов слева(пользователей с кем есть хоть 1 сообщение), тоже переделать
    $login = isset($_COOKIE['user']) ? htmlentities(filter_var(trim($_COOKIE['user']), FILTER_SANITIZE_STRING)) : null;
    $sql = "SELECT DISTINCT CASE WHEN `to` = ? THEN `username` WHEN `username` = ? THEN `to` ELSE `to` END as `companion` FROM `messages` WHERE `username` = ? OR `to` = ?";

    if ($stmt = $mysql_DB->prepare($sql)) {
        $stmt->bind_param("ssss", $login, $login, $login, $login);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo '<div class="user companion">'. htmlentities(filter_var(trim($row['companion']), FILTER_SANITIZE_STRING)) .'</div>';
            }

            $result->free();

        } else {
            echo "Ошибка: " . $mysql_DB->error;
        }

        $stmt->close();

    } else {
        echo "Ошибка: " . $mysql_DB->error;
    }

    $mysql_DB->close();
}

$save = htmlentities(filter_var(trim($_POST['save']), FILTER_SANITIZE_STRING));
if (isset($save) && !empty($save)) {//Сохраняет сообщения в БД
    $textarea = htmlentities(filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING));
    $companion_name = htmlentities(filter_var(trim($_POST['companion_name']), FILTER_SANITIZE_STRING));
    $today = date("H:i, d.m");
    $login = isset($_COOKIE['user']) ? htmlentities(filter_var(trim($_COOKIE['user']), FILTER_SANITIZE_STRING)) : null;
    // Подготовленный запрос к базе данных
    $stmt = $mysql_DB->prepare("INSERT INTO `messages`(`id`, `message`, `username`, `to`, `datetime`) VALUES (NULL, ?, ?, ?, ?)");
    $stmt->bind_param("ssss", $textarea, $login, $companion_name, $today);

    if ($stmt->execute()) {
        // Запрос выполнен успешно
    } else {
        echo "Ошибка при добавлении сообщения в базу данных: " . $mysql_DB->error;
    }

    $stmt->close();
    $mysql_DB->close();
}

$searchTerm = htmlentities(filter_var(trim($_GET['searchTerm']), FILTER_SANITIZE_STRING));
if (isset($searchTerm) && !empty($searchTerm)) {//поиск пользователей
    $searchTerm = "%" . $searchTerm . "%";
    $stmt = $mysql_DB->prepare("SELECT * FROM `users` WHERE `login` LIKE ?");
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo '<div class="friend">'. $row['login'] . '</div>';
        }

    } else {
        echo "No results found.";
    }

    $stmt->close();
    $mysql_DB->close();
}

exit();
?>