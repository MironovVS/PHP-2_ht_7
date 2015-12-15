	<h1>Авторизация</h1>
	<a href="index.php">Главная</a>
	<a href="index.php?c=users&amp;act=register">Зарегистрироваться</a>
	<div class="error"><?php echo $err?></div>
	<form method="post">
		E-mail: <input type="text" name="login" /><br/>
		Пароль: <input type="password" name="password" /><br/>
		<input type="checkbox" name="remember" /> Запомить меня<br/>
		<input type="submit" />		
	</form>