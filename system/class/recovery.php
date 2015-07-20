<?php
	include_once '../class.php';
	
	echo 
	'
		<center>
			<div id="form_recovery" class="Blanco border-round" style="width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
					<input id="mail" class="inputDefault" type="email" style="width:90%; margin-bottom:2%" maxlength="50" value="Introduzca su correo para recuperar su cuenta" />
					<button class="btn btn-red" style="width:40%;" onclick="recovery($(\'#mail\').val())">Recuperar Cuenta</button>
			</div>
			<span id="recovery"></span>
		</center>
	';
?>