<?php

function startup()
{
	// Настройки подключения к БД.
	/*$hostname = 'localhost'; 
	$username = 'root'; 
	$password = 'GC7mvXt4urV8eAJG';
	$dbName = 'gb_php2_l7';
	
	// Языковая настройка.
	setlocale(LC_ALL, 'ru_RU.utf8');	
	
	// Подключение к БД.
	mysql_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysql_query('SET NAMES utf8');
	mysql_select_db($dbName) or die('No data base');*/

	// Открытие сессии.
	session_start();		
}
