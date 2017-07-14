<?php
	if ($_SESSION['client_level'] == 0) 
	{
		echo "<p class='alert alert-danger'>Debe identificarse para poder entrar al panel de usuario</p>";
		exit;
	}	

	$data = $db->query("SELECT client_file_size_upload FROM clients WHERE client_username='".$_SESSION['client_username']."'")->fetch_row();
	$space = $db->query("SELECT client_type_space, client_type_text FROM clients_type WHERE client_type_level='".$_SESSION['client_level']."'")->fetch_row();
	$size = number_format($data[0]/$space[0], 2) * 100;
	
	echo 
	"

		<p class='alert alert-success'>".number_format($data[0]/1048576, 2)." mb de ".$space[1]."</p>
		<div class='progress'>
			<div class='progress-bar progress-bar-success progress-bar-striped' style='width: ".$size."%'></div>
			<div class='progress-bar progress-bar-warning progress-bar-striped' style='width: ".(100-$size)."%'></div>
		</div>
		<div class='btn-group btn-group-justified' role='group'>
			<div class='btn-group' role='group'>
				<a href='/info'><button type='button' class='btn btn-default'>Informacción de cuenta</button></a>
			</div>
			<div class='btn-group' role='group'>
				<a href='/password'><button type='button' class='btn btn-default'>Cambiar contraseña</button></a>
			</div>
			<div class='btn-group' role='group'>
				<a href='/email'><button type='button' class='btn btn-default'>Cambiar correo</button></a>
			</div>
		</div>
			<br />
		<div id='alert' style='display: none'></div>
	";

	$number_files = $db->query("SELECT * FROM files WHERE client_id='".$_SESSION['client_id']."' && file_active=1")->num_rows;
	$number_pages = ceil($number_files/10);
	
	if (empty($id) || $id <= 0 || $id > $number_pages)
		$id = 1;
	
	if ($number_files == 0)
		echo "<p class='alert alert-info'>No tiene ningun archivo</p>";
	else
	{
		$first = ($id > 1) ? ($id - 1) * 10 : 0;

		echo
		"
			<div class='panel panel-default'>
				<table id='files_table' class='table table-hover'>
					<tr>
						<th>Nombre de archivo</th>
						<th></th>
					</tr>
		";
		
		$data = $db->query("SELECT file_id, file_name, file_ftp, file_folder_id FROM files WHERE client_id='".$_SESSION['client_id']."' && file_active=1 order by file_id LIMIT $first, 10");		
		
		while($row = $data->fetch_row()) 
		{
			?>
				<tr id="row_<?php echo $row[0]; ?>">
					<th id="name_<?php echo $row[0]; ?>" data-toggle="modal" data-target="#filename<?php echo $row[0]; ?>"><?php echo comprimirnombre($row[1])?></th>
					<th style="text-align: right;">
						<a href="<?php echo $script_dir . "function_download.php?id=" . $row[2]; ?>"><img src= "<?php echo $images_dir; ?>download.png" width="25" height="25" border="0" align="middle" alt="" /></a>
						<a href="/folder/<?php echo $row[3]; ?>"><img src= "<?php echo $images_dir; ?>folder.png" border="0" align="middle" alt="" /></a>
						<img src="<?php echo $images_dir; ?>remove.png" data-toggle="modal" data-target="#fileremove<?php echo $row[0]; ?>" border="0" align="middle" alt="" />
					</th>
				</tr>

				<div class="modal fade" id="filename<?php echo $row[0]; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Nombre de archivo: <?php echo comprimirnombre($row[1]); ?></h4>
							</div>
							<div class="modal-body">
								<input id="filename_<?php echo $row[0]; ?>" type="text" class="form-control" name="password" placeholder="Nombre de archivo">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary" data-dismiss='modal' onclick="changefilename(<?php echo $row[0]; ?>, $('#filename_<?php echo $row[0]; ?>').val())">Cambiar nombre</button>
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
								<button type="button" class="btn btn-primary" data-dismiss='modal' onclick="deletefile(<?php echo $row[0]; ?>)">Eliminar archivo</button>
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