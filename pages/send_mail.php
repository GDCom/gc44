<?php
require_once("../base/dbconnect.php");
require_once("../base/database.php");

$link = db_connect();

$array = get_table($link, "SELECT mailus FROM info"); //Загружаем данные из базы

$to = $array[0]['mailus']; //Кому
$from = $_POST['email']; //От кого
$name = $_POST['name']; //Имя
$message = $_POST['message']; //Текст сообщения

//Обрабатываем переменную От кого
$from = htmlspecialchars($from); //Преобразование символов
$from = urldecode($from); //Декодирование url
$from = trim($from); //Обрезание пробелов спереди и сзади

//Обрабатываем переменную Имя
$name = htmlspecialchars($name); //Преобразование символов
$name = urldecode($name); //Декодирование url
$name = trim($name); //Обрезание пробелов спереди и сзади

//Обрабатываем переменную Сообщение
$message = htmlspecialchars($message); //Преобразование символов
$message = urldecode($message); //Декодирование url
$message = trim($message); //Обрезание пробелов спереди и сзади

$message = "Отправитель: ".$name." (".$from.")\n\nСообщение: ".$message; //Добавляем в сообщение информацию об отправителе

if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $from)) $f = 1; //Если некоректный e-mail, код сообщения 1

if(mail($to, "Сообщение от ".$name, $message, "Frome: ".$from)) $f = 0; //Если успешно отправлено, код сообщения 2
else $f = 2; //Иначе код сообщения 2

header('Location: ../index.php?page=contacts&alert='.$f); //Перенаправляем на страницу контактов с кодом сообщения

?>

<link rel="canonical" href="http://www.gc44.ru/index.php?page=send_mail">