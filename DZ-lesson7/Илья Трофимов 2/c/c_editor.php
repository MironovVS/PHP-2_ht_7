<?php
class C_Editor extends C_Base
{
	private static $instance;
	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new self();
		
		return self::$instance;
	}

	use paginator; //трейт пагинатора
	//список статей
	protected function auth(){
		$mUsers = M_Users::Instance();
		$user=$mUsers->check();
		if (!$mUsers->Can('EDITOR',$user['id_user']))
		{
			die('Отказано в доступе');
		}
	}
	public function action_index(){
		$this->title.= '::Консоль редактора';
		$this->paginator(); //функция из трейта
		$this->articles=$this->model->get_articles($this->page);
		$this->content = $this->Template('v/editor_view.php', array('articles' => $this->articles, 'paginator'=>$this->paginator, 'err'=>$this->err, 'res'=>$this->res));	
	}
	//форма редактирования статьи
	public function action_edit(){
		$this->title.= '::Редактирование статьи';
		$this->check_params(array('id'));
		$id=(int)$_GET['id'];
		$this->article=$this->model->get_article($id)[0];
		if(!$this->article){
			$this->err=COMMON_ERROR;
			$this->article['article_title']=$this->article['article_content']='';
		}
		$this->content = $this->Template('v/edit_view.php', array('article' => $this->article, 'id'=>$id, 'err'=>$this->err, 'res'=>$this->res));	
	}
	//сохранение статьи
	public function action_save(){
		$this->title.= '::Редактирование статьи';
		$this->check_params(array('id'));
		if($this->IsPost()){
			$id=(int)$_GET['id'];
			$result=$this->model->edit_article($id,trim($_POST['title']),trim($_POST['content']));
			if($result){
				$this->res='Статья успешно сохранена.';
			}
			else {
				$this->err=COMMON_ERROR;
			}
			$this->action_edit();
		}
	}
	//удаление статьи
	public function action_delete(){
		$this->check_params(array('id'));
		$id=(int)$_GET['id'];
		$result=$this->model->delete_article($id);
		if($result){
			$this->res='Статья удалена';
		}
		else{
			$this->err=COMMON_ERROR;
		}
		$this->action_index();
	}
	//форма добавления статьи
	public function action_add(){
		$this->title.='::Добавление статьи';
		$data['article_title']=$data['article_content']=$data['err']=$data['res']='';
		$this->content=$this->Template('v/add_view.php',$data);
	}
	//сохранение новой статьи
	public function action_new(){
		$this->title.='::Добавление статьи';
		if($this->IsPost()){
			$result=$this->model->add_article(trim($_POST['title']),trim($_POST['content']));
			if($result){
				$this->res='Статья добавлена';
			}
			else{
				$this->err=COMMON_ERROR;
			}
			$this->action_index();
		}
	}
}