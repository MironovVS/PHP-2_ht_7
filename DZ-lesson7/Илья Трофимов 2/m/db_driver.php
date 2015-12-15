<?php
// Драйвер БД
class DB extends mysqli
{
	private static $instance;
	private $hostname = 'localhost';
	private $username = 'root';
	private $password = '';
	private $dbName = 'gb_php2_itrofimov';
	private $mysqli;
	
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new self();
		
		return self::$instance;
	}
	
	private function __construct()
	{
		//ООП так ООП
		parent::__construct($this->hostname, $this->username, $this->password);
		if ($this->connect_errno) {
    		die('No connect with database');
		}
		$this->query('SET NAMES utf8');
		$this->set_charset('utf8');
		$this->select_db($this->dbName) or die("No databse");
	}
	
	//
	// Выборка строк
	// $query    	- полный текст SQL запроса
	// результат	- массив выбранных объектов
	//
	public function Select($query)
	{
		$result = $this->query($query);
		
		if (!$result)
			die($this->error);
		
		$n = $result->num_rows;
		$arr = array();
	
		for($i = 0; $i < $n; $i++)
		{
			$row = $result->fetch_assoc();
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
			$key = $this->real_escape_string($key . '');
			$columns[] = "`$key`";
			
			if ($value === null)
			{
				$values[] = 'NULL';
			}
			else{
				$value = $this->real_escape_string($value . '');							
				$values[] = "'$value'";
			}
		}

		$columns_s = implode(',', $columns); 
		$values_s = implode(',', $values);  
			
		$query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
		$result = $this->query($query);
								
		if (!$result)
			die($this->error);
			
		return $this->insert_id;
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
			$key = $this->real_escape_string($key . '');
			
			if ($value === null)
			{
				$sets[] = "$value=NULL";			
			}
			else
			{
				$value = $this->real_escape_string($value . '');					
				$sets[] = "`$key`='$value'";			
			}			
		}

		$sets_s = implode(',', $sets);			
		$query = "UPDATE $table SET $sets_s WHERE $where";
		$result = $this->query($query);
		
		if (!$result)
			die($this->error);

		return $this->affected_rows;
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
		$result = $this->query($query);
						
		if (!$result)
			die($this->error);

		return $this->affected_rows;	
	}
}
