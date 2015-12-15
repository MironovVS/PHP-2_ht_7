<?php

class C_Articles extends C_Base
{
	function __construct()
	{

	}

	public function action_all(){
		$mArticles = M_Articles::getInstance();
		$this->title="Главная страница";
		$text = $mArticles->All();		
	$this->content = $this->Template('view/v_index.php', array('text' => $text));	

	}	
/*
	public function action_all(){
		$mArticles = M_Articles::getInstance();
	
		$res = "";
		$num_pages="";
		$per_page = 2;
		$page ="";
		$total= $mArticles->total_rows();

		  if (isset($_GET['page'])){

		  $page=($_GET['page']-1); 
			 }
		  else {
			$page=0;
				}
				

		$start=abs($page*$per_page);
		$num_pages=ceil($mArticles->total_rows()/$per_page);		 
		//$view_article_paginator = $mArticles->latests($start,$per_page);	
		$text = $mArticles->latests($start,$per_page);		
		// $this->content = $this->Template('view/v_index.php', array('text' => $text));
		$this->content =$this->template('view/v_index.php', array(
											  'res' 				   =>$res,
											  'num_pages'			   =>$num_pages,
											  'page'				   =>$page,
											  'text' 				   => $text
											  ) 
					);	

	}	

	*/
	public function action_add(){
		$this->title="Добавить страницу";
		$mArticles = M_Articles::getInstance();
		$text="";
		// Проверка на существование данных
			if (isset($_POST['title_add'])&&isset($_POST['text_add'])) {
				$db_tiltle =$_POST['title_add'];
				$db_text   = $_POST['text_add'];
				$date  = date("Y-m-d");
				$object=array('title'=>$db_tiltle,'text'=>$db_text,'date'=>$date);
				$text = $mArticles->ADD($object);
			}
	$this->content = $this->Template('view/v_add.php', array('text' => $text));	

	}
	public function action_view(){
		$this->title="Просмотр страници";
		$id= $_GET['id'];
		$mArticles = M_Articles::getInstance();
		$text= $mArticles->ONE($id);
			foreach ($text as $value) {
				$param=$value;
			}		
		// вывод коментарий под id статьи
		$comment = $mArticles->COMMENT($id);

 		$text ="";
 		//Проверка на ввод даных коментарий
		if (isset($_POST['name_comment']) && isset($_POST['text_comment'])) {
			$db_name_comment  = $this->clear_article($_POST['name_comment']);
			$db_text_comment  = $this->clear_article($_POST['text_comment']);
				if ($db_name_comment!="" && $db_text_comment!="" ) {
					$date  = date("Y-m-d");
					$object=array('name'=>$db_name_comment,'text'=>$db_text_comment,'date'=>$date,'article_id'=>$id);
					$text = $mArticles->add_comment($object);
						if (isset($text)===TRUE) {
							header("Location:/?c=page&act=view&id=".$_GET['id']."");
						}				
				}
			
		}
		// удаление коментария
		if (isset($_GET['del'])!="") {			
			$del_id=$_GET['del'];
			$res =  $mArticles->DELETE_COMMENT($del_id);
			header("Location:/?c=page&act=view&id=".$_GET['id']."");
		}	
		
	$this->content = $this->Template('view/v_articale.php', array('param' => $param, 'comment'=>$comment));	

	}
	

	public function action_delete()	{
		$this->title="Удаление страници";
		if (isset($_GET['yes'])) {
		$id= $_GET['id'];
		$mArticles = M_Articles::getInstance();
		$text= $mArticles->DELETE($id);
		}
		$this->content = $this->Template('view/v_delete.php', array('text' => $text));	

	}
	public function action_edit()	{	
		$this->title="Редактирование страници";
		$id= $_GET['id'];
		$mArticles = M_Articles::getInstance();
		$text= $mArticles->ONE($id);
			foreach ($text as $value) {
				$param=$value;

			}
			$res="";	
		if (isset($_POST['title'])&&isset($_POST['text'])) {

			$db_tiltle =$this->clear_article($_POST['title']);
			$db_text   = $this->clear_article($_POST['text']);
			$object=array('id'=>$id,'title'=>$db_tiltle,'text'=>$db_text);
			//var_dump($object);		
			$text= $mArticles->UPDATE($id,$object);
				if (isset($text)===TRUE) {

					header("Location:/?c=page&act=edit&id=".$_GET['id']."&good");
				}

		}		
		
		$this->content = $this->Template('view/v_edit.php', array('param' => $param, 'res'=>$res));	

	}

public function clear_article($cl_str){
  	$cl_str  = preg_replace('| +|', ' ', $cl_str);
	$cl_str=strip_tags($cl_str);
	// $cl_str=mysql_real_escape_string($cl_str);
	$cl_str=trim($cl_str);
  // $order = array("\r\n", "\n", "\r","&amp;","&quot;","&#039;","&lt;","&gt;","\\","quot;");
  // $text  =str_replace($order,' ', $text);
  $cl_str = htmlspecialchars($cl_str);
  return $cl_str;  
}

}