<?php
/*
Plugin Name: Optimizaclick Migration Plugin
Description: Plugin automatizador de tareas para completar la migración de una web.
Author: Departamento de Desarrollo - Optimizaclick
Author URI: http://www.optimizaclick.com/
Text Domain: Optimizaclick Migration Plugin
Version: 2.2.1
Plugin URI: http://www.optimizaclick.com/
*/

define("plugin_name", "Optimiza-Plugin-WordPress-master");
define("respository_url", "https://githubversions.optimizaclick.com/repositories/view/54186440/");

require_once( dirname(__FILE__) . '/wordpress-sentry.php' );
require_once( dirname(__FILE__) . '/htaccess.php' );
require_once( dirname(__FILE__) . '/cron.php' );

//FUNCION INICIAL PARA AÑADIR LA OPCION DEL PLUGIN EN EL MENU DE HERRAMIENTAS Y CARGAR OTRAS FUNCIONES
function migration_admin_menu() 
{	
	//SE AÑADE UNA OPCION EN EL MENU HERRAMIENTAS PARA MOSTRAR LAS OPCIONES DEL PLUGIN
	$menu = add_menu_page( 'Migration', 'Migration', 'read',  'migration', 'migration_form', ' ', 80);
	
	//ACCION PARA CARGAR ESTILOS Y SCRIPTS EN EL ADMINISTRADOR EN LA PAGINA DE MIGRACIÓN
	add_action( 'admin_print_scripts-' . $menu, 'custom_admin_js' );
		
	//ACCION PARA REGISTRAR LAS OPCIONES DEL PLUGIN	
	add_action( 'admin_init', 'migration_optmizaclick_register_options' );
	
	//COMPROBACION DE LAS OPCIONES DE ACTUALIZACION
	if(get_option('updates_core') == "n")
		add_filter('pre_site_transient_update_core','remove_updates');
	
	if(get_option('updates_plugins') == "n")
		add_filter('pre_site_transient_update_plugins','remove_updates');
	
	if(get_option('updates_themes') == "n")
		add_filter('pre_site_transient_update_themes','remove_updates');		
}

//FUNCION PARA DESHABILITAR LAS ACTUALIZACIONES
function remove_updates()
{
    global $wp_version;
	
	return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}

//ACCION INICIAL PARA AÑADIR LA OPCION DEL PLUGIN EN EL MENU DE HERRAMIENTAS
add_action( 'admin_menu', 'migration_admin_menu' );


//FUNCION PARA MOSTRAR LAS OPCIONES DEL PLUGIN
function migration_form()
{
?><div class="wrap_migration">

		<div id="load_div" class="dashicons dashicons-update"></div>

		<form method="post" action="options.php">
		
			<?php submit_button(); ?>
			
			<h1 class="title_plugin"><img src="<?php echo "../wp-content/plugins/".plugin_name."/img/icons/icon.png" ?>" alt="Icono Optimizaclick" /> <span> Migration Plugin</span></h1>
				
			
				
		<?php 
			settings_fields( 'migration_optimizaclick_options' ); 
			do_settings_sections( 'migration_optimizaclick_options' ); 
			
			?>		
		
			<div id="messages_plugin"></div>
			
			<div id="tabs">
								
				<ul>
					<li class="tab_links" title="#tabs-actualizaciones">Actualizaciones</li>
					<li class="tab_links" title="#tabs-admin-menu">Admin Menú</li>
					<li class="tab_links" title="#tabs-aviso-legal">Aviso Legal</li>
					<li class="tab_links" title="#tabs-backups">Backups</li>
					<li class="tab_links" title="#tabs-contact-form">Contact Form</li>
					<li class="tab_links" title="#tabs-cookies">Cookies</li>
					<li class="tab_links" title="#tabs-escaner">Escáner</li>
					<li class="tab_links" title="#tabs-footer">Footer</li>			
					<li class="tab_links" title="#tabs-login">Login</li>	
					<li class="tab_links" title="#tabs-optimizador">Optimizador</li>						
					<li class="tab_links" title="#tabs-plugins">Plugins</li>		
					<li class="tab_links" title="#tabs-seguridad">Seguridad</li>	
					<li class="tab_links" title="#tabs-woocommerce">WooCommerce</li>				
					
				</ul>
				
			</div>
			
			<div id="content_plugin_tabs">
			
				<div class="tab_content"  id="tabs-actualizaciones">
					
					<h2 class="title_migration">Configuración Actualizaciones</h2>
					
					
					<table class="form-table">
						<tr>
							<th scope="row">Notificaciones del núcleo:</th>
							<td>
								<select name="updates_core">
									<option <?php if("y" == get_option( 'updates_core' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'updates_core' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							<th scope="row">Notificaciones de plugins:</th>
							<td>
								<select name="updates_plugins">
									<option <?php if("y" == get_option( 'updates_plugins' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'updates_plugins' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							<th scope="row">Notificaciones de temas:</th>
							<td>
								<select name="updates_themes">
									<option <?php if("y" == get_option( 'updates_themes' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'updates_themes' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							
						</tr>
					</table>
					
				</div>
				
				<div class="tab_content"  id="tabs-admin-menu">
					
					<h2 class="title_migration">Configuración Menú de Administración</h2>
					
					
					<table class="form-table">

					<tr>
						<td colspan="2"><input type="button" class="button button-primary" id="checked_checkboxes_btn" value="Marcar todos" /> 
						<input type="button" class="button button-primary" id="unchecked_checkboxes_btn" value="Desmarcar todos" /></td>
						
						<td colspan="2"><p>Estas opciones <strong>NO</strong> se ocultarán para el usuario:
						
						
						<select name="user_menu_admin" id="user_menu_admin">
						
						<?php $args = array('orderby' => 'ID','order' => 'ASC' ); 
						$users = get_users( $args ); 
						
						foreach($users as $user)
						{
							echo "<option ";

							if(get_option( 'user_menu_admin' ) == $user->ID)
								echo " selected='selected' ";
							
							echo "value='".$user->ID."'>".$user->user_login."</option>";
						}
						
						?>
						
						</select>

					</tr>
			
					
					<?php
					
					global $menu;
					
					$admin_menu = get_option("migration_plugin_admin_menu_data");
					
					$x = 0;
	
					foreach($menu as $item)
					{		
						if($item[0] != "")
						{
							if($x % 4 == 0)
								echo "<tr>";
							
							if(strpos($item[0], "<span") > 0)
								$name = substr($item[0], 0, strpos($item[0], " "));
							else
								$name = $item[0];
							
							echo "<td><p class='admin_menu_check'><input type='checkbox' ";
							
							if($admin_menu[$item[2]] == 1) echo " checked ";

							echo " class='value_check' />";
							
							echo "<input type='hidden' class='admin_menu_name'  value='".$item[2]."' /> ".$name."</p></td>";
							
							$x++;
							
							if($x % 4 == 0)
								echo "</tr>";	
						}		
			
					}
					
					?>
					<tr>
						<td colspan="4">	
							<input type="button" class="button button-primary" value="Aplicar cambios" id="save_admin_menu" />
						</td>
					</tr>

					</table>

				</div>
			  
				<div class="tab_content"  id="tabs-aviso-legal">
					
					<h2 class="title_migration">Configuración Aviso Legal</h2>
					
					<table class="form-table">
						<tr>
							<th scope="row">Titulo página aviso legal:</th>
							<td>
								<input type="text" name="title_aviso_legal" id="title_aviso_legal"  value="<?php echo get_option( 'title_aviso_legal' ); ?>"/>
							</td>
							<th scope="row">Etiqueta aviso legal:</th>
							<td>
								<input type="text" name="slug_aviso_legal" id="slug_aviso_legal" value="<?php echo get_option( 'slug_aviso_legal' ); ?>"/>
							</td>
						</tr>
						<tr>		
							<th scope="row">Nombre empresa:</th>
							<td>
								<input type="text" name="name_empresa" id="name_empresa" value="<?php echo get_option( 'name_empresa' ); ?>"/>
							</td>
							<th scope="row">Dirección empresa:</th>
							<td>
								<input type="text" name="address_empresa" id="address_empresa" value="<?php if(get_option( 'address_empresa' ) == "") echo 'con domicilio social en ';  echo get_option( 'address_empresa' ); ?>"/>
							</td>
						</tr>
						<tr>				
							<th scope="row">CIF empresa:</th>
							<td>
								<input type="text" name="cif_empresa" id="cif_empresa" value="<?php  if(get_option( 'cif_empresa' ) == "") echo 'con CIF nº ';   echo get_option( 'cif_empresa' ); ?>"/>
							</td>
							<th scope="row">Registro mercantil empresa:</th>
							<td>
								<input type="text" name="register_empresa" id="register_empresa" value="<?php if(get_option( 'register_empresa' ) == "") echo 'e inscrita en el Registro Mercantil ';  echo get_option( 'register_empresa' ); ?>"/>
							</td>
						</tr>
						<tr>		
							<th scope="row">Dominio empresa:</th>
							<td>
								<input type="text" name="domain_empresa" id="domain_empresa" value="<?php echo get_option( 'domain_empresa' ); ?>"/>
							</td>
							<th scope="row">E-mail empresa:</th>
							<td>
								<input type="text" name="email_empresa" id="email_empresa" value="<?php echo get_option( 'email_empresa' ); ?>"/>
							</td>
						</tr>
						<tr>
							<th scope="row">	
								<input type="button" class="button button-primary" value="Crear página de aviso legal" id="button_aviso_legal_page" />
							</th>
						</tr>
					</table>
					
				</div>
				
				<div class="tab_content"  id="tabs-backups">
					<h2 class="title_migration">Backups</h2>
					
					<table class="form-table centered" id="backups_table">		
						<thead>
						<tr><th>Nombre</th><th>Fecha de creación</th><th>Tamaño (MB)</th><th></th></tr></thead>
						<tbody>
						
						<?php
					
							$dir = "../wp-content/plugins/".plugin_name."/backups/";

							if ($dh = scandir($dir, SCANDIR_SORT_ASCENDING)) 
							{
								foreach ($dh as $file) 
								{
									if($file != "." && $file != "..")
									{
										echo "<tr><td>".$file." </td><td> ".date('Y/m/d - H:i:s', filemtime($dir.$file))." </td><td> ".substr((filesize($dir.$file)/1000000), 0, -4)."</td>
										<td><a class='button button-primary' href='".$dir.$file."'>Descargar</a>&nbsp; <a id='del_".$file."' class='button button-primary delete_backups'>Eliminar</a></td></tr>";
									}
								}		
							}
						
						?>
												
						</tbody>						
						</table>

						<div id="content_backups"></div>
						<table class="form-table centered" >
							<tr>
								<th scope="row">Generar backup:</th>
									<td>
										<select id="generate_backup_url">
											<option value="db">Base de datos</option>							
											<option value="../">Plugins</option>
											<option value="../../themes/">Temas</option>
											<option value="../../uploads/">Uploads</option>
											<option value="../../../">Wordpress (ficheros)</option>
											<option value="../../">WP-content</option>
										</select>
									</td>
								</th>
								
								<td>
									<input type="text" id="url_old_wordpress" value="<?php echo get_home_url(); ?>"/>
								</td>
								<td>
									<input type="text" id="url_new_wordpress" placeholder="URL final" />
								</td>
								<td>
									<input type="button" class="button button-primary" value="Crear copia de seguridad" id="button_generate_backup" />
								</td>
							</tr>
						</table>
				</div>
				
				<div class="tab_content"  id="tabs-contact-form">
					
					<h2 class="title_migration">Configuración Contact Form</h2>
					
						<p class="contact_p">Generar contact form según el maquetador visual de la plantilla: 

						<select name="contact_form_type" id="contact_form_type">
							<option value="composer">Visual Composer</option>
							<option value="avada">Avada</option>
						</select>

						<input type="button" class="button button-primary" value="Generar Contact Form" id="generate_form" /></p>

					
				</div>
				
				<div class="tab_content"  id="tabs-cookies">
					
					<h2 class="title_migration">Configuración Cookies</h2>
							 
					<table class="form-table">		
						<tr>
							<th scope="row">Mostrar mensaje:</th>
							<td>
								<select name="display_message_cookies">
									<option <?php if("y" == get_option( 'display_message_cookies' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'display_message_cookies' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							<th scope="row">Ubicación del mensaje:</th>
							<td>
								<select name="position_cookies">
									<option <?php if("bottom" == get_option( 'position_cookies' )) echo "selected"; ?> value="bottom">Abajo</option>
									<option <?php if("top" == get_option( 'position_cookies' )) echo "selected"; ?> value="top">Arriba</option>
								</select>
							</td>
							<th scope="row">Ocultar mensaje:</th>
							<td>
								<select name="hide_cookies">
									<option <?php if("aceptar" == get_option( 'hide_cookies' )) echo "selected"; ?> value="aceptar">Botón Aceptar</option>
									<option <?php if("auto" == get_option( 'hide_cookies' )) echo "selected"; ?> value="auto">Automáticamente</option>
								</select>
							</td>
							
						</tr>
						</table>
						<table class="form-table">		
						
						<tr>			
							<th scope="row">Texto button cookies:</th>
							<td>
								<input type="text" name="text_button_cookies" value="<?php if(get_option( 'text_button_cookies' ) == "") echo 'Aceptar'; else echo get_option( 'text_button_cookies' ); ?>"/>
							</td>
							
							<th scope="row">Texto enlace cookies:</th>
							<td colspan="3">
								<input type="text" name="link_text_cookies" style="width: 100%;" value="<?php if(get_option( 'link_text_cookies' ) != "") echo get_option( 'link_text_cookies' ); else echo "condiciones de uso."; ?>" />
							</th>
							
						</tr>
						<tr>
							<th scope="row">Mensaje cookies:</th>
							<td colspan="5">
								<input type="text" name="text_message_cookies" style="width: 100%;" value="<?php if(get_option( 'text_message_cookies' ) != "") echo get_option( 'text_message_cookies' ); else echo "Esta web utiliza cookies. Si sigues navegando entendemos que aceptas las"; ?>" />
							</th>
						</tr>
					</table>
					
					<table class="form-table">	
						<tr>
							<th scope="row">Background color:</th>
							<td>
								<input type="color" name="background_color_cookies" value="<?php if(get_option( 'background_color_cookies' ) == "") echo '#ffffff'; else echo get_option( 'background_color_cookies' ); ?>"/>
							</td>
							<th scope="row">Font color:</th>
							<td>
								<input type="color" name="font_color_cookies" value="<?php if(get_option( 'font_color_cookies' ) == "") echo '#000000'; else echo get_option( 'font_color_cookies' ); ?>"/>
							</td>
							<th scope="row">Background color button:</th>
							<td>
								<input type="color" name="background_button_cookies" value="<?php if(get_option( 'background_button_cookies' ) == "") echo '#000000'; else echo get_option( 'background_button_cookies' ); ?>"/>
							</td>
							<th scope="row">Font color button:</th>
							<td>
								<input type="color" name="font_color_button_cookies" value="<?php if(get_option( 'font_color_button_cookies' ) == "") echo '#ffffff'; else echo get_option( 'font_color_button_cookies' ); ?>"/>
							</td>																			
						</tr>
					</table>
					
					<table class="form-table">					
						<tr>
							<th scope="row">Titulo política cookies:</th>
							<td>
								<input type="text" name="title_politica_cookies" id="title_politica_cookies"  value="<?php if(get_option( 'title_politica_cookies')  == "") echo "Política de Cookies"; else echo get_option( 'title_politica_cookies' ); ?>"/>
							</td>
							<th scope="row">Slug política cookies:</th>
							<td>
								<input type="text" name="slug_politica_cookies" id="slug_politica_cookies" value="<?php if(get_option( 'slug_politica_cookies')  == "") echo "politica-cookies"; else echo get_option( 'slug_politica_cookies' ); ?>"/>
							</td>
						</tr>
												
						<tr>
							<th scope="row">Titulo información cookies:</th>
							<td>
								<input type="text" name="title_mas_informacion" id="title_mas_informacion" value="<?php if(get_option( 'title_mas_informacion')  == "") echo "Más información sobre las Cookies"; else echo get_option( 'title_mas_informacion' ); ?>"/>
							</td>
							<th scope="row">Slug información cookies:</th>
							<td>
								<input type="text" name="slug_mas_informacion" id="slug_mas_informacion" value="<?php if(get_option( 'slug_mas_informacion')  == "") echo "informacion-cookies"; else echo get_option( 'slug_mas_informacion' ); ?>"/>
							</td>
						</tr>
						<tr>
							<th scope="row">	
								<input type="button" class="button button-primary" value="Crear páginas sobre las cookies" id="button_cookies_pages" />
							</th>
						</tr>
					</table>
					
				</div>
				
				<div class="tab_content"  id="tabs-escaner">
					<h2 class="title_migration">Escáner</h2>
								 
						<table class="form-table centered" id="scan_table">		
						<thead>
						<tr><th>Nombre fichero</th><th>Fecha modificación</th><th>Tamaño (bytes)</th><th>Permisos</th></tr></thead>
												
						</table>
						
						<p><input type="button" class="button button-primary" value="Escanear ficheros" id="button_scan_files" /></p>
				</div>
				
				<div class="tab_content"  id="tabs-footer">
						
					<h2 class="title_migration">Configuración Footer</h2>
					
					<table class="form-table">
						<tr>
							<th scope="row">Mostrar footer:</th>
							<td>
								<select name="footer_display">						
									<option <?php if("y" == get_option( 'footer_display' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'footer_display' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							<th scope="row">Boxed footer:</th>
							<td>
								<select name="boxed_footer">						
									<option <?php if("n" == get_option( 'boxed_footer' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'boxed_footer' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>
							<th scope="row">Footer fixed Betheme:</th>
							<td>
								<select name="footer_betheme">
									<option <?php if("n" == get_option( 'footer_betheme' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'footer_betheme' )) echo "selected"; ?> value="y">Si</option>

								</select>
							</td>
											
						</tr>
						<tr>
							<th scope="row">Background footer:</th>
							<td>
								<input type="color" name="footer_background_color" value="<?php if(get_option( 'footer_background_color' ) != "") echo get_option( 'footer_background_color' ); else echo "#000000" ?>"/>
							</td>
							<th scope="row">Font color footer:</th>
							<td>
								<input type="color" name="footer_font_color" value="<?php if(get_option( 'footer_font_color' ) != "") echo get_option( 'footer_font_color' ); else echo "#ffffff" ?>"/>
							</td>
							<th scope="row">Footer width:</th>
							<td>
								<input type="text" name="footer_width" value="<?php if(get_option( 'footer_width' ) != "") echo get_option( 'footer_width' ); else echo "100%"; ?>"/>
							</td>	
						</tr>
						<tr>
							<th scope="row">Mostrar logo Optimizaclick:</th>
							<td>
								<select name="optimiza_logo_display">
									<option <?php if("y" == get_option( 'optimiza_logo_display' )) echo "selected"; ?> value="y">Si</option>
									<option <?php if("n" == get_option( 'optimiza_logo_display' )) echo "selected"; ?> value="n">No</option>
								</select>
							</td>
							<th scope="row">Versión logo Optimizaclick:</th>
							<td>
								<select id="optimiza_logo_version" name="optimiza_logo_version">
								
								<?php 
									$directorios = scandir("../wp-content/plugins/".plugin_name."/img/");
									
									foreach ($directorios as $nombre_fichero)
									{				
										if($nombre_fichero != "." && $nombre_fichero != ".." && $nombre_fichero != "icons")
										{
											echo '<option ';  
											
											if( $nombre_fichero == get_option( 'optimiza_logo_version' )) echo "selected"; 
											
											echo ' value="'.$nombre_fichero.'">'.substr($nombre_fichero, 0, -4).'</option>';
										}

								 } ?>
								</select>
							</td>
							<th scope="row">Alt logo Optimizaclick:</th>
							<td>
								<input type="text" name="alt_logo_optimizaclick" value="<?php if(get_option( 'alt_logo_optimizaclick' ) == "") echo 'Posicionamiento SEO'; else echo get_option( 'alt_logo_optimizaclick' ); ?>"/>
							</td>
						</tr>
					</table>
					
					<div id="prev_logo_optimizaclick" style="background-image: url('<?php echo WP_PLUGIN_URL.'/'.plugin_name.'/img/'.get_option('optimiza_logo_version'); ?>')"></div>
					
				</div>
					
				<div class="tab_content"  id="tabs-login">
				
					<h2 class="title_migration">Configuración Login</h2>
					
					<table class="form-table">
						<tr>
							<th scope="row">Cambiar estilos login:</th>
							<td>
								<select name="enable_login_styles">								
									<option <?php if("n" == get_option( 'enable_login_styles' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'enable_login_styles' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">URL logo login:</th>
							<td colspan="2">
								<input type="text" name="url_logo_image" id="url_logo_image"  value="<?php echo get_option( 'url_logo_image' ); ?>"/>
							</td>
							<th scope="row">URL background login:</th>
							<td colspan="2">
								<input type="text" name="url_login_image" id="url_login_image"  value="<?php echo get_option( 'url_login_image' ); ?>"/>
							</td>
							
						<tr valign="top">	
							<th scope="row">Altura logo login (px):</th>
							<td>
								<input type="number" name="height_login_image" id="height_login_image"  value="<?php echo get_option( 'height_login_image' ); ?>"/>	
							</td>
							<th scope="row">Anchura logo login (px):</th>
							<td>
								<input type="number" name="width_login_image" id="width_login_image"  value="<?php echo get_option( 'width_login_image' ); ?>"/>
							</td>
							<td>
								<input id="load_dimensions_logo" class="button button-primary" type="button" value="Cargar dimensiones" />	
							</td>
						</tr>	
						</tr>
						</table>
						<table class="form-table">
						<tr>
							<th scope="row">Background color:</th>
							<td>
								<input type="color" name="login_background_color" value="<?php if(get_option( 'login_background_color' ) == "") echo '#F1F1F1'; else  echo get_option( 'login_background_color' ); ?>"/>
							</td>
							<th scope="row">Form color:</th>
							<td>
								<input type="color" name="login_form_color" value="<?php if(get_option( 'login_form_color' ) == "") echo '#FFFFFF'; else echo  get_option( 'login_form_color' ); ?>"/>
							</td>
							<th scope="row">Button form color:</th>
							<td>
								<input type="color" name="button_form_color" value="<?php if(get_option( 'button_form_color' ) == "") echo '#0091CD'; else echo  get_option( 'button_form_color' ); ?>"/>
							</td>
						</tr>
						<tr>
							<th scope="row">Form font color:</th>
							<td>
								<input type="color" name="font_form_color" value="<?php if(get_option( 'font_form_color' ) == "") echo '#008EC2'; else echo get_option( 'font_form_color' ); ?>"/>
							</td>
							<th scope="row">Form button font color:</th>
							<td>
								<input type="color" name="font_button_form_color" value="<?php if(get_option( 'font_button_form_color' ) == "") echo '#ffffff'; else echo get_option( 'font_button_form_color' ); ?>"/>
							</td>
							
						</tr>
						<tr>
							<th scope="row">Habilitar redirección login:</th>
							<td>
								<select name="enable_login_redirect">								
									<option <?php if("n" == get_option( 'enable_login_redirect' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'enable_login_redirect' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>
							<th scope="row">URL redirección login:</th>
							<td colspan="3">
								<input type="text" name="url_login_redirect" value="<?php echo get_option( 'url_login_redirect' ); ?>"/>
							</td>
						</tr>
						<tr>
							<th scope="row">Habilitar redirección logout:</th>
							<td>
								<select name="enable_logout_redirect">								
									<option <?php if("n" == get_option( 'enable_logout_redirect' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'enable_logout_redirect' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>
							<th scope="row">URL redirección logout:</th>
							<td colspan="3">
								<input type="text" name="url_logout_redirect" value="<?php echo get_option( 'url_logout_redirect' ); ?>"/>
							</td>
						</tr>
						
					</table>
				
				</div>
				
				<div class="tab_content"  id="tabs-optimizador">
					<h2 class="title_migration">Optimizador</h2>
					
 
						<table class="form-table centered" id="scan_deleted_table">		
						<thead>
						<tr><th>Nombre fichero</th><th>Fecha modificación</th><th>Tamaño (bytes)</th><th>Permisos</th></tr></thead>
												
						</table>
						
						<p><input type="button" class="button button-primary" value="Buscar ficheros innecesarios" id="button_scan_deleted_files" />
						<input type="button" class="button button-primary" value="Eliminar ficheros innecesarios" id="button_deleted_files" /></p>
				</div>
				
				<div class="tab_content"  id="tabs-plugins">
					<h2 class="title_migration">Plugins recomendados</h2>
								 
						<table class="form-table centered" id="plugins_table">		
						<thead>
						<tr><th>Nombre</th><th>Estado</th><th>Acción</th></tr></thead>
						<tbody>
						
						<?php
							//DIRECTORIO DE Plugins
							$dir = "../wp-content/plugins/";
							
							//ARRAY CON LOS DATOS DE PLUGINS RECOMENDADOS
							$plugins = array(
								"Akismet" => array( "slug" => "akismet", "url" => "https://downloads.wordpress.org/plugin/akismet.3.1.11.zip"),
								"All in One SEO Pack" => array( "slug" => "all-in-one-seo-pack", "url" => "https://downloads.wordpress.org/plugin/all-in-one-seo-pack.2.3.5.1.zip"),
								"Contact form to Database" => array( "slug" => "contact-form-7-to-database-extension", "url" => "https://downloads.wordpress.org/plugin/contact-form-7-to-database-extension.2.10.13.zip"),
								"Contact Form 7" => array( "slug" => "contact-form-7", "url" => "https://downloads.wordpress.org/plugin/contact-form-7.4.4.2.zip"),
								"Insert Codes Plugin" => array( "slug" => "insert-codes-plugin-master", "url" => "https://github.com/Optimiza-Click/insert-codes-plugin/archive/master.zip"),
								"P3 Profiler" => array( "slug" => "p3-profiler", "url" => "https://downloads.wordpress.org/plugin/p3-profiler.1.5.3.9.zip"),								
								"Updraft Plus" => array( "slug" => "updraftplus", "url" => "https://downloads.wordpress.org/plugin/updraftplus.1.12.13.zip"),
								"WooCommerce Google Analytics" => array( "slug" => "woocommerce-google-analytics-integration", "url" => "https://downloads.wordpress.org/plugin/woocommerce-google-analytics-integration.1.4.0.zip"),
								"WP Mandrill" => array( "slug" => "wpmandrill", "url" => "https://downloads.wordpress.org/plugin/wpmandrill.zip"),
								"WP Migrate DB" => array("slug" => "wp-migrate-db", "url" => "https://downloads.wordpress.org/plugin/wp-migrate-db.0.8.zip"),
								"WP Plugin Tutoriales" => array( "slug" => "Lifeguard---OptimizaClick-master", "url" => "https://github.com/david1311/Lifeguard---OptimizaClick/archive/master.zip")
								
								);
									
							//SE LISTAN QUE PLUGINS RECOMENDADOS ESTAN INSTALADOS
							foreach($plugins as $plugin=>$key)
							{
								echo "<tr><td>".$plugin."<input type='hidden' id='val_".$key["slug"]."' value='".$key["url"]."' /></td>";
								
								if(file_exists($dir.$key["slug"]))							
									echo "<td><span id='mess_".$key["slug"]."'>Instalado</span></td><td></td></tr>";
								else
									echo "<td><span id='mess_".$key["slug"]."'>No Instalado</span></td><td><input type='button' class='button button-primary install_plugins' value='Instalar' id='install_".$key["slug"]."' /></td></tr>";
							}							
							 
						
						?>
												
						</tbody>						
						</table>
						
				</div>
				
				<div class="tab_content"  id="tabs-seguridad">
					<h2 class="title_migration">Configuración Seguridad</h2>
								 
						<table class="form-table">		
							<tr>
								<th colspan="2">
									<input type="button" class="button button-primary" value="Cambiar permisos de ficheros" id="button_permissions_files" />
								</th>
								<th scope="row">Recaptcha en login:</th>
								<td>
									<select name="recaptcha_google_activate">								
										<option <?php if("n" == get_option( 'recaptcha_google_activate' )) echo "selected"; ?> value="n">No</option>
										<option <?php if("y" == get_option( 'recaptcha_google_activate' )) echo "selected"; ?> value="y">Si</option>
									</select>
								</td>						
							</tr>
							<tr>
								<th scope="row">Clave del sitio (Recaptcha):</th>
								<td>
									<input type="text" id="recaptcha_site_key" name="recaptcha_site_key" value="<?php echo get_option( 'recaptcha_site_key' ); ?>"/>
								</td>
								<th scope="row">Clave secreta (Recaptcha):</th>
								<td>
									<input type="text" id="recaptcha_secret_key" name="recaptcha_secret_key" value="<?php echo get_option( 'recaptcha_secret_key' ); ?>"/>
								</td>			
							</tr>				
						</table>
				</div>
					
				<div class="tab_content"  id="tabs-woocommerce">	
				
					<h2 class="title_migration">Configuración WooCommerce</h2>
				
					<table class="form-table woocommerce_table">		
						<tr>
							
							<th scope="row">Modo catálogo:</th>
							<td>
								<select name="catalog_mode">								
									<option <?php if("n" == get_option( 'catalog_mode' )) echo "selected"; ?> value="n">No</option>
									<option <?php if("y" == get_option( 'catalog_mode' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>		
							<th scope="row">Ocultar precios:</th>
							<td>
								<select name="catalog_mode_price">								
									<option <?php if("n" == get_option( 'catalog_mode_price' )) echo "selected"; ?> value="n">No</option>	
									<option <?php if("y" == get_option( 'catalog_mode_price' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>	
							
						</tr>
						<tr>
							<th scope="row">Modifcar productos por página:</th>
							<td>
								<select name="enable_produts_page">								
									<option <?php if("n" == get_option( 'enable_produts_page' )) echo "selected"; ?> value="n">No</option>	
									<option <?php if("y" == get_option( 'enable_produts_page' )) echo "selected"; ?> value="y">Si</option>
								</select>
							</td>	
							<th scope="row">Productos por página:</th>
							<td>
								<input type="text" id="num_produts_page" name="num_produts_page" value="<?php if(get_option( 'num_produts_page' ) != "") echo get_option( 'num_produts_page' ); else echo 12; ?>"/>
							</td>	
						</tr>
					</table>
				</div>

			</div>	
						
			<input type="hidden" value="<?php echo WP_PLUGIN_URL."/".plugin_name."/"; ?>" id="url_base" />
		</form>
		
		<style>div.notice, .update-nag, #wpfooter,  #message{display: none !important;}</style>
		
  </div><?php 

}   

//SE REGISTRAN TODAS LAS OPCIONES DEL PLUGIN PARA QUE SE GUARDEN EN LA TABLA OPTIONS
function migration_optmizaclick_register_options() 
{
	register_setting( 'migration_optimizaclick_options', 'footer_display' );
	register_setting( 'migration_optimizaclick_options', 'footer_width' );
	register_setting( 'migration_optimizaclick_options', 'boxed_footer' );
	register_setting( 'migration_optimizaclick_options', 'footer_background_color' );
	register_setting( 'migration_optimizaclick_options', 'footer_font_color' );
	register_setting( 'migration_optimizaclick_options', 'optimiza_logo_display' );
	register_setting( 'migration_optimizaclick_options', 'optimiza_logo_version' );
	register_setting( 'migration_optimizaclick_options', 'slug_aviso_legal' );
	register_setting( 'migration_optimizaclick_options', 'title_aviso_legal' );
	register_setting( 'migration_optimizaclick_options', 'name_empresa' );
	register_setting( 'migration_optimizaclick_options', 'address_empresa' );
	register_setting( 'migration_optimizaclick_options', 'cif_empresa' );
	register_setting( 'migration_optimizaclick_options', 'register_empresa' );
	register_setting( 'migration_optimizaclick_options', 'domain_empresa' );
	register_setting( 'migration_optimizaclick_options', 'email_empresa' );
	register_setting( 'migration_optimizaclick_options', 'url_login_image' );
	register_setting( 'migration_optimizaclick_options', 'height_login_image' );
	register_setting( 'migration_optimizaclick_options', 'width_login_image' );
	register_setting( 'migration_optimizaclick_options', 'login_background_color' );
	register_setting( 'migration_optimizaclick_options', 'login_form_color' );
	register_setting( 'migration_optimizaclick_options', 'font_form_color' );
	register_setting( 'migration_optimizaclick_options', 'font_button_form_color' );
	register_setting( 'migration_optimizaclick_options', 'footer_betheme' );
	register_setting( 'migration_optimizaclick_options', 'alt_logo_optimizaclick' );
	register_setting( 'migration_optimizaclick_options', 'updates_core' );
	register_setting( 'migration_optimizaclick_options', 'updates_plugins' );
	register_setting( 'migration_optimizaclick_options', 'updates_themes' );
	register_setting( 'migration_optimizaclick_options', 'display_message_cookies' );
	register_setting( 'migration_optimizaclick_options', 'title_politica_cookies' );
	register_setting( 'migration_optimizaclick_options', 'slug_politica_cookies' );
	register_setting( 'migration_optimizaclick_options', 'title_mas_informacion' );
	register_setting( 'migration_optimizaclick_options', 'slug_mas_informacion' );
	register_setting( 'migration_optimizaclick_options', 'position_cookies' );
	register_setting( 'migration_optimizaclick_options', 'background_color_cookies' );
	register_setting( 'migration_optimizaclick_options', 'font_color_cookies' );	
	register_setting( 'migration_optimizaclick_options', 'hide_cookies' );	
	register_setting( 'migration_optimizaclick_options', 'text_button_cookies' );	
	register_setting( 'migration_optimizaclick_options', 'background_button_cookies' );		
	register_setting( 'migration_optimizaclick_options', 'font_color_button_cookies' );	
	register_setting( 'migration_optimizaclick_options', 'button_form_color' );
	register_setting( 'migration_optimizaclick_options', 'url_logo_image' );	
	register_setting( 'migration_optimizaclick_options', 'recaptcha_google_activate' );	
	register_setting( 'migration_optimizaclick_options', 'recaptcha_site_key' );	
	register_setting( 'migration_optimizaclick_options', 'recaptcha_secret_key' );	
	register_setting( 'migration_optimizaclick_options', 'enable_login_redirect' );	
	register_setting( 'migration_optimizaclick_options', 'url_login_redirect' );	
	register_setting( 'migration_optimizaclick_options', 'enable_logout_redirect' );	
	register_setting( 'migration_optimizaclick_options', 'url_logout_redirect' );	
	register_setting( 'migration_optimizaclick_options', 'catalog_mode' );	
	register_setting( 'migration_optimizaclick_options', 'text_message_cookies' );		
	register_setting( 'migration_optimizaclick_options', 'link_text_cookies' );	
	register_setting( 'migration_optimizaclick_options', 'enable_login_styles' );	
	register_setting( 'migration_optimizaclick_options', 'catalog_mode_price' );	
	register_setting( 'migration_optimizaclick_options', 'num_produts_page' );	
	register_setting( 'migration_optimizaclick_options', 'enable_produts_page' );	
	register_setting( 'migration_optimizaclick_options', 'user_menu_admin' );
}

//FUNCION PARA OCULTAR LAS OPCIONE DEL MENU DE ADMINISTRACION
function hide_menu_options()
{
	global $menu;
	
	$current_user = wp_get_current_user();
	
	//SE COMPRUEBA CUAL ES EL USUARIO CON EL QUE SE INICIO SESION
	if( get_option( 'user_menu_admin' ) != $current_user->ID)
	{
		$admin_menu = get_option("migration_plugin_admin_menu_data");
		
		//SE COMPRUEBA CADA OPCION DEL MENU PARA OCULTARLA EN EL CASO CORRESPONDIENTE
		foreach($menu as $item)
		{		
			if($admin_menu[$item[2]] == 1)
			{
				remove_menu_page($item[2]);
			}	
		}
			
		//EN EL CASO DEL VISUAL COMPOSER HAY QUE COMPROBARLO DIFERENTE POR EL CAMBIO DE SLUG
		if($admin_menu["vc-general"] == 1)
			remove_menu_page("vc-welcome");
	}
}

//ACCION PARA OCULTAR LAS OPCIONE DEL MENU DE ADMINISTRACION
add_action('admin_init', "hide_menu_options");


//FUNCION PARA CARGAR SCRIPTS EN EL ADMINISTRADOR
function custom_admin_js() 
{
	wp_enqueue_script( 'migration_script', WP_PLUGIN_URL. '/'.plugin_name.'/js/migration.js', array('jquery') );
	
	wp_enqueue_script( 'colorpicker_script', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/js/colorpicker.js', array('jquery') );
	wp_enqueue_script( 'colorpicker_eye', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/js/eye.js', array('jquery') );
	wp_enqueue_script( 'colorpicker_utils', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/js/utils.js', array('jquery') );
	wp_enqueue_script( 'colorpicker_layout', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/js/layout.js', array('jquery') );
	
	wp_enqueue_script( 'datatables', 'http://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js' );
	
	//ACCION PARA CARGAR ESTILOS EN LA ADMINISTRACION
	add_action('admin_head', "custom_admin_styles");
}

//FUNCION PARA CARGAR ESTILO GENERAL DEL PLUGIN
function migration_admin_styles() 
{
	wp_register_style( 'custom_wp_admin_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/migration-style.css', false, '1.0.0' );	
	wp_enqueue_style( 'custom_wp_admin_css' );
}

//ACCION PARA CARGAR ESTILO GENERAL DEL PLUGIN
add_action('admin_head', "migration_admin_styles");

//FUNCION PARA CARGAR ESTILOS EN EL ADMINISTRADOR
function custom_admin_styles() 
{
	wp_register_style( 'custom_colorpicker', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/css/colorpicker.css', false, '1.0.0' );
	wp_register_style( 'colorpicker_layout', WP_PLUGIN_URL. '/'.plugin_name.'/colorpicker/css/layout.css', false, '1.0.0' );
	wp_register_style( 'datatables', 'http://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css', false, '1.0.0' );
	
	wp_enqueue_style( 'custom_colorpicker' );
	wp_enqueue_style( 'custom_colorpicker' );
	wp_enqueue_style( 'datatables' );
}

//FUNCION PARA OCULTAR LAS NOTIFICACIONES VISUALES DE LAS ACTUALIZACIONES
function custom_css_updates()
{
	wp_register_style( 'custom_updates_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/updates-style.css', false, '1.0.0' );
	  
	wp_enqueue_style( 'custom_updates_css' );
}

//ACCION PARA OCULTAR LAS NOTIFICACIONES DE LAS ACTUALIZACIONES
if(get_option('updates_plugins') == "n")
	add_action( 'admin_print_scripts', 'custom_css_updates' );

//FUNCION PARA CARGAR ESTILOS Y SCRIPTS EN LA PAGINA
function custom_js_styles() 
{
	wp_enqueue_script( 'cookies_script', WP_PLUGIN_URL. '/'.plugin_name.'/js/cookies.js', array('jquery') );
	
	wp_register_style( 'custom_wp_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/front-style.css', false, '1.0.0' );
	
	wp_enqueue_style( 'custom_wp_css' );
	
	//SE CARGAN EL CSS QUE OCULTA LOS BOTONES DE AÑADIR LOS PRODUCTOS AL CARRTIO
	if(get_option("catalog_mode") == "y")
	{
		wp_register_style( 'catalog_mode_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/catalog_mode.css', false, '1.0.0' );
		
		wp_enqueue_style( 'catalog_mode_css' );
	}
	
	//SE CARGA EL CSS PARA OCULTAR LOS PRECIOS DE LOS PRODUCTOS
	if(get_option("catalog_mode_price") == "y")
	{
		wp_register_style( 'catalog_mode__price_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/catalog_mode_price.css', false, '1.0.0' );
		
		wp_enqueue_style( 'catalog_mode__price_css' );
	}
}

//ACCION PARA CARGAR ESTILOS Y SCRIPTS EN LA PAGINA
add_action( 'wp_enqueue_scripts', 'custom_js_styles' );

//FUNCION PARA CARGAR LOS ESTILOS DEFINIDOS Y LOS SCRIPTS EN EL PLUGIN EN LA PAGINA DE LOGIN
function custom_login_style() 
{
	if(get_option( 'login_background_color' ) == "")
		$backgroundcolor = '#F1F1F1';
	else
		$backgroundcolor = get_option( 'login_background_color' );
	
	if(get_option( 'login_form_color' ) == "")
		$formcolor = '#F1F1F1';
	else
		$formcolor = get_option( 'login_form_color' );
	
	if(get_option( 'button_form_color' ) == "")
		$formbuttoncolor = '#0091CD';
	else
		$formbuttoncolor = get_option( 'button_form_color' );
	
	if(get_option( 'font_form_color' ) == "")
		$formfontcolor = '#F1F1F1';
	else
		$formfontcolor = get_option( 'font_form_color' );
	
	if(get_option('font_button_form_color') == "")
		$fombuttonfontcolor = '#fff';
	else
		$fombuttonfontcolor = get_option( 'font_button_form_color' );
	
	echo '<style>.login h1 a {
    background-image:  url("'.get_option( 'url_logo_image' ).'") !important;
    background-size: cover !important;
	height: '.get_option( 'height_login_image' ).'px !important;
	width: '.get_option( 'width_login_image' ).'px !important;
	}	
	body{
	background-image:  url("'.get_option( 'url_login_image' ).'") !important;
    background-size: cover !important;
    background-color: '.$backgroundcolor.' !important;
	}
	#loginform{
    background-color: '.$formcolor.' !important;
	}	
	#loginform p label, #loginform a, .login #nav a, #backtoblog a{
		color: '.$formfontcolor.' !important;
	}
	#wp-submit{
    background-color: '.$formbuttoncolor.' !important; border-color: '.$formbuttoncolor.' !important; 
	color: '.$fombuttonfontcolor.' !important; text-shadow: none !important;
	}	
	#login{width:340px !important;}
	.g-recaptcha>div>div{width: 100% !important;height: 85px !important;}
	body div .rc-anchor-logo-portrait{margin-left: 0px !important; margin-top: 10px !important;}
	iframe{width: 100% !important;}
	</style>';
}

//ACCION PARA AÑADIR ESTILOS Y SCRIPTS EN LA PAGINA DE LOGIN
if(get_option("enable_login_styles") == "y")
	add_action( 'login_head', 'custom_login_style' );

//SE CARGAN LOS SCRIPTS NECESARIOS PARA EL RECPATCHA DE GOOGLE
function login_recaptcha_script() 
{
	wp_register_script("recaptcha_login", "https://www.google.com/recaptcha/api.js");
	wp_enqueue_script("recaptcha_login");
}

//SE AÑADE EL CODIGO DEL RECPATCHA EL FORMULARIO DE LOGIN
function display_login_captcha() 
{ ?>
	<div class="g-recaptcha" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
<?php 
}

//VERIFICACION DEL RECPATCHA DE GOOGLE
function verify_login_captcha($user, $password) 
{
	if (isset($_POST['g-recaptcha-response'])) 
	{
		$recaptcha_secret = get_option('recaptcha_secret_key');
		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=". $recaptcha_secret ."&response=". $_POST['g-recaptcha-response']);
		$response = json_decode($response["body"], true);
		
		if (true == $response["success"]) 
			return $user;
		else 
			return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: Complete el Recaptcha"));	
	} 
	else 
		return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: Complete el Recaptcha. Compruebe que tiene habilitado Javascript.")); 
}

//SE COMPRUEBA SI ESTA HABILITADO EL RECPATCHA DE GOOGLE
if(get_option('recaptcha_google_activate') == "y")
{
	//SE CARGAN LAS FUNCIONES PARA EL FUNCIONAMIENTO DEL RECPATCHA
	add_action( "login_form", "display_login_captcha" );
	add_action("login_enqueue_scripts", "login_recaptcha_script");
	add_filter("wp_authenticate_user", "verify_login_captcha", 10, 2);
}

//FUNCION PARA MOSTRAR EL FOOTER CON EL AVISO LEGAL Y EL LOGO DE OPTIMIZACLICK
function footer_content() 
{
	$footer_style = 'width: 100%;float:left;position:relative;z-indez:99999;background-color: '.get_option( 'footer_background_color' ).';color: '.get_option( 'footer_font_color' ).';';
	
	if(get_option("boxed_footer") == "y")
		$footer_style .= 'max-width: '.get_option('footer_width').';margin: 0 auto;';
	else
		$footer_style .= 'width: 100%;';
	
	//ESTILOS PARA EL SLIDYNG FOOTER DE BETHEME
	if(get_option( 'footer_betheme' ) == "y") 
	{
		$footer_style .= "position: fixed;z-index: 1;bottom: 0px;";

		echo "<style>#Footer{bottom: 100px !important;z-index: 1 !important;}</style>";
	}
	
	
	//SE CARGA EL FOOTER CON LOS ESTILOS ELEGIDOS Y EL ENLACE AL AVISO LEGAL
    echo '<div style="'.$footer_style.' !important;">';
	
	if(get_option("boxed_footer") == "y")
		echo '<div style="max-width: 100%;padding: 3px 0px;margin: 0 auto !important;">';
	else
		echo '<div style="width: '.get_option('footer_width').';padding: 3px 0px;margin: 0 auto !important;">';
	
	echo "<div class='columns_1_4_footer'>";
	echo '<p style="padding-left: 5%;padding-top: 5px;color:'.get_option( 'footer_font_color' ).'">® '.date("Y").' '.get_option( 'name_empresa' ).' 
		- <a style="color:'.get_option( 'footer_font_color' ).'" href="'.get_home_url().'/'.get_option('slug_aviso_legal').'">'.get_option('title_aviso_legal').'
		</a></p>';
		
	echo "</div><div class='columns_1_2_footer'>";
	
	dynamic_sidebar( 'widget_area_footer_plugin' );	
	
	echo "</div><div class='columns_1_4_footer'>";
	
	//SE MUESTRA EL LOGO DE OPTIMIZACLICK
	if(get_option('optimiza_logo_display') == 'y')
		echo	'<a style="float:right;padding-right: 5%;" href="http://www.optimizaclick.com/" target="_blank" title="'.get_option('alt_logo_optimizaclick').'">
			<img src="'.WP_PLUGIN_URL.'/'.plugin_name.'/img/'.get_option('optimiza_logo_version').'" alt="'.get_option('alt_logo_optimizaclick').'" />
		</a>';
		
	echo '</div></div></div>';
}

//ACTION PARA AÑADIR EL FOOTER
if(get_option("footer_display") == "y")
add_action( 'wp_footer', 'footer_content', 100 );


//FUNCION PARA AÑADIR EL SCRIPT DE COMPROBACION DE ERRORES JAVASCRIPT PARA SENTRY 
function footer_scripts()
{
	echo '<script src="https://cdn.ravenjs.com/2.3.0/raven.min.js"></script>';
	
	$theme = strtoupper (substr(get_bloginfo('template_directory'), strpos(get_bloginfo('template_directory'), "themes") + 7));

	echo "<script> Raven.config('https://1cd56edc3780439a8cf73bfcb493e5ed@sentry.optimizaclick.com/3').setTagsContext({ 'WP_VERSION': '".get_bloginfo('version')."', 'WP_THEME': '".$theme."' }).install(); 
	
	</script>";
}

add_action( 'wp_footer', 'footer_scripts', 101 );

/// FUNCION QUE MUESTRA EL AVISO DE COOKIES, POR DEFECTO ESTA OCULTO POR CSS
function header_content() 
{
	?>
			<div class="div_cookies" style="display: none;<?php echo get_option('position_cookies'); ?>: 0px; background-color: <?php echo get_option('background_color_cookies'); ?>;">
			
				<div class="block_cookies">
					<div <?php if(get_option('hide_cookies') != "auto") echo 'class="col_2_3"' ?>>
					
					<p class="texto_cookies" style="color: <?php echo get_option('font_color_cookies'); ?>;">
					
						<?php echo get_option("text_message_cookies"); ?>
						
						<strong><a style="text-decoration: underline;color: <?php echo get_option('font_color_cookies'); ?>;" target="_blank" 
						href="<?php echo get_home_url().'/'.get_option('slug_politica_cookies'); ?>"> <?php echo get_option("link_text_cookies"); ?></a></strong>
						
						<input type='hidden' value='<?php echo get_option('hide_cookies'); ?>' id='cookie_mode' />
						</p>
						</div>
						<?php
						
						if(get_option('hide_cookies') != "auto")
						{
							?> 
								<div class="col_1_3">
								<span id="btn_cookies" style="color: <?php echo get_option('font_color_button_cookies'); ?>; 
								background-color: <?php echo get_option('background_button_cookies'); ?>">
								<?php echo get_option('text_button_cookies'); ?></span></div>
							
							<?php
						}
						?>
				
				</div>
				
			</div>
		
		<?php
}

//ACTION PARA AÑADIR EL AVISO DE COOKIES
if(get_option("display_message_cookies") == "y")
	add_action( 'wp_footer', 'header_content', 1 );

//FUNCION PARA LA REDIRECCION TRAS EL INICIAR SESION
function custom_login_redirect()
{
	wp_redirect(get_option("url_login_redirect"));
	
	exit();
}

//ACCION PARA LA REDIRECCION TRAS EL INICIAR SESION
if(get_option("enable_login_redirect") == "y")
	add_action( 'wp_login', 'custom_login_redirect' );


//FUNCION PARA LA REDIRECCION TRAS CERRAR SESION
function custom_logout_redirect()
{
	wp_redirect(get_option("url_logout_redirect"));
	
	exit();
}

//ACCION PARA LA REDIRECCION TRAS CERRAR SESION
if(get_option("enable_logout_redirect") == "y")
	add_action( 'wp_logout', 'custom_logout_redirect');


//FUNCION PARA CAMBIAR EL LINK DEL LOGO DEL LOGIN
function logo_url_login()
{
    return get_home_url();
}

//ACCION PARA CAMBIAR EL LINK DEL LOGO DEL LOGIN
add_filter( 'login_headerurl', 'logo_url_login' );

//FUNCION PARA MODIFICAR EL NUMERO DE PRODUCTOS LISTADOS POR PAGINA
if(get_option("enable_produts_page") == "y")
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.get_option("num_produts_page").';' ), 20 );


//SE GENERA UN AREA DE WIDGET PARA EL FOOTER FINAL
function widget_area_footer_plugin() {

	register_sidebar( array(
		'name' => 'Optimizaclick Widget Area',
		'id' => 'widget_area_footer_plugin',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}

add_action( 'widgets_init', 'widget_area_footer_plugin' );

//SE ACTIVAN LAS ACTIVIDADES CRON DEL PLUGIN AL SER ACTIVADO
register_activation_hook(__FILE__, 'activate_cron_accions');

//SE ASOCIA UNA FUNCION AL ACTIVARSE EL PLUGIN
function activate_cron_accions() 
{
	//SE REGISTRA UNA ACCION PARA QUE SE EJECUTE DIARIAMENTE
    if (! wp_next_scheduled ( 'optimiza_notifications' )) 
		wp_schedule_event(time(), 'daily', 'optimiza_notifications');
	
	//SE REGISTRA UNA ACCION PARA QUE SE EJECUTE 2 VECES AL DIA
	if (! wp_next_scheduled ( 'optimiza_plugin_auto_update' )) 
		wp_schedule_event(time(), 'twicedaily', 'optimiza_plugin_auto_update');	
}

//SE ASOCIAN LAS FUNCIONES QUE REALIZARAN LAS ACCIONES DE LAS ACTIVIDADES DEL CRON
add_action('optimiza_notifications', 'send_notifications_wp');

add_action('optimiza_plugin_auto_update', 'check_update_optimiza_plugin');

//SE ASOCIA UNA FUNCION AL DESACTIVAR EL PLUGIN
register_deactivation_hook(__FILE__, 'deactivate_cron_accions');

//SE CANCELAN LAS ACTIVIDADES CRON DEL PLUGIN AL SER DESACTIVADO
function deactivate_cron_accions() 
{
	wp_clear_scheduled_hook('optimiza_plugin_auto_update');
	wp_clear_scheduled_hook('optimiza_notifications');
}

?>