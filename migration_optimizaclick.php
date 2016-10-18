<?php
/*
Plugin Name: Optimizaclick Migration Plugin
Description: Plugin automatizador de tareas para completar la migración de una web.
Author: Departamento de Desarrollo - Optimizaclick
Author URI: http://www.optimizaclick.com/
Text Domain: Optimizaclick Migration Plugin
Version: 2.3
Plugin URI: http://www.optimizaclick.com/
*/

if (!defined('plugin_name')) 
	define("plugin_name", "Optimiza-Plugin-WordPress-master");

require_once( dirname(__FILE__) . '/wordpress-sentry.php' );
require_once( dirname(__FILE__) . '/update.php' );

$migration_options = json_decode(get_option("migration_optimizaclick_options"), true);

function redirect_save_options_migration() 
{
	$page_viewed = basename($_SERVER['REQUEST_URI']);
	
	if( $page_viewed == "optimiza_migration_save_options") {

		update_option("migration_optimizaclick_options", json_encode($_REQUEST));
		wp_redirect(get_home_url()."/wp-admin/admin.php?migration");

		exit();
	}
}

add_action( 'admin_menu', 'redirect_save_options_migration' );

//FUNCION INICIAL PARA AÑADIR LA OPCION DEL PLUGIN EN EL MENU DE HERRAMIENTAS Y CARGAR OTRAS FUNCIONES
function migration_admin_menu() 
{	
	//SE AÑADE UNA OPCION EN EL MENU HERRAMIENTAS PARA MOSTRAR LAS OPCIONES DEL PLUGIN
	$menu = add_menu_page( 'Migration', 'Migration', 'read',  'migration', 'migration_form', ' ', 80);
	
	//ACCION PARA CARGAR ESTILOS Y SCRIPTS EN EL ADMINISTRADOR EN LA PAGINA DE MIGRACIÓN
	add_action( 'admin_print_scripts-' . $menu, 'custom_admin_js' );
			
	//COMPROBACION DE LAS OPCIONES DE ACTUALIZACION
	if($migration_options['updates_core'] == "n")
		add_filter('pre_site_transient_update_core','remove_updates');
	
	if($migration_options['updates_plugins'] == "n")
		add_filter('pre_site_transient_update_plugins','remove_updates');
	
	if($migration_options['updates_themes'] == "n")
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
	
?>
	<div class="wrap_migration">

		<div id="load_div" class="dashicons dashicons-update"></div>

		<form method="post" action="optimiza_migration_save_options">
		
			<p class="submit"> <input id="submit" type="submit" class="button button-primary" value="Guardar Cambios" /> </p>
			
			<h1 class="title_plugin"><img src="<?php echo "../wp-content/plugins/".plugin_name."/img/icons/icon.png" ?>" alt="Icono Optimizaclick" /> <span> Migration Plugin</span></h1>
					
			<div id="messages_plugin"></div>
			
			<div id="tabs">
								
				<ul>
				
				<?php
				
				$dir = "../wp-content/plugins/".plugin_name."/templates/";
				
				$templates = array();
							 
				if (is_dir($dir)){
					if ($dh = scandir($dir)){
						foreach ($dh as $file){
							if($file != "." && $file != ".."){
								$templates[] = $file;
							}
						}
					}
				}
				
				
				foreach ($templates as $template)
				{
					echo '<li class="tab_links" title="#tabs-'.substr($template, 0, -4).'">'.str_replace("-", " ", ucwords(substr($template, 0, -4), "-")).'</li>';
				}
				
				?>
					
				</ul>
				
			</div>
			
			<div id="content_plugin_tabs">
			
				<?php foreach ($templates as $template){ ?>
			
				<div class="tab_content" id="tabs-<?php echo substr($template, 0, -4); ?>">

					<?php include ("templates/".$template); ?>	
					
				</div>
				
				<?php } ?>



			</div>	
						
			<input type="hidden" value="<?php echo WP_PLUGIN_URL."/".plugin_name."/"; ?>" id="url_base" />
		</form>
		
		<style>div.notice, .update-nag, #wpfooter,  #message{display: none !important;}</style>
		
  </div><?php 

}   


//FUNCION PARA OCULTAR LAS OPCIONE DEL MENU DE ADMINISTRACION
function hide_menu_options()
{
	global $menu;
	
	$current_user = wp_get_current_user();
	
	//SE COMPRUEBA CUAL ES EL USUARIO CON EL QUE SE INICIO SESION
	if( $migration_options[ 'user_menu_admin'] != $current_user->ID)
	{
		$admin_menu = $migration_options["migration_plugin_admin_menu_data"];
		
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
if($migration_options['updates_plugins'] == "n")
	add_action( 'admin_print_scripts', 'custom_css_updates' );

//FUNCION PARA CARGAR ESTILOS Y SCRIPTS EN LA PAGINA
function custom_js_styles() 
{
	wp_enqueue_script( 'cookies_script', WP_PLUGIN_URL. '/'.plugin_name.'/js/cookies.js', array('jquery') );
	
	wp_register_style( 'custom_wp_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/front-style.css', false, '1.0.0' );
	
	wp_enqueue_style( 'custom_wp_css' );
	
	//SE CARGAN EL CSS QUE OCULTA LOS BOTONES DE AÑADIR LOS PRODUCTOS AL CARRTIO
	if($migration_options["catalog_mode"] == "y")
	{
		wp_register_style( 'catalog_mode_css', WP_PLUGIN_URL. '/'.plugin_name.'/css/catalog_mode.css', false, '1.0.0' );
		
		wp_enqueue_style( 'catalog_mode_css' );
	}
	
	//SE CARGA EL CSS PARA OCULTAR LOS PRECIOS DE LOS PRODUCTOS
	if($migration_options["catalog_mode_price"] == "y")
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
	if($migration_options[ 'login_background_color' ] == "")
		$backgroundcolor = '#F1F1F1';
	else
		$backgroundcolor = $migration_options[ 'login_background_color' ];
	
	if($migration_options[ 'login_form_color' ] == "")
		$formcolor = '#F1F1F1';
	else
		$formcolor = $migration_options[ 'login_form_color' ];
	
	if($migration_options[ 'button_form_color' ] == "")
		$formbuttoncolor = '#0091CD';
	else
		$formbuttoncolor = $migration_options[ 'button_form_color' ];
	
	if($migration_options[ 'font_form_color' ] == "")
		$formfontcolor = '#F1F1F1';
	else
		$formfontcolor = $migration_options[ 'font_form_color' ];
	
	if($migration_options['font_button_form_color'] == "")
		$fombuttonfontcolor = '#fff';
	else
		$fombuttonfontcolor = $migration_options[ 'font_button_form_color' ];
	
	echo '<style>.login h1 a {
    background-image:  url("'.$migration_options[ 'url_logo_image' ].'") !important;
    background-size: cover !important;
	height: '.$migration_options[ 'height_login_image' ].'px !important;
	width: '.$migration_options[ 'width_login_image' ].'px !important;
	}	
	body{
	background-image:  url("'.$migration_options[ 'url_login_image' ].'") !important;
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
if($migration_options["enable_login_styles"] == "y")
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
	<div class="g-recaptcha" data-sitekey="<?php echo $migration_options['recaptcha_site_key']; ?>"></div>
<?php 
}

//VERIFICACION DEL RECPATCHA DE GOOGLE
function verify_login_captcha($user, $password) 
{
	if (isset($_POST['g-recaptcha-response'])) 
	{
		$recaptcha_secret = $migration_options['recaptcha_secret_key'];
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
if($migration_options['recaptcha_google_activate'] == "y")
{
	//SE CARGAN LAS FUNCIONES PARA EL FUNCIONAMIENTO DEL RECPATCHA
	add_action( "login_form", "display_login_captcha" );
	add_action("login_enqueue_scripts", "login_recaptcha_script");
	add_filter("wp_authenticate_user", "verify_login_captcha", 10, 2);
}

//FUNCION PARA MOSTRAR EL FOOTER CON EL AVISO LEGAL Y EL LOGO DE OPTIMIZACLICK
function footer_content() 
{
	$footer_style = 'width: 100%;float:left;position:relative;z-indez:99999;background-color: '.$migration_options[ 'footer_background_color' ].';color: '.$migration_options[ 'footer_font_color' ].';';
	
	if($migration_options["boxed_footer"] == "y")
		$footer_style .= 'max-width: '.$migration_options['footer_width'].';margin: 0 auto;';
	else
		$footer_style .= 'width: 100%;';
	
	//ESTILOS PARA EL SLIDYNG FOOTER DE BETHEME
	if($migration_options[ 'footer_betheme' ] == "y") 
	{
		$footer_style .= "position: fixed;z-index: 1;bottom: 0px;";

		echo "<style>#Footer{bottom: 100px !important;z-index: 1 !important;}</style>";
	}
	
	
	//SE CARGA EL FOOTER CON LOS ESTILOS ELEGIDOS Y EL ENLACE AL AVISO LEGAL
    echo '<div style="'.$footer_style.' !important;">';
	
	if($migration_options["boxed_footer"] == "y")
		echo '<div style="max-width: 100%;padding: 3px 0px;margin: 0 auto !important;">';
	else
		echo '<div style="width: '.$migration_options['footer_width'].';padding: 3px 0px;margin: 0 auto !important;">';
	
	echo "<div class='columns_1_4_footer'>";
	echo '<p style="padding-left: 5%;padding-top: 5px;color:'.$migration_options[ 'footer_font_color'].'">® '.date("Y").' '.$migration_options[ 'name_empresa' ].' 
		- <a style="color:'.$migration_options[ 'footer_font_color' ].'" href="'.get_home_url().'/'.$migration_options['slug_aviso_legal'].'">'.$migration_options['title_aviso_legal'].'
		</a></p>';
		
	echo "</div><div class='columns_1_2_footer'>";
	
	dynamic_sidebar( 'widget_area_footer_plugin' );	
	
	echo "</div><div class='columns_1_4_footer'>";
	
	//SE MUESTRA EL LOGO DE OPTIMIZACLICK
	if($migration_options['optimiza_logo_display'] == 'y')
		echo	'<a style="float:right;padding-right: 5%;" href="http://www.optimizaclick.com/" target="_blank" title="'.$migration_options['alt_logo_optimizaclick'].'">
			<img src="'.WP_PLUGIN_URL.'/'.plugin_name.'/img/'.$migration_options['optimiza_logo_version'].'" alt="'.$migration_options['alt_logo_optimizaclick'].'" />
		</a>';
		
	echo '</div></div></div>';
}

//ACTION PARA AÑADIR EL FOOTER
if($migration_options["footer_display"] == "y")
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
			<div class="div_cookies" style="display: none;<?php echo $migration_options['position_cookies']; ?>: 0px; background-color: <?php echo $migration_options['background_color_cookies']; ?>;">
			
				<div class="block_cookies">
					<div <?php if($migration_options['hide_cookies'] != "auto") echo 'class="col_2_3"' ?>>
					
					<p class="texto_cookies" style="color: <?php echo $migration_options['font_color_cookies']; ?>;">
					
						<?php echo $migration_options["text_message_cookies"]; ?>
						
						<strong><a style="text-decoration: underline;color: <?php echo $migration_options['font_color_cookies']; ?>;" target="_blank" 
						href="<?php echo get_home_url().'/'.$migration_options['slug_politica_cookies']; ?>"> <?php echo $migration_options["link_text_cookies"]; ?></a></strong>
						
						<input type='hidden' value='<?php echo $migration_options['hide_cookies']; ?>' id='cookie_mode' />
						</p>
						</div>
						<?php
						
						if($migration_options['hide_cookies'] != "auto")
						{
							?> 
								<div class="col_1_3">
								<span id="btn_cookies" style="color: <?php echo $migration_options['font_color_button_cookies']; ?>; 
								background-color: <?php echo $migration_options['background_button_cookies']; ?>">
								<?php echo $migration_options['text_button_cookies']; ?></span></div>
							
							<?php
						}
						?>
				
				</div>
				
			</div>
		
		<?php
}

//ACTION PARA AÑADIR EL AVISO DE COOKIES
if($migration_options["display_message_cookies"] == "y")
	add_action( 'wp_footer', 'header_content', 1 );

//FUNCION PARA LA REDIRECCION TRAS EL INICIAR SESION
function custom_login_redirect()
{
	wp_redirect($migration_options["url_login_redirect"]);
	
	exit();
}

//ACCION PARA LA REDIRECCION TRAS EL INICIAR SESION
if($migration_options["enable_login_redirect"] == "y")
	add_action( 'wp_login', 'custom_login_redirect' );


//FUNCION PARA LA REDIRECCION TRAS CERRAR SESION
function custom_logout_redirect()
{
	wp_redirect($migration_options["url_logout_redirect"]);
	
	exit();
}

//ACCION PARA LA REDIRECCION TRAS CERRAR SESION
if($migration_options["enable_logout_redirect"] == "y")
	add_action( 'wp_logout', 'custom_logout_redirect');


//FUNCION PARA CAMBIAR EL LINK DEL LOGO DEL LOGIN
function logo_url_login()
{
    return get_home_url();
}

//ACCION PARA CAMBIAR EL LINK DEL LOGO DEL LOGIN
add_filter( 'login_headerurl', 'logo_url_login' );

//FUNCION PARA MODIFICAR EL NUMERO DE PRODUCTOS LISTADOS POR PAGINA
if($migration_options["enable_produts_page"] == "y")
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$migration_options["num_produts_page"].';' ), 20 );


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

new WP_Migration_Optimiza_Auto_Update();

?>