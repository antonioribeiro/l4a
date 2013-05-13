<?php

class Users {

	static public function showAll() 
	{
		$sth = ExecSQL('select * from pessoa order by login');

		Users::openContent();

		if(Users::adminLogged()) {
			echo '<tr><td><a href="?novousuario=sim">Criar novo usuario</a></td></tr>';
		}

		while ($row = ibase_fetch_object ($sth)) {

			$passwordLink = Users::link($row->LOGIN, "updatePasword", "alterar senha");
			$deleteLink = (Users::adminLogged() and !Users::isAdmin($row->LOGIN)) ? Users::link($row->LOGIN, "deleteUser", "deletar") : '';

			if(Users::adminLogged() or $_SESSION['logged_user'] == $row->LOGIN) {
				echo "<tr><td>$row->LOGIN</td><td>$passwordLink</td><td>$deleteLink</td></tr>";
			}
			
		}

		Users::closeContent();
	}

	static public function adminLogged() 
	{
		return Users::isAdmin($_SESSION['logged_user']);
	}

	static public function isAdmin($login)
	{
		return in_array($login, array('antoniocarlos', 'anselmo', 'germano.cd', 'david.cd'));		
	}

	static public function link($user, $option, $caption)
	{
		return '<a href="?usuario='.$user.'&'.$option.'=sim">'.$caption.'</a>';
	}

	static public function newUser() 
	{
		Users::openContent();
		
		$login = isset($_POST['login']) ? $_POST['login'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		if(empty($login) or empty($password)) {
			if($login.$password !== '') {
				echo "Digite o login e a senha.";
			}
		} else {
			if(Users::userExists($login))
			{
				echo "J&aacute; existe um usu&aacute;rio com este login";
			} else {
				Users::createNewUser($login, $password);

				Users::closeContent();

				return true;
			}
		}

		Users::createUserForm();

		Users::closeContent();
	}

	static public function createUserForm()
	{
		?>

		<tr>
		
			<form id="formulario" href="?novousuario=sim" method="POST">
				Login: <input type="text" name="login"><br>
				Senha: <input type="password" name="password"><br>
				<input type="submit" id="submit" value="Criar"><br>
			</form>

		</tr> 

		<?
	}

	static public function createNewUser($login, $password) {
		$password = md5($password);

		$sth = ExecSQL("insert into pessoa (login,senha) values ('$login', '$password')");

		echo "Usu&aacute;rio criado: $login";
	}

	static public function openContent() {
		echo '<div><center><table CELLSPACING=10><tr><td>';
	}

	static public function closeContent() {
		echo '</td></tr></table></div></center>';
	}

	static public function userExists($login) {
		$sth = ExecSQL("select * from pessoa where login = '$login'");
		$row = ibase_fetch_object ($sth);

		return $row->LOGIN == $login;
	}

	static public function updatePassword() 
	{
		Users::openContent();
		
		$login = isset($_POST['login']) ? $_POST['login'] : '';
		if(!empty($login)) 
		{
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			$passwordConfirmation = isset($_POST['password_confirmation']) ? $_POST['password_confirmation'] : '';

			if(empty($password)) {
				if($login.$password !== '') {
					echo "Digite uma senha.";
				}
			} else {
				if($password == $passwordConfirmation) {
					Users::updateUserPassword($login, $password);
					Users::closeContent();
					return true;
				}

				echo "As senhas precisam ser iguais.";
			}
		} else {
			$login = $_REQUEST['usuario'];
		}

		Users::updatePasswordForm($login);

		Users::closeContent();
	}

	static public function updateUserPassword($login, $password)
	{
		$password = md5($password);

		$sth = ExecSQL("update pessoa set senha = '$password' where login = '$login'");

		echo "Senha do usu&aacute;rio $login alterada.";
	}

	static public function updatePasswordForm($login)
	{
		?>

		<tr>
		
			<form id="formulario" href="?updatePasword=sim" method="POST">
				<input type="hidden" name="login" value="<? echo $login; ?>"><br>
				Login: <? echo $login; ?><br>
				Nova senha: <input type="password" name="password"><br>
				Redigite a senha: <input type="password" name="password_confirmation"><br>
				<input type="submit" id="submit" value="Alterar senha"><br>
			</form>

		</tr> 

		<?
	}

	static public function deleteUser() 
	{
		Users::openContent();
		
		$login = isset($_POST['login']) ? $_POST['login'] : '';
		if(!empty($login)) 
		{
			$confirmed = isset($_POST['confirmed']) ? $_POST['confirmed'] : '';

			if(!empty($confirmed) and !Users::isAdmin($login)) {
				Users::deleteUserLogin($login);
				Users::closeContent();
				return true;
			}
		} else {
			$login = $_REQUEST['usuario'];
		}

		Users::deleteUserForm($login);

		Users::closeContent();
	}

	static public function deleteUserForm($login)
	{
		?>

		<tr>
		
			<form id="formulario" href="?deleteUser=sim" method="POST">
				<input type="hidden" name="login" value="<? echo $login; ?>"><br>
				<input type="hidden" name="confirmed" value="true"><br>
				<input type="submit" id="submit" value="Clique aqui para deletar o usu&aacute;rio <? echo $login; ?>"><br>
			</form>

		</tr> 

		<?
	}

	static public function deleteUserLogin($login)
	{
		$sth = ExecSQL("delete from pessoa where login = '$login'");

		echo "Usu&aacute;rio $login deletado.";
	}
}
