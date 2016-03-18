jQuery(document).ready( function( jQuery ) 
{
	//FUNCION PARA CARGAR LAS GALERIA MULTIMEDIA PARA CARGAR LA IMAGEN DE FONDO DEL LOGIN
    jQuery('#url_login_image_button').click(function() 
	{
		window.send_to_editor = function(html) {

			imgurl = jQuery('img',html).attr('src');
			jQuery('#url_login_image').val(imgurl);
			tb_remove();
		}

        formfield = jQuery('#url_login_image').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

	//FUNCION PARA CARGAR LAS GALERIA MULTIMEDIA PARA CARGAR LA IMAGEN DEL LOGO DEL LOGIN
	jQuery('#url_login_logo_button').click(function() 
	{
	    window.send_to_editor = function(html) 
		{
			imgurl = jQuery('img',html).attr('src');
			jQuery('#url_logo_image').val(imgurl);		
			tb_remove();
		}

        formfield = jQuery('#url_logo_image').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );		
        return false;
    });
	
	//FUNCION PARA CARGAR LAS DIMENSIONES DE LA IMAGEN DEL LOGO DE LOGIN
	jQuery('#load_dimensions_logo').click(function() 
	{
		var img = new Image();
		img.src = jQuery('#url_logo_image').val();
		jQuery('#height_login_image').val(img.height);
		jQuery('#width_login_image').val(img.width);
    });
	
});