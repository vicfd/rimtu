<?php
	$id = injection($db, $_GET['id']);
	$temp_check = $db->query("SELECT * FROM temps WHERE temp_code='$id' && temp_active=1");
	$row_cnt = $temp_check->num_rows;	
	
	if ($row_cnt == 0) 
	{
		echo "<p class='alert alert-danger'>No existe el codigo introducido.</p>";
		exit;
	}

	if($row = $temp_check->fetch_array(MYSQLI_ASSOC))
	{
		switch($row["temp_type"])
		{
			case 1:
				$db->query("INSERT INTO clients(client_username, client_password, client_email, client_ip, client_date_registered) VALUES('".$row['temp_username']."', '".$row['temp_password']."', '".$row['temp_email']."', '".$row['temp_ip']."', '".$row['temp_date_registered']."')");
				echo "<p class='alert alert-success'>La cuenta con nombre <strong>".$row['temp_username']."</strong> ha sido creada</p>";
				break;
			case 2:
				$db->query("UPDATE clients SET client_email='".$row['temp_email']."' WHERE client_username='".$row['temp_username']."'");
				$_SESSION['client_email'] = $row['temp_email'];
				echo "<p class='alert alert-success'>Su nuevo correo es <strong>".$row['temp_email']."</strong></p>";
				break;
			case 3:
				$client_password = RandomString(8);
				$db->query("UPDATE clients SET client_password='".sha1(strtoupper($row['temp_username']).":".$client_password)."' WHERE client_username ='".$row['temp_username']."'");
				echo "<p class='alert alert-success'>Su nueva contraseña es <strong>".$client_password."</strong></p>";
				break;
		}
		
		$db->query("UPDATE temps SET temp_active=0 WHERE temp_code='$id'");
	}
?>