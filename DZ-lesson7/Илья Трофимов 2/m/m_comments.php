<?php
class M_Comments extends M_Base{
	private static $instance;
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new self();
		
		return self::$instance;
	}
	//получить все комментарии к статье
	public function get_comments($article_id){
		$sql = sprintf('SELECT * FROM comments WHERE article_id=%d ORDER BY mod_time ASC',$article_id);
		return $this->db->Select($sql);
	}
	//добавить комемнтарий
	public function add_comment($data=array()){
		return $this->db->Insert('comments',$data);
	}
	//удалить комментарий. используется при удалении статьи
	public function delete_comments($article_id){
		$where="article_id={$article_id}";
		return $this->db->Delete('comments',$where);	
	}
}