<?php
	include_once '../class.php';

	if(isset($_GET['id'])) 
	{
		$exist = $db->SelectDb("count(*)","confirmar","WHERE confirmar='".addslashes(injection($_GET['id']))."'");

		if ($exist[0] > 0) 
		{
			$datos = $db->SelectDb("tipo,usuario,email","confirmar","WHERE confirmar='".addslashes($_GET['id'])."'");
			switch($datos[0])
			{
				case 1:
					$query = $db->SelectDb("usuario,nombre,password,email,ip,ingreso","confirmar","WHERE confirmar='".addslashes($_GET['id'])."'");
					$db->InsertDb("usuarios","usuario,nombre,password,email,ip,ingreso","'$query[0]','$query[1]','$query[2]','$query[3]','$query[4]','$query[5]'");
					html_function("La cuenta con nombre <strong>".$datos[1]."</strong> ha sido validada, sera redireccionado a la pagina principal.");
					$time = 3000;
					break;
				case 2:
					$db->UpdateDb("usuarios","email='$datos[2]'","usuario='".addslashes($datos[1])."'");
					html_function("La cuenta con nombre <strong>".$datos[1]."</strong> ha sido cambiado su correo a <strong>".$datos[2]."</strong>, sera redireccionado a la pagina principal.");
					$time = 3000;
					break;
				case 3:
					$account = $db->SelectDb("usuario","usuarios","WHERE email='".addslashes($datos[2])."'");
					$pass = RandomString(8);
					$password = sha1(strtoupper($account[0]).":".$pass); 
					$db->UpdateDb("usuarios","password='$password'","usuario='".addslashes($account[0])."'");
					html_function("Su nueva contrase&ntilde;a para la cuenta del correo <strong>".$datos[2]."</strong> ha sido cambiado, Apunte esta nueva contrase&ntilde;a <strong>".$pass."</strong>, ser&aacute; redireccionado a la pagina principal.");
					$time = 20000;
					break;
			}
			$db->DeleteDb("confirmar","confirmar='".addslashes($_GET['id'])."'");
			jsredireccionar("goMylove('#container','../system/class/home.php','/index.html')",$time);
		} 
		else 
		{
			html_function("El codigo introducido es invalido, sera redireccionado a la pagina principal.");
			jsredireccionar("goMylove('#container','../system/class/home.php','/index.html')",3000);
		}
	} 
	else
	{
		html_function("El codigo introducido es invalido, sera redireccionado a la pagina principal.");
		jsredireccionar("goMylove('#container','../system/class/home.php','/index.html')",3000);
	}
?>