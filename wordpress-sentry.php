<?php

require_once( dirname(__FILE__) . '/class.wp-raven-client.php' );

class WPSentry extends WP_Raven_Client 
{

	public static function load() {
		try {
			$wps = new WPSentry();
		} catch (Exception $e) {
			
		}
	}
}

add_action('plugins_loaded', array('WPSentry', 'load'));