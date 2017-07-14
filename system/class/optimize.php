 <?php
 
	if ($_SESSION['client_level'] < 3) 
	{
		echo "<p class='alert alert-danger'>Debe ser adminsitrador para poder entrar al panel de administración</p>";
		exit;
	}
	
	echo "<h1>Comprobar estado FTP</h1>";

	$dir = "uploads/";
	$ach = scandir($dir);
	$cnt = count($ach);
	for($i=0;$i<$cnt;$i++)
	{
		if(!in_array($ach[$i], array(".","..")))
		{
			//$original = $ach[$i];
			$ach[$i] = substr($ach[$i],0, strrpos($ach[$i],'.'));
			
			if($db->query("SELECT * FROM files WHERE file_ftp='".$ach[$i]."'")->num_rows == 0)
			{
				echo "Sobra en ftp " . $ach[$i] . "<br>";
				/*
					if(unlink($dir . $original)) 			
						echo "Borrado excedente " . $ach[$i] . "<br>";
				*/
			}
		}		
	}
	
	echo "<h1>Comprobar estado BD</h1>";
	
	$check = $db->query("SELECT file_ftp, file_extension FROM files WHERE file_active=1");
	
	while($row = $check->fetch_row())
	{
		$dir = 'uploads/'. $row[0] . $row[1];
	
		if(!file_exists($dir))
		{
			//mysql_query("DELETE FROM archivos WHERE ftp='".mysql_result($query, $i, 0)."'");
			echo "Sobra " . $row[0] . "<br>";
		}
	}
	
	echo "<h1> Recalculado espacio de usuarios </h1>";
	
	$query = mysql_query("SELECT usuario FROM usuarios");
	$check = $db->SelectDb("count(*)","usuarios");
	
	/*
		for($i=0;$i<$check[0];$i++)
		{
			$size = mysql_query("SELECT sum(size) FROM archivos where usuario='".addslashes(mysql_result($query, $i))."'");
			$size = mysql_fetch_row($size);
			mysql_query("UPDATE usuarios SET size = '$size[0]' WHERE usuario = '".addslashes(mysql_result($query, $i))."'");
			echo "Recalculado espacio " . mysql_result($query, $i) . "<br>";
		}
	*/
?> 