<?php
	include_once '../class.php';
	
	if (isset($_GET['id']))
	{
		$exist = $db->SelectDb("count(*)","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
		
		if($exist[0] != 0)
		{
			$id = $_GET['id'];
			$datos = $db->SelectDb("id,nombre,extension","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
			
			if (is_img($datos[2])) 
				$id = $_GET['id'] . $datos[2];
				
			$datos[1] = str_replace(array(' ',','),'_',$datos[1]);
			
			$link = $datos[1] . $datos[2];
			$id = '../../ficheros/' . $id;
			
			descargado($datos[0],$db);
			recargarTiempo($dato[0],$db);
			
			switch($datos[2])
			{
				case ".pdf": $ctype="application/pdf"; break;
				case ".exe": $ctype="application/octet-stream"; break;
				case ".zip": $ctype="application/zip"; break;
				case ".doc": $ctype="application/msword"; break;
				case ".xls": $ctype="application/vnd.ms-excel"; break;
				case ".ppt": $ctype="application/vnd.ms-powerpoint"; break;
				case ".gif": $ctype="image/gif"; break;
				case ".png": $ctype="image/png"; break;
				case ".jpeg": $ctype="image/png"; break;
				case ".jpg": $ctype="image/jpeg"; break;
				default: $ctype="application/octet-stream";
			}
			 
			header("Pragma: public"); 
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Type: $ctype");
			header("Content-Disposition: attachment; filename=".$link.";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($id));
			ob_clean();
			flush();
			readfile($id);
		}
	}
	else
		redireccionar("index.html");
?>