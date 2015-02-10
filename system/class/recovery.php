<?php
	include_once '../class.php';
	
	echo 
	'
		<div id="form_recovery" class="Blanco border-round" style="width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
			<form id="form_login" action="javascript:;" onsubmit="javascript:recovery($(\'#mail\').val())">
				<input id="mail" type="text" value="Introduzca su correo para recuperar su cuenta" style="width:300px; margin-bottom: 30px" maxlength="50" />
					<br />
				<input type="submit" class="Boton grande azul" value="Recuperar Cuenta" />
			</form>
		</div>
		<span id="recovery"></span>
	';
?>