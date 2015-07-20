<?php
	include_once '../class.php';
	
	echo
	'		
		<script type="text/javascript">
			Recaptcha.create("6LdTEtsSAAAAANHOxuUHBQl9doInxmFfBjDPOcxz", "recaptcha_div");
		</script>
		<center>
			<div id="form_login" class="Blanco border-round" style="width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Usuario</div>
						<div style="width:75%; display: inline-block;"><input id="username" class="inputDefault" type="text" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Nombre</div>
						<div style="width:75%; display: inline-block;"><input id="name" class="inputDefault" type="text" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Contrase&ntilde;a</div>
						<div style="width:75%; display: inline-block;"><input id="password" class="inputDefault" type="password" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Repetir</div>
						<div style="width:75%; display: inline-block;"><input id="password2" class="inputDefault" type="password" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Email</div>
						<div style="width:75%; display: inline-block;"><input id="email" class="inputDefault" type="email" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div id="recaptcha_div" style="margin-bottom:2%"></div>
					<button class="btn btn-red" style="width:40%;" onclick="register($(\'#username\').val(), $(\'#name\').val(), $(\'#password\').val(), $(\'#password2\').val(), $(\'#email\').val(), $(\'#recaptcha_challenge_field\').val(), $(\'#recaptcha_response_field\').val())">Registar</button>

			</div>
			<span id="register"></span>
		</center>
	';
?>