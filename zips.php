<?php

if(isset($_REQUEST["plugin_install"]))
	install_plugin($_REQUEST["plugin_install"]);

if(isset($_REQUEST["generate_backup_url"]))
	generate_backup($_REQUEST["generate_backup_url"]);

if(isset($_REQUEST["delete_backup_file"]))
	delete_backup($_REQUEST["delete_backup_file"]);


//FUNCION PARA DESCOMPRIMIR LOS FICHEROS DEL PLUGIN QUE SE QUIERE INSTALAR
function install_plugin($plugin)
{
	$zip = new ZipArchive;
	
	$res = $zip->open('./plugins/'.$plugin.'.zip');
	
	if ($res === TRUE) 
	{
		$zip->extractTo('../');
		
		echo 'ok';
	} 
	else 
		echo 'error';
	
	$zip->close();
}


function agregar_zip($dir, $zip) 
{
  //verificamos si $dir es un directorio
  if (is_dir($dir)) {
    //abrimos el directorio y lo asignamos a $da
    if ($da = opendir($dir)) {
      //leemos del directorio hasta que termine
      while (($archivo = readdir($da)) !== false) {
        /*Si es un directorio imprimimos la ruta
         * y llamamos recursivamente esta función
         * para que verifique dentro del nuevo directorio
         * por mas directorios o archivos
         */
        if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
        //  echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
          agregar_zip($dir . $archivo . "/", $zip);

          /*si encuentra un archivo imprimimos la ruta donde se encuentra
           * y agregamos el archivo al zip junto con su ruta 
           */
        } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
          //echo "Agregando archivo: $dir$archivo <br/>";
          $zip->addFile($dir . $archivo, $dir . $archivo);
        }
      }
      //cerramos el directorio abierto en el momento
      closedir($da);
    }
  }
}

  
 //FUNCION PARA DESCOMPRIMIR LOS FICHEROS DEL PLUGIN QUE SE QUIERE INSTALAR
function generate_backup($dir)
{	  
	//fin de la función
	//creamos una instancia de ZipArchive
	$zip = new ZipArchive();

	//ruta donde guardar los archivos zip, ya debe existir
	$rutaFinal = "backups";
	
	$archivoZip = "backup".backup_type($dir).date("d-m-Y_G-i-s").".zip";

	if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) 
	{
		agregar_zip($dir, $zip);
		$zip->close();

		//Muevo el archivo a una ruta
		//donde no se mezcle los zip con los demas archivos
		rename($archivoZip, "$rutaFinal/$archivoZip");

		//Hasta aqui el archivo zip ya esta creado
		//Verifico si el archivo ha sido creado
		if (file_exists($rutaFinal. "/" . $archivoZip)) 
		{
			$fila = "<tr><td>".$archivoZip." </td><td> ".date('Y/m/d - H:i:s', filemtime("./backups/".$archivoZip))." </td><td> ".substr((filesize("./backups/".$archivoZip)/1000000), 0, -4)."</td>
				<td><a class='button button-primary' href='../wp-content/plugins/migration_optimizaclick/backups/".$archivoZip."'>Descargar</a>&nbsp; 
				<a id='del_".$archivoZip."' class='button button-primary delete_backups'>Eliminar</a></td></tr>";
			
			$result = array("message" => "Fichero creado correctamente.","result" => $fila);
			echo json_encode($result);
		} 
		else {
			echo "Error, archivo zip no ha sido creado!!";
		}
	}
}

//FUNCION PARA COMPROBAR EL TIPO DE BACKUP
function backup_type($dir)
{
	$tipo = "";
	
	switch($dir)
	{
		case "../":
		
			$tipo = "-plugins-";
			
		break;
		
		case "../../":
		
			$tipo = "-wp-content-";
			
		break;
		
		case "../../../":
		
			$tipo = "-wordpress-";
			
		break;
		
		case "../../themes/":
		
			$tipo = "-themes-";
			
		break;
		
		case "../../uploads/":
		
			$tipo = "-uploads-";
			
		break;
	}
	
	return $tipo;
}

//FUNCION PARA ELMINIR UN FICHERO CONCRETO DE UN BACKUP
function delete_backup($file)
{
	if(unlink("./backups/".$file) )
		echo "Fichero eliminado.";
	else
		echo "Error, no se pudo eliminar el fichero.";
}

?>