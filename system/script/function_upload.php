<?php
	include_once '../class.php';
	
	/*
		max_execution_time=14400
		upload_max_filesize=200M
		post_max_size=200M
	*/

	if (isset($_POST["folder_id"]) && isset($_FILES)) 
	{
		$client_id = $_SESSION['client_id'];
		$client_level = $_SESSION['client_level'];
		$folder_id = $_POST['folder_id'];
		$file = $_FILES['Filedata']['name'];
		$file_can_upload = true;
		
		$file_extension = '.'.pathinfo($file, PATHINFO_EXTENSION);
		$nombre = injection($db, basename($file, $file_extension));  
		$ftp =  substr(md5($nombre.time()), 0, 199);
		$nombre = strtr(utf8_decode($nombre), utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ'), 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby');
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		$targetFile = '../../uploads/' . $ftp . '.' . $extension;
		
		if (is_img($extension) && move_uploaded_file($_FILES['Filedata']['tmp_name'],$targetFile))
		{
			$size = $_FILES['Filedata']['size'];
			$db->query("UPDATE clients set client_file_size_upload=client_file_size_upload+".$_FILES['Filedata']['size']." WHERE client_id=".$client_id);
			$db->query("INSERT INTO files(file_name, file_extension, file_size, file_ftp, file_folder_id, file_ip_upload, client_id, file_date_upload, file_date_expire) VALUES('$nombre','$extension',".$_FILES['Filedata']['size'].",'$ftp','$folder_id','".$_SERVER['REMOTE_ADDR']."','$client_id','".date("Y-m-d h:i:s")."','".date("Y-m-d h:i:s", strtotime('+1 month'))."')");	
		}
	}
?>