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
				'height'			: 40,
				'width'				: 100,
				'uploadLimit' 		: 100,
				'removeTimeout' 	: 100,
				'swf'              	: '/system/assets/php/uploadify.swf',
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
				<div id="banner">
					<h2>En este momento nos encontramos en mantenimiento, volvemos lo antes posible</h2>
				</div>
			';
			exit;
		}
		
		if (isVisitor() && canUpload($db)) 
		{
			$exist = $db->SelectDb("count(*)","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
			
			if ($exist[0] > 0)
			{	
				$data = $db->SelectDb("size","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
				$space = $db->SelectDb("space","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
				
				$porcentaje = number_format((($data[0]*100)/$space[0]),2);
				$division = $data[0] / 1048576; 

				if ($porcentaje > 100) 
					$porcentaje = 100;
					
				if ($division > 100) 
				{
					$tas = 100;
					$division = 100;							
				}
				else 
					$tas = round($division, 2, PHP_ROUND_HALF_DOWN);
				
				echo '
				<div class="progress">
					<progress id="anonimo" style="width:100%" max="100" value=""></progress>
					<p style="margin-top:-2%">'.$tas.' mb de 100 mb</p>
				</div>
				<script type="text/javascript"> 
					animateprogress("#anonimo",'.$porcentaje.');
				</script>
				';
			}
		}

		if (canUpload($db))
			echo
			'
				<input type="file" name="file_upload" id="file_upload" />
				<div id="file_queue"></div>
			';
		else
		{
			echo
			'
				<div id="banner">
					<h2>No tienes permitido subir m&aacute;s im&aacute;genes, tienes todo tu espacio ocupado</h2>
				</div>
			';
			exit;
		}
	?>