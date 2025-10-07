<?php
include_once("class.paging.php");
include_once("class.admin.php");

class DB_Backups extends Admin
{
	public function backup_tables($name,$tables = '*')
	{
		$DBH = new mysqlConnection();
		if($tables == '*')
		{
			$tables = array();
			$sql = "SHOW TABLES";
			//$this->execute_query($sql);
                        $STH = $DBH->query($sql);
			//while($row = $this->fetchRow())
                        while($row = $STH->fetch(PDO::FETCH_ASSOC)) 
			{
				$tables[] = $row['Tables_in_wellness'];
			}
                        
                        //print_r($tables);
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		foreach($tables as $table)
		{
			$sql = "SELECT * FROM ".$table;
			//$this->execute_query($sql);
                        $STH2 = $DBH->query($sql);
			$num_fields = $STH2->rowCount();
			
			$return.= 'DROP TABLE IF EXISTS '.$table.';';
			
			//$obj2 = new DB_Backups();
			//$obj2->connectDB();
			
			$sql2 = "SHOW CREATE TABLE ".$table;
			//$obj2->execute_query($sql2);
			//$row2 = $obj2->fetchRow();
                         $STH3 = $DBH->query($sql2);
                         $row2 = $STH3->fetch(PDO::FETCH_ASSOC);
			
                        // echo print_r($row2);
                         
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = $STH3->rowCount())
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = preg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		
		$tmp_date = date("dmYHis");
		$dir      = SITE_PATH."/dbbackups/"; //zelfde map
		$file = 'wellness-db-backup-'.$tmp_date.'.sql';
		
		//save file
		$handle = fopen($dir.$file,'w+');
		fwrite($handle,$return);
		fclose($handle);
		header("Content-type: application/force-download"); 
		header('Content-Disposition: inline; filename="' . $dir.$file . '"'); 
		header("Content-Transfer-Encoding: Binary"); 
		header("Content-length: ".filesize($dir.$file)); 
		header('Content-Type: application/octet-stream'); 
		/*Note that if I comment out the line below, the behaviour is like mendix: the download is not recognized as a Worddoc but as a zip-file or unknown extension*/
		header('Content-Disposition: attachment; filename="' . $file . '"'); 
		readfile("$dir$file"); 
	}
}
?>