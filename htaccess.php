<?php

function update_htaccess_security()
{
	//SE BUSCA LA ETIQUETA PARA INCLUIR EL CODIGO EN EL HTACCESS
	$search_start = "
	#security_options";
	
	$search_end = "#end_security_options";

	$content_htaccess = '../.htaccess';

	//VALORES A INCLUIR EN EL HTACCESS
	$htext = "
	#security_options


	#end_security_options

	";

	//SE COMPRUEBA SI EXISTE EL HTACCESS
	if(file_exists($content_htaccess))
	{
		$content = file_get_contents($content_htaccess);
		
		$pos = strpos($content, $search_start);
		
		//SE COMPRUEBA SI YA SE AÑADIO EL CODIGO DE SEGURIDAD ANTERIORMENTE
		if($pos > 0)
		{
			$new_content = substr($content, 0, $pos); 
			
			$pos2 = strpos($content, $search_end);
			
			$new_content .= substr($content, $pos2 + strlen($search_end)); 
			
			$content = $new_content . $htext;
		}
		else
			$content .= $htext; 

		//SE SOBREESCRIBE EL HTACCESS
		file_put_contents($content_htaccess, $content);
	} 
	
		
	
	$content_htaccess_uploads = '../wp-content/uploads/.htaccess';

	//VALORES A INCLUIR EN EL HTACCESS DE UPLOADS
	$htext2 = "
	#security_options


	#end_security_options

	";

	//SE CREA/SOBREESCRIBE EL HTACCESS
	file_put_contents($content_htaccess_uploads, $htext2);

		
}
?>