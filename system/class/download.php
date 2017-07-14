<?php
	if(empty($id)) 
	{
		redireccionar("../index.html");
		exit;
	}
	
	$id = injection($db, $_GET['id']);
	$file = $db->query("SELECT file_id, file_name, file_extension, file_ftp, file_view, file_download FROM files WHERE file_ftp='$id'");
	$row_cnt = $file->num_rows;	
	
	if($row_cnt == 0)
	{
		redireccionar("../index.html");
		exit;
	}
	
	if($row = $file->fetch_row())
	{
		file_view($db, $row[0]);
		file_date_renew($db, $row[0]);
		
		$image = '../../uploads/' . $row[3] . '.' . $row[2];
		
		echo 
		"	
			<center>
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
			</center>
		";
	}
?>