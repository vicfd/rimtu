<?php
	include_once '../class.php';
	
	if(isAdmin())
	{
		switch($config[2])
		{
			case 0:
				$update = ("UPDATE config SET mantenimiento=1");
				break;			
			case 1:
				$update = ("UPDATE config SET mantenimiento=0");
		}
		mysql_query($update) or die(mysql_error());
	}
	jsredireccionar("javascript:goMylove('#container','/system/class/admin.php?id=1')");
?>