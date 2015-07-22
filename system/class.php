<?php
	/* PhP */
		/* Class */
		
		class DataBase
		{
			public function DataBase()
			{
				$this -> connect();
				$this -> SetDb();
			}
			
			public function connect($server="127.0.0.1",$user="root",$password="1es2can3dalo")
			{
				mysql_connect($server,$user,$password)or die ('Ha fallado la conexión con el servidor.');
			}
			
			public function SetDb($db="Upload")
			{
				mysql_select_db($db)or die ('Error al seleccionar la Base de Datos.');
			}
			
			public function SelectDb($select,$table,$clause = "")
			{
				return mysql_fetch_row(mysql_query("SELECT ".$select." FROM ".$table." ".$clause));		
			}
			
			public function SelectDbArray($query,$position,$slot)
			{
				return mysql_result($query,$position,$slot);
			}
			
			public function QueryDb($select = "*",$table,$clause = "")
			{
				return mysql_query("SELECT ".$select." FROM ".$table." ".$clause);
			}
			
			public function InsertDb($table,$into,$value)
			{
				mysql_query("INSERT INTO ".$table."(".$into.")VALUES(".$value.")");
			}
			
			public function UpdateDb($table,$value,$clause)
			{
				mysql_query("UPDATE ".$table." SET ".$value." WHERE ".$clause);
			}
			
			public function DeleteDb($table,$clause)
			{
				mysql_query("DELETE FROM ".$table." WHERE ".$clause);
			}
		}
		
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
			
			function jsredireccionar($link,$time=0)
			{
				echo 
				'
					<script type="text/javascript">
						setTimeout("'.$link.'", '.$time.');
					</script>
				';
			}
			
			function html_function($string)
			{
				echo '
					<center>
						<div class="Blanco border-round" style="width: 600px; padding: 20px 10px 20px 10px; color: #006699; text-align:center">
							'.$string.'
						</div>
					</center>					
				';
			}
			
		/* Fin HTML */
	
		/* Inicio funciones en general */
		
			function isVisitor()
			{
				if($_SESSION['nivel'] == 0)
					return true;
				return false;
			}
		
			function isUser()
			{
				if($_SESSION['nivel'] > 0)
					return true;
				return false;
			}
			
			function isAdmin()
			{
				if($_SESSION['nivel'] >= 3)
					return true;
				return false;
			}
			
			function showrank($rank)
			{
				if($rank == 0 && isVisitor())
					return true;
				else if($rank == 1 && isUser())
					return true;
				else if($rank == 2)
					return true;
				else if($rank == 3 && isAdmin())
					return true;
				return false;	
			}
			
			function canUpload($db)
			{
				$space = $db->SelectDb("space","caracteristica","WHERE id=".addslashes($_SESSION['nivel']));
				if(isVisitor())
					$data = $db->SelectDb("size","anonimo","WHERE ip='".addslashes($_SERVER['REMOTE_ADDR'])."'");
				else
					$data = $db->SelectDb("size","usuarios","WHERE usuario='".addslashes($_SESSION['usuario'])."'");
				
				if($data[0] < $space[0])
					return true;
				return false;
			}
			
			function generar_md5($user,$email)
			{
				return md5($user . $email . md5(rand()));	
			}
			
			function comprimirnombre($nombre)
			{
				if (strlen($nombre) <= 22) 
					imprimir($nombre); 
				else
					imprimir(substr($nombre,0,21).'...');
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
				if(in_array($str, array('.jpg','.jpeg','.gif','.png','.bmp'))) 
					return true; 
				return false;
			}
			
			function replaceStr($old,$new,$str)
			{
				return str_replace($old,$new,$str);
			}			

			function injection($variable)
			{
				return str_replace(array("<",">","[","]","*","^","'",'"'),"", mysql_real_escape_string($variable));
			}
			
			function imprimir($echo)
			{
				echo $echo;
			}
			
			function visto($id,$db)
			{
				$db->UpdateDb("archivos","visto=visto+1","id='".addslashes($id)."'");
			}
			
			function descargado($id,$db)
			{
				$db->UpdateDb("archivos","descargado=descargado+1","id='$id'");
			}
			
			function recargarTiempo($id,$db)
			{
				$db->UpdateDb("archivos","expira = ". date('Y-m-d h:i:s', $m=strtotime('+1 month')),"id='$id'");	
			}

		/* Final funciones en general */
		
		/* Inicio */
		$db = new DataBase();
		$config = $db->SelectDb("*","config");
		if(empty($_SESSION['nivel']))
		{
			$_SESSION['usuario'] = "anonimo";
			$_SESSION['nivel'] = 0;
		}
		/* Final Programa */
	
?>