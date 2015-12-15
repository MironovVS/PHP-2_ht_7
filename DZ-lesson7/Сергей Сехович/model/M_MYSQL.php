<?php

// Помощник работы с БД

class M_MYSQL
{
    // Настройки подключения к БД.
    private $hostname = 'localhost';
    private $username = 'admin';
    private $password = '12345';
    private $dbName   = 'article';

    private static $instance;

    protected $link;

    // SINGLETON
    public static function getInstance()
    {
    	if (self::$instance === null) {
    		self::$instance = new self();
    	}
    	return self::$instance;
    }

	private function __construct()
	{
	    // Подключение к БД
	    $link = mysqli_connect($this->hostname, $this->username, $this->password);
	    $db = mysqli_select_db($link, $this->dbName);
	    // Создание БД, таблицы и заполнение таблицы
	    if(!$db) {
	        mysqli_select_db($link, $this->dbName);
	    }
	    mysqli_query($link, 'SET NAMES utf8');
	    mysqli_set_charset($link, 'utf8');
	    $this->link = $link;
	}

	/** Выборка строк
		@var $query - полный текст SQL запроса
		@result array - массив полученных строк из БД
	*/
	public function select($query)
	{
		$result = mysqli_query($this->link, $query);
		if (!$result) {
			die(mysqli_error($this->link));
		}
		
		while (@$row = mysqli_fetch_assoc($result)) {
			$arr[] = $row;
		}
		return $arr;
	}

	/**
		@var $table - имя таблицы
		@var $object - массив, ключи - имена столбцов, значение - данные в базу
		@return int id вставленной записи
	*/
	public function insert($table, $object)
	{
		$columns = array();
		$values = array();

		foreach($object as $key => $value) {
			$key = mysqli_escape_string($this->link, $key . '');
			$columns[] = "`$key`";
			if ($value === null) {
				$values[] = 'NULL';
			} else {
				$value = mysqli_escape_string($this->link, $value . '');
				$values[] = "'$value'";
			}
		}
		// INSERT INTO `table` (`col1`, `col2`, `col3`) VALUES ('val1', 'val2', 'val3')
		$columns = implode(', ', $columns);
		$values = implode(', ', $values);

		$query = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $table, $columns, $values);
		$result = mysqli_query($this->link, $query);
		if (!$result) {
			die(mysqli_error($this->link));
		}
		return mysqli_insert_id($this->link);
	}

	/**
		@var $table - имя таблицы
		@var $object - массив, ключи - имена столбцов, значение - данные в базу
		@var $where - условие (часть SQL запроса)
		@return int кол-во затронутых строк
	*/
public function update($table, $object, $where){
		$sets = array();

		foreach ($object as $key => $value) {
			$key = mysqli_escape_string($this->link, $key . '');
			echo "<br>";
			// var_dump($key);

			if ($value === null) {
				$sets[] = "`$key`=NULL";
			} else {
				$value = mysqli_escape_string($this->link, $value . '');
				$sets[] = "`$key`='$value'";
			}
		}
	 
		$sets = implode(', ', $sets);		
		$query = sprintf("UPDATE `%s` SET %s WHERE %s", $table, $sets, $where);
		$result = mysqli_query($this->link, $query);
		if (!$result) {
			die(mysqli_error($this->link));
		}
		return mysqli_affected_rows($this->link);
		// UPDATE `table` SET `col1` = 'val1', `col2` = 'val2'
	}
	/**
		@var $table - имя таблицы
		@var @where - строка вида первичный ключ = число
		@return int количество удаленных строк
	*/
	public function delete($table, $where)
	{
		$query = sprintf("DELETE FROM %s WHERE `id`= %s", $table, $where);
		//var_dump($query);
		$result = mysqli_query($this->link, $query);
		if (!$result) {
			die(mysqli_error($this->link));
		}
		return mysqli_affected_rows($this->link);
	}
function latests_paginator($start,$per_page){
    $sql="SELECT * FROM `article` ORDER BY  id ASC LIMIT ".$start.",".$per_page."";
    $result = mysqli_query($this->link, $sql);
      if (!$result) {
          die(mysqli_error($this->link));
        }
        $row=array();
   while(@$row = mysqli_fetch_assoc($result)) { // @ PHP 5.3 выбивал ошибку волшебные кавычки     
        $articles[] = $row;
      }
      if (isset( $articles)) {
        return $articles;
      }        
}
// Количество записей в базе
public function total_rows_base(){
	$sql="SELECT count(*) FROM `article`";
  	$result = mysqli_query($this->link, $sql);
  	$row=mysqli_fetch_row($result);
	$total_rows=$row[0];
	return $total_rows;
}

}





