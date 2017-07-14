<?php
	$error = "";
	$client_username = "";
	
	if (isset($_POST["username"]) && isset($_POST['password'])) 
	{
		$client_username = strtolower(injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['username']) : $_POST['username']));
		$client_password = sha1(strtoupper($client_username).":".injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['password']) : $_POST['password']));

		if ($client = $db->query("SELECT client_id, client_email, client_level FROM clients WHERE client_username='$client_username' && client_password='$client_password'")->fetch_row())
		{
			$_SESSION['client_id'] = $client[0];
			$_SESSION['client_username'] = $client_username;
			$_SESSION['client_email'] = $client[1];
			$_SESSION['client_level'] = $client[2];
			
			$db->query("UPDATE clients SET client_ip='".$_SERVER['REMOTE_ADDR']."', client_date_last_login='".date("Y-m-d h:i:s")."' WHERE client_id=$client[0]");
			echo "<p class='alert alert-success'>Acaba de identificarse, sera redireccionado a la pagina principal</p>";
			redireccionar("/index.html",2000);
		} 
		else
			$error = "No introdujo bien los datos vuelva a intentarlo";
	}
	
	if(!empty($error)) 
		echo "<p class='alert alert-danger'>$error</p>";
?>
<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario" value="<?php if(isset($client_username)) echo $client_username; ?>">
				<br />
				<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
				<br />
				<div class="btn-group btn-group-justified" role="group">
					<div class="btn-group" role="group">
						<button type="submit" class="btn btn-default">Enviar</button>
					</div>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-default" onclick="window.location='recovery'">Recuperar Cuenta</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</center>