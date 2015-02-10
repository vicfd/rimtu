<?php
	include_once '../class.php';

	if (isset($_POST["oldpass"]) && isset($_POST["newpass"]) && isset($_POST["repass"])) 
	{
		$pass = !get_magic_quotes_gpc() ? addslashes($_POST['oldpass']) : $_POST['oldpass']; $pass = injection($pass);
		$newpass = !get_magic_quotes_gpc() ? addslashes($_POST['newpass']) : $_POST['newpass']; $newpass = injection($newpass);
		$repass = !get_magic_quotes_gpc() ? addslashes($_POST['repass']) : $_POST['repass']; $repass = injection($repass);
		
		$usuario = $_SESSION['usuario'];
		
		$pass = sha1(strtoupper($usuario).":".$pass);
		
		$exist = $db->SelectDb("count(*)","usuarios","WHERE usuario='$usuario' AND password='$pass'");
		
		if ($exist[0] > 0) 
		{
			if ($newpass == $repass && is_str($newpass)) 
			{
				$longitudpass = strlen($newpass);
				if ($longitudpass >= 5 && $longitudpass <= 20) 
				{
					$newpass = sha1(strtoupper($usuario).":".$newpass);
					$db->UpdateDb("usuarios","password = '$newpass'","usuario = '$usuario'");
					imprimir("La contrase&ntilde;a ha sido cambiada");
				}					
				else
					imprimir("La contrase&ntilde;a debe tener entre 5 a 20 caract&eacute;res");
			}
			else	
				imprimir("La contrase&ntilde;as no coinciden");
		}
		else
			imprimir("Su contrase&ntilde;a es incorrecta");
	}
?>