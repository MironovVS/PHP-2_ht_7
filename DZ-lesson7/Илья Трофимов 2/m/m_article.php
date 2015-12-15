<?php
//модель для статей
class M_Article extends M_Base{

	private static $instance;
	public static function Instance()
	{
		if (self::$instance == null){
			self::$instance = new self();
		}
		return self::$instance;
	}
	//Возвращает массив статей в соответствии с текущей страницей $page
	public function get_articles($page)
	{
		$sql = sprintf('SELECT * FROM articles ORDER BY mod_time DESC LIMIT %d, %s',($page-1)*APP,APP);
		return $this->db->Select($sql);
	}
	public function get_pages(){
		$sql=sprintf('SELECT count(*) as pages FROM articles');
		$result=$this->db->Select($sql);
		$pages=ceil($result[0]['pages']/APP);
		return $pages;
	}
	public function add_article($title, $content){
		if($title=='' || $content==''){
			return false;
		}
		$data=array('article_title'=>$title, 'article_content'=>$content);
		$result=$this->db->Insert('articles',$data);
		if($result){
			return true;
		}
		else{
			return false;
		}
	}
	public function get_article($id){
		$article=array();
		$sql=sprintf('SELECT * FROM articles WHERE article_id=%d',$id);
		$article=$this->db->Select($sql);
		return $article;
	}
	public function edit_article($id=flase,$title='',$content=''){
		if(!$id || $title=='' || $content==''){
			return false;
		}
		$data=array('article_title'=>$title,'article_content'=>$content);
		$where=sprintf('article_id=%d',$id);
		$result=$this->db->Update('articles', $data, $where);
		if($result){
			return true;
		}
		else{
			return false;
		}
	}
	public function delete_article($id){
		$id=(int)$id;
		$where=sprintf('article_id=%d',$id);
		$result=$this->db->Delete('articles',$where);
		$m_comments=M_Comments::Instance();
		$m_comments->delete_comments($id); //удалим комментарии, раз уж статью решили удалить
		if($result>0){
			return true;
		}
		else{
			return false;
		}
	}
	//обрезанные статьи
	public function articles_intro($page){
		$articles=array();
		$sql=sprintf('SELECT * FROM articles ORDER BY mod_time DESC LIMIT %d, %s',($page-1)*APP,APP);
		$result=$this->db->Select($sql);
		foreach($result as $row){
			if(mb_strlen($row['article_content'])>INTRO_SIZE){
				$row['article_content']=mb_strimwidth($row['article_content'],0,INTRO_SIZE);
				$row['readmore']=true;
			}
			else {
				$row['readmore']=false;
			}
			$articles[]=$row;
		}
		return $articles;
	}
}
	// Конкретная статья
/*	public function Get($id_article)
	{
		// Запрос.
		$t = "SELECT * 
			  FROM articles 
			  WHERE id_article = '%d'";
			  
		$query = sprintf($t, $id_article);
		$result = $this->msql->Select($query);
		return $result[0];
	}

	//
	// Добавить статью
	//
	public function Add($title, $content)
	{
		// Подготовка.
		$title = trim($title);
		$content = trim($content);

		// Проверка.
		if ($title == '')
			return false;
		
		// Запрос.
		$obj = array();
		$obj['title'] = $title;
		$obj['content'] = $content;
		
		$this->msql->Insert('articles', $obj);
		return true;
	}

	//
	// Изменить статью
	//
	public function Edit($id_article, $title, $content)
	{
		// Подготовка.
		$title = trim($title);
		$content = trim($content);

		// Проверка.
		if ($title == '')
			return false;
		
		// Запрос.
		$obj = array();
		$obj['title'] = $title;
		$obj['content'] = $content;
		
		$t = "id_article = '%d'";		
		$where = sprintf($t, $id_article);		
		$this->msql->Update('articles', $obj, $where);
		return true;
	}

	//
	// Удалить статью
	//
	public function Delete($id_article)
	{
		// Запрос.
		$t = "id_article = '%d'";		
		$where = sprintf($t, $id_article);		
		$this->msql->Delete('articles', $where);
		return true;
	}*/
	?>