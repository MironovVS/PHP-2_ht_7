<?php
include_once('model/startup.php');

startup();
$em=$_POST['email'];
$pas=$_POST['pas'];
$pasb=md5($pas);
$name=$_POST['name'];
if (isset($em)&& isset($pas)&&isset($name)){
mysql_query("INSERT INTO `geekbrains_nikit`.`users` (`id_user` ,`login` ,`password`, `id_role`,`name`)
VALUES (NULL ,'$em','$pasb','1', '$name')");
header('location: login.php');
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
<form method="post">
    E-mail:<input type="text" name="email"><br>
    Имя:<input type="text" name="name"><br>
    Пороль:<input type="password" name="pas"><br>
    <input type="submit" value="Заригистрироваться">
    </form>
<?php
