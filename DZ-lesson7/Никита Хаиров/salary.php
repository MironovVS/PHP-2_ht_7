<?phpinclude_once('model/startup.php');include_once('model/M_Users.php');// Кодировка.header('Content-type: text/html; charset=utf-8');// Установка параметров, подключение к БД, запуск сессии.startup();// Менеджеры.$mUsers = M_Users::Instance();// Очистка старых сессий.$mUsers->ClearSessions();// Текущий пользователь.$user = $mUsers->Get();// Если пользователь не зарегистрирован - отправляем на страницу регистрации.if ($user == null){	header("Location: login.php");	die();}// Может ли пользователь смотерть зарплату?if ($mUsers->Can('USE_SECRET_FUNCTIONS',$user)){	die('Отказано в доступе');}?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>	<title>Веб-Гуру</title>	<meta content="text/html; charset=utf-8" http-equiv="content-type">		<link rel="stylesheet" type="text/css" media="screen" href="theme/style.css" /> </head><body>	<h1>Оклад сотрудников</h1>	<a href="index.php">Главная</a>	<ul>		<li>Иванов, 14 000</li>		<li>Петров, 28 000</li>		<li>Замуруев, 96 000</li>		<li>Семенова, 48 000</li>			</ul></body></html>