<?php
	if ($_SESSION['client_level'] == 0) 
	{
		echo "<p class='alert alert-danger'>Debe identificarse para poder cambiar la contraseña</p>";
		exit;
	}	
	
	$error = "";
	
	if (isset($_POST["email"])) 
	{
		$client_email = strtolower(injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['email']) : $_POST['email']));
		
		if ($client = $db->query("SELECT * FROM clients WHERE client_email='".$client_email."'")->num_rows == 0)
		{
			if (emailvalido($client_email))
			{	
				$temp_email_exist = $db->query("SELECT * FROM temps WHERE temp_email='$client_email' && temp_type=2 && active=1")->num_rows;
				if ($temp_email_exist == 0) 
				{
					$temp_code = generar_md5($client_email, time());
					
					$subject = "Mensaje para la activacion de cuenta en Rimtu."; 
					$body = 
					"Bienvenido " . $_SESSION['client_username'] . ", a Rimtu
						<br /><br />
					Este link que le proporcionamos caduca aproximadamente al dia de su petici&oacute;n, es decir, debe confirmar el cambio de correo en menos de un d&iacute;a o deber&aacute; volver a registrarse de nuevo.
						<br /><br />
					Para cambiar su correo pulse en el link, o copielo en su navegador <a href=" . $domain . "check/" . $temp_code . ">" . $domain . "check/" . $temp_code . "</a>";
					$headers = 'From: '. $mail . '' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
					$headers .= "MIME-Version: 1.0\n"; 
					$headers .= "Content-type: text/html; charset=utf-8\n";				
					
					sendemail($_SESSION['client_email'], $email, $subject, $body);
					$db->query("INSERT INTO temps(temp_code, temp_type, temp_username, temp_email) VALUES('$temp_code', '2', '".$_SESSION['client_username']."', '$client_email')");
					echo "<p class='alert alert-success'>Se acaba de enviar un enlace al correo ".$_SESSION['client_email']." para confirmar el cambio.</p>";
				}
				else
					$error = "Ya tienes un cambio de correo electrónico activo.";
			}
			else
				$error = "El formato del correo no es el adecuado, repitalo. ejemplo: ejemplo@correo.com";
		} 
		else
			$error = "Ya existe una cuenta con ese correo";
	}
	
	if(!empty($error)) 
		echo "<p class='alert alert-danger'>$error</p>";
?>
<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="email" class="form-control" id="email" name="email" placeholder="Nuevo correo electrónico">
				<br />
				<input type="submit" class="form-control" value="Cambiar">
			</form>
		</div>
	</div>
</center>