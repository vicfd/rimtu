	<?php
		include_once '../class.php';
		$data = $db->SelectDb("size,extension","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
	?>
	<script type="text/javascript">
		var codigo = hex_md5((Math.round(Math.random()*1000),((new Date()).getTime() / 1000)).toString()).substring(0, 20);
		$(function() {
			$("#file_upload").uploadify({
				'auto'     			: true,
				'buttonText' 		: 'SUBIR ARCHIVOS',
				'formData' 			: {'carpeta' : codigo, 'usuario' : '<?php echo $_SESSION['usuario']; ?>'},
				'fileSizeLimit' 	: '<?php echo $data[0]; ?>',
				'fileTypeExts' 		: '<?php echo $data[1]; ?>',
				'uploadLimit' 		: 100,
				'removeTimeout' 	: 100,
				'width' 			: 370,
				'swf'              	: '/system/library/uploadify.swf',
				'uploader'			: '/system/script/home_upload.php',
				'queueID'			: 'file_queue',	
				'onUploadError' 	: function(file, errorCode, errorMsg, errorString) {alert('El archivo de nombre ' + file.name + ' no pudo ser subido: ' + errorString);},
				'onQueueComplete'  	: function() {setTimeout ("goMylove('#container','../system/class/folder.php?id='+codigo,'/folder/'+codigo)", 1000);}
			});
		});
	</script>	
	<?php
		if($config[2] == 1)
		{
			echo
			'
				<div class="Gradiente" align="left" style="width: 325px; padding: 10px 10px 10px 10px">
					No permitimos la subida de archivos por ahora, estamos de mantenimiento volvemos pronto.
				</div>
			';
			exit;
		}

		if (canUpload($db))
			echo
			'
				<div class="Gradiente" align="left" style="height: 160px; width: 375px; padding: 10px 10px 10px 10px">
					<input type="file" name="file_upload" id="file_upload" />
					<div id="file_queue"></div>
				</div>
			';
		else
			echo
			'
				<div class="Gradiente" align="left" style="width: 375px; padding: 10px 10px 10px 10px">
					Por hoy no tienes permitidos subir más informacion borra archivos o en el caso de ser un usuario anónimo create una cuenta
				</div>
			';

		if (isVisitor()) 
		{
			$exist = $db->SelectDb("count(*)","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
			
			if ($exist[0] > 0)
			{	
				$data = $db->SelectDb("size","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
				$space = $db->SelectDb("space","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
				
				$porcentaje = number_format((($data[0]*100)/$space[0]) * 2.6,2);
				$division = $data[0] / 1048576; 

				if ($porcentaje > 260) 
					$porcentaje = 260;
					
				if ($division > 100) 
				{
					$tas = 100;
					$division = 100;							
				}
				else 
					$tas = round($division, 2, PHP_ROUND_HALF_DOWN);
				
				echo '
					<div class="Gradiente" style="margin-top: 10px; padding: 20px 10px 20px 10px; width: 290px" align="center">
						<div id="barra2" class="barra_progreso">
							<div class="barra_arriba" style="clip:rect(0px, '.$porcentaje.'px, auto, 0px);">
								'.$tas.' mb de 100 mb		
							</div>
							<div class="barra_abajo">
								'.$tas.' mb de 100 mb
							</div>
						</div>
					</div>
				';
			}
		}
	?>