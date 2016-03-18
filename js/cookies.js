jQuery(document).ready(function($)
{
	//FUNCION PARA EL BOTON DE OCULTAR EL AVISO DE COOKIES
	jQuery("#btn_cookies").click(function()
	{	
		setcookie();
				
		jQuery(".div_cookies").fadeOut(600);
	});
	
	//FUNCION PARA CREAR EL REGISTRO DE LA COOKIE
	function setcookie()
	{
	    localStorage.controlcookie = (localStorage.controlcookie || 0);

		localStorage.controlcookie++; 
	}

	//SI NO HAY REGISTRO CREADO DE LA COOKIE SE MUESTRA EL AVISO
	if(!localStorage.controlcookie)
		jQuery(".div_cookies").fadeIn(600);	
	
	//SI EL AVISO DE COOKIES ESTA EN MODO AUTOMATICO SE GENERA EL REGISTRO
	if(jQuery("#cookie_mode").val()  == "auto")
		setcookie();	
}); 