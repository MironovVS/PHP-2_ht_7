<?phpinclude_once('model/startup.php');include_once('model/M_Users.php');include_once('model/MSQL.php');// Установка параметров, подключение к БД, запуск сессии.startup();// Менеджеры.$mUsers = M_Users::Instance();$msql= MSQL::Instance();// Очистка старых сессий.$mUsers->ClearSessions();// Выход.$mUsers->Logout();//	if (empty ($_GET))	{		header('Location: index.php');		die();	}		elseif ($_GET['act'] == 'login')	{		$title = 'Авторизация';		$remember_me = true;		// Обработка формы авторизации.		if (!empty($_POST))		{			if ($mUsers->Login($_POST['login'], 							   $_POST['password'], 							   isset($_POST['remember'])))			{				header('Location: index.php');				die();			}		}	}	elseif ($_GET['act'] == 'register')	{		$title = 'Регистрация';		$remember_me = false;		// Обработка формы авторизации.		if (!empty($_POST))		{			if ($mUsers->GetByLogin($_POST['login']))			{				$message = "Такое имя пользователя уже существует!";			}			elseif (!empty ($_POST['login'] ) && !empty ($_POST['password']) && !empty ($_POST['nick']))			{				$table_= 'users';				$account = array(	'login' => $_POST['login'], 									'password' => md5($_POST['password']), 									'id_role' => 2, 									'name' => $_POST['nick']);				$id_ = $msql-> Insert($table_, $account);				header('Location: index.php');				die();			}			else			{				$message = "Необходимо заполнить все поля!";			}		}	}	else 	{		echo "Что-то неладно с адресной строкой.";	}	// Кодировка.header('Content-type: text/html; charset=utf-8');?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>	<title>Веб-Гуру</title>	<meta content="text/html; charset=utf-8" http-equiv="content-type">		<link rel="stylesheet" type="text/css" media="screen" href="theme/style.css" /> </head><body>	<h1><?php echo $title?></h1>		<a href="index.php">Главная</a>	<form method="post">		E-mail: <input type="text" name="login" /><br/>		Пароль: <input type="password" name="password" /><br/>		<?php if ($remember_me == true):?>		<input type="checkbox" name="remember" /> Запомить меня<br/>		<?php else:?>		Имя <br>пользователя: <input type="text" name="nick" /><br/>		<?php endif?>		<input type="submit" />			</form>	<?php echo $message;?></body></html>