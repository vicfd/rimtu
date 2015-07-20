<?php
	include_once '../class.php';
	
	echo
	'
		<script type="text/javascript">
			Recaptcha.create("6LdTEtsSAAAAANHOxuUHBQl9doInxmFfBjDPOcxz", "recaptcha_div");
		</script>
		<div class="Blanco border-round" style="height: auto; width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
			<form id="form_register" action="javascript:;" onsubmit="javascript:register($(\'#username\').val(), $(\'#name\').val(), $(\'#password\').val(), $(\'#password2\').val(), $(\'#email\').val(), $(\'#recaptcha_challenge_field\').val(), $(\'#recaptcha_response_field\').val()),Recaptcha.reload()">
				<table width="350" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left">Usuario</td>
						<td>
							<div align="right">
								<input id="username" type="text" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="left">Nombre</td>
						<td>
							<div align="right">
								<input id="name" type="text" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="left">Contrase&ntilde;a</td>
						<td>
							<div align="right">
								<input id="password" type="password" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="left">Repetir contrase&ntilde;a</td>
						<td>
							<div align="right">
								<input id="password2" type="password" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="left">Email</td>
						<td>
							<div align="right">
								<input id="email" type="text" value="" style="width:170px" maxlength="40" />
							</div>
						</td>
					</tr>
				</table>
				<br /> 		
					 <div id="recaptcha_div"></div>
				<br />
				<input type="submit" id="recaptcha_reload_btn" class="Boton grande azul" value="Registrar"/>
			</form>
		</div>
		<span id="register"></span>
	';
?>