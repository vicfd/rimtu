<?php
	include_once '../class.php';

	if (isset($_POST["id"]) && isset($_POST["name"])) 
	{
		$id = !get_magic_quotes_gpc() ? addslashes($_POST['id']) : $_POST['id']; $id = injection($id);
		$nombre = !get_magic_quotes_gpc() ? addslashes($_POST['name']) : $_POST['name']; $nombre = injection($nombre);
		
		$user = $db->SelectDb("usuario","archivos","WHERE id='$id'");
		
		if ($user[0] == $_SESSION['usuario']) 
		{
			if($nombre == null)
				$nombre = "Default";
				
			$db->UpdateDb("archivos","nombre = '$nombre'","id = '$id'");
			redireccionar("panel/1");
		}
	}
?>