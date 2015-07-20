<?php
	include_once '../class.php';

	if (!empty($_GET['id'])) 
	{
		if(!empty($_GET['sql']))
		{
			if($_SESSION['nivel'] == 3)
			{
				$db->DeleteDb("reporte","id='".addslashes($_GET['sql'])."'");
				redireccionar("./admin/index.html?id=1");
			}
		}
		else
		{
			$exist = $db->SelectDb("count(*)","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
			
			if($exist[0] > 0)
			{
				$archivo = $db->SelectDb("usuario,extension,size","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
				
				if (is_img($archivo[1])) 
					$dir = '../../uploads/'. $_GET['id'] . $archivo[1];
				else 
					$dir = '../../uploads/' . $_GET['id']; 

				$db->UpdateDb("usuarios","size = size-'$archivo[2]'","usuario = '".addslashes($_SESSION['usuario'])."'");
				$db->DeleteDb("archivos","ftp='".addslashes($_GET['id'])."'");
				$db->DeleteDb("reporte","archivo='".addslashes($_GET['id'])."'");
				
				if(file_exists($dir) && ($_SESSION['usuario'] == $archivo[0] || $_SESSION['nivel'] == 3))
				{
					if(unlink($dir)) 
					{
						if(!empty($_GET['admin']))
							redireccionar("./admin/index.html?id=1");
						else
							imprimir("Archivo eliminado correctamente");
					}
				}
				else
					imprimir("Archivo eliminado de la base de datos");
			}
			else
				imprimir("El archivo no pudo ser eliminado");
		}
	}
?>