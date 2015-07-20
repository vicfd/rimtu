<?php
	include_once '../class.php';

	if (isset($_GET['id'])) 
	{
		$id = injection($_GET['id']);
		
		$user = $db->SelectDb("nombre","archivos","WHERE id='$id'");
		
		echo $user[0];
	}
?>