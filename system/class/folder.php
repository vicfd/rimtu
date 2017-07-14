<center>
	<?php
		if (empty($_GET['id'])) 
		{
			echo "<p class='alert alert-danger'>La carpeta introducida no existe.</p>";
			exit;
		}
		
		$id = injection($db, $_GET['id']);
		$folder = $db->query("SELECT file_id, file_name, file_extension, file_ftp, file_view, file_download FROM files WHERE file_folder_id='$id' && file_active=1 ORDER BY file_id");
		$row_cnt = $folder->num_rows;
			
		if($row_cnt == 0)
		{
			echo "<p class='alert alert-danger'>La carpeta introducida no existe.</p>";
			exit;
		}
		
		echo 
		"
			<div class='input-group'>
				<span class='input-group-addon' id='basic-addon1'>Carpeta</span>
				<input type='text' class='form-control' value='".$domain."folder/".$id."' aria-describedby='basic-addon1'>
			</div>

			<br />
		
			<div class='btn-group btn-group-justified' role='group'>
				<div class='btn-group' role='group'>
					<button id='copyWeb' type='button' class='btn btn-default'>Enlaces web</button>
				</div>
				<div class='btn-group' role='group'>
					<button id='copyEnlaces' type='button' class='btn btn-default'>Enlaces directos</button>
				</div>
			</div>			
			<span id='copyAnswer'></span>
			
			<br />
			
			<div id='alert' style='display: none'></div>
		";
		
		$linksWeb = "";
		$linksDirect = "";
		
		while($row = $folder->fetch_row())
		{
			if(!empty($row[0]))
			{
				file_view($db, $row[0]);
				file_date_renew($db, $row[0]);
				
				$image = '../../uploads/' . $row[3] . '.' . $row[2];
				$linksWeb .=  $domain . "download/" . $row[3] . "\n";
				$linksDirect .= $domain . "uploads/" . $row[3] . '.' . $row[2] . "\n";
				
				echo
				"
					<div class='panel panel-default'>
						<div class='panel-body'>
							<img class='img-responsive' style='width: 30%' src='./$image' border='0' alt='' />
								<br />
							<a href='../system/script/function_download.php?id=$row[3]'><img src='".$images_dir."descarga.png"."' border='0' align='middle' alt='' /></a>
							<a href='/report/".$row[0]."'><img src='".$images_dir."reporte.png"."' border='0' align='middle' alt='' /></a>
							<p>Visto: <b>$row[4]</b> Descargado <b>$row[5]</b></p>
							
							<div class='input-group'>
								<span class='input-group-addon' id='basic-addon1'>Nombre</span>
								<input type='text' class='form-control' value='".$row[1]."' aria-describedby='basic-addon1'>
							</div>	
							<br />
							<div class='input-group'>
								<span class='input-group-addon' id='basic-addon1'>Enlace web</span>
								<input type='text' class='form-control' value='".$domain."download/".$row[3]."' aria-describedby='basic-addon1'>
							</div>					
							<br />
							<div class='input-group'>
								<span class='input-group-addon' id='basic-addon1'>Enlace imágen</span>
								<input type='text' class='form-control' value='" . $domain . "uploads/" . $row[3] . "." . $row[2] . "' aria-describedby='basic-addon1'>
							</div>
						</div>
					</div>
				";
			}
		}

		echo
		"
			<textarea id='enlacesWeb' style='display: none'>".$linksWeb."</textarea>
			<textarea id='enlacesDirectos' style='display: none'>".$linksDirect."</textarea>
		";
	?>
</center>

<script language="JavaScript">
	function copyToCliboard(txt) 
	{
		if (document.queryCommandSupported && document.queryCommandSupported("copy")) 
		{
			var textarea = document.createElement("textarea");
			textarea.textContent = txt;
			document.body.appendChild(textarea);
			textarea.select();
			
			try 
			{
				$("#alert").removeClass();
				$("#alert").addClass('alert alert-success');
				document.getElementById("alert").removeAttribute("style");
				document.getElementById("alert").innerHTML = 'Copiado con exito';
				setTimeout(function () {document.getElementById("alert").style.display = "none";}, 2000);
				return document.execCommand("copy");
			} 
			catch (ex)
			{
				$("#alert").removeClass();
				$("#alert").addClass('alert alert-danger');
				document.getElementById("alert").removeAttribute("style");
				document.getElementById("alert").innerHTML = 'Error al copiar';
				setTimeout(function () {document.getElementById("alert").style.display = "none";}, 2000);
				return false;
			} 
			finally 
			{
				document.body.removeChild(textarea);
			}
		}
	}

	document.getElementById('copyWeb').addEventListener('click', function(){copyToCliboard(document.getElementById('enlacesWeb').innerHTML);});
	document.getElementById('copyEnlaces').addEventListener('click', function(){copyToCliboard(document.getElementById('enlacesDirectos').innerHTML);});
</script>