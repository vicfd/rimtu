<?php
	include_once '../class.php';

	if (isset($_POST["user"]) && isset($_POST['pass'])) 
	{
		$username = injection(!get_magic_quotes_gpc() ? addslashes($_POST['user']) : $_POST['user']);
		$password = injection(!get_magic_quotes_gpc() ? addslashes($_POST['pass']) : $_POST['pass']);

		$password = sha1(strtoupper($username).":".$password);

		$exist = $db->SelectDb("count(*)","usuarios","WHERE usuario='".addslashes($username)."' and password='".addslashes($password)."'");

		if ($exist[0] > 0) 
		{				
			$usuario = $db->SelectDb("email,nivel","usuarios","WHERE usuario='".addslashes($username)."' and password='".addslashes($password)."'");
			$_SESSION['usuario'] = $username;
			$_SESSION['email'] = $usuario[0];
			$_SESSION['nivel'] = $usuario[1];
			$db->UpdateDb("usuarios","ip = '".addslashes($_SERVER['REMOTE_ADDR'])."', login = '".addslashes(date("Y-m-d h:i:s"))."'","usuario='".addslashes($username)."'");
			html_function("Acaba de identificarse, sera redireccionado a la pagina principal.");
			echo
			'
				<script type="text/javascript">
					goMylove(\'#head\',\'../system/class/head.php\');
					setTimeout(function(){goMylove(\'#container\',\'../system/class/home.php\',\'../index.html\')},2000);
				</script>
			';
		} 
		else
			html_function("No introdujo bien los datos vuelva a intentarlo.");
	}
?>