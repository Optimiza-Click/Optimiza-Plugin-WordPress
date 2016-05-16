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
	$theme = strtoupper (substr(get_bloginfo('template_directory'), strpos(get_bloginfo('template_directory'), "themes") + 7));
		
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
}


?>