<?php

	if ($_SESSION['client_level'] < 3) 
	{
		echo "<p class='alert alert-danger'>Debe ser adminsitrador para poder entrar al panel de administración</p>";
		exit;
	}
	
	if(isset($_POST['maintenance']))
	{		
		$config = file("system/config.php");
		$text ="";
		foreach ($config as $row)
		{
			if(strpos($row, 'maintenance'))
			{
				$maintenance = '$maintenance=';
				if(strpos($row, '0'))
				{	
					$row = $maintenance . "1;\n";
					$maintenance = 1;
				}
				else
				{
					$row = $maintenance . "0;\n";
					$maintenance = 0;
				}
			}
			$text .= $row;
		}	
		
		$file = fopen("system/config.php","w+");
		fwrite($file, $text);
		fclose($file);
	}
	
	$maintenance_text = ($maintenance == 0) ? "Mantenimiento activo" : "Mantenimiento desactivado";

	echo
	"
		<form method='post' class='bs-example bs-example-bg-classes'>
			<input name='maintenance'type='submit' class='form-control' value='$maintenance_text'>
		</form>
		<br />
	";
	
	$number_files = $db->query("SELECT * FROM files_report WHERE report_active=1");
	$number_pages = ceil($number_files->num_rows/10);
	
	if (empty($id) || $id <= 0 || $id > $number_pages)
		$id = 1;
	
	if ($number_files->num_rows == 0)
		echo "<p class='alert alert-info'>No hay ningún reporte</p>";
	else
	{
		$first = ($id > 1) ? ($id - 1) * 10 : 0;

		echo
		"
			<div class='panel panel-default'>
				<table id='files_table' class='table table-hover'>
					<tr>
						<th>Id del archivo</th>
						<th>Nombre del archivo</th>
						<th>Ftp del archivo</th>
						<th></th>
					</tr>
		";
		
		$data = $db->query("SELECT report_id, file_id, report_reason FROM files_report WHERE report_active=1 order by file_id LIMIT $first, 10");		
		
		while($row = $data->fetch_row()) 
		{
			$file = $db->query("SELECT file_name, file_ftp FROM files WHERE file_id='$row[1]'")->fetch_row();
			?>
				<tr id="row_<?php echo $row[0]; ?>">
					<th data-toggle="modal" data-target="#reason<?php echo $row[0]; ?>"><?php echo comprimirnombre($row[1])?></th>
					<th data-toggle="modal" data-target="#reason<?php echo $row[0]; ?>"><?php echo comprimirnombre($file[0])?></th>
					<th data-toggle="modal" data-target="#reason<?php echo $row[0]; ?>"><?php echo comprimirnombre($file[1])?></th>
					<th style="text-align: right;">
						<a href="<?php echo $script_dir . "function_download.php?id=" . $file[1]; ?>"><img src= "<?php echo $images_dir; ?>download.png" width="25" height="25" border="0" align="middle" alt="" /></a>
						<img src="<?php echo $images_dir; ?>remove.png" data-toggle="modal" data-target="#fileremove<?php echo $row[0]; ?>" border="0" align="middle" alt="" />
					</th>
				</tr>

				<div class="modal fade" id="reason<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Nombre de archivo: <?php echo comprimirnombre($file[0]); ?></h4>
							</div>
							<div class="modal-body">
								<textarea rows="4" class="form-control" style="resize: none" placeholder="Razón"><?php echo $row[2]; ?></textarea>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
							</div>
						</div>
					</div>
				</div>	

				<div class="modal fade" id="fileremove<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Nombre de archivo: <?php echo comprimirnombre($row[1]); ?></h4>
							</div>
							<div class="modal-body">
								Mediante esta ventana podrá eliminar el fichero seleccionado.
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary" data-dismiss='modal' onclick="deletereport(<?php echo $row[0]; ?>, 0, <?php echo $id; ?>)">Eliminar reporte</button>
								<button type="button" class="btn btn-primary" data-dismiss='modal' onclick="deletereport(<?php echo $row[0]; ?>, 1, <?php echo $id; ?>)">Eliminar archivo</button>
							</div>
						</div>
					</div>
				</div>											
			<?php
		}
		
		echo 
		"
				</table>
			</div>
			<nav aria-label='Page navigation'>
				<ul class='pagination'>
		";
		
		$first = $id - 4;
		$last = $id + 4;

		if($id > 5)
		{
			echo
			"
				<li>
					<a href='/panel/1' aria-label='First'>
						<span aria-hidden='true'>&laquo;</span>
					</a>
				</li>
			";
		}

		if($id > 1)
		{
			echo
			"
				<li>
					<a href='/panel/".($id-1)."' aria-label='Previous'>
						<span aria-hidden='true'>&lsaquo;</span>
					</a>
				</li>
			";
		}

		for ($i=1; $i<=$number_pages; $i++) 
		{
			if ($i >= $first && $i <= $last) 
			{
				if ($i == $id) 
				{ 
					echo
					"
						<li class='active'>
							<a href='#'>
								$i
								<span class='sr-only'>(current)</span>
							</a>
						</li>
					";
				} 
				else 
				{
					echo
					"
						<li>
							<a href='/panel/$i'>$i</a>
						</li>
					";
				}
			}
		}

		if($id < $number_pages)
		{
			echo
			"
				<li>
					<a href='/panel/".($id+1)."' aria-label='Next'>
						<span aria-hidden='true'>&rsaquo;</span>
					</a>
				</li>				
			";
		}
		
		if(($id + 4) < $number_pages)
		{
			echo
			"
				<li>
					<a href='/panel/$number_pages' aria-label='Last'>
						<span aria-hidden='true'>&raquo;</span>
					</a>
				</li>
			";
		}
		
		echo
		"
				</ul>
			</nav>
		";
	}
?>