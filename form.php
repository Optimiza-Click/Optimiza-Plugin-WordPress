<?php 

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );

require_once( $parse_uri[0] . 'wp-load.php' );

//SE COMPRUEBAN LOS PARAMETROS RECIBIDOS PARA CREAR LAS PAGINAS CORRESPONDIENTES
if(isset($_REQUEST['form_type']))
	create_form($_REQUEST['form_type']);

//FUNCION PARA CREAR LAS PAGINAS DE AVISO LEGAL, POLITICA DE COOKIES O MAS INFORMACION
function create_form($type)
{
	if($type == "composer")
	{
		
		$content = '
<div class="vc_col-sm-6"><p>[text* your-name placeholder "Nombre"]</p></div>
<div class="vc_col-sm-6"><p>[email* your-email placeholder "E-mail"]</p> </div>
<div class="vc_col-sm-6"><p>[text* your-phone placeholder "Teléfono"]</p> </div>
<div class="vc_col-sm-6"><p>[text your-subject placeholder "Asunto"]</p> </div>

<div class="vc_col-sm-12"><p>[textarea* your-message placeholder "Mensaje"] </p></div>

<div class="vc_col-sm-12"><p>[acceptance acceptance-10] Acepto la <a target="_blank" href="#">Política de Privacidad</a></p></div>

<div class="vc_col-sm-12"><p><br/>[submit "Enviar"]</p></div>';

	}
	elseif($type == "avada")
	{
		
		$content = '
<div class="fusion-one-half fusion-layout-column fusion-spacing-yes"><p>[text* your-name placeholder "Nombre"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes"><p>[email* your-email placeholder "E-mail"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-spacing-yes"><p>[text* your-phone placeholder "Teléfono"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes"><p>[text your-subject placeholder "Asunto"]</p></div>
<p>[textarea* your-message placeholder "Mensaje"] </p>
<p>[acceptance acceptance-10] Acepto la <a target="_blank" href="">Política de Privacidad</a></p>
<p>[submit "Enviar"]</p>';

	}
		elseif($type == "flatsome")
	{
		
		$content = '
<div class="small-12 large-6 columns"><p>[text* your-name placeholder "Nombre"]</p></div>
<div class="small-12 large-6 columns"><p>[email* your-email placeholder "E-mail"]</p></div>
<div class="small-12 large-6 columns"><p>[text* your-phone placeholder "Teléfono"]</p></div>
<div class="small-12 large-6 columns"><p>[text your-subject placeholder "Asunto"]</p></div>
<p>[textarea* your-message placeholder "Mensaje"] </p>
<p>[acceptance acceptance-10] Acepto la <a target="_blank" href="">Política de Privacidad</a></p>
<p>[submit "Enviar"]</p>';

	}
	
	$post = array(
	  'post_name'      => "contact form ".$type." ".(string)rand(1, 1000), 
	  'post_content' => $content,
	  'post_title'     => "contact form ".$type." ".(string)rand(1, 1000),
	  'post_status'    => 'publish', 
	  'post_type'      => 'wpcf7_contact_form' 
	);  
	

	$id = wp_insert_post($post);  
	
	add_post_meta($id, "_form", $content);
	
	add_post_meta($id, "_locale", "es_ES");
	
	$values = array("subject" => 'Contacto "[your-subject]"', "sender"=> '[your-name] <no-reply@mandrillapp.com>', "body" => 'De: [your-name] <[your-email]>

Teléfono: [your-phone]
Asunto: [your-subject]

Cuerpo del mensaje:
[your-message]

--
Este mensaje se ha enviado desde un formulario de contacto', "recipient" => "", "additional_headers" => 'Reply-To: [your-email]', "attachments" => "", "use_html" => 'exclude_blank');
	
	add_post_meta($id, "_mail", $values);
		
	echo "Formulario generado correctamente. " ;

}

?>