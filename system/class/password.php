<?php
	if ($_SESSION['client_level'] == 0) 
	{
		echo "<p class='alert alert-danger'>Debe identificarse para poder cambiar la contraseña</p>";
		exit;
	}	
	
	$error = "";
	
	if (isset($_POST["password"]) && isset($_POST['newpassword']) && isset($_POST['repeat'])) 
	{
		$client_password = sha1(strtoupper($_SESSION['client_username']).":".injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['password']) : $_POST['password']));
		$client_new_password = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['newpassword']) : $_POST['newpassword']);
		$client_repeat = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['repeat']) : $_POST['repeat']);

		if ($client = $db->query("SELECT * FROM clients WHERE client_id='".$_SESSION['client_id']."' && client_password='$client_password'")->num_rows == 0)
			$error = "No introdujo bien su contraseña.<br />";
			
		if($client_new_password != $client_repeat)
			$error .= "Las contraseñas dadas no son iguales.<br/>";
		
		if (strlen($client_new_password) < 5 || strlen($client_new_password) > 20) 
			$error .= "La contraseña debe tener entre cinco y veinte caracteres.<br />";

		if(empty($error))
		{
			$client_new_password = sha1(strtoupper($_SESSION['client_username']).":".$client_new_password);
			$db->query("UPDATE clients SET client_password='".$client_new_password."' WHERE client_id=".$_SESSION['client_id']);
			echo "<p class='alert alert-success'>Acaba de modificar su contraseña.</p>";
		}
		else
			echo "<p class='alert alert-danger'>$error</p>";		
	}
		
?>
<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña actual">
				<br />
				<input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Nueva contraseña">
				<br />
				<input type="password" class="form-control" id="repeat" name="repeat" placeholder="Repetir contraseña">
				<br />
				<input type="submit" class="form-control" value="Cambiar">
			</form>
		</div>
	</div>
</center>