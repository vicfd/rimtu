<?php
	include_once '../class.php';
	
	if(isset($_GET['id']) && isset($_GET['type']) && isset($_GET['mail']) && isset($_GET['reason']))
	{
		$id = replaceStr("%"," ",injection($_GET['id']));
		$type = replaceStr("%"," ",injection($_GET['type']));
		$mail = replaceStr("%"," ",injection($_GET['mail']));
		$reason = replaceStr("%"," ",injection($_GET['reason']));

		$db->InsertDb("reporte","archivo,tipo,correo,razon","'$id','$type','$mail','$reason'");
		html_function("El reporte ha sido registrado. Le reenviaremos de nuevo a la pagina anterior");
		jsredireccionar("goMylove('#container','../system/class/download.php?id=$id')",3000);
	}
?>