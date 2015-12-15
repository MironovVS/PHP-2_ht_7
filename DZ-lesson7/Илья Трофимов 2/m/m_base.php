<?php
require_once 'db_driver.php';

class M_Base{
	
	protected $db; 					// драйвер БД

	protected function __construct()
	{
		$this->db = DB::Instance();
	}
}