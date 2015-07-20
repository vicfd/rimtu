<?php
	include_once '../class.php';
	include_once '../language/esES.php';

	if(isset($_GET['id'])) 
	{ 
		$exist = $db->SelectDb("count(*)","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
		
		if($exist[0] > 0)
		{
			$archivo = $db->SelectDb("id,nombre,carpeta","archivos","WHERE ftp='".addslashes($_GET['id'])."'");
			visto($archivo[0],$db);
			recargarTiempo($archivo[0],$db);
			?>
			<center>
				<div id="banner" style="margin-top:-10%;">
					<h2><?php comprimirnombre($archivo[1]); ?></h2>
				</div>
				<div style="float: none; width: 80%;">
					<div class="Blanco border-round" style="padding: 20px 0px 20px 0px; margin-top: -10%">
						<textarea cols="58" rows="1" style="width:90%; margin-bottom: 5px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "folder/" . $archivo[2]); ?></textarea>
						<textarea cols="58" rows="1" style="width:90%; margin-bottom: 5px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "download/" . $_GET['id']); ?></textarea>
						<a href="../system/script/function_download.php?&id=<?php imprimir($_GET['id']); ?>">
							<button class="btn" style="width:90%; margin-bottom: 5px;">Descargar Archivo</button>
						</a>
						<button class="btn" style="width:90%; margin-bottom: 5px;" onclick="FilereportFile('<?php imprimir($_GET['id']); ?>')">Reportar Archivo</button>
						<button class="btn" style="width:90%" onclick="goMylove('#container','<?php echo $config[3] . "home.php"; ?>','<?php echo "/index.html"; ?>')"><?php imprimir($carpeta_1); ?></button>
					</div>
				</div>	
			</center>
		<?php 
		}
		else	
			jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
	}
	else	
		jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
?>