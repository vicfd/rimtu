<?php
	include_once 'config.php';
	
	/* HTML */
			
		function redireccionar($link,$time = 0)
		{
			echo 
			'
				<script type="text/javascript">
					function redireccionar()
					{
						window.location="'.$link.'";
					}
					setTimeout("redireccionar()", '.$time.');
				</script>
			';
		}
			
		/* Fin HTML */
	
		/* Inicio funciones en general */
			
			function showrank($rank, $user_level)
			{
				$access = false;
				if($user_level == 0 && $rank == 0 || ($rank > 0 && $user_level >= $rank))
					$access = true;
				return $access;	
			}
			
			function canUpload($db, $user_id, $space)
			{
				$data = $db->query("SELECT client_file_size_upload FROM clients WHERE client_id=".$user_id)->fetch_row();
				return $data[0] < $space;
			}
			
			function generar_md5($user,$email)
			{
				return md5($user . $email . md5(rand()));	
			}
			
			function comprimirnombre($nombre)
			{
				if (strlen($nombre) <= 40) 
					return $nombre; 
				else
					return substr($nombre,0,39).'...';
			}
			
			function emailvalido($email) 
			{ 
				if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) 
					return true; 
				return false; 
			} 
			
			function RandomString($length=10,$uc=true,$n=true,$sc=false)
			{
				$source = 'abcdefghijklmnopqrstuvwxyz';
				if($uc) 
					$source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				if($n) 
					$source .= '1234567890';
				if($sc) 
					$source .= '|@#~$%()=^*+[]{}-_';
				if($length>0)
				{
					$rstr = "";
					$source = str_split($source,1);
					for($i=1; $i<=$length; $i++)
					{
						$num = mt_rand(1,count($source));
						$rstr .= $source[$num-1];
					}
				}
				return $rstr;
			}
			
			function is_str($str) 
			{ 
				if(preg_match("/^[A-Za-z0-9]+$/",$str))
					return true;
				return false;
			}
			
			function is_img($str)
			{
				if(in_array($str, array('jpg','jpeg','gif','png','bmp'))) 
					return true; 
				return false;
			}		

			function injection($db, $variable)
			{
				return str_replace(array("<",">","[","]","*","^","'",'"'),"",mysqli_real_escape_string($db, $variable));
			}
			
			function imprimir($echo)
			{
				echo $echo;
			}
			
			function file_view($db, $file_id)
			{
				$db->query("UPDATE files SET file_view=file_view+1 WHERE file_id=$file_id");
			}
			
			function file_downloaded($db, $file_id)
			{
				$db->query("UPDATE files SET file_download=file_download+1 WHERE file_id=$file_id");
			}
			
			function file_date_renew($db, $file_id)
			{
				$db->query("UPDATE files SET expira=".date('Y-m-d h:i:s', strtotime('+1 month'))." WHERE file_id=$file_id");
			}
			
			function sendemail($sendemail, $email, $subject, $body)
			{
				$headers = "From: " . $email . "\n";
				$headers .= "MIME-Version: 1.0\n"; 
				$headers .= "Content-type: text/html; charset=utf-8\n";	
				mail($sendemail,$subject,$body,$headers);
			}

		/* Final funciones en general */
		
		/* Inicio */
		
		session_start();
		$db = new mysqli("localhost", "upload", "123456", "upload");
		
		if(empty($_SESSION['client_id']))
		{
			$_SESSION['client_id'] = 0;
			$_SESSION['client_level'] = 0;
		}
?>