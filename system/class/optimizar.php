 <?php
	
	include_once '../class.php';
	
	if(isAdmin())
	{
		echo "<h1>Comprobar estado FTP</h1>";
		
		$dir = "../../ficheros/";
		$ach = scandir($dir);
		$cnt = count($ach);
		for($i=0;$i<$cnt;$i++)
		{
			if(!in_array($ach[$i], array(".","..")))
			{
				$original = $ach[$i];
				if(strstr($ach[$i],'.'))
					$ach[$i] = substr($ach[$i],0, strrpos($ach[$i],'.'));
				$exist = $db->SelectDb("count(*)","archivos","WHERE ftp='".addslashes($ach[$i])."'");
				if($exist[0] == 0)
				{
					if(unlink($dir . $original)) 			
						echo "Borrado excedente " . $ach[$i] . "<br>";
				}/*
				else
					echo "Existe " . $ach[$i] . "<br>";*/
			}
				
		}
		
		echo "<h1>Comprobar estado BD</h1>";
		
		$query = mysql_query("SELECT ftp,extension FROM archivos");
		$check = $db->SelectDb("count(*)","archivos");
		
		for($i=0;$i<$check[0];$i++)
		{
		
		if (is_img(mysql_result($query, $i, 1))) 
			$dir = '../../ficheros/'. mysql_result($query, $i, 0) . mysql_result($query, $i, 1);
		else
			$dir = '../../ficheros/'. mysql_result($query, $i, 0);
		
			if(!file_exists($dir))
			{
				mysql_query("DELETE FROM archivos WHERE ftp='".mysql_result($query, $i, 0)."'");
				echo "Borrado excedente " . mysql_result($query, $i, 0) . "<br>";
			}/*
			else
				echo "Existe " . mysql_result($query, $i, 0) . "<br>";*/
		}
		
		echo "<h1> Recalculado espacio de usuarios </h1>";
		
		$query = mysql_query("SELECT usuario FROM usuarios");
		$check = $db->SelectDb("count(*)","usuarios");
		
		for($i=0;$i<$check[0];$i++)
		{
			$size = mysql_query("SELECT sum(size) FROM archivos where usuario='".addslashes(mysql_result($query, $i))."'");
			$size = mysql_fetch_row($size);
			mysql_query("UPDATE usuarios SET size = '$size[0]' WHERE usuario = '".addslashes(mysql_result($query, $i))."'");
			echo "Recalculado espacio " . mysql_result($query, $i) . "<br>";
		}
	}
?> 