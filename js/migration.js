﻿jQuery(document).ready(function($)
{
	//BOTON PARA CREAR PAGINA DE AVISO LEGAL
	jQuery("#button_aviso_legal_page").click(function()
	{	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "pages.php", 
			  method: "POST",
			  data: { name_empresa :  jQuery( "#name_empresa").val(), address_empresa : jQuery( "#address_empresa").val(), cif_empresa: jQuery( "#cif_empresa").val(),  
			  register_empresa: jQuery( "#register_empresa").val(), domain_empresa: jQuery( "#domain_empresa").val(),  email_empresa: jQuery( "#email_empresa").val(), 
			  title_aviso_legal: jQuery( "#title_aviso_legal").val(), slug_aviso_legal: jQuery( "#slug_aviso_legal").val()  }	
		});
			 
		request.done(function( msg ) 
		{		
			alert(msg);

		});
	});
	
	//BOTON PARA CREAR PAGINAS DE COOKIES
	jQuery("#button_cookies_pages").click(function()
	{	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "pages.php", 
			  method: "POST",
			  data: { slug_mas_informacion :  jQuery( "#slug_mas_informacion").val(), slug_politica_cookies : jQuery( "#slug_politica_cookies").val(), title_politica_cookies: jQuery( "#title_politica_cookies").val(),  
			  title_mas_informacion: jQuery( "#title_mas_informacion").val()}	
		});
			 
		request.done(function( msg ) 
		{		
			alert(msg);

		});
	});
	
	
	//BOTON PARA INSTALAR EL PLUGINS SELECCIONADO
	jQuery(".install_plugins").click(function()
	{	
		var boton =  jQuery(this);
	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "zips.php", 
			  method: "POST",
			  data: { plugin_install :  boton.attr("id").substring(8)}	
		});
			 
		request.done(function( msg ) 
		{		
			if(msg == "ok")
			{
				alert("Plugin instalado correctamente.")
				
				boton.css("display", "none");
				
				jQuery("#mess_" + boton.attr("id").substring(8) ).html("Instalado");

			}
			else
				alert("¡Error! No se pudo instalar el plugin.");

		});
	});
	
	//BOTON PARA CAMBIAR LOS PERMISOS DE LOS FICHEROS
	jQuery("#button_permissions_files").click(function()
	{	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "scan.php", 
			  method: "POST",
			  data: { change_file_permissions :  "OK"}	
		});
			 
		request.done(function( msg ) 
		{		
			alert(msg);

		});
	});
		
	//BOTON PARA GENERAR UN BACKUP DE LOS FICHEROS
	jQuery("#button_generate_backup").click(function()
	{	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "zips.php", 
			  method: "POST",
			  dataType: 'json',
			  data: { generate_backup_url :  jQuery("#generate_backup_url").val()}	
		});
			 
		request.done(function( msg ) 
		{		
			alert(msg["message"]);
			jQuery("#backups_table").append(msg["result"]);
			
			jQuery(".delete_backups").unbind();
			
			delele_backups_buttons();
			
		});
	});

	//FUNCION PARA ASIGNAR EL EVENTO DE BORRADO DE FICHEROS DE BACKUPS A LOS BOTONES CORRESPONDIENTES
	function delele_backups_buttons()
	{
		//BOTON PARA ELIMINAR EL FICHERO DE UN BACKUP
		jQuery(".delete_backups").click(function()
		{			
			if(confirm("¿Estas seguro?") )
			{
				var boton =  jQuery(this);
			
				var request = jQuery.ajax({
					  url: jQuery( "#url_base").val() + "zips.php", 
					  method: "POST",
					  data: { delete_backup_file :  boton.attr("id").substring(4)}	
				});
					 
				request.done(function( msg ) 
				{		
					boton.parent().parent().css("display","none");
				});
			}
		});
	}
		
	delele_backups_buttons();
	
	//BOTON PARA ESCANEAR LOS FICHEROS DE LA WEB
	jQuery("#button_scan_files").click(function()
	{	
		var request = jQuery.ajax({
			  url: jQuery( "#url_base").val() + "scan.php", 
			  method: "POST",
			  data: { scan_files :  "OK"}	
		});
			 
		request.done(function( content ) 
		{		
							
			jQuery('#scan_table thead').after(content);
			
				
			jQuery("#scan_table").DataTable( 
			{
				columnDefs: [ {
					targets: [ 0 ],
					orderData: [ 0, 1 ]
				}, {
					targets: [ 1 ],
					orderData: [ 1, 0 ]
				}, {
					targets: [ 1 ],
					orderData: [ 1, 0 ]
				}, {
					targets: [ 1 ],
					orderData: [ 1, 0 ]
				},{
					targets: [ 1 ],
					orderData: [ 1, 0 ]
				}],
				paging:         false
			} );
		});
	});
	
	
	jQuery("#tabs").tabs();
	
	//SE ASOCIADA EL COLOR PICKER A TODOS LOS INPUT DE TIPO COLOR
	jQuery('input[type=color]').each(function(){
		
		var element = jQuery(this);
		
		element.ColorPicker(
		{
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				element.val('#' + hex);
		}});
		
		element.ColorPickerSetColor(element.val());
		
	});
	
	jQuery("#optimiza_logo_version").change(function(){
		
		jQuery("#prev_logo_optimizaclick").css("background-image", 'url("../wp-content/plugins/migration_optimizaclick/img/' + jQuery("#optimiza_logo_version").val() + '")');
		
	});
	

}); 