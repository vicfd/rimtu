<?php
	unset($_SESSION["client_id"]); 
	unset($_SESSION["client_nickname"]);
	unset($_SESSION["client_email"]);
	unset($_SESSION["client_level"]);	
	session_destroy();
	echo "<p class='alert alert-success'>Acaba de desconectarse, sera redireccionado a la pagina principal.</p>";
	redireccionar("/index.html", 2000);
?>