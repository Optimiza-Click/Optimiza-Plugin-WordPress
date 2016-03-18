<?php

if(isset($_REQUEST['scan_deleted_files']))
{
	$value = rglob("../../../*.txt", 0);

	if(isset($_REQUEST['delele_files']) )
	{
		foreach($value as $file)
		{
			unlink($file);
		}
	}
	else
	{
		echo "<tbody>";
		
		foreach($value as $file)
		{
			echo "<tr><td>".substr($file, 9)." </td><td> ".date('Y/m/d - H:i:s', filemtime($file))." </td><td> ".filesize($file)."</td>";
			echo "<td>".decoct(fileperms($file) & 0777)."</td></tr>";
		}
	}
		
	$value = rglob("../../../*.html", 0);

	if(isset($_REQUEST['delele_files']) )
	{
		foreach($value as $file)
		{
			unlink($file);
		}
	}
	else
	{
		foreach($value as $file)
		{
			echo "<tr><td>".substr($file, 9)." </td><td> ".date('Y/m/d - H:i:s', filemtime($file))." </td><td> ".filesize($file)."</td>";
			echo "<td>".decoct(fileperms($file) & 0777)."</td></tr>";
		}
	
		echo "</tbody";
	}
}



if(isset($_REQUEST['scan_files']))
{
	$value = rglob("../../../*.php", 0);
	
	echo "<tbody>";

	foreach($value as $file)
	{
		echo "<tr><td>".substr($file, 9)." </td><td> ".date('Y/m/d - H:i:s', filemtime($file))." </td><td> ".filesize($file)."</td>";
		echo "<td>".decoct(fileperms($file) & 0777)."</td><td>".scan_file($file)."</td></tr>";
	}
	
	echo "</tbody";
}

if(isset($_REQUEST['change_file_permissions']))
	change_file_permissions();

//Funcion recursiva de busqueda de ficheros 
function rglob($pattern, $flags = 0) 
{
	$files = glob($pattern, $flags); 
	
	foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) 
	{
		$files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
	}
	
	return $files;
}

//Funcion que lee el conteido de un fichero para comprobar si esta infectado
function scan_file($file)
{
	$message = "";
	$result= "";
		
	//ARRAYS CON LOS VALORES A BUSCAR
	$infected_values = array('/[\'\"\$\\ \/]*?([a-zA-Z0-9]{' .strlen(base64_encode('sergej + swetlana = love.')). ',})/', " ?><?php @error_reporting(0)");
	
	$suspect_values = array('?><?php', 'eval(', '/get_option\s*\(\s*[\'"](.*?)[\'"]\s*\)/', 'eval(base64_decode', "GLOBALS[");
	
	$infected_names = array("file.php", "init.php", "css.php", "folder.php", "sytem.php");
	
	//Se buscan cadenas de caracteres sospechosas
	foreach(file($file) as $fli=>$fl)
	{
		foreach($suspect_values as $value)
		{
			if(strpos($fl, $value)!==false)
			{
				$message .= "<br/>". $filename . ' linea ' . ($fli+1);
				
				$result = 2;
			}
		}
	}	
	
	//Se buscan cadenas de caracteres seguramente infectadas
	foreach(file($file) as $fli=>$fl)
	{
		foreach($infected_values as $value)
		{
			if(strpos($fl, $value)!==false)
			{
				$message .= "<br/>". $filename . ' linea ' . ($fli+1);
				
				$result = 1;
			}
		}
	}
	
	//Se comprueban los nombres de los ficheros comunes de estar infectados
	foreach($infected_names as $value)
	{
		if(strpos($file, $value)!==false)
			$result = 1;
	}
	
	if(strpos($file, "scan.php")!==false)
		$result = "";
	
	//SE DEVUELVE EL RESULTADO CORRESPONDIENTE
	switch ($result)
	{
		case 1:
		
			return "<span class='state_bad'>Infectado".$message."</span>";
			
			break;
			
		case 2:
		
			return "<span class='state_suspect'>Sospechoso".$message."</span>";
			
			break;
		
		default:
		
			return "<span class='state_ok'>Sin Virus</span>";
			
			break;
	}
	
}

//FUNCION QUE CAMBIA LOS PERMISOS DE LOS DIRECTORIOS Y FICHEROS
function change_file_permissions()
{
	$messsage = "";
	
	//SE COMPRUEBA SI EL SERVIDOR ES WINDOWS
	if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
	{	
		$files = get_change_file_permissions();
		
		foreach($files as $k => $v)
		{
			$filePath = $v['filePath'];
			$sp = $v['suggestedPermissions'];
			$sp = (is_string($sp) ? octdec($sp) : $sp);

			//fichero readme.html
			$isReadme = false;
			if(false !== ($pos = stripos($filePath, 'readme')))
				$isReadme = true;

			if (file_exists($filePath))
				if (false === @chmod($filePath, $sp)) 
					$message = "No se pudo cambiar los permisos de uno o varios ficheros.";
			else 
			{
				if(empty($filePath)){
					continue;
				}
				if($isReadme){ // se ignora el readme.html
					continue;
				}	
				
				if (false === @chmod($filePath, $sp)) 
					$message = "No se pudo cambiar los permisos de uno o varios ficheros.";
			}
		}
		
		if($message == "")
			echo "Permisos cambiados correctamente.";
		else
			echo $message;
	}
	else 
		echo "Servidor Windows. ¡No se pueden cambiar los permisos!";
	
	
}

//FUNCION QUE DEVUELVE EL LISTADO DE DIRECTORIOS Y FICHEROS CUYOS PERMISOS HAN DE SER CAMBIADOS
function get_change_file_permissions()
{
	return array(
		//@@ Directories
		'root directory' => array( 'filePath' => '../../../', 'suggestedPermissions' => '0755'),
		'wp-admin' => array( 'filePath' => '../../../wp-admin', 'suggestedPermissions' => '0755'),
		'wp-content' => array( 'filePath' => '../../../wp-content', 'suggestedPermissions' => '0755'),
		'wp-includes' => array( 'filePath' => '../../../wp-includes', 'suggestedPermissions' => '0755'),
		//@@ Files
		'.htaccess' => array( 'filePath' => '../../../htaccess', 'suggestedPermissions' => '0644'),
		'readme.html' => array( 'filePath' => '../../../readme.html', 'suggestedPermissions' => '0400'),
		'wp-config.php' => array( 'filePath' => '../../../wp-config.php', 'suggestedPermissions' => '0644'),
		'wp-admin/index.php' => array( 'filePath' => '../../../wp-admin/index.php', 'suggestedPermissions' => '0644'),
		'wp-admin/.htaccess' => array( 'filePath' => '../../../wp-admin/.htaccess', 'suggestedPermissions' => '0644'),
		'wp-content/index.php' => array( 'filePath' => '../../../wp-content/index.php', 'suggestedPermissions' => '0444'),
		'wp-content/themes/index.php' => array( 'filePath' => '../../../wp-content/themes/index.php', 'suggestedPermissions' => '0444'),
		'wp-content/plugins/index.php' => array( 'filePath' => '../../../wp-content/plugins/index.php', 'suggestedPermissions' => '0444'),
		'wp-content/uploads/index.php' => array( 'filePath' => '../../../wp-content/uploads/index.php', 'suggestedPermissions' => '0444'),
	);
}

?>