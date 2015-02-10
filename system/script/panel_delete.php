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
					$dir = '../../ficheros/'. $_GET['id'] . $archivo[1];
				else 
					$dir = '../../ficheros/' . $_GET['id']; 

				$db->UpdateDb("usuarios","size = size-'$archivo[2]'","usuario = '".addslashes($_SESSION['usuario'])."'");
				$db->DeleteDb("archivos","ftp='".addslashes($_GET['id'])."'");
				$db->DeleteDb("reporte","archivo='".addslashes($_GET['id'])."'");
				
				if(file_exists($dir) && ($_SESSION['usuario'] == $archivo[0] || $_SESSION['nivel'] == 3))
				{
					if(unlink($dir)) 
					{
						if(!empty($_GET['admin']))
							redireccionar("./admin/index.html?id=1");
						else if(empty($_GET['v']))
							jsredireccionar("javascript:goMylove('#container','../system/class/panel.php?id=1&remove=1')");
						else
							jsredireccionar("javascript:goMylove('#container','../system/class/panel.php?id=".$_GET['v']."&remove=1')");
					}
				}
				else
					jsredireccionar("javascript:goMylove('#container','../system/class/panel.php?id=1&remove=2')");
			}
			else
				jsredireccionar("javascript:goMylove('#container','../system/class/panel.php?id=1&remove=3')");
		}
	} 
	else 
		jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
?>