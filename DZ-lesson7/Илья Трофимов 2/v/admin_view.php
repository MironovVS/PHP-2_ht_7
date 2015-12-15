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
	<?php if($privs2roles):?>
		<table>
			<tr>
				<th>Роли</th>
				<th>Привилегии</th>
				<th>Удалить</th>
			</tr>
			<?php $current_role=null;
			foreach($privs2roles as $row):
			?>
				<tr>
					<td class="<?php echo ($current_role!=$row['id_role']) ? 'no_bottom' : 'no_bottom no_top'?>"><?php echo ($current_role!=$row['id_role']) ? $row['role_name'] : ''?></td>
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
