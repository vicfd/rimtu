<?php
	include_once '../class.php';
	
	echo 
	'
		<center>
			<div id="form_login" class="Blanco border-round" style="width: 635px; color: #006699; padding: 20px 0px 15px 0px; margin-bottom: 20px">
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Usuario</div>
						<div style="width:75%; display: inline-block;"><input id="user" class="inputDefault" type="text" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<div style="width: 80%; margin-bottom: 2%;">
						<div style="width: 20%; text-align: left; display: inline-block;">Contrase&ntilde;a</div>
						<div style="width:75%; display: inline-block;"><input id="pass" class="inputDefault" type="password" value="" style="width:90%;" maxlength="20" /></div>
					</div>
					<button class="btn btn-red" style="width:40%;" onclick="login($(\'#user\').val(), $(\'#pass\').val())">Identificar</button>
					<button class="btn btn-red" style="width:40%;" onclick="goMylove(\'#container\',\'/system/class/recovery.php\',\'/recovery/\')">Recuperar Cuenta</button>
			</div>
			<span id="login"></span>
		</center>
	';
?>