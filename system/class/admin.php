<?php
	include_once '../class.php';
			
	function maintenance($cadena)
	{
		echo
		'
			<form method="post" action="javascript:;" onsubmit="doMaintenance()">
				<input id="do_maintenance" class="Boton mediano azul" value="'.$cadena.'" type="submit"/>
			</form>
			<br />
		';
	}

	if(isAdmin())
	{
		switch($config[2])
		{
			case 0:
				$cadena = "Mantenimiento Off";
				break;
			case 1:
				$cadena = "Mantenimiento On";
				break;
		}
		maintenance($cadena);	
		
		if (empty($_GET['id']))
			jsredireccionar("javascript:goMylove('#container','/system/class/admin.php?id=1')");
		else
		{
			?>
			<div style="height: 340px; width: 590px; margin-left: 20px;" align="left">
				<?php
		
			$id = injection($_GET['id']);
			$numero = $db->SelectDb("count(*)","reporte");
			$repetir = ceil(($numero[0]/10));
			if (empty($repetir)) 
			{ 
				$repetir = 1;
				echo '
					<div class="row" style="padding: 6px 10px 6px 10px">
						No tiene ningun reporte
					</div>
				';
			} 
			
			if ($id > $repetir or $id <= 0) 
				jsredireccionar("javascript:goMylove('#container','/system/class/admin.php?id=1')");
			else 
			{
				$ultimo = $id . 0;
				$primero = $ultimo - 10; 
				
				if ($repetir == $id) 
				{
					$ultimo = $ultimo - $numero[0];
					$ultimo = 10 - $ultimo;
				} 
				else 
					$ultimo = 10;
				
				for ($l=1; $l<=$ultimo; $l++) 
				{
					$archivo = $db->SelectDb("id,archivo,tipo,correo,razon","reporte","ORDER BY id LIMIT $primero, $ultimo");
					?>
					
						<div class="row" style = "height:30px; padding: 3px 10px 3px 10px; color: #000000;"> 
							<table height="20" border="0">
								<td width="700" style="padding: 5px 0px 0px 0px">
									<a href="javascript:;" onclick="goMylove('#container','../system/class/download.php?id=<?php imprimir($archivo[1]); ?>','/login/')" class="admin" ><?php echo 'Archivo: ' . $archivo[1]; ?></a>
									
									<a href="#" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Cambiar contrase&ntilde;a:', wrapperClassName: 'titlebar' } )" class="admin" title="Razon">Razon</a>
									<div class="highslide-maincontent" align="center" style="padding-top:25px">
										<?php echo 'Correo: ' . $archivo[3] . '<br />Tipo: ' . $archivo[2] . '<br />Razon: ' . $archivo[4]; ?>
											<br />
											<br />
										<a href="../function.php?type=3&id=<?php echo $archivo[1]; ?>&admin=true" class="admin" style="margin-right: 30px">Borrar Archivo</a>
										<a href="../function.php?type=3&id=<?php echo $archivo[1]; ?>&sql=<?php echo $archivo[0] ?>" class="admin" style="margin-right: 30px">Borrar SQL</a>
									</div>
								</td>
							</table>
						</div>
					<?php
					$primero++;
				}

				$bajo = $id - 4;
				$alto = $id + 4;
				
				if($id > 5)
				{
					?>
						<a href="index.php?id=1" style="color:#006699">
							<div class="active border-round">
								<<
							</div>
						</a>
					<?php
				}
				
				if($id > 1)
				{
					?>
						<a href="index.php?id=<?php imprimir($id-1); ?>" style="color:#006699">
							<div class="active border-round">
								<
							</div>
						</a>
					<?php
				}							
				
				for ($i=1; $i<=$repetir; $i++) 
				{
					if ($i >= $bajo && $i <= $alto) 
					{
						if ($i == $id) 
						{ 
						?>
							<div class="desactive border-round">
								<?php echo $i; ?>
							</div>
						<?php 
						} 
						else 
						{ 
						?>
							<a href="index.php?id=<?php imprimir($i); ?>" style="color:#006699">
								<div class="active border-round">
									<?php echo $i; ?>
								</div>
							</a>
						<?php 
						}
					}
				}
				
				if($id < $repetir)
				{
					?>
						<a href="index.php?id=<?php imprimir($id+1); ?>" style="color:#006699">
							<div class="active border-round">
								>
							</div>
						</a>
					<?php
				}
				
				if(($id + 5)< $repetir)
				{
					?>
						<a href="index.php?id=<?php imprimir($repetir); ?>" style="color:#006699">
							<div class="active border-round">
								>>
							</div>
						</a>
					<?php
				}
					?>
				</div>
				<?php
			}
		}
	}
	else
		jsredireccionar("javascript:goMylove('#container','/system/class/home.php')");
?>