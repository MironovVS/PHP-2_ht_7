<?php
class C_Index extends C_Base
{
	private static $instance;
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new self();
		
		return self::$instance;
	}
	protected function auth(){
		
	}
	use paginator;//трейт пагинатора
	//список статей
	public function action_index(){
		$this->title .= '::Главная';
		$this->paginator();//функция из трейта
		$this->articles=$this->model->articles_intro($this->page);
		$this->content = $this->Template('v/index_view.php', array('articles' => $this->articles, 'paginator'=>$this->paginator, 'page'=>$this->page));
	}
	//просмотр статьи
	public function action_view(){
		$this->comments_model=M_Comments::Instance();
		$this->title .= '::Просмотр';
		$this->check_params(array('id','page'));
		$id=(int)$_GET['id'];
		$page=(int)$_GET['page'];
		$this->article=$this->model->get_article($id)[0];
		if($this->IsPost()){
			if(!isset($_POST['article_id']) || !isset($_POST['author']) || !isset($_POST['content'])){
				$this->err='Что-то пошло не так!';
			}
			else{
				$data['article_id']=(int)$_POST['article_id'];
				$data['comment_author']=trim($_POST['author']);
				$data['comment_content']=trim($_POST['content']);
				if($data['comment_author']=='' || $data['comment_content']==''){
					$this->err='Комментарий не опубликован. Не хватает имени или содержимого комментария.';
				}
				else{
					$this->comments_model->add_comment($data);
					$this->res='Комментарий добавлен';
				}
			}
		}
		$comments_data=$this->comments_model->get_comments($id);
		$comments=$this->Template('v/comments_view.php', array('article' => $this->article, 'page'=>$page, 'comments'=>$comments_data, 'err'=>$this->err, 'res'=>$this->res));
		$this->content = $this->Template('v/article_view.php', array('article' => $this->article, 'page'=>$page, 'comments'=>$comments));
	}
}