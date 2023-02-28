<?php
$serverName_DB = "localhost";
$userName_DB = "Dobrunia";
$password_DB = "";
$dbname_DB = "chat";

// $serverName_DB = "localhost";
// $userName_DB = "dobru783_user";
// $password_DB = "Dobrunia123";
// $dbname_DB = "dobru783_chat";

$mysql_DB = new mysqli($serverName_DB, $userName_DB, $password_DB, $dbname_DB);
if ($mysql_DB->connect_errno) {
    echo "Ошибка подключения к БД";
    exit;
};
// $mysql_DB->close();
?>