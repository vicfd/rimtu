	<?php
		include_once '../class.php';
		include_once '../language/esES.php';
		
		$id = $_GET['id'];
		$id = injection($id);

		if (!empty($_GET['id'])) 
		{
			$id = injection($_GET['id']);
			$check = $db->SelectDb("count(*)","archivos","WHERE carpeta='".addslashes($id)."'");
			
			if($check[0] > 0)
			{	
				$links = null;
				$imagenes = null;
				$imagen = null;
				
				$ciclo = 1;
				
				/* Ciclos para alturas y restar para anchos */
				
					while($check[0] > 5)
					{
						$check[0] = $check[0] - 5;
						$ciclo++;
					}
					
					/* Altura */
					$size = 315 * $ciclo; 
					
					/* Anchura */
					switch($check[0])
					{
						case 1:
							$espacio = 500;
							break;
						case 2:
							$espacio = 370;
							break;
						case 3:
							$espacio = 250;
							break;
						case 4:
							$espacio = 120;
							break;
						case 5:
							$espacio = 0;
							break;
					}
				/* final de pre configuracion */	
				
				?>
					<div style="height: <?php imprimir($size); ?>px; width: 1240px; margin-bottom: 20px">
						<?php 	
							$check = $db->SelectDb("count(*)","archivos","WHERE carpeta='".addslashes($id)."'");
							$contador = 0;
							$limite = 0;
							$imagen = false;
							
							$contadorA = 1;
							$centinela = false;
							
							
							while ($limite < $check[0]) 
							{
								$exist = $db->SelectDb("count(*)","archivos","WHERE carpeta='".addslashes($id)."' AND numero=".addslashes($contador)."");
								
								if ($exist[0] > 0) 
								{
									if($ciclo == 1 && !$centinela)
									{
										$margin = '20px 10px 0px ' . $espacio . 'px';
										$centinela = true;
									}
									else
									{
										if($contadorA == 5 && $limite != 0)
										{
											$margin = "20px 0px 0px 0px";
											$contadorA = 0;
											$ciclo--;
										}
										else
											$margin = "20px 10px 0px 0px";
									}
									
									$dato = $db->SelectDb("id,nombre,extension,ftp,visto,descargado","archivos","WHERE carpeta='".addslashes($id)."' AND numero=".addslashes($contador)."");
									
									visto($dato[0],$db);
									recargarTiempo($dato[0],$db);

									$carpeta = "../system/style/default.jpg";

									if (is_img($dato[2])) 
									{ 
										$carpeta = '../../uploads/'; $carpeta = $carpeta . $dato[3] . $dato[2];
										$imagen = true;
										
										if(empty($imagenes))
											$imagenes .= $config[0] . "uploads/" . $dato[3] . $dato[2];
										else
											$imagenes .= "\n" . $config[0] . "uploads/" . $dato[3] . $dato[2];
											
										$size = getimagesize($carpeta);
										$anchura=$size[0];
										$altura=$size[1];
												
										if ($anchura >= 213 || $altura >= 168) 
										{
											$anchura = 213;
											$altura = 168;
										}
									} 
									else
									{ 
										$anchura = 213;
										$altura = 168;		
									}
									
									if(empty($links))
										$links .= $config[0] . "download/" . $dato[3];
									else
										$links .=  "\n" . $config[0] . "download/" . $dato[3];
									
									?>
										<div style="float: left; height: 295px; width: 240px; margin: <?php imprimir($margin); ?>">	
											<div class="Blanco border-round" style="padding: 10px 0px 0px 0px">
													<div class="border-round" style="line-height: 168px; height: 168px; width: 218px">
														<a href="<?php imprimir("./$carpeta"); ?>" onclick="return hs.htmlExpand(this, { width: '530', headingText: 'Carpeta del Archivo: <?php comprimirnombre($dato[1]); ?>', wrapperClassName: 'titlebar' } )">
															<img class="border-round" style="vertical-align: middle" src= "<?php imprimir("./$carpeta"); ?>" width="<?php imprimir($anchura); ?>" height="<?php imprimir($altura); ?>" border="0" alt="" />
														</a>
														<div class="highslide-maincontent" align="center">
															<br />
															<?php
																if($contador != 0)
																{
																	echo
																	'
																	<div style="position:absolute; top: 50px; left:20px;">
																		<a href="javascript:void(0)" title="Anterior" onclick="return hs.previous(this)">
																			<img src= "../system/style/last.png" border="0" alt="" />
																		</a>
																	</div>
																	';
																}

																if($contador != $check[0]-1)
																{
																	echo
																	'
																		<div style="position:absolute; top: 50px; right: 20px;">
																			<a href="javascript:void(0)" title="Siguiente" onclick="return hs.next(this)">
																				<img src= "../system/style/next.png" border="0" alt="" />
																			</a>
																		</div>
																	';
																}
															?>
															<a href="<?php imprimir("./$carpeta"); ?>">
																<img class="border-round" style="vertical-align: middle" src= "<?php imprimir("./$carpeta"); ?>" width="<?php imprimir($anchura); ?>" height="<?php imprimir($altura); ?>" border="0" alt="" />
															</a>
															<br />
															<br />
															<?php 
																echo 'Nombre: ';
																comprimirnombre($dato[1]);
															?>
															<br />
															<br />
															Visto: <b><?php echo $dato[4]; ?></b> Descargado <b><?php echo $dato[5]; ?></b>
															<br />
															<br />
															<textarea cols="60" rows="1" style="max-height: 100px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "download/" . $dato[3]); ?></textarea>
															<?php 		
																if ($imagen == true) 
																{
															?>
																<textarea cols="60" rows="1" style="margin-top: 5px" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "uploads/" . $dato[3] . $dato[2]); ?></textarea>
															<?php
																}
															?>
														</div>								
													</div>
													<br />
													<?php 
														comprimirnombre($dato[1]);
													?>
													<br />
												<a href="../system/script/function_download.php?id=<?php imprimir($dato[3]); ?>">
													<img src= "../system/style/descarga.png" width="78" height="78" border="0" align="middle" alt="" />
												</a>
											</div>		
										</div>	
									<?php
									$limite++;
									$contadorA++;
								}
								$contador++;
							}
						?>
					</div>
					
					<a href="#" onclick="return hs.htmlExpand(this, { width: '700', headingText: 'Links de la Carpeta', wrapperClassName: 'titlebar' } )">
						<img src= "../system/style/link.png" border="0" alt="" />
					</a>
					<div class="highslide-maincontent" align="center">
						<table>
							<tr>
								<td width="110px" align="left" style="color: #006699; padding-top: 5px;">Carpeta</td>
								<td width="495px">
									<div style="padding: 20px 0px 0px 0px; margin:0px 0px 15px 0px">
										<textarea cols="60" rows="1" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "folder/" . $id); ?></textarea>
									</div>	
								</td>
							</tr>
							<tr>
								<td width="110px" align="left" style="color: #006699; padding-top: 5px;">Enlaces</td>
								<td width="495px">
									<div style="padding: 20px 0px 0px 0px; margin:0px 0px 15px 0px">
										<textarea cols="60" rows="1" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($links); ?></textarea>
									</div>
								</td>
							</tr>
							<?php 		
								if (isset($imagenes)) 
								{
							?>
								<tr>
									<td width="110px" align="left" style="color: #006699; padding-top: 5px;">Im&aacute;genes</td>
									<td width="495px">
										<div style="padding: 20px 0px 0px 0px; margin:0px 0px 15px 0px">
											<textarea cols="60" rows="1" style="max-height: 100px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php print($imagenes); ?></textarea>
										</div>
									</td>
								</tr>
							<?php 
								} 
							?>
						</table>
						<a href="index.php" style="color: #006699"><?php imprimir($carpeta_1); ?></a>
					</div>	
				<?php
			}
			else
				jsredireccionar("goMylove('#container','../system/pages.php?type=2','/index.html')");
		}
		else
			jsredireccionar("goMylove('#container','../system/pages.php?type=2','/index.html')");
	?>