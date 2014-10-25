<?php require_once '_header.mandatory.php';

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
	
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($name,$link);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = str_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
    $filename = 'db-backup-'.time().'.sql';
	$handle = fopen($filename,'w+');
	fwrite($handle,$return);
	fclose($handle);
    return $filename;
}



// Create backup
$sql_filename = backup_tables($dbconfig['server'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database_name']);
$zip_filename = 'backup/db-backup-'.time().'.zip';

// Create backup folder
if (!file_exists('backup')) {
  mkdir('backup');
}


//Open zip archive.
$zip = new ZipArchive();
if(($zip->open($zip_filename, ZipArchive::CREATE))!==true){ die('Error: Unable to create zip file');}
$zip->addFile($sql_filename);
$zip->close();

// Deletes the file SQL
unlink ($sql_filename);

//Download zip file.
header("Location: ".$zip_filename);

?>