	<?php
		include_once '../class.php';
	
		if (isUser()) 
		{
			$data = $db->SelectDb("size","usuarios","WHERE usuario='".addslashes($_SESSION['usuario'])."'");
			$space = $db->SelectDb("space,text","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
			$porcentaje = number_format((($data[0]*100)/$space[0]),2);
			$division = $data[0] / 1048576; 

			if ($porcentaje > 100) 
				$porcentaje = 100;
				
			if ($division > $space[0]) 
			{
				$tas = 100;
				$division = 100;							
			}
			else 
				$tas = round($division, 2, PHP_ROUND_HALF_DOWN);
			
			echo 
			'
			<div class="progress" style="margin-top: 40px;">
				<progress id="anonimo" style="width:80%" max="100" value=""></progress>
				<p style="margin-top:-2%">'.$tas.' mb de ' . $space[1] .'</p>
			</div>
			<script type="text/javascript"> 
				animateprogress("#anonimo",'.$porcentaje.');
			</script>
			';
		?>
			
				<div style="width: 80%; height: 350px; margin: 0 auto;">
					<div style="Float: left; width: 25%">
						<div class="Blanco border-round" style="height: auto; width: 100%; padding: 20px 0px 20px 0px;" align="center">
							<img src= "<?php imprimir($config[5]); ?>cara.png" width="78" height="78" border="0" align="middle" onclick="$('#popupAccount').w2popup()" alt=""  />
							<div id="popupAccount" style="display: none; width: 25%; height: 30%; overflow: hidden">
								<div rel="title">
									Informaci&oacute;n de cuenta
								</div>
								<div rel="body" style="padding-top: 5%; line-height: 150%">
									<center>
									<div style="width: 80%; margin-top:40px">
										<img src= "<?php imprimir($config[5]); ?>cara.png" width="78" height="78" border="0" align="middle" alt="" />
										<p>
											<?php
												echo 
												"
													Correo Eletr&oacute;nico: <b>".$_SESSION['email']."</b><br />
													Espacio de tu disco: <b>".ceil($data[0] / 1048576)."mb de ".$space[1]."</b><br />
													Usuario: <b>".$_SESSION['usuario']."</b>
												";
											?>
											</p>
										</div>
									</center>
								</div>
							</div>	
						</div>
						<div class="Blanco border-round" style="height: auto; width: 100%; margin-top: 40px; padding-top: 8%;">			
							<center>
								<button class="btn btn-red" style="width:80%" onclick="userChangePass()">Cambiar contrase&ntilde;a</button>
								<button class="btn btn-red" style="width:80%; margin-top: 8%; margin-bottom: 8%;" onclick="userChangeEmail()">Cambiar correo electr&oacute;nico</button>
							</center>
						</div>		
						

						<div id="temporal_message" style="font-size: 14px"></div>
					</div>
						
					<div style="Float: left; height: 100%; width: 73%; margin-left: 2%;" align="left">
						<?php
							if (empty($_GET['id']))
								jsredireccionar("javascript:goMylove('#container','/system/class/panel.php?id=1')");
							else
							{
								$id = injection($_GET['id']);
								$numero = $db->SelectDb("count(*)","archivos","WHERE usuario='".addslashes($_SESSION['usuario'])."'");
								$repetir = ceil(($numero[0]/10));
								if (empty($repetir)) 
								{ 
									$repetir = 1;
									echo 
									'
										<div class="rowPanel" style="padding: 6px 10px 6px 10px">
											No tiene ningun archivo
										</div>
									';
								} 
								
								if ($id > $repetir or $id <= 0) 
									jsredireccionar("javascript:goMylove('#container','/system/class/panel.php?id=1')");
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
										$archivo = $db->SelectDb("id,nombre,ftp,carpeta","archivos","WHERE usuario='".addslashes($_SESSION['usuario'])."' ORDER BY id LIMIT $primero, $ultimo");
										?>
											<div class="rowPanel" style = "height:10%; width: 100%; padding: 3px 10px 3px 10px; color: #006699;"> 
												<div style="float:left; padding: 5px 0px 0px 0px; width:85%; display: inline-block;">
													<a onclick="FileChangeFileName(<?php imprimir($archivo[0]); ?>)" style="color:#006699" title="Cambiar nombre de archivo">
														Nombre de archivo: <span id="filename_<?php imprimir($archivo[0]); ?>"><?php comprimirnombre($archivo[1])?></span>
													</a>
												</div>
												<div style="float:left; display: inline-block;">
													<a href="../system/script/function_download.php?id=<?php echo $archivo[2] ?>" style="color:#006699" title="Descargar Archivo">
														<img src= "<?php imprimir($config[5]); ?>download.png" width="25" height="25" border="0" align="middle" alt="" />
													</a>														
													<a href="javascript:void(0)" onclick="goMylove('#container','<?php echo $config[3] . 'folder.php?id=' . $archivo[3];?>','<?php echo '/folder/' . $archivo[3]; ?>')" style="color:#006699" title="Carpeta del Archivo">
														<img src= "<?php imprimir($config[5]); ?>folder.png" border="0" align="middle" alt="" />
													</a>

													<img src= "<?php imprimir($config[5]); ?>remove.png" onclick="$('#popDeleteFile_<?php imprimir($archivo[0]); ?>').w2popup()" border="0" align="middle" alt="" />
													
													<div id="popDeleteFile_<?php imprimir($archivo[0]); ?>" style="display: none; width: 25%; height: 17%; overflow: hidden">
														<div rel="title">
															Eliminar Archivo
														</div>
														<div rel="body" style="padding-top: 5%; line-height: 150%">
															<center>
																<p>&iquest;Seguro que quieres borrar el archivo?<p>
															</center>
														</div>
														<div rel="buttons">
															<button class="btn" onclick="w2popup.close();">Cancelar</button>
															<button class="btn" onclick="deletefile('<?php echo $archivo[2]; ?>',<?php echo $id; ?>)">Borrar</button>
														</div>
													</div>
												</div>
											</div>
										<?php
										$primero++;
									}

									$bajo = $id - 4;
									$alto = $id + 4;
									
									if($id > 5)
									{
										?>
											<a href="javascript:void(0)" onclick="javascript:goMylove('#container','../system/class/panel.php?id=1')" style="color:#006699">
												<div class="active border-round">
													<<
												</div>
											</a>
										<?php
									}
									
									if($id > 1)
									{
										?>
											<a href="javascript:void(0)" onclick="javascript:goMylove('#container','../system/class/panel.php?id=<?php imprimir($id-1); ?>')" style="color:#006699">
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
												<a href="javascript:void(0)" onclick="javascript:goMylove('#container','../system/class/panel.php?id=<?php imprimir($i); ?>')" style="color:#006699">
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
											<a href="javascript:void(0)" onclick="javascript:goMylove('#container','../system/class/panel.php?id=<?php imprimir($id+1); ?>')" style="color:#006699">
												<div class="active border-round">
													>
												</div>
											</a>
										<?php
									}
									
									if(($id + 5) <= $repetir)
									{
										?>
											<a href="javascript:void(0)" onclick="javascript:goMylove('#container','../system/class/panel.php?id=<?php imprimir($repetir); ?>')" style="color:#006699">
												<div class="active border-round">
													>>
												</div>
											</a>
										<?php
									}
								}
							}
						?>
					</div>
				</div>
	
			<?php
		}
	?>