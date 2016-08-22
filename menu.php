<?php

require_once( '../../../wp-load.php' );
 
if(isset($_REQUEST["values"]))
{	
	if ( ! function_exists( 'update_option' ) ) 
     require_once '../../../wp-includes/option.php';
 
	 //SE GUARDAN LOS DATOS DE LAS OPCIONES DEL MENU
	if(update_option("migration_plugin_admin_menu_data", $_REQUEST["values"]))
		echo "<span class='message_ok'>Cambios guardados correctamente.</span>";
	else if (get_option("migration_plugin_admin_menu_data") == $_REQUEST["values"])
		echo "<span class='message_no_changes'>No se han realizado cambios.</span>";
	else
		echo "<span class='message_error'>¡Error al guardar los cambios!</span>";
}


?>