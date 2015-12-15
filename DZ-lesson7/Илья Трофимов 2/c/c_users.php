<?php
class C_Users extends C_Base{
	
	private static $instance;
	protected $mUsers;
	public static function Instance()
	{
		if (self::$instance == null){
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct(){
		// Менеджеры.
		parent::__construct();
		$this->mUsers = M_Users::Instance();
		$this->mUsers->ClearSessions();
		//
		// Обработка отправки формы.
	}
	public function action_auth(){
//		$this->mUsers->Logout();
		if (!empty($_POST))
		{
			if ($this->mUsers->Login($_POST['login'], 
			                   $_POST['password'], 
							   isset($_POST['remember'])))
			{
				header('Location: '.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
				die();
			}
			else{
				$this->err=NOT_AUTHED;
			}
		}
		$this->title.= '::Авторизация';
		$this->content = $this->Template('v/login_view.php', array('err'=>$this->err));	
	}
	public function action_register(){
		$this->title.= '::Регистрация';
		$this->content = $this->Template('v/register_view.php', array('err'=>$this->err, 'res'=>$this->res));	
	}
	public function action_logout(){
		$this->mUsers->Logout();
		header('Location: index.php');
		die;
	}
}