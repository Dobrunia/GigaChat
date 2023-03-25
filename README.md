нужно создать файл db.php
Код:
<?php
$serverName_DB = "localhost";
$userName_DB = "";
$password_DB = "";
$dbname_DB = "";

$mysql_DB = new mysqli($serverName_DB, $userName_DB, $password_DB, $dbname_DB);
if ($mysql_DB->connect_errno) {
    echo "Ошибка подключения к БД";
    exit;
};
?>