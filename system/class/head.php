	<?php
		include_once '../class.php';

		$menu = $db->QueryDb("text,link,onclick,href,rank","menu","order by position");
		$limit = mysql_num_rows($menu);
		
		?>
		
												<nav id="nav">
											<ul>
											<?php
		
		for($k=0;$k<$limit;$k++)
		{
			if(showrank($db->SelectDbArray($menu, $k, 4)))
			{
				if(empty($db->SelectDbArray($menu, $k, 3)))
					echo
					'
						<li><a href="javascript:void(0)" onclick="'.$db->SelectDbArray($menu, $k, 2).'">
								'.$db->SelectDbArray($menu, $k, 0).'
						</a></li>
					';
				else
					echo
					'
						<li><a href="'.$config[0].$db->SelectDbArray($menu, $k, 3).'">
								'.$db->SelectDbArray($menu, $k, 0).'
						</a><li>
					';
			}
		}
	?>	</ul>
										</nav>