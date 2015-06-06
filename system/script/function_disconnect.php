<?php
	include_once '../class.php';

	session_unset();
	session_destroy();
	$_SESSION['usuario'] = "anonimo";
	$_SESSION['nivel'] = 0;
	html_function("Acaba de desconectarse, sera redireccionado a la pagina principal.");
	echo
	'
		<script type="text/javascript">
			goMylove(\'#head\',\'../system/class/head.php\');
			setTimeout(function(){goMylove(\'#container\',\'../system/class/home.php\',\'../index.html\')},2000);
		</script>
	';
?>