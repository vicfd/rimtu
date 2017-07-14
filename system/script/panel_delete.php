<?php
	include_once '../class.php';

	if (isset($_POST['file_id'])) 
	{
		$file_id = injection($db, !get_magic_quotes_gpc() ? addslashes($_POST['file_id']) : $_POST['file_id']);
		$file = $db->query("SELECT client_id, file_ftp, file_extension, file_size FROM files WHERE file_id='$file_id'")->fetch_row();
			
		if ($_SESSION['client_id'] == $file[0] && is_file('../../uploads/'. $file[1] . '.' . $file[2]))
		{
			$db->query("UPDATE clients SET client_file_size_upload=client_file_size_upload-$file[3] WHERE client_id='$file[0]'");
			$db->query("UPDATE files SET file_active='false' WHERE file_id='$file_id'");
			
			if($db->query("SELECT * FROM files_report WHERE file_id='$file_id' && report_active=1")->num_rows == 0)
				unlink('../../uploads/'. $file[1] . '.' . $file[2]);
			echo 0;
		}
		else
			echo 1;
	}
?>