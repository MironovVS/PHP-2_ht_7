<?php
require_once 'C_Controller.php';

abstract class C_Base extends C_Controller
{
	function __construct()
	{

	}
	protected function before()
	{
		$this->title = '';
		$this->content = '';

		// в левый блок на каждой странице сайта вывести последние записи
		$mArticles = M_Articles::getInstance();
		$this->latests = $mArticles->latests();
	}

		public function render()
	{
		$vars = array('title' => $this->title, 'content' => $this->content);	
		$page = $this->Template('view/v_main.php', $vars);
		header("Content-type: text/html; charset=utf-8;");				
		echo $page;
	}
}