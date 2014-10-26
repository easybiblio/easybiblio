<?php require_once '_header.mandatory.php';

/* Backup the db OR just a table */
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
	
    // Deleting tables in the inverse order
    $tables_reversed = array_reverse($tables);
	foreach($tables_reversed as $table)
	{
		$return.= 'DROP TABLE IF EXISTS '.$table.";\n";
	}
    
	// Creating tables and its content
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
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
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= 'NULL'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}

    return $return;
}

// Name of files
$sql_filename = 'db-backup-'.time().'.sql';
$zip_filename = 'backup/db-backup-'.time().'.zip';


// Create backup
$files_to_backup = "tb_category,tb_language,tb_person,tb_type,tb_book,tb_lend";
$db_backup = backup_tables($dbconfig['server'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database_name'], $files_to_backup);

// Fixing problem with date_return
$db_backup .= "update tb_lend set date_return = null where date_return = '0000-00-00';\n";


$handle = fopen($sql_filename,'w+');
    
// Making sure the file is in the encoding UTF-8
file_put_contents($sql_filename, "\xEF\xBB\xBF".  utf8_encode($db_backup)); 
    
fclose($handle);



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