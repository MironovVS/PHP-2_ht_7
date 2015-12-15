<?php

class M_Articles{
	// ссылка на экземпляр класса
	private static $instance;

	// ссылка на драйвер
	private $mysql;

	private function __construct()
	{
		$this->mysql = M_MYSQL::getInstance();
	}

	// получение единственного экземпляра класса
	public static function getInstance()
	{
		// гарантия одного экземпляра
		if (self::$instance === null) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	// общие методы для всех моделей
	public function All()	{
		$query = "SELECT * FROM article ORDER BY id DESC";
		return $this->mysql->select($query);
	}
	// коментарий к каждой статьи
	public function COMMENT($id){
		 $id  = (int)$id;
		$query = "SELECT * FROM `comment`  WHERE `article_id` ={$id} ORDER BY id DESC" ;
		return $this->mysql->select($query);
	}
	// Добавление коментария
	public function add_comment($object){
	$table="comment";      
      	return $this->mysql->insert($table, $object);
	}
	public function DELETE_COMMENT($id){
	  $table="`comment`";
      $id  = (int)$id;
     	return $this->mysql->delete($table,$id);		
	}
	// вывод одной статьи
	public function ONE($id){
      $id  = (int)$id;
      $query = "SELECT * FROM `article` WHERE `article`.`id`=".$id." ";
		return $this->mysql->select($query);
		
	}
	// удаление статьи
	public function DELETE($id){
	  $table="`article`";
      $id  = (int)$id;
     	return $this->mysql->delete($table,$id);		
	}
	// обновление статьи
	public function UPDATE($id,$object){
	  $table="article";
      $id  = (int)$id;
      $where = 'id='.$id;
     	return $this->mysql->update($table, $object, $where);
		
	}
	// Добавление статьи
	public function ADD($object){
	  $table="article";      
      	return $this->mysql->insert($table, $object);		
	}


	// получить последние 10 записей
public function latests()	{
		$start=0;
		$per_page =1;		
		return $this->mysql->latests_paginator($start,$per_page);		

	}
	// количество записей из базы
public function total_rows(){
	return $this->mysql->total_rows_base();
}


public function Intro($content){
		return mb_substr(0, 50, $content);
	}


	
}