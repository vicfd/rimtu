<?php
	if (isset($_POST["email"]))
	{
		$client_email = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['email']) : $_POST['email']);
		$client_email_exist = $db->query("SELECT * FROM clients WHERE client_email='$client_email'");
		$error = "";
		
		if ($client_email_exist->num_rows > 0) 
		{
			if(!emailvalido($client_email))
				$error = "El formato del correo no es el adecuado, repitalo. ejemplo: ejemplo@correo.com<br />";
			
			$temp_email_exist = $db->query("SELECT * FROM temps WHERE temp_email='$client_email' && temp_type=3 && temp_active=1")->num_rows;
			if ($temp_email_exist > 0) 
				$error = "Ya tienes un reseteo de contraseña activo.";
		}
		else
			$error = "No tenemos registrado ese correo electrónico.";

		if(empty($error) && $row = $client_email_exist->fetch_array(MYSQLI_ASSOC))
		{
			$temp_code = generar_md5(RandomString(32), time());
			
			$subject = "Mensaje para reseteo de clave de acceso en Rimtu."; 
			$body = 
			"Hola, han pedido recuperar la contraseña de su cuenta en Rimtu
				<br /><br />
			Este link que le proporcionamos caduca aproximadamente a la hora de su petici&oacute;n, es decir, debe recuperar la cuenta en menos de una hora o debera volver a solicitar un nuevo correo.
				<br /><br />
			Para recuperar su cuenta pulse en el link, o copielo en su navegador <a href=" . $domain . "check/" . $temp_code . ">" . $domain . "check/" . $temp_code. "</a>";	
			
			sendemail($client_email, $email, $subject, $body);
			$db->query("INSERT INTO temps(temp_code, temp_type, temp_username, temp_email, temp_date_expire) VALUES('$temp_code', '3', '".$row['client_username']."', '$client_email', '".date("Y-m-d h:i:s", strtotime('+1 day'))."')");
			echo "<p class='alert alert-success'>Hemos enviado un mensaje a tu correo para resetear su contraseña.</p>";
		}
		else
			echo "<p class='alert alert-danger'>$error</p>";
	}
?>

<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="text" class="form-control" name="email" placeholder="Correo electrónico para recuperar su cuenta" value="<?php if(isset($client_email)) echo $client_email; ?>">
				<br />
				<input type="submit" class="form-control" value="Recuperar cuenta">
			</form>
		</div>
	</div>
</center>