<?php
	include_once '../class.php';
						
	if (isset($_POST["mail"])) 
	{
		$correo = !get_magic_quotes_gpc() ? addslashes($_POST['mail']) : $_POST['mail']; $correo = injection($correo);
		$usuario = $_SESSION['usuario'];
		$checkmail = mysql_query("SELECT email FROM usuarios WHERE usuario='$usuario'"); $name = mysql_fetch_array($checkmail); $email=$name["email"];
		$checkconfirmar = mysql_query("SELECT * FROM confirmar WHERE usuario='$usuario' AND tipo='2'"); $confirmar = mysql_num_rows($checkconfirmar);
		$checkconfirmacion = mysql_query("SELECT email FROM usuarios WHERE email='$correo'"); $confirmacion = mysql_num_rows($checkconfirmacion);

		if ($confirmacion < 1) 
		{
			if ($confirmar < 1) 
			{				
				$confirmar = generar_md5($usuario,$correo);
				if (emailvalido($correo)) 
				{
					$longitudmail = strlen($correo);
					if ($longitudmail <= 40) 
					{
						$time = time() + 3600;
						$query = 'INSERT INTO confirmar (tipo, usuario, nombre, password, email, ip, confirmar, ingreso, expira)
						VALUES (\''."2".'\',\''.$usuario.'\',\''."null".'\',\''."null".'\',\''.$correo.'\',\''."null".'\',\''.$confirmar.'\',\''.date("Y-m-d h:i:s").'\',\''.$time.'\')';
						
						$link = $config[0] . "check/" . $confirmar;
						// Correo
							$asunto = "Mensaje para cambio de correo electr&oacute; de cuenta."; 
							$cuerpo = 
							"Bienvenido " . $usuario . ", a nuesta pagina web " . $config[0] . "
								<br /><br />
							Va a cambiar su correo <strong>" . $email . "</strong> por <strong>" . $correo . "</strong>
								<br />
							Este link que le proporcionamos caduca aproximadamente a la hora de su petici&oacute;n, es decir, debe validar la cuenta en menos de una hora o debera volver a crearla en nuestro sitio web.
								<br /><br />
							Recuerde que este cambio es irreversible
								<br />
							Para cambiar de correo su cuenta pulse en el link, o copielo en su navegador <a href=" . $link . ">" . $link. "</a>";
							$headers = 'From: '. $config[1] . '' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
							$headers .= "MIME-Version: 1.0\n"; 
							$headers .= "Content-type: text/html; charset=utf-8\n";	
							
						mail($email,$asunto,$cuerpo,$headers);	
						mysql_query($query) or die(mysql_error());
						imprimir("Se ha enviado un mail a tu correo para confirmar el cambio");
					}
					else
						imprimir("El correo electr&oacute;nico debe tener maximo 40 caract&eacute;res");
				}	
				else
					imprimir("El correo electr&oacute;nico es invalido");
			}
			else
				imprimir("Mira tu correo tienes ya una petici&oacute;n");

		}
		else
			imprimir("Ya existe una cuenta con ese correo");
	}
?>