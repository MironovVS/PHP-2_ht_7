<?php
// Менеджер пользователей
class M_Rights
{	
	private static $instance;	// экземпляр класса
	private $db;				// драйвер БД

	public static function Instance()
	{
		if (self::$instance == null)
			self::$instance = new M_Rights();
			
		return self::$instance;
	}

	// Конструктор
	public function __construct()
	{
		$this->db = DB::Instance();
	}
	
	//Получение прав
	public function GetUsersRoles(){
		$sql='SELECT u.id_user, login, u.name, r.id_role as role_id, r.name as role_name, r.description as role_description, id_session 
		FROM `users` u 
		LEFT JOIN roles r ON u.id_role=r.id_role 
		LEFT JOIN sessions s ON u.id_user=s.id_user GROUP BY u.id_user';
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			return $result;
		}
		else{
			return array();
		}
	}
	public function ChangeUserRole($id_user,$id_role){
		$user['id_role'] = $id_role;
		$where=sprintf('id_user=\'%s\'',$id_user);
		if($this->db->Update('users', $user, $where)){
			return true;
		}
		else return false;
	}
	public function GetRoles(){
		$sql='SELECT * FROM roles ORDER BY id_role';
		return $this->db->Select($sql);
	}
	public function AddRole($name,$description){
		$data['name'] = $name;
		$data['description'] = $description;
		$this->db->Insert('roles', $data); 
	}
	public function DelRole($role_id){
		$where=sprintf('id_role=\'%s\'',$role_id);
		$this->db->Delete('roles',$where);
		$this->db->Delete('privs2roles',$where);
	}
	public function GetPrivs(){
		$sql='SELECT * FROM privs ORDER BY id_priv';
		return $this->db->Select($sql);
	}
	public function AddPriv($name,$description){
		$data['name'] = $name;
		$data['description'] = $description;
		$this->db->Insert('privs', $data); 
	}
	public function DelPriv($priv_id){
		$where=sprintf('id_priv=\'%s\'',$priv_id);
		$this->db->Delete('privs',$where);
		$this->db->Delete('privs2roles',$where);
	}
	public function AddP2R($role,$priv){
		$check_role_sql=sprintf('SELECT id_role FROM roles WHERE id_role=\'%s\'',$role);
		$check_priv_sql=sprintf('SELECT id_priv FROM privs WHERE id_priv=\'%s\'',$priv);
		$check_role=$this->db->Select($check_role_sql);
		$check_priv=$this->db->Select($check_priv_sql);
		if(!empty($check_role) && !empty($check_priv)){
			$check_p2r_sql=sprintf('SELECT * FROM privs2roles WHERE id_priv=\'%s\' AND id_role=\'%s\'',$priv,$role);
			$check_p2r=$this->db->Select($check_p2r_sql);
			if(empty($check_p2r)){
				$data['id_role']=$role;
				$data['id_priv']=$priv;
				$this->db->Insert('privs2roles',$data);
			}
		}
	}
	public function DelP2R($role,$priv){
		$where=sprintf('id_role=\'%s\' AND id_priv=\'%s\'',$role,$priv);
		$this->db->Delete('privs2roles',$where);
	}
	public function GetPrivs2Roles(){
		$sql='SELECT r.name as role_name, p.name as priv_name, r.id_role, p.id_priv FROM roles r 
		LEFT JOIN privs2roles p2r ON r.id_role=p2r.id_role 
		INNER JOIN privs p ON p2r.id_priv=p.id_priv ORDER BY r.id_role';
		$result=$this->db->query($sql);
		if($result->num_rows>0){
			return $result;
		}
		else{
			return false;
		}
	}
}