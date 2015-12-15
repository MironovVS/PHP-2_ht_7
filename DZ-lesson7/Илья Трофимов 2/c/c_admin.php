<?php
class C_Admin extends C_Base{
	
	private static $instance;
	protected $mUsers;
	protected $mRights;
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
		$this->mRights = M_Rights::Instance();
		// Обработка отправки формы.
	}
	public function auth(){
		$mUsers = M_Users::Instance();
		$user=$mUsers->check();
		if (!$mUsers->Can('ADMIN',$user['id_user']))
		{
			die('Отказано в доступе');
		}
	}
	public function action_index(){
		if(!empty($_POST)){
			switch ($_POST['action']) {
				case 'changeuserrole':
					$id_user=(int)$_POST['user'];
					$id_role=(int)$_POST['role'];
					$this->mRights->ChangeUserRole($id_user,$id_role);
					break;
				case 'add_priv':
					$name=trim($_POST['name']);
					$description=trim($_POST['description']);
					if($name!=''){
						$this->mRights->AddPriv($name,$description);
					}
					break;
				case 'del_priv':
					$priv_id=(int)$_POST['priv_id'];
					$this->mRights->DelPriv($priv_id);
					break;
				case 'add_role':
					$name=trim($_POST['name']);
					$description=trim($_POST['description']);
					if($name!=''){
						$this->mRights->AddRole($name,$description);
					}
					break;
				case 'del_role':
					$role_id=(int)$_POST['role_id'];
					$this->mRights->DelRole($role_id);
					break;
				case 'add_p2r':
					$role=(int)$_POST['role'];
					$priv=(int)$_POST['priv'];
					$this->mRights->AddP2R($role,$priv);
					break;
				case 'del_p2r':
					$role=(int)$_POST['role'];
					$priv=(int)$_POST['priv'];
					$this->mRights->DelP2R($role,$priv);
				default:
					break;
			}
			header('Location: '.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
		}
		$this->title.= '::Консоль администратора';
		$users=$this->mRights->GetUsersRoles();
		$roles=$this->mRights->GetRoles();
		$privs=$this->mRights->GetPrivs();
		$privs2roles=$this->mRights->GetPrivs2Roles();
		$this->content = $this->Template('v/admin_view.php', 
			array('users' => $users,
				'roles'=>$roles,
				'privs'=>$privs,
				'privs2roles'=>$privs2roles,
				'err'=>$this->err, 'res'=>$this->res));	
	}
}