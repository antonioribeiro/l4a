<?
	require_once dirname(__FILE__)."/conf.php";        /// configura parâmetros e variáveis globais
	require_once dirname(__FILE__)."/cys.php";  /// verifypassword
	require_once dirname(__FILE__)."/UsersController.php";

	function CheckLogin() {
	global $debug, $logoff;

		$sth = ExecSQL('select * from pessoa');

		// while ($row = ibase_fetch_object ($sth)) {
		// 	if ($row->LOGIN == 'anselmo' or $row->LOGIN == 'antoniocarlos') {
		// 		$password = 'abc1234567890';
		// 	} else { 
		// 		$password = '123456';
		// 	}

		// 	echo "$row->LOGIN, $password<br>";

		// 	$password = md5($password);

		// 	ExecSQL("update pessoa set senha = '$password' where login = '$row->LOGIN'");
		// }

		// die;


		if ($debug) echo "logoff=|$logoff|<br>";

		if ($_REQUEST['logoff']) {
			if ($debug) echo "logging off user";
			$_SESSION['logged_user'] = FALSE;
			$_SESSION['system'] = "";
		}

		if ($_REQUEST['setsys']=="mudarsistema") {
			$_SESSION['system'] = "";
		}
	}

	function UserLogin($login,$password) {
	global $debug;

		if ( verifyDatabasePasswd($login, $password) ) {
			$_SESSION['logged_user'] = $login;
			if ($_SESSION['logged_user']=='consultor') {
				$_SESSION['logged_user'] = "antoniocarlos";
			}
			Return TRUE;
		} else {
			Return FALSE;
		}
	}

	function verifyDatabasePasswd($login, $password)
	{
		$sth = ExecSQL("select * from pessoa where login = '$login'");

		$row = ibase_fetch_object($sth);

		return $row->LOGIN == $login and $row->SENHA == md5($password);
	}

	function LoginForm() {
	global $debug;

	?>
		<br>
		<br>
		<div align="center">
					<form name="LoginMailAdmin" action="<? global $url; print $url; ?>" method="POST">
									<table border="0" witdh="100%" height="63" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
									 <tr>
					<td width="725" height="63">
									<div align="center" style="width: 725">
													<table border="0" width="54%" cellpadding="0" cellspacing="0">
																	<tr>
													<td width="45%" align="right"><font face="Arial" size="2" color="#000000"><b>Login de usuário</b></font></td>
																					<td width="2%" align="center"><p align="left"></td>
																					<td width="53%" align="center"><p align="left"><input type="text" name="login" size="20" value=""></td>
																	</tr>
													<tr>
																	<td width="45%" align="right"><font face="Arial" size="2" color="#000000"><b>Senha </b></font></td>
																	<td width="2%" align="center"></td>
													<td width="53%" align="center"> <p align="left"><input type="password" name="password" size="20" value=""></p></td>
													</tr>
													</table>
													<br>
													<input type="submit" value="Entrar" name="B1">
													<br>
									</div>
					</td>
													</tr>
									</table>
					</form>
		</div>
		<SCRIPT LANGUAGE=JAVASCRIPT>document.LoginMailAdmin.login.focus()</SCRIPT>
	<?
	}

	function dd($var)
	{
		var_dump($var);
		die;
	}

?>