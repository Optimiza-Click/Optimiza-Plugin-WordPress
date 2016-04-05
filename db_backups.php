<?php


/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$old_url, $new_url, $tables = '*')
{
	$link = mysqli_connect($host,$user,$pass);
	mysqli_select_db($link, $name);
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysqli_query($link, 'SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	$return = "";
	
	if($new_url != "")
		if(!get_option("old_url_migration"))
			add_option("old_url_migration", "-".get_home_url());
		else
			update_option("old_url_migration", "-".get_home_url());
		
	//cycle through
	foreach($tables as $table)
	{
		$result = mysqli_query($link, 'SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		//$return.= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j < $num_fields; $j++) 
				{
					
					$row[$j] = str_replace("\n","\\n",$row[$j]);				
					
					if($new_url != "")
					{						
						if(substr($table, -8) == "_options")
						{
							if($old_url == $row[$j])
								$row[$j] = $new_url;
						}
						else
						{
							$row[$j] = str_replace($old_url, $new_url,$row[$j]);
							
							$row[$j] = str_replace(str_replace("/", "\\/",$old_url), str_replace("/", "\\/",$new_url),$row[$j]);
						}
					}
					
					$row[$j] = addslashes($row[$j]);
					
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j < ($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	
	$archivo = 'db-backup-'.date("d-m-Y_G-i-s").'.sql';
	
	$handle = fopen('./backups/'.$archivo,'w+');
	fwrite($handle,$return);
	fclose($handle);
	
	$fila = "<tr><td>".$archivo." </td><td> ".date('Y/m/d - H:i:s', filemtime("./backups/".$archivo))." </td><td> ".substr((filesize("./backups/".$archivo)/1000000), 0, -4)."</td>
				<td><a class='button button-primary' href='../wp-content/plugins/".plugin_name."/backups/".$archivo."'>Descargar</a>&nbsp; 
				<a id='del_".$archivo."' class='button button-primary delete_backups'>Eliminar</a></td></tr>";
			
	$result = array("message" => "Fichero creado correctamente.","result" => $fila);
	echo json_encode($result);
}

?>