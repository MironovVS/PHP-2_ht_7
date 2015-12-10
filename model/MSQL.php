<?php
//
// Помощник работы с БД
//

class MSQL {

	// Настройки подключения к БД.
	private static $instance;
	private $hostname = 'localhost';
	private $username = 'root';
	private $password = '';
	private $dbName = 'PHP2-7';
  protected $link;

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

	//
	// Получение экземпляра класса
	// результат	- экземпляр класса MSQL
	//
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new MSQL();
			
		return self::$instance;
	}

	//
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
	public function Select($query)
	{
		$result = mysqli_query($this->link, $query);
		
		if (!$result)
			die(mysqli_error($this->link));
		
		$n = mysqli_num_rows($result);
		$arr = array();
	
		for($i = 0; $i < $n; $i++)
		{
			$row = mysqli_fetch_assoc($result);
			$arr[] = $row;
		}

		return $arr;				
	}
	
	//
	// Вставка строки
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// результат	- идентификатор новой строки
	//
	public function Insert($table, $object)
	{			
		$columns = array();
		$values = array();
	
		foreach ($object as $key => $value)
		{
			$key = mysqli_real_escape_string($this->link, $key . '');
			$columns[] = $key;
			
			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else
			{
				$value = mysqli_real_escape_string($this->link, $value . '');
				$values[] = "'$value'";
			}
		}
		
		$columns_s = implode(',', $columns);
		$values_s = implode(',', $values);
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = mysqli_query($this->link, $query);
								
		if (!$result)
			die(mysqli_error($this->link));
			
		return mysqli_insert_id($this->link);
	}
	
	//
	// Изменение строк
	// $table 		- имя таблицы
	// $object 		- ассоциативный массив с парами вида "имя столбца - значение"
	// $where		- условие (часть SQL запроса)
	// результат	- число измененных строк
	//	
	public function Update($table, $object, $where)
	{
		$sets = array();
	
		foreach ($object as $key => $value)
		{
			$key = mysqli_real_escape_string($this->link, $key . '');
			
			if ($value === null)
			{
				$sets[] = "$key=NULL";			
			}
			else
			{
				$value = mysqli_real_escape_string($this->link, $value . '');
				$sets[] = "$key='$value'";			
			}			
		}
		
		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = mysqli_query($this->link, $query);
		
		if (!$result)
			die(mysqli_error($this->link));

		return mysqli_affected_rows($this->link);
	}
	
	//
	// Удаление строк
	// $table 		- имя таблицы
	// $where		- условие (часть SQL запроса)	
	// результат	- число удаленных строк
	//		
	public function Delete($table, $where)
	{
		$query = "DELETE FROM $table WHERE $where";		
		$result = mysqli_query($this->link, $query);
						
		if (!$result)
			die(mysqli_error($this->link));

		return mysqli_affected_rows($this->link);
	}

	// экранирование переменных
	public function sql_escape($param)
	{
		return mysqli_escape_string($this->link, $param);
	}
}
