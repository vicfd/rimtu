<?php
	include_once '../class.php';
	
	/*
	max_execution_time=14400
	upload_max_filesize=4194304000
	post_max_size=5242880000
	*/

	if (isset($_POST["usuario"]) && isset($_POST["carpeta"]) && isset($_FILES)) 
	{
		$usuario = $_POST['usuario'];
		$carpeta = $_POST['carpeta'];
		$archivo = $_FILES['Filedata']['name'];
		$subir = true;
		
		$extension = '.'.pathinfo($archivo, PATHINFO_EXTENSION);
		$nombre = injection(basename($archivo, $extension));  
		
		$ftp =  substr(md5($nombre.time()), 0, 20);

		$nombre = utf8_decode($nombre);
		$nombre = strtr($nombre, utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ'), 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby');
		
		
		$data = $db->SelectDb("nivel","usuarios","WHERE usuario like '$usuario'");
		$numero = $db->SelectDb("count(numero)","archivos","WHERE carpeta='".addslashes($carpeta)."'");
		$extension = mb_strtolower(".".pathinfo($archivo, PATHINFO_EXTENSION));

		if (is_img($extension))
			$targetFile = '../../uploads/' . $ftp . $extension;
		else
			$targetFile = '../../uploads/' . $ftp;
			
		switch($data[0])	
		{
			case 0:
			case 1:
			case 2:
				if (!is_img($extension))
					$subir = false;
				break;				
		}
		
		if (move_uploaded_file($_FILES['Filedata']['tmp_name'],$targetFile) && $subir)
		{
			if (isVisitor()) 
			{
				$ip_exist = $db->SelectDb("count(*)","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
				
				if ($ip_exist[0] == 0)
					$db->InsertDb("anonimo","ip, size","'".$_SERVER['REMOTE_ADDR']."','".$_FILES['Filedata']['size']."'");
				else
					$db->UpdateDb("anonimo","size=size+".addslashes($_FILES['Filedata']['size']),"ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
			}
			$db->UpdateDb("usuarios","size=size+".addslashes($_FILES['Filedata']['size']),"usuario='".addslashes($usuario)."'");
			$db->InsertDb("archivos","nombre, extension, size, ftp, carpeta, numero, ip, usuario, nivel, subido, expira","'$nombre','$extension','".$_FILES['Filedata']['size']."','$ftp','$carpeta','$numero[0]','".$_SERVER['REMOTE_ADDR']."','$usuario','$data[0]','".addslashes(date("Y-m-d h:i:s"))."','".(date("Y-m-d h:i:s", $m=strtotime('+1 month')))."'");	
		}
	}
?>