<?php
	include_once '../class.php';
	
	echo 
	'
		<div id="form_login" class="Blanco border-round" style="width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
			<form id="form_login" action="javascript:;" onsubmit="javascript:login($(\'#user\').val(), $(\'#pass\').val())">
				<table width="350" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left">Usuario</td>
						<td>
							<div align="right">
								<input id="user" type="text" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
					<tr>
						<td align="left">Contrase&ntilde;a</td>
						<td>
							<div align="right">
								<input id="pass" type="password" value="" style="width:170px" maxlength="20" />
							</div>
						</td>
					</tr>
				</table>
					<br />
				<input type="submit" class="Boton grande azul" value="Identificar" />
				<a onclick="goMylove(\'#container\',\'/system/class/recovery.php\',\'/recovery/\')" class="Boton grande azul">Recuperar Cuenta</a>
			</form>
		</div>
		<span id="login"></span>
	';
?>