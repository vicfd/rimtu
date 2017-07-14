<?php

	if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["repeat"]) && isset($_POST["email"])) 
	{
		$client_username = strtolower(injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['username']) : $_POST['username']));
		$client_password = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['password']) : $_POST['password']);
		$client_repeat = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['repeat']) : $_POST['repeat']);
		$client_email = strtolower(injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['email']) : $_POST['email']));
		$client_ip = $_SERVER['REMOTE_ADDR'];
		$error = "";
		
		$client_ip_exist = $db->query("SELECT * FROM clients WHERE client_ip='$client_ip'")->num_rows;
		$temp_ip_exist = $db->query("SELECT * FROM temps WHERE temp_ip='$client_ip' && temp_type=1 && temp_active=1")->num_rows;
		
		if ($client_ip_exist > 0 || $temp_ip_exist > 0) 
			$error = "Usted ya tiene una cuenta registrada en nuestra web.<br />";
		else 
		{
			$client_username_exist = $db->query("SELECT * FROM clients WHERE client_username='$client_username'")->num_rows;
			$temp_username_exist = $db->query("SELECT * FROM temps WHERE temp_username='$client_username' && temp_type=1")->num_rows;			
			
			$client_email_exist = $db->query("SELECT * FROM clients WHERE client_email='$client_email'")->num_rows;
			$temp_email_exist = $db->query("SELECT * FROM temps WHERE temp_email='$client_email' && temp_type=1 && temp_active=1")->num_rows;

			if ($client_username_exist > 0 || $temp_username_exist > 0) 
				$error .= "El nombre de usuario esta en uso.<br />";

			if ($client_email_exist >0  || $temp_email_exist > 0) 
				$error .= "La cuenta de correo esta en uso<br />";
			
			if (strlen($client_username) < 3 || strlen($client_username) > 20) 
				$error .= "El usuario debe tener entre tres caracteres y veinte caracteres.<br />";
			
			if (strlen($client_password) < 5 || strlen($client_password) > 20) 
				$error .= "La contraseña debe tener entre cinco y veinte caracteres.<br />";

			if($client_password != $client_repeat) 
				$error .= "Las contraseñas no coinciden.<br />";
			else
				$client_password = sha1(strtoupper($client_username).":".$client_password);		

			if (!emailvalido($client_email))
				$error .= "El formato del correo no es el adecuado, repitalo. ejemplo: ejemplo@correo.com<br />";
		}

		if(empty($error))
		{
			$temp_code = generar_md5($client_username, $client_email);
			
			$subject = "Mensaje para la activacion de cuenta en Rimtu."; 
			$body = 
			"Bienvenido " . $client_username . ", a Rimtu
				<br /><br />
			Este link que le proporcionamos caduca aproximadamente al dia de su petici&oacute;n, es decir, debe validar la cuenta en menos de un d&iacute;a o deber&aacute; volver a registrarse de nuevo.
				<br /><br />
			Para activar su cuenta pulse en el link, o copielo en su navegador <a href=" . $domain . "check/" . $temp_code . ">" . $domain . "check/" . $temp_code . "</a>";
			
			$db->query("INSERT INTO temps(temp_code, temp_type, temp_username, temp_password, temp_email, temp_ip, temp_date_registered, temp_date_expire) VALUES('$temp_code', '1', '$client_username', '$client_password', '$client_email','$client_ip','".date("Y-m-d h:i:s")."','".date("Y-m-d h:i:s", strtotime('+1 day'))."')");
			sendemail($client_email, $email, $subject, $body);
			echo "<p class='alert alert-success'>El usuario <strong>$client_username</strong> ha sido registrado se le enviara un mensaje de confirmación al correo para validar su cuenta.</p>";
		}
		else
			echo "<p class='alert alert-danger'>$error</p>";
	}
?>

<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="text" class="form-control" name="username" placeholder="Nombre de usuario" value="<?php if(isset($client_username)) echo $client_username; ?>">
				<br />
				<input type="password" class="form-control" name="password" placeholder="Contraseña">
				<br />
				<input type="password" class="form-control" name="repeat" placeholder="Repetir contraseña">
				<br />
				<input type="text" class="form-control" name="email" placeholder="Correo electrónico" value="<?php if(isset($client_email)) echo $client_email; ?>">
				<br />
				<input type="submit" class="form-control" value="Registrar">
			</form>
		</div>
	</div>
</center>