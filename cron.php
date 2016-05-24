<?php

//SE REGISTRA UNA ACCION PARA QUE SE EJECUTE DIARIAMENTE
register_activation_hook(__FILE__, 'notificactions_wp');

function notificactions_wp() 
{
    if (! wp_next_scheduled ( 'notificactions_wp' )) 
		wp_schedule_event(time(), 'daily', 'notificactions_wp');
}

add_action('notificactions_wp', 'send_notifications_wp');

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


?>