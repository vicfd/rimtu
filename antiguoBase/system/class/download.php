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

			<div style="font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; color: #1c8cda; font-size: 30px; margin:80px 0px 0px 0px">
				<?php comprimirnombre($archivo[1]); ?>
			</div>
			<div style="height: auto; width: 238px; margin:40px 0px 0px 0px">
				<div class="Blanco border-round" style="padding: 20px 10px 20px 10px">
					<a href="../system/script/function_download.php?&id=<?php imprimir($_GET['id']); ?>">
						<img src= "../system/style/descarga.png" width="78" height="78" border="0" align="middle" alt="" />
					</a>
				</div>
			</div>
			
			<div style="float: none; height: auto; width: 600px; margin-top:100px">
				<div class="Blanco border-round" style="padding: 20px 10px 10px 10px; color: #006699">
					<table width="550" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px">	
						<tr>
							<td>
								Carpeta
							</td> 
							<td>
								<div align="right" style="height: auto; width: 380px">
									<textarea cols="58" rows="1" style="max-height: 100px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "folder/" . $archivo[2]); ?></textarea>
								</div>
							 </td>
						</tr>

						<tr>
							<td>								
								Link
							</td>
							 <td>
								<div align="right" style="height: auto; width: 380px; padding-top: 10px">
									<textarea cols="58" rows="1" style="max-height: 100px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "download/" . $_GET['id']); ?></textarea>
								</div>
							</td>
						</tr>						
					</table>
					<a href="javascript:;" onclick="goMylove('#container','../system/class/home.php','/index.html')" style="color:#006699">Pulse aquí para subir otro archivo</a> | 											
					<a href="" style="color:#006699" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Reportar Archivo: <?php comprimirnombre($archivo[1]); ?>', wrapperClassName: 'titlebar' } )">Reportar</a>
					<div class="highslide-maincontent" align="center">
						<form id="form_report" action="javascript:;" onsubmit="return hs.close(this),reportFile('<?php imprimir($_GET['id']); ?>',$('#file_mail').val(),$('#file_type').val(),$('#file_reason').val())">
							<br />
							<input id="file_mail" type="text" value="Su Correo Electronico" style="width:170px"/>
								<br />
							<select id="file_type" style="width:180px">
								<option>Copyright</option>
								<option>Contenido Inadecuado</option>
							</select>
								<br />
							<textarea id="file_reason" cols="10" rows="1" id="razon" style="width:170px; height: 100px;">Razon...</textarea>
								<br />
								<br />
							<input name="submit" type="submit" class="Boton grande azul" value="Reportar" />
						</form>
					</div>	
				</div>
			</div>	
		<?php 
		}
		else	
			jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
	}
	else	
		jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
?>