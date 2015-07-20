	<?php
		include_once '../class.php';
		include_once '../language/esES.php';
		
		$id = $_GET['id'];
		$id = injection($id);

		if (!empty($_GET['id'])) 
		{
			$id = injection($_GET['id']);
			$check = $db->SelectDb("max(numero),COUNT(*)","archivos","WHERE carpeta='".addslashes($id)."'");
			
			if($check[1] > 0)
			{	
				$links = "";
				$imagenes = "";
				$contador = 0;
				
				for ($k=0; $k <= $check[0]; $k++) 
				{
						
						$dato = $db->SelectDb("id,nombre,extension,ftp,visto,descargado","archivos","WHERE carpeta='".addslashes($id)."' AND numero=".addslashes($k)."");
						
						if(!empty($dato[0]))
						{
							visto($dato[0],$db);
							recargarTiempo($dato[0],$db);
							$carpeta = "../system/style/images/default.jpg";
							$links .=  $config[0] . "download/" . $dato[3] . "\n";
							if (is_img($dato[2])) 
							{ 
								$carpeta = '../../uploads/' . $dato[3] . $dato[2];
								$imagenes .= $config[0] . "uploads/" . $dato[3] . $dato[2] . "\n";
							}
							?>	
							
							
							<div class="Blanco border-round" style="height: 300px; width: 23%; margin-bottom: 1%; margin-left: 1%; padding: 1%; display: inline-table;">
								<center>
									<img onclick="$('#popup<?php echo $contador; ?>').w2popup()" class="border-round" style="width: 250px; height: 188px;" src= "<?php imprimir("./$carpeta"); ?>" border="0" alt="" />
									<a href="../system/script/function_download.php?id=<?php imprimir($dato[3]); ?>">
										<img src= "<?php imprimir($config[5]); ?>descarga.png" width="78" height="78" border="0" align="middle" alt="" />
									</a>
								</center>
							</div>
							
							<div id="popup<?php echo $contador; ?>" style="display: none; width: 30%; height: 40%; overflow: hidden">
								<div rel="title">
									Nombre del Archivo: <?php comprimirnombre($dato[1]); ?>
								</div>
								<div rel="body" style="padding-top: 5%; line-height: 150%">
									<?php
										if($contador != 0)
										{
											echo
											"
												<div style=\"position:absolute; top: 50px; left: 10px;\">
													<img onclick=\"$('#popup" . ($contador-1) . "').w2popup()\" src= \"".$config[5]."last.png\" border=\"0\" alt=\"\" />
												</div>
											";
										}

										if($contador != $check[1]-1)
										{
											echo
											"
												<div style=\"position:absolute; top: 50px; right: 10px;\">
													<img onclick=\"$('#popup" . ($contador+1) . "').w2popup()\" src= \"".$config[5]."next.png\" border=\"0\" alt=\"\" />
												</div>
											";
										}
									
										echo
										"
										<center>
											<a href=\"/$carpeta\">
												<img class=\"border-round\" style=\"max-width: 250px; max-height: 188px;\" src=\"/$carpeta\" border=\"0\" alt=\"\" />
											</a>
										
										
										<p>Visto: <b>$dato[4]</b> Descargado <b>$dato[5]</b></p>

										
											<textarea cols=\"60\" rows=\"1\" onclick=\"this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');\" readonly=\"readonly\">" . $config[0] . "download/" . $dato[3] . "</textarea>
										";
										
										if (is_img($dato[2])) 
										{
											echo
											"
												<textarea cols=\"60\" rows=\"1\" style=\"margin-top: 5px\" onclick=\"this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');\" readonly=\"readonly\">" . $config[0] . "uploads/" . $dato[3] . $dato[2] . "</textarea>
											";
										}
										echo "</center></div></div>";
							$contador++;
						}
				}
			?>
			
			<div>
				<img style="margin-top: 2%;" onclick="$('#popupLinks').w2popup()" src= "<?php imprimir($config[5]); ?>link.png" border="0" alt="" />
			</div>
			
				<div id="popupLinks" style="display: none; width: 30%; height: 45%; overflow: hidden">
					<div rel="title">
						Enlaces de los archivos
					</div>
					<div rel="body" style="padding-top: 5%; line-height: 150%">
						<center>
							<div style="margin:0px 0px 15px 0px">
								<p>Carpeta</p>
								<textarea cols="60" rows="1" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($config[0] . "folder/" . $id); ?></textarea>
							</div>	


							<div style="padding: 20px 0px 0px 0px; margin:0px 0px 15px 0px">
								<p>Enlaces</p>
								<textarea cols="60" rows="1" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php imprimir($links); ?></textarea>
							</div>

							<?php 		
								if (!empty($imagenes)) 
								{
							?>
									<div style="padding: 20px 0px 0px 0px; margin:0px 0px 15px 0px">
										<p>Im&aacute;genes</p>
										<textarea cols="60" rows="1" style="max-height: 100px;" onclick="this.select(); pageTracker._trackEvent('new-done-click','alt-forum-link-click');" readonly="readonly"><?php print($imagenes); ?></textarea>
									</div>
							<?php 
								} 
							?>
						</center>
					</div>
					<div rel="buttons">
						<button class="btn" onclick="w2popup.close(), goMylove('#container','<?php echo $config[3] . "home.php"; ?>','<?php echo "/index.html"; ?>')"><?php imprimir($carpeta_1); ?></button>
					</div>
				</div>
				<?php
					
			}
		}
	?>