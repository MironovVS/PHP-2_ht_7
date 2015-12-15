<?php
include_once('model/startup.php');
include_once('model/M_Users.php');
include_once('model/MSQL.php');

startup();

$mUsers = M_Users::Instance();

if (!$mUsers->Can('CHANGE_PRIVS'))
{
	die('Отказано в доступе');
}
else
{
	die('К сожалению, не хватило времени сделать эту часть, хотя метод действий понятен.');
}