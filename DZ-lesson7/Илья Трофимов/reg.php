<?php
header('Content-type: text/html; charset=utf-8');

include_once('model/startup.php');
include_once('model/M_Users.php');

// Установка параметров, подключение к БД, запуск сессии.
startup();

// Менеджеры.
$mUsers = M_Users::Instance();

// Очистка старых сессий.
$mUsers->ClearSessions();

// Выход.
$mUsers->Logout();
$err=array();
// Обработка отправки формы.
if (!empty($_POST))
{
	$regdata=array();
	foreach($_POST as $key=>$value){
		$value=trim($value);
		if($value!=''){
			$regdata[$key]=$value;
		}
		else{
			$err[]='Не заполнено поле '.$key.'<br />';
		}
	}
	if(empty($err)){
		$is_user = $mUsers->GetByLogin($regdata['login']);
		if($is_user==null){
			if ($mUsers->Register($regdata['login'], $regdata['password'], $regdata['name']))
			{
				header('Location: login.php');
				die();
			}
			else {
				$err[]='Что-то пошло не так.';
			}
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Веб-Гуру</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	<link rel="stylesheet" type="text/css" media="screen" href="theme/style.css" /> 
</head>
<body>
	<h1>Авторизация</h1>
	<a href="index.php">Главная</a>
	<br />Форма регистрации<br />
	<div style="color:red"><?php foreach($err as $value) echo $value?></div>
	<form method="post">
		Имя: <input type="text" name="name" /><br/>
		E-mail: <input type="text" name="login" /><br/>
		Пароль: <input type="password" name="password" /><br/>
		<input type="submit" />		
	</form>
</body>
</html>
