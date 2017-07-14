<?php
	if($menu = $db->query("SELECT text,href,rank FROM menu ORDER BY POSITION"))
	{
		while($row = mysqli_fetch_row($menu))
		{
			if(showrank($row[2], $_SESSION['client_level']))
			{
				printf("<li><a href=%s>%s</a></li>", $domain.$row[1], $row[0]);
			}
		}
	}
?>