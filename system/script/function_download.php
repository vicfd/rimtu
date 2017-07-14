<?php
	include_once '../class.php';
	
	if (empty($_GET['id']))
	{
		redireccionar("index.html");
		exit;
	}
		
	$id = injection($db, $_GET['id']);
	$file = $db->query("SELECT file_id, file_name, file_extension file_download FROM files WHERE file_ftp='$id'");
	$row_cnt = $file->num_rows;			
	
	if($row_cnt == 0)
	{
		redireccionar("../index.html");
		exit;
	}
	
	if($row = $file->fetch_row())
	{
		$ftp = $_GET['id'] . '.' . $row[2];
			
		$row[1] = str_replace(array(' ',','),'_',$row[1]);
		
		$name = $row[1] . '.' . $row[2];
		$ftp = '../../uploads/' . $ftp;
		
		file_view($db, $row[0]);
		file_date_renew($db, $row[0]);
		
		switch($row[2])
		{
			case "bmp": $ctype="image/bmp"; break;
			case "gif": $ctype="image/gif"; break;
			case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			case "png": $ctype="image/png"; break;
			default: $ctype="application/octet-stream";
		}
		 
		header("Pragma: public"); 
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=".$name.";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($ftp));
		ob_clean();
		flush();
		readfile($ftp);
	}
?>