<?php
	include_once '../class.php';

	if (isset($_POST["username"]) && isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["password2"]) && isset($_POST["email"])) 
	{
		$usuario = !get_magic_quotes_gpc() ? addslashes($_POST['username']) : $_POST['username']; $usuario = injection($usuario);
		$nombre = !get_magic_quotes_gpc() ? addslashes($_POST['name']) : $_POST['name']; $nombre = injection($nombre);
		$password = !get_magic_quotes_gpc() ? addslashes($_POST['password']) : $_POST['password']; $password = injection($password);
		$password2 = !get_magic_quotes_gpc() ? addslashes($_POST['password2']) : $_POST['password2']; $password2 = injection($password2);
		$correo = !get_magic_quotes_gpc() ? addslashes($_POST['email']) : $_POST['email']; $correo = injection($correo);
		
		$comp = false;
		$link = null;
		$variabledetexto = null;
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$username = mb_strtolower($usuario);
		$cadena = strtr(strtoupper($nombre), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ"); $name = ucwords(strtolower($nombre));
		$email = mb_strtolower($correo);
		
		$confirmar = generar_md5($usuario,$email);
		$link = $config[0] . "check/" . $confirmar;
		
		// Correo
		$asunto = "Mensaje para la activacion de cuenta en Rimtu."; 
		$cuerpo = 
		"Bienvenido " . $name . ", a nuesta pagina web " . $config[0] . "
			<br /><br />
		Este link que le proporcionamos caduca aproximadamente a la hora de su petici&oacute;n, es decir, debe validar la cuenta en menos de una hora o debera volver a crearla en nuestro sitio web.
			<br /><br />
		Para activar su cuenta pulse en el link, o copielo en su navegador <a href=" . $link . ">" . $link. "</a>";
		$headers = 'From: '. $config[1] . '' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0\n"; 
		$headers .= "Content-type: text/html; charset=utf-8\n";				
		
		// Calculos de variables

			// IP
			$ip_exist = $db->SelectDb("count(*)","confirmar","WHERE ip='".addslashes($ip)."'");
			$ip_exist1 = $db->SelectDb("count(*)","usuarios","WHERE ip='".addslashes($ip)."'");
			
			// Mail
			$email_exist = $db->SelectDb("count(*)","confirmar","WHERE email='".addslashes($email)."'");
			$email_exist1 = $db->SelectDb("count(*)","usuarios","WHERE email='".addslashes($email)."'");
			
			// Usuario
			$username_exist = $db->SelectDb("count(*)","confirmar","WHERE usuario='".addslashes($username)."'");
			$username_exist1 = $db->SelectDb("count(*)","usuarios","WHERE usuario='".addslashes($username)."'");
			
			// Longitud
			$longituduser = strlen($username);
			$longitudname = strlen($name);	
			$longitudpass = strlen($password);
			$longitudmail = strlen($email);

		// Comprobar los campos									
		
		// Comprobar ip
			if ($ip_exist[0]>0 || $ip_exist1[0]>0) 
			{
				$variabledetexto .= "Usted ya tiene una cuenta registrada en nuestra web.<br />";
				$comp = true;
			} 
			else 
			{
				// Re-captcha
				include_once 'recaptchalib.php';
				$privatekey = "6LdTEtsSAAAAAGACb-2W_Ztp0E5V3xeQ5IY0IWjC";
				$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

				if (!$resp->is_valid) 
				{
					$variabledetexto .= "Captcha introducido es incorrecto.<br />";
					$comp = true;
				} 
				else
				{
			
					// Hay campos en blanco
					if($username == NULL || $nombre == NULL || $password == NULL || $password2 == NULL || $email == NULL) 
					{
						$variabledetexto .= "Debe rellenar todos los campos.<br />";
						$comp = true;
					} 
					
					// Existencia del usuario
					if ($username_exist[0] > 0 || $username_exist1[0] > 0) 
					{
						$variabledetexto .= "El nombre de usuario esta ya en uso.<br />";
						$comp = true;
					}
					
					// Existencia del correo
					if ($email_exist[0]>0 || $email_exist1[0]>0) 
					{
						$variabledetexto .= "La cuenta de correo esta ya en uso<br />";
						$comp = true;
					}
					
					// Contraseñas no coinciden
					if($password != $password2) 
					{
						$variabledetexto .= "Las contraseñas no coinciden.<br />";
						$comp = true;
					} 
					else 
					{ 
						$encriptacion = sha1(strtoupper($username).":".$password);
					}							
					
					// Formato letras de usuario
					if (!is_str($username)) 
					{
						$variabledetexto .= "El formato del usuario no es el adecuado, solo se permite de a-z A-Z 0-9.<br />";
						$comp = true;
					}
					
					// Formato letras de usuario
					if (!is_str($name)) 
					{
						$variabledetexto .= "El formato del nombre no es el adecuado, solo se permite de a-z A-Z 0-9.<br />";
						$comp = true;
					}
					
					// Formato letras de contraseña
					if (!is_str($password)) 
					{
						$variabledetexto .= "El formato de la contraseña no es el adecuado, solo se permite de a-z A-Z 0-9.<br />";
						$comp = true;
					}

					// Formato de email
					if (!emailvalido($email)) 
					{
						$variabledetexto .= "El formato del correo no es el adecuado, repitalo. ejemplo: ejemplo@hotmail.com<br />";
						$comp = true;
					}							
					
					// Comprobar rango de usuario
					if ($longituduser < 3 || $longituduser > 20) 
					{
						$variabledetexto .= "El usuario debe tener minimo tres caracteres, y maximo veinte.<br />";
						$comp = true;
					}
					
					// Comprobar rango de nombre
					if ($longitudname > 20) 
					{
						$variabledetexto .= "El nombre debe tener maximo veinte caracteres.<br />";
						$comp = true;
					}
					
					// Comprobar rango de contraseña
					if ($longitudpass <= 5 || $longitudpass >= 20) 
					{
						$variabledetexto .= "La contraseña debe tener minimo cinco caracteres, y maximo veinte.<br />";
						$comp = true;
					}
					
					// Comprobar rango de mail
					if ($longitudmail >40) 
					{
						$variabledetexto .= "El correo electronico debe tener maximo cuarenta caracteres.<br />";
						$comp = true;
					}
				}
			}
				
		// Imprimir o no el usuario
		if($comp == true)
			html_function($variabledetexto);
		else 
		{
			$time = time() + 3600;
				
			$db->InsertDb("confirmar","tipo,usuario,nombre,password,email,ip,confirmar,ingreso,expira","'1','$username','$name','$encriptacion','$email','$ip','$confirmar','".addslashes(date("Y-m-d h:i:s"))."','$time'");
			mail($email,$asunto,$cuerpo,$headers);
			
			html_function("El usuario <strong>".$username."</strong> ha sido registrado se le enviara un mensaje de confirmación al correo para validar su cuenta, vamos a redireccionarlo a la pagina principal.");
			redireccionar("index.html",5000);
		}
	}
?>