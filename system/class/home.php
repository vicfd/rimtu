	<?php
		$data = $db->query("SELECT client_type_size, client_type_space, client_type_extension FROM clients_type WHERE client_type_level=".addslashes($_SESSION['client_level']))->fetch_row();
	?>
	<script type="text/javascript">
		var folder_id = hex_md5((Math.round(Math.random()*1000),((new Date()).getTime() / 1000)).toString()).substring(0, 199);
		$(function() {
			$('#file_upload').uploadifive({
				'auto'     			: false,
				'formData' 			: {'folder_id' : folder_id},
				'fileSizeLimit' 	: '200MB',
				'fileType' 			: 'image/*',
				'buttonText'   		: 'Elegir archivos',
				'buttonClass'		: 'btn btn-primary',
				'queueSizeLimit' 	: 20,
				'width'				: "100%",
				'removeCompleted' 	: true,
				'multi'        		: true,
				'uploadScript'		: '/system/script/function_upload.php',
				'queueID'			: 'queue',
				'onAddQueueItem' 	: function(file){
					var file_extension = file.name.substring(file.name.lastIndexOf('.') + 1);
					var extensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
					if(!extensions.includes(file_extension.toLowerCase()))
					{
						alert("Solo se permite subir imagenes");
						$('#file_upload').uploadifive('cancel', file);
					}
				},				
				'onUploadError' 	: function(file, errorCode, errorMsg, errorString) {alert('El archivo de nombre ' + file.name + ' no pudo ser subido: ' + errorString);},
				'onUploadComplete' 	: function(file, data) {redireccionar('./folder/'+folder_id, 0);}
			});
		});
	</script>	
	<?php
		if($maintenance == 1)
		{

			echo "<p class='alert alert-danger'>En este momento nos encontramos en mantenimiento, volvemos lo antes posible</p>";
			exit;
		}

		if (canUpload($db, $_SESSION['client_id'], $data[1]))
		{
			?>
				<div class='panel panel-default'>
					<div class='panel-body'>
						<form class="bs-example bs-example-bg-classes">
							<div id="queue"></div>
							<input id="file_upload" name="file_upload" type="file" multiple="true" />
								<br />
								<br />
							<a style="position: relative;" href="javascript:$('#file_upload').uploadifive('upload')"><button type="button" class="btn btn-primary" style="width: 100%">Comenzar subida</button></a>
						</form>
					</div>
				</div>
			<?php
		}
		else
		{
			echo
			'
				<div id="banner">
					<h2>No tienes permitido subir m&aacute;s im&aacute;genes, tienes todo tu espacio ocupado</h2>
				</div>
			';
		}
	?>