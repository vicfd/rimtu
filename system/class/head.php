	<?php
		include_once '../class.php';

		$menu = $db->QueryDb("text,link,onclick,href,rank","menu","order by position");
		$limit = mysql_num_rows($menu);
	?>
	
	<div id="head" name="head">
		<div style="height: 80px; margin-bottom: 30px; padding-top:20px; background-color: #333333; border-bottom: 5px #ffffff solid; -moz-box-shadow: 0px 0px 5px #838383; -webkit-box-shadow: 0px 0px 5px #838383; box-shadow: 0px 0px 5px #838383" align="center">
			<div style="background-image:url(<?php imprimir($config[0]); ?>/system/style/logo.png); background-repeat: no-repeat; height:56px; width:920px; padding-top:7px;">
				<div style="float:right">
					<?php
						for($k=0;$k<$limit;$k++)
						{
							if(showrank($db->SelectDbArray($menu, $k, 4)))
							{
								if($db->SelectDbArray($menu, $k, 3) == 0)
									echo
									'
										<a href="javascript:void(0)" onclick="'.$db->SelectDbArray($menu, $k, 2).'" class="Separador">
												'.$db->SelectDbArray($menu, $k, 0).'
										</a>
									';
								else
									echo
									'
										<a href="'.$config[0].$db->SelectDbArray($menu, $k, 1).'" class="Separador">
												'.$db->SelectDbArray($menu, $k, 0).'
										</a>
									';
							}
						}
					?>
				</div>
				<span id="resultado" style="position:absolute; right:10%;"></span>
			</div>
		</div>
	</div>