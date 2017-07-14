<?php
	if ($_SESSION['client_level'] == 0) 
	{
		echo "<p class='alert alert-danger'>Debe identificarse para poder entrar al panel de usuario</p>";
		exit;
	}
	
	echo
	"
		<div class='panel panel-default'>
			<div class='panel-body'>
				<div class='input-group'>
					<span class='input-group-addon' id='basic-addon1'>Nombre de usuario</span>
					<input type='text' class='form-control' value='".$_SESSION['client_username']."' aria-describedby='basic-addon1'>
				</div>	
				<br />
				<div class='input-group'>
					<span class='input-group-addon' id='basic-addon1'>Correo electrónico</span>
					<input type='text' class='form-control' value='".$_SESSION['client_email']."' aria-describedby='basic-addon1'>
				</div>
			</div>
		</div>
	";