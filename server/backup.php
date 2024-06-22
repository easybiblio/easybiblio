<?php require_once '_header.mandatory.php';

$fmw->checkOperator();

/* Backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{

	$link = mysqli_connect($host,$user,$pass);
	mysqli_select_db($link, $name);
	
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
		$result = mysqli_query($link, 'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
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
$date_string = date("Y-m-d_-_H_i_s");
$sql_filename = 'db-easybiblio-'.$date_string.'.sql';
$zip_filename = 'backup/db-easybiblio-'.$date_string.'.zip';


// Create backup
$files_to_backup = "tb_about,tb_category,tb_language,tb_person,tb_type,tb_book,tb_lend,tb_audit";
$db_backup = backup_tables($fmw->config->server, $fmw->config->username, $fmw->config->password, $fmw->config->database_name, $files_to_backup);

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