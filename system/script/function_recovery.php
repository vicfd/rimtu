<?php
// dayan panshi
	include_once '../class.php';

	if (isset($_POST["mail"]))
	{
		$mail = injection(!get_magic_quotes_gpc() ? addslashes($_POST['mail']) : $_POST['mail']);

		$exist = $db->SelectDb("count(*)","usuarios","WHERE email='".addslashes($mail)."'");

		if ($exist[0] > 0) 
		{
			$exist_confirm = $db->SelectDb("count(*)","confirmar","WHERE tipo=3 && email='".addslashes($mail)."'");
			if ($exist_confirm[0] == 0) 
			{
				if(emailvalido($mail))
				{
					$check = RandomString(32);
					$link = $config[0] . "check/" . $check;
					$title = "Mensaje para reseteo de clave de acceso en Rimtu."; 
					$body = 
					"Bienvenido a nuesta pagina web " . $config[0] . "
						<br /><br />
					Este link que le proporcionamos caduca aproximadamente a la hora de su petici&oacute;n, es decir, debe validar la cuenta en menos de una hora o debera volver a crearla en nuestro sitio web.
						<br /><br />
					Para activar su cuenta pulse en el link, o copielo en su navegador <a href=" . $link . ">" . $link. "</a>";
					$headers = 'From: '. $config[1] . '' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\n"; 
					$headers .= "Content-type: text/html; charset=utf-8\n";	
					
					mail($mail,$title,$body,$headers);
					$db->InsertDb("confirmar","tipo,email,ip,confirmar,ingreso,expira","'3','$mail','".addslashes($_SERVER['REMOTE_ADDR'])."','$check','".addslashes(date("Y-m-d h:i:s"))."','".addslashes(time() + 3600)."'");
					html_function("Hemos enviado un mensaje a tu correo para resetear su correo ser&aacute; enviado a la p&aacute;gina principal.");
					jsredireccionar("javascript:goMylove('#container','/system/class/home.php','/index.html')",3000);
				}
				else
					html_function("Este correo electr&oacute;nico no es valido.");
			}
			else
				html_function("Ya tienes un cambio de correo electr&oacute;nico activo.");
		} 
		else
			html_function("No tenemos registrado ese correo electr&oacute;nico.");
	}
?>