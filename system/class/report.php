<?php
	if (isset($_POST["email"]) && isset($_POST['reason'])) 
	{
		$report_email = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['email']) : $_POST['email']);
		$report_reason = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['reason']) : $_POST['reason']);
		$error = "";
		
		if(empty($id))
			$error = "Reinicie la página, no hay seleccionado ningún archivo.";
		else
		{
			if(!emailvalido($report_email))
				$error = "El formato del correo no es el adecuado, repitalo. ejemplo: ejemplo@correo.com<br />";

			if($row = $db->query("SELECT file_ftp FROM files WHERE file_id=$id && file_active=1")->num_rows == 0)
				$error .= "El fichero seleccionado no existe.";
		}

		
		if(empty($error))
		{
			$db->query("INSERT INTO files_report(file_id, report_email, report_reason) VALUES($id, '$report_email', '$report_reason')");
			echo "<p class='alert alert-success'>Reporte registrado con exito.</p>";
		} 
		else
			echo "<p class='alert alert-danger'>$error</p>";
	}		
?>
<center>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<form method="post" class="bs-example bs-example-bg-classes">
				<input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico">
				<br />
				<textarea type="password" class="form-control" id="reason" name="reason" placeholder="Razon" rows="4" style="resize:none"></textarea>
				<br />
				<input type="submit" class="form-control" value="Reportar">
			</form>
		</div>
	</div>
</center>