<?php
	include_once '../class.php';
	
	if ($_SESSION['client_level'] < 3) 
	{
		redireccionar("/index.html");
		exit;
	}	
	
	if (isset($_POST['report_id']) && isset($_POST['report_type'])) 
	{
		$report_id = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['report_id']) : $_POST['report_id']);
		$report_type = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['report_type']) : $_POST['report_type']);
		$report = $db->query("SELECT file_id, report_email FROM files_report WHERE report_id='$report_id'")->fetch_row();
		$file = $db->query("SELECT client_id, file_name, file_ftp, file_extension, file_size, file_active FROM files WHERE file_id='$report[0]'")->fetch_row();
		
		if($report_type == 0)
		{
			$db->query("UPDATE files_report SET report_active=0 WHERE report_id='$report_id'");
			if(is_file('../../uploads/'. $file[2] . '.' . $file[3]) && $db->query("SELECT * FROM files_report WHERE file_id='$report[0]' && report_active=1")->num_rows == 0 && !$file[5])
				unlink('../../uploads/'. $file[2] . '.' . $file[3]);
		}
		else
		{
			$client = $db->query("SELECT client_username, client_email FROM clients WHERE client_id='$file[0]'")->fetch_row();
			$db->query("UPDATE clients SET client_file_size_upload=client_file_size_upload-$file[4] WHERE client_id='$file[0]'");
			$db->query("UPDATE files_report SET report_active=0 WHERE report_id='$report_id'");
			$db->query("UPDATE files SET file_active=0 WHERE file_id='$report[0]'");
			unlink('../../uploads/'. $file[2] . '.' . $file[3]);
			
			$subject = "Contenido eliminado en Rimtu."; 
			$body = 
			"Bienvenido " . $client[0] . ", a Rimtu.
				<br /><br />
			Este mensaje es una notificación avisandole que el archivo <b>$file[1]</b> ha sido eliminado debido a un reporte e incumplir las normas de nuestra comunidad.";
			sendemail($client[1], $email, $subject, $body);
			
			$body = 
			"Bienvenido " . $report[1] . ", a Rimtu.
				<br /><br />
			Este mensaje es una notificación avisandole que el archivo <b>$file[1]</b> que reporto ha sido eliminado, gracias por ayudarnos.";					
			sendemail($report[1], $email, $subject, $body);
		}
	}
?>