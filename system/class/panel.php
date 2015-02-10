	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="http://www.rimtu.com/system/highslide/highslide-ie6.css" />
	<![endif]-->
	<script type="text/javascript" src="http://www.rimtu.com/system/highslide/highslide-full.js"></script>
	<script type="text/javascript" src="http://www.rimtu.com/system/highslide/highslide.config.js"></script>
	<script type="text/javascript" src="http://www.rimtu.com/system/class.js"></script>	
	
	<?php
		include_once '../class.php';
		error_reporting(E_ALL);
	
		if (isUser()) 
		{
			$size = $db->SelectDb("size","usuarios","WHERE usuario='".addslashes($_SESSION['usuario'])."'");
			$data = $db->SelectDb("space,text","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
			?>
				<div style="width: 870px; height: 600px;">
					<div style="Float: left; width: 260px">
						<div class="Blanco border-round" style="height: auto; width: 260px; padding: 20px 0px 20px 0px;" align="center">
								<img src= "/system/style/cara.png" width="78" height="78" border="0" align="middle" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Informaci&oacute;n de cuenta', wrapperClassName: 'titlebar' } )" alt=""  />
								<div class="highslide-maincontent" align="center" style="padding-top:25px;">
									<img src= "/system/style/cara.png" width="78" height="78" border="0" align="middle" alt="" />
									<div style="width: 80%; text-align: left; margin-top:40px">
										<?php
											echo 
											"
												Correo Eletr&oacute;nico: <b>".$_SESSION['email']."</b><br />
												Espacio de tu disco: <b>".ceil($size[0] / 1048576)."mb de ".$data[1]."</b><br />
												Usuario: <b>".$_SESSION['usuario']."</b>
											";
										?>
									</div>
								</div>		
						</div>
						<div class="Blanco border-round" style="height: auto; width: 250px; margin-top: 40px; padding: 20px 0px 20px 10px; text-align:left;">
							<a href="#" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Cambiar contrase&ntilde;a:', wrapperClassName: 'titlebar' } )" style="color:#006699" title="Cambiar contrase&ntilde;a">Cambiar contrase&ntilde;a</a>
							<div class="highslide-maincontent" align="center" style="padding-top:25px">
								<form id="form_changepass" action="javascript:;" onsubmit="return hs.close(this),changepass($('#oldpass_user').val(),$('#newpass_user').val(),$('#repass_user').val())">
									<table width="400px">
										<tr>
											<td>
												Contrase&ntilde;a
											</td>
											<td>
												<input id="oldpass_user" type="password" style="width:170px" maxlength="20" />
											</td>
										</tr>
										<tr>
											<td>
												Nueva Contrase&ntilde;a
											</td>
											<td>
												<input id="newpass_user" type="password" style="width:170px" maxlength="20" />
											</td>
										</tr>
										<tr>
											<td>
												Repetir Contrase&ntilde;a
											</td>
											<td>
												<input id="repass_user" type="password" style="width:170px" maxlength="20" />
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
													<br />
												<input type="submit" class="Boton azul" value="Cambiar" />
											</td>
										</tr>
									</table>
								</form>				
							</div>
							<br />						
							<a href="#" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Cambiar correo electr&oacute;nico', wrapperClassName: 'titlebar' } )" style="color:#006699" title="Cambiar correo electr&oacute;nico">Cambiar correo electr&oacute;nico</a>
							<div class="highslide-maincontent" align="center" style="padding-top:25px">
								<p>Debes confirmar el cambio en tu correo actual</p>
									<br />
								<form id="form_changemail" action="javascript:;" onsubmit="return hs.close(this),changemail($('#mail_user').val())">
									<table width="400px">
										<tr>
											<td>
												Nuevo correo electr&oacute;nico
											</td>
											<td>
												<input id="mail_user" type="text" style="width:170px" maxlength="40" />
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
													<br />
												<input type="submit" class="Boton azul" value="Cambiar" />
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>					
						<div class="Blanco border-round" style="height: auto; width: 260px; margin-top: 40px; padding: 20px 0px 20px 0px">
							<?php 
								$porcentaje = ceil((($size[0]*100)/$data[0]) * 2.4);  
								if ($porcentaje > 240) 
								{ 
									$porcentaje = 240;
									$tas = 100; 
								} 
								else 
									$tas = round(($porcentaje/240)*100, 2, PHP_ROUND_HALF_DOWN);	
								echo
								'
									<div id="barra1" class="barra_progreso">
										<div class="barra_arriba" style="clip:rect(0px,'.$porcentaje.'px, auto, 0px);">
											'.$tas.'%
										</div>
										<div class="barra_abajo">
											'.$tas.'%
										</div>
									</div>
								';
							?>
						</div>					
						<?php
							if (!empty($_GET['message'])) 
							{ 
								switch($_GET['message'])
								{
									case 1:
										$message = "Archivo eliminado correctamente";
										break;
									case 2:
										$message = "Archivo eliminado de la base de datos";
										break;
									case 3:
										$message = "El archivo no pudo ser eliminado";
										break;
								}
							}
							
								echo
								'
									<div id="temporal_message"></div>
								';	
						?>
					</div>
						
					<div style="Float: left; height: 340px; width: 590px; margin-left: 20px;" align="left">
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
										<div class="row" style="padding: 6px 10px 6px 10px">
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
											<div class="row" style = "height:30px; padding: 3px 10px 3px 10px; color: #006699;"> 
												<div style="float:left; padding: 5px 0px 0px 0px;  width: 480px;">
													<a href="../carpeta.html?id=<?php echo $archivo[3]; ?>" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Nombre del Archivo: <?php comprimirnombre($archivo[1]); ?>', wrapperClassName: 'titlebar' } )" style="color:#006699" title="Cambiar nombre de archivo">
														Nombre de archivo: <span id="filename_<?php imprimir($archivo[0]); ?>"><?php comprimirnombre($archivo[1])?></span>
													</a>
													<div class="highslide-maincontent" align="center" style="padding-top:25px">
														<p>Cambiar nombre del archivo<p>
															<br />
															<form id="form_filename" action="javascript:;" onsubmit="return hs.close(this),changefilename($('#id_filename_<?php imprimir($archivo[0]); ?>').val(),$('#name_filename_<?php imprimir($archivo[0]); ?>').val())">
																<textarea id="id_filename_<?php imprimir($archivo[0]); ?>" type="hidden" readonly="readonly" style="display:none"><?php imprimir($archivo[0]); ?></textarea>
																<input id="name_filename_<?php imprimir($archivo[0]); ?>" type="text" style="width:170px" maxlength="22" />
																<input type="submit" class="Boton grande azul" value="Cambiar"/>	
															</form>
													</div>
												</div>
												<div style="float:left; width: 90px;">
													<div class="highslide-gallery">
														<a href="../system/script/function_download.php?id=<?php echo $archivo[2] ?>" style="color:#006699" title="Descargar Archivo">
															<img src= "/system/style/download.png" width="25" height="25" border="0" align="middle" alt="" />
														</a>														
														<a href="javascript:void(0)" onclick="javascript:showFolder('<?php echo $archivo[3]; ?>')" style="color:#006699" title="Carpeta del Archivo">
															<img src= "/system/style/folder.png" border="0" align="middle" alt="" />
														</a>

														<a href="/system/style/remove.png" onclick="return hs.htmlExpand(this, { width: '480', headingText: 'Eliminar Archivo: <?php comprimirnombre($archivo[1]); ?>', wrapperClassName: 'titlebar' } )" style="color:#006699" title="Borrar Archivo">
															<img src= "/system/style/remove.png" border="0" align="middle" alt="" />
														</a>
														<div class="highslide-maincontent" align="center" style="padding-top:25px">
															<p>&iquest;Seguro que quieres borrar el archivo?<p>
															<div style="font-size:18px; margin-top: 10px">
																<a href="javascript:void(0)" onclick="return hs.close(this),deletefile('<?php echo $archivo[2]; ?>',<?php echo $id; ?>)" style="color:#006699; margin-right: 30px">Borrar</a>
																<a href="#" title="Close (esc)" onclick="return hs.close(this)" style="color:#006699"><span>No Borrar</span></a>
															</div>
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
		else 
			jsredireccionar("goMylove('#container','../system/class/home.php','index.html')");
	?>