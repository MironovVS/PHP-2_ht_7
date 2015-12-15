<?php
header('Content-type: text/html; charset=utf-8');
include_once('model/startup.php');
include_once('model/M_Users.php');
include_once('model/M_Rights.php');

// Установка параметров, подключение к БД, запуск сессии.
startup();
// Менеджеры.
$mUsers = M_Users::Instance();
$mRights = M_Rights::Instance();

// Очистка старых сессий.
$mUsers->ClearSessions();

/*// Текущий пользователь.
$user = $mUsers->Get();

// Если пользователь не зарегистрирован - отправляем на страницу регистрации.
if ($user == null)
{
	header("Location: login.php");
	die();
}
*/
// Может ли пользователь смотерть контакты?
if (!$mUsers->Can('ADMIN'))
{
	die('Отказано в доступе');
}

if (!empty($_POST))
{
	switch ($_POST['action']) {
		case 'changeuserrole':
			$id_user=(int)$_POST['user'];
			$id_role=(int)$_POST['role'];
			$mRights->ChangeUserRole($id_user,$id_role);
			break;
		case 'add_priv':
			$name=trim($_POST['name']);
			$description=trim($_POST['description']);
			if($name!=''){
				$mRights->AddPriv($name,$description);
			}
			break;
		case 'del_priv':
			$priv_id=(int)$_POST['priv_id'];
			$mRights->DelPriv($priv_id);
			break;
		case 'add_role':
			$name=trim($_POST['name']);
			$description=trim($_POST['description']);
			if($name!=''){
				$mRights->AddRole($name,$description);
			}
			break;
		case 'del_role':
			$role_id=(int)$_POST['role_id'];
			$mRights->DelRole($role_id);
			break;
		case 'add_p2r':
			$role=(int)$_POST['role'];
			$priv=(int)$_POST['priv'];
			$mRights->AddP2R($role,$priv);
			break;
		case 'del_p2r':
			$role=(int)$_POST['role'];
			$priv=(int)$_POST['priv'];
			$mRights->DelP2R($role,$priv);
		default:
			break;
	}
	header('Location:admin.php');
}

$users=$mRights->GetUsersRoles();
$roles=$mRights->GetRoles();
$privs=$mRights->GetPrivs();
$priv2roles=$mRights->GetPrivs2Roles();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Веб-Гуру</title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" /> 
</head>
<body>
	<h1>Управление доступом</h1>
	<a href="index.php">Главная</a><br /><br />
	Пользователи
	<table>
		<tr>
			<th>Имя</th>
			<th>Логин/Почта</th>
			<th>Роль</th>
			<th>Статус</th>
		</tr>
	<?php foreach($users as $row):?>
		<tr>
			<td><?php echo $row['name']?></td>
			<td><?php echo $row['login']?></td>
			<td>
				<form method="post">
					<input type="hidden" name="action" value="changeuserrole" />
					<input type="hidden" name="user" value="<?php echo $row['id_user']?>" />
					<select name="role">
						<option value="0">Не установлена</option>
						<?php foreach($roles as $role_row):?>
							<option value="<?php echo $role_row['id_role']?>"<?php echo ($role_row['id_role']==$row['role_id']) ? ' selected' : ''?>><?php echo $role_row['name']?></option>
						<?php endforeach?>
					</select>
					<input type="submit" value=">">
				</form>
			</td>
			<td><?php echo empty($row['id_session']) ? '<span style="color:red">Офлайн</span>' : '<span style="color:green">Онлайн</span>'?></td>
		</tr>
	<?php endforeach?>
	</table>
	<br/>
	Роли и Привелегии
	<?php if($priv2roles):?>
		<table>
			<tr>
				<th>Роли</th>
				<th>Привилегии</th>
				<th>Удалить</th>
			</tr>
			<?php $current_role=null;
			foreach($priv2roles as $row):
			?>
				<tr>
					<td class="<?php echo ($current_role!=$row['id_role']) ? 'no_bottom' : 'no_top'?>"><?php echo ($current_role!=$row['id_role']) ? $row['role_name'] : ''?></td>
					<td><?php echo $row['priv_name']?></td>
					<td>
					<form method="post">
						<input type="hidden" name="action" value="del_p2r" />
						<input type="hidden" name="role" value="<?php echo $row['id_role']?>" />
						<input type="hidden" name="priv" value="<?php echo $row['id_priv']?>" />
						<input type="submit" value="X">
					</form>
					</td>
				</tr>
			<?php 
			$current_role=$row['id_role'];
			endforeach?>
		</table>
		Добавить отношение<br />
		<form method="post">
			<input type="hidden" name="action" value="add_p2r" />
			<select name="role">
				<option value="0">Не выбрано</option>
				<?php foreach($roles as $row):?>
				<option value="<?php echo $row['id_role']?>"><?php echo $row['name']?></option>
			<?php endforeach?>
			</select>
			<select name="priv">
				<option value="0">Не выбрано</option>
				<?php foreach($privs as $row):?>
				<option value="<?php echo $row['id_priv']?>"><?php echo $row['name']?></option>
			<?php endforeach?>
			</select>
			<input type="submit" value="Добавить" />
		</form>
	<?php endif?>
	<br/>Привилегии
	<table>
		<tr>
			<th>Имя привилегии</th>
			<th>Описание привилегии</th>
			<th>Удалить</th>
		</tr>
		<?php foreach($privs as $row):?>
			<tr>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['description']?></td>
				<td>
					<form method="post">
						<input type="hidden" name="action" value="del_priv">
						<input type="hidden" name="priv_id" value="<?php echo $row['id_priv']?>">
						<input type="submit" value="X">
					</form>
				</td>
			</tr>
		<?php endforeach?>
	</table>
	Добавить привилегию<br />
	<form method="post">
		<input type="hidden" name="action" value="add_priv" />
		Имя: <input type="text" name="name" />
		Описание: <input type="text" name="description" />
		<input type="submit" value="Добавить" />
	</form>
	<br/>Роли
	<table>
		<tr>
			<th>Имя роли</th>
			<th>Описание роли</th>
			<th>Удалить</th>
		</tr>
		<?php foreach($roles as $row):?>
			<tr>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['description']?></td>
				<td>
					<form method="post">
						<input type="hidden" name="action" value="del_role">
						<input type="hidden" name="role_id" value="<?php echo $row['id_role']?>">
						<input type="submit" value="X">
					</form>
				</td>
			</tr>
		<?php endforeach?>
	</table>
	Добавить роль<br />
	<form method="post">
		<input type="hidden" name="action" value="add_role" />
		Имя: <input type="text" name="name" />
		Описание: <input type="text" name="description" />
		<input type="submit" value="Добавить" />
	</form>
</body>
</html>
