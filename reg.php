<?php
function __autoload($classname)
{
  require_once("model/$classname.php");
}
// Установка параметров, подключение к БД, запуск сессии.
//startup();

// Менеджеры.
$mUsers = M_Users::Instance();

// Очистка старых сессий.
$mUsers->ClearSessions();


if (isset ($_POST['username']) && isset ($_POST['pass'])) {
  $mUsers->register($_POST['username'], $_POST['pass'], $_POST['id_role']);
  header('Location: index.php');
  die();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
</head>
<body>
<table border="1px" width="100%">
  <td width="85%">
    <h1>Регистрация</h1>
    <hr>
    <form method="post">
      <fieldset>
        <legend>Регистрация.</legend>
        <label>username
          <p><input type="text" name="username""><br></p>
        </label>
        <label>pass
          <p><input type="text" name="pass"> <br></p>
        </label>
        <label>role
          <select name="id_role">
            <option value="admin">admin</option>
            <option value="moder">moder</option>
            <option value="user">user</option>
            </select>
        </label>
        <input type="submit" name="submit">
      </fieldset>

    </form>
</table>
<footer>
  <p align="center" >&#169; знак copyright</p>
</footer>
</body>
</html>