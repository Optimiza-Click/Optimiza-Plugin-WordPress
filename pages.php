<?php 

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );

require_once( $parse_uri[0] . 'wp-load.php' );
//require_once( $parse_uri[0] . 'wp-includes/wp-db.php' );

//SE COMPRUEBAN LOS PARAMETROS RECIBIDOS PARA CREAR LAS PAGINAS CORRESPONDIENTES
if(isset($_REQUEST['title_aviso_legal']))
	create_page($_REQUEST['title_aviso_legal'], $_REQUEST['slug_aviso_legal'], 1);

if(isset($_REQUEST['title_politica_cookies']))
	create_page($_REQUEST['title_politica_cookies'], $_REQUEST['slug_politica_cookies'], 2);

if(isset($_REQUEST['title_mas_informacion']))
	create_page($_REQUEST['title_mas_informacion'],$_REQUEST['slug_mas_informacion'], 3);

//FUNCION PARA CREAR LAS PAGINAS DE AVISO LEGAL, POLITICA DE COOKIES O MAS INFORMACION
function create_page($title, $slug, $type)
{
	$content = "";
		
	switch($type)
	{
		case 1: //AVISO LEGAL
		
			$content = page_aviso_legal($_REQUEST['name_empresa'], $_REQUEST['address_empresa'], $_REQUEST['cif_empresa'], $_REQUEST['register_empresa'], $_REQUEST['domain_empresa'], $_REQUEST['email_empresa']);
		
		break;
		
		case 2: //POLITICA DE COOKIES
		
			$content = page_politica_cookies(get_home_url().'/'.$_REQUEST['slug_mas_informacion']);
		
		break;
		
		case 3: //MAS INFORMACION
		
			$content = page_mas_informacion();
		
		break;
	}
	
	$post = array(
	  'post_name'      => $slug, 
	  'post_content' => $content,
	  'post_title'     => $title,
	  'post_status'    => 'publish', 
	  'post_type'      => 'page' 
	);  
	
	$page = get_page_by_title($title);
	
	//SE COMPRUEBA SI EXITE LA PAGINA
	if( $page == null)
	{
		wp_insert_post($post);  
		
		echo "Página creada correctamente. " ;
	}
	else 
	{
		$post['ID'] = $page->ID;
		
		wp_update_post( $post );
		
		echo 'Página actualizada. ';
	}
}

//FUNCION PARA CREAR EL CONTENIDO DE LA PAGINA DE POLITICA DE COOOKIES A PARTIR DE LAS VARIABLES RECIBIDAS
function page_politica_cookies($enlace)
{
	return '<h1>Política de cookies</h1>
<p>
	Una <em>cookie</em> es un pequeño fichero de texto que se almacena en su navegador cuando visita casi cualquier página web. Su utilidad es que la web sea capaz de recordar su visita cuando vuelva a navegar por esa página. Las <em>cookies</em> suelen almacenar información de carácter técnico, preferencias personales, personalización de contenidos, estadísticas de uso, enlaces a redes sociales, acceso a cuentas de usuario, etc. El objetivo de la <em>cookie</em> es adaptar el contenido de la web a su perfil y necesidades, sin <em>cookies</em> los servicios ofrecidos por cualquier página se verían mermados notablemente. Si desea consultar más información sobre qué son las <em>cookies</em>, qué almacenan, cómo eliminarlas, desactivarlas, etc., <a href="'.$enlace.'">le rogamos se dirija a este enlace.</a>
</p>
<h2>Cookies utilizadas en este sitio web</h2>
<p>
	Siguiendo las directrices de la Agencia Española de Protección de Datos procedemos a detallar el uso de <em>cookies</em> que hace esta web con el fin de informarle con la máxima exactitud posible.
</p>
<p>
	Este sitio web utiliza las siguientes <strong>cookies propias</strong>:
	<ul>
		<li>Cookies de sesión, para garantizar que los usuarios que escriban comentarios en el blog sean humanos y no aplicaciones automatizadas. De esta forma se combate el <em>spam</em>.</li>
	</ul>
</p>
<p>
	Este sitio web utiliza las siguientes <strong>cookies de terceros</strong>:
	<ul>
		<li>Google Analytics: Almacena <em>cookies</em> para poder elaborar estadísticas sobre el tráfico y volumen de visitas de esta web. Al utilizar este sitio web está consintiendo el tratamiento de información acerca de usted por Google. Por tanto, el ejercicio de cualquier derecho en este sentido deberá hacerlo comunicando directamente con Google.</li>
		<li>Redes sociales: Cada red social utiliza sus propias <em>cookies</em> para que usted pueda pinchar en botones del tipo <em>Me gusta</em> o <em>Compartir</em>.</li>
	</ul>
</p>
<h2>Desactivación o eliminación de cookies</h2>
<p>
	En cualquier momento podrá ejercer su derecho de desactivación o eliminación de cookies de este sitio web. Estas acciones se realizan de forma diferente en función del navegador que esté usando. <a href="'.$enlace.'">Aquí le dejamos una guía rápida para los navegadores más populares</a>.
</p>
<h2>Notas adicionales</h2>
<p>
	<ul>
		<li>
			Ni esta web ni sus representantes legales se hacen responsables ni del contenido ni de la veracidad de las políticas de privacidad que puedan tener los terceros mencionados en esta política de <em>cookies</em>.
		</li>
		<li>
			Los navegadores web son las herramientas encargadas de almacenar las <em>cookies</em> y desde este lugar debe efectuar su derecho a eliminación o desactivación de las mismas. Ni esta web ni sus representantes legales pueden garantizar la correcta o incorrecta manipulación de las <em>cookies</em> por parte de los mencionados navegadores.
		</li>
		<li>
			En algunos casos es necesario instalar <em>cookies</em> para que el navegador no olvide su decisión de no aceptación de las mismas.
		</li>
		<li>
			En el caso de las <em>cookies</em> de Google Analytics, esta empresa almacena las <em>cookies</em> en servidores ubicados en Estados Unidos y se compromete a no compartirla con terceros, excepto en los casos en los que sea necesario para el funcionamiento del sistema o cuando la ley obligue a tal efecto. Según Google no guarda su dirección IP. Google Inc. es una compañía adherida al Acuerdo de Puerto Seguro que garantiza que todos los datos transferidos serán tratados con un nivel de protección acorde a la normativa europea. Puede consultar información detallada a este respecto <a href="http://safeharbor.export.gov/companyinfo.aspx?id=16626" target="_blank">en este enlace</a>. Si desea información sobre el uso que Google da a las cookies <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage?hl=es&csw=1" target="_blank">le adjuntamos este otro enlace</a>.
		</li>
		<li>
			Para cualquier duda o consulta acerca de esta política de <em>cookies</em> no dude en comunicarse con nosotros a través de la sección de contacto.</a>
		</li>
	</ul>
</p>';
	
}



//FUNCION PARA CREAR EL CONTENIDO DE LA PAGINA DE MAS INFORMACION A PARTIR DE LAS VARIABLES RECIBIDAS
function page_mas_informacion()
{

return '
<h2>¿Qué es una cookie?</h2>
<p>
	Una <em>cookie</em> es un fichero de texto <b>inofensivo</b> que se almacena en su navegador cuando visita casi cualquier página web. La utilidad de la <em>cookie</em> es que la web sea capaz de recordar su visita cuando vuelva a navegar por esa página. Aunque mucha gente no lo sabe las <em>cookies</em> se llevan utilizando desde hace 20 años, cuando aparecieron los primeros navegadores para la World Wide Web.
</p> 
<h2>¿Qué NO ES una cookie?</h2>
<p>
	No es un virus, ni un troyano, ni un gusano, ni spam, ni spyware, ni abre ventanas pop-up.
</p> 
<h2>¿Qué información almacena una <em>cookie</em>?</h2>
<p>
	Las <em>cookies</em> no suelen almacenar información sensible sobre usted, como tarjetas de crédito o datos bancarios, fotografías, su DNI o información personal, etc. Los datos que guardan son de carácter técnico, preferencias personales, personalización de contenidos, etc.
</p>
<p>
	El servidor web no le asocia a usted como persona si no a su navegador web. De hecho, si usted navega habitualmente con Internet Explorer y prueba a navegar por la misma web con Firefox o Chrome verá que la web no se da cuenta que es usted la misma persona porque en realidad está asociando al navegador, no a la persona.
</p>
<h2>¿Qué tipo de <em>cookies</em> existen?</h2>
<p>
	<ul>
		<li><em>Cookies</em> técnicas: Son las más elementales y permiten, entre otras cosas, saber cuándo está navegando un humano o una aplicación automatizada, cuándo navega un usuario anónimo y uno registrado, tareas  básicas para el funcionamiento de cualquier web dinámica.</li>
		<li><em>Cookies</em> de análisis: Recogen información sobre el tipo de navegación que está realizando, las secciones que más utiliza, productos consultados, franja horaria de uso, idioma, etc.</li>
		<li><em>Cookies</em> publicitarias: Muestran publicidad en función de su navegación, su país de procedencia, idioma, etc.</li>
	</ul>
</p>
<h2>¿Qué son las <em>cookies</em> propias y las de terceros?</h2>
<p>
	Las <em>cookies propias</em> son las generadas por la página que está visitando y las <em>de terceros</em> son las generadas por servicios o proveedores externos como Facebook, Twitter, Google, etc.
</p> 
<h2>¿Qué ocurre si desactivo las <em>cookies</em>?</h2>
<p>
	Para que entienda el alcance que puede tener desactivar las <em>cookies</em> le mostramos unos ejemplos:
	<ul>
		<li>No podrá compartir contenidos de esa web en Facebook, Twitter o cualquier otra red social.</li>
		<li>El sitio web no podrá adaptar los contenidos a sus preferencias personales, como suele ocurrir en las tiendas online.</li>
		<li>No podrá acceder al área personal de esa web, como por ejemplo <em>Mi cuenta</em>, o <em>Mi perfil</em> o <em>Mis pedidos</em>.</li>
		<li>Tiendas online: Le será imposible realizar compras online, tendrán que ser telefónicas o visitando la tienda física si es que dispone de ella.</li>
		<li>No será posible personalizar sus preferencias geográficas como franja horaria, divisa o idioma.</li>
		<li>El sitio web no podrá realizar analíticas web sobre visitantes y tráfico en la web, lo que dificultará que la web sea competitiva.</li>
		<li>No podrá escribir en el blog, no podrá subir fotos, publicar comentarios, valorar o puntuar contenidos. La web tampoco podrá saber si usted es un humano o una aplicación automatizada que publica <em>spam</em>.</li>
		<li>No se podrá mostrar publicidad sectorizada, lo que reducirá los ingresos publicitarios de la web.</li>
		<li>Todas las redes sociales usan <em>cookies</em>, si las desactiva no podrá utilizar ninguna red social.</li>
	</ul>
</p>
<h2>¿Se pueden eliminar las <em>cookies</em>?</h2>
<p>
	Sí. No sólo eliminar, también bloquear, de forma general o particular para un dominio específico.
</p>
<p>
	Para eliminar las <em>cookies</em> de un sitio web debe ir a la configuración de su navegador y allí podrá buscar las asociadas al dominio en cuestión y proceder a su eliminación.
</p>
<h2 id="navegadores">Configuración de <em>cookies</em> para los navegadores más polulares</h2>
<p>
	A continuación le indicamos cómo acceder a una <em>cookie</em> determinada del navegador <b>Chrome</b>. Nota: estos pasos pueden variar en función de la versión del navegador:
	<ol>
		<li>Vaya a Configuración o Preferencias mediante el menú Archivo o bien pinchando el icono de personalización que aparece arriba a la derecha.</li>
		<li>Verá diferentes secciones, pinche la opción <em>Mostrar opciones avanzadas</em>.</li>
		<li>Vaya a <em>Privacidad</em>, <em>Configuración de contenido</em>.</li>
		<li>Seleccione <em>Todas las <em>cookies</em> y los datos de sitios</em>.</li>
		<li>Aparecerá un listado con todas las <em>cookies</em> ordenadas por dominio. Para que le sea más fácil encontrar las <em>cookies</em> de un determinado dominio introduzca parcial o totalmente la dirección en el campo <em>Buscar cookies</em>.</li>
		<li>Tras realizar este filtro aparecerán en pantalla una o varias líneas con las <em>cookies</em> de la web solicitada. Ahora sólo tiene que seleccionarla y pulsar la <em>X</em> para proceder a su eliminación.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador <b>Internet Explorer</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Vaya a <em>Herramientas</em>, <em>Opciones de Internet</em></li>
		<li>Haga click en <em>Privacidad</em>.</li>
		<li>Mueva el deslizador hasta ajustar el nivel de privacidad que desee.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador <b>Firefox</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Vaya a <em>Opciones</em> o <em>Preferencias</em> según su sistema operativo.</li>
		<li>Haga click en <em>Privacidad</em>.</li>
		<li>En <em>Historial</em> elija <em>Usar una configuración personalizada para el historial</em>.</li>
		<li>Ahora verá la opción <em>Aceptar cookies</em>, puede activarla o desactivarla según sus preferencias.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador <b>Safari para OSX</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Vaya a <em>Preferencias</em>, luego <em>Privacidad</em>.</li>
		<li>En este lugar verá la opción <em>Bloquear cookies</em> para que ajuste el tipo de bloqueo que desea realizar.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador <b>Safari para iOS</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Vaya a <em>Ajustes</em>, luego <em>Safari</em>.</li>
		<li>Vaya a <em>Privacidad y Seguridad</em>, verá la opción <em>Bloquear cookies</em> para que ajuste el tipo de bloqueo que desea realizar.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador para dispositivos <b>Android</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Ejecute el navegador y pulse la tecla <em>Menú</em>, luego <em>Ajustes</em>.</li>
		<li>Vaya a <em>Seguridad y Privacidad</em>, verá la opción <em>Aceptar cookies</em> para que active o desactive la casilla.</li>
	</ol>
</p>
<p>
	Para acceder a la configuración de <em>cookies</em> del navegador para dispositivos <b>Windows Phone</b> siga estos pasos (pueden variar en función de la versión del navegador):
	<ol>
		<li>Abra <em>Internet Explorer</em>, luego <em>Más</em>, luego <em>Configuración</em></li>
		<li>Ahora puede activar o desactivar la casilla <em>Permitir cookies</em>.</li>
	</ol>
</p>';

}


//FUNCION PARA CREAR EL CONTENIDO DE LA PAGINA DE AVISO LEGAL A PARTIR DE LAS VARIABLES RECIBIDAS
function page_aviso_legal($nombre_empresa, $direccion_empresa, $cif_empresa, $registro_mercantil, $dominio_empresa, $correo_empresa)
{

return '

<ol>
	<li><strong> Política de privacidad y protección de datos personales </strong></li>
</ol>
Mediante este aviso, '.$nombre_empresa.', '.$direccion_empresa.' '.$cif_empresa.' '.$registro_mercantil.' informa a los usuarios del portal web '.$dominio_empresa.' acerca de su política de protección de datos de carácter personal (en adelante, "los Datos Personales") para que los Usuarios determinen, libre y voluntariamente, si desean facilitar a '.$nombre_empresa.' los Datos Personales que se les puedan requerir o que se puedan obtener de los Usuarios con ocasión de la suscripción o alta en algunos de los servicios ofrecidos por '.$nombre_empresa.' en el Portal o a través del Portal. '.$nombre_empresa.' se reserva el derecho a modificar la presente política para adaptarla a novedades legislativas o jurisprudenciales así como a prácticas de la industria.

En dichos supuestos, '.$nombre_empresa.' anunciará en esta página los cambios introducidos con razonable antelación a su puesta en práctica. A los efectos de la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que los datos recabados en los distintos formularios serán incluidos en un fichero de datos de carácter personal con el fin de tramitar adecuadamente su solicitud, y cuyo destinatario será '.$nombre_empresa.'. '.$nombre_empresa.', como responsable del fichero, garantiza el ejercicio de los derechos de acceso, rectificación, cancelación y oposición de los datos facilitados. Para ello, y con el fin de facilitarle este trámite, bastará con que nos remita un mensaje con su petición, a la dirección electrónica: '.$correo_empresa.'.

De igual modo, se compromete, en la utilización de los datos incluidos en el fichero, a respetar su confidencialidad y a utilizarlos de acuerdo con la finalidad del fichero. Remitiendo la información solicitada en los formularios, el interesado consiente expresamente el tratamiento y cesión de sus datos a '.$nombre_empresa.', para el cumplimiento de la finalidad arriba indicada.

A los efectos de la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que sus datos recabados en los distintos formularios serán incluidos en un fichero de '.$nombre_empresa.' con la finalidad de tramitar su solicitud y gestionar adecuadamente la prestación de servicios. Dichos datos serán tratados asimismo para informarle y remitirle publicidad sobre promociones especiales relativas a servicios o productos relacionados con internet y la nuevas tecnologías. Si no desea que sus datos sean tratados con finalidad comercial, le rogamos comunique marque la casilla que le aparecerá en el momento de contratar el servicio. En la dirección electrónica: '.$correo_empresa.' podrá ejercer los derechos de acceso rectificación, cancelación y oposición que la normativa le reconoce.
<ol start="2">
	<li><strong> Navegación web. Cookies</strong></li>
</ol>
Las cookies son pequeños archivos de texto que se instalan en el navegador del ordenador del Usuario para registrar su actividad, enviando una identificación anónima que se almacena en el mismo, con la finalidad de que la navegación sea más sencilla, permitiendo, por ejemplo, el acceso a los Usuarios que se hayan registrado previamente y el acceso a las áreas, servicios, promociones o concursos reservados exclusivamente a ellos sin tener que registrarse en cada visita. Se pueden utilizar también para medir la audiencia, parámetros del tráfico y navegación, tiempo de sesión, y/o controlar el progreso y el número de entradas.

'.$nombre_empresa.' procurará en todo momento establecer mecanismos adecuados para obtener el consentimiento del Usuario para la instalación de cookies que lo requieran. No obstante lo anterior, deberá tenerse en cuenta que, de conformidad con la Ley, se entenderá que el Usuario ha dado su consentimiento si modifica la configuración del navegador deshabilitando las restricciones que impiden la entrada de cookies y que el referido consentimiento no será preciso para la instalación de aquellas cookies que sean estrictamente necesarias para la prestación de un servicio expresamente solicitado por el Usuario (mediante registro previo).

A continuación adjuntamos una lista de las cookies principales que '.$nombre_empresa.' está utilizando:
<table>
<tbody>
<tr>
<td><strong>Nombre</strong></td>
<td><strong>Origen</strong></td>
<td><strong>Función de la cookie</strong></td>
</tr>
<tr>
<td>-utma</td>
<td>Google Analytics</td>
<td>Habilitan la función de control de visitas únicas. La primera vez que un usuario entre en el sitio Web de '.$nombre_empresa.'. A través de un navegador se instalará esta cookie. Cuando este usuario vuelva a entrar en nuestra página con el mismo navegador, la cookie considerará que es el mismo usuario. Solo en el caso de que el usuario cambie de navegador, Google Analytics lo considerará otro usuario.</td>
</tr>
<tr>
<td>-utmb

-utmc</td>
<td>Google Analytics</td>
<td>Habilitan la función de cálculo del tiempo de sesión. La primera (utmb) registra la hora de entrada en la página y la segunda (utmc) comprueba si se debe mantener la sesión abierta o se debe crear una sesión nueva. La cookie utmb caduca a los 30 minutos desde el último registro de página vista mientras que la utmc es una variable de sesión, por lo que se elimina automáticamente al cambiar de web o al cerrar el navegador.</td>
</tr>
<tr>
<td>-utmz</td>
<td>Google Analytics</td>
<td>Habilitan la función de registro de la procedencia del usuario. Los datos registrados serán, entre otros, si el usuario llega a nuestro sitio Web por tráfico directo, desde otra web, desde una campaña publicitaria o desde un buscador (indicando la palabra clave utilizada y la fuente)</td>
</tr>
<tr>
<td>PHPSESSID</td>
<td>Propia de '.$nombre_empresa.'</td>
<td>Habilita la función de control de idioma, detectando asi el pais de origen del visitante y mandandolo al idioma correcto.</td>
</tr>
<tr>
<td>'.$nombre_empresa.'</td>
<td>Propia de '.$nombre_empresa.'</td>
<td>Permite realizar la permanencia de la sesión para mostrar el mensaje de informacion de las cookies</td>
</tr>
</tbody>
</table>
Sin perjuicio de lo anterior, el Usuario tiene la posibilidad de configurar su navegador para ser avisado de la recepción de cookies y para impedir su instalación en su equipo.

&nbsp;
<ol start="3">
	<li><strong> Condiciones de Uso y su aceptación</strong></li>
</ol>
Estas condiciones regulan el uso de la web de '.$nombre_empresa.' para el usuario de Internet, y expresan la aceptación plena y sin reservas del mismo de todas y cada una de las condiciones y restricciones que estén publicadas en la web en el momento en que acceda a la misma. El acceso a la web y/o la utilización de cualquiera de los servicios en ella incluidos supondrá la aceptación de todas las condiciones de uso. '.$nombre_empresa.' se reserva el derecho a modificar unilateralmente la web y los servicios en ella ofrecidos, incluyendo la modificación de las condiciones de uso. Por ello se recomienda al usuario que lea este Aviso Legal tantas veces como acceda a la web.

&nbsp;
<ol start="4">
	<li><strong> Condiciones de utilización de la Web</strong></li>
</ol>
El usuario debe utilizar la web de conformidad con los usos autorizados. Queda expresamente prohibida la utilización de la web o de cualquiera de sus servicios con fines o efectos ilícitos, contrarios a la buena fe, al orden público o a lo establecido en las condiciones de uso. Queda igualmente prohibido cualquier uso lesivo de derechos o intereses de terceros o que, de cualquier forma, dificulten la utilización por parte de otros usuarios la normal utilización de la web y/o sus servicios. La utilización de la web es gratuita para el usuario.

&nbsp;
<ol start="5">
	<li><strong> Derechos de Propiedad Intelectual e Industrial</strong></li>
</ol>
Todos los contenidos de la web (marca, nombres comerciales, imágenes, iconos, diseño y presentación general de las diferentes secciones) están sujetos a derechos de propiedad intelectual o industrial de '.$nombre_empresa.' o de terceros. En ningún caso el acceso a la web implica que por parte de '.$nombre_empresa.' o del titular de esos derechos: (1) se otorgue autorización o licencia alguna sobre esos contenidos, (2) se renuncie, transmita o ceda total o parcialmente ninguno de sus derechos sobre esos contenidos (entre otros, sus derechos de reproducción, distribución y comunicación pública). No podrán realizarse utilizaciones de la web y/o de sus contenidos, diferentes de las expresamente autorizadas por '.$nombre_empresa.'. Ningún usuario de esta web puede revender, volver a publicar, imprimir, bajar, copiar, retransmitir o presentar ningún elemento de esta web ni de los contenidos de la misma sin el consentimiento previo por escrito de '.$nombre_empresa.', a menos que la ley permita, en medida razonable, copiar o imprimir los contenidos para uso personal y no comercial manteniéndose inalterados, en todo caso, el Copyright y demás datos identificativos de los derechos de '.$nombre_empresa.' y/o del titular de los derechos de esos contenidos. Esta web y sus contenidos están protegidos por las leyes de protección de la Propiedad Industrial e Intelectual internacionales y de España, ya sea como obras individuales y/o como compilaciones. El usuario no puede borrar ni modificar de ninguna forma la información relativa a esos derechos incluidos en la web. Quedan reservados todos los derechos a favor de '.$nombre_empresa.' o del titular de los mismos.

&nbsp;
<ol start="6">
	<li><strong> Exclusión de Garantías y Responsabilidad</strong></li>
</ol>
<strong>Exclusión de garantías y responsabilidad por el funcionamiento de la Web</strong>

'.$nombre_empresa.' no garantiza y no asume ninguna responsabilidad por el funcionamiento de la web y/o sus servicios. En caso de producirse interrupciones en su funcionamiento '.$nombre_empresa.' tratará, si esto fuera posible, de advertirlo al usuario. '.$nombre_empresa.' tampoco garantiza la utilidad de la web y/o sus servicios para la realización de ninguna actividad en particular, su infalibilidad ni que el usuario pueda utilizar en todo momento la web o los servicios que se ofrezcan. '.$nombre_empresa.' está autorizado a efectuar cuantas modificaciones técnicas sean precisas para mejorar la calidad, rendimiento, eficacia del sistema y de su conexión. Salvo que se indique expresamente un plazo, la prestación de los servicios tiene en principio una duración indefinida, no obstante, '.$nombre_empresa.' está autorizado a dar por terminados alguno de los servicios o el acceso a la web en cualquier momento. Siempre que esto fuera posible, '.$nombre_empresa.' tratará de comunicarlo con antelación al usuario.

<strong>Exclusión de garantías y responsabilidad por los contenidos</strong>

Los contenidos de todo tipo incluidos en la web que se hallan disponibles para el público en general, facilitan el acceso a información, productos y servicios suministrados o prestados por '.$nombre_empresa.'. Dichos contenidos son facilitados de buena fe por '.$nombre_empresa.' con información procedente, en ocasiones, de fuentes distintas a '.$nombre_empresa.'. Por lo tanto, '.$nombre_empresa.' no puede garantizar la fiabilidad, veracidad, exhaustividad y actualidad de los contenidos y, por tanto queda excluido cualquier tipo de responsabilidad de '.$nombre_empresa.' que pudiera derivarse por los daños causados, directa o indirectamente, por la información a la que se acceda por medio de la web. '.$nombre_empresa.' no garantiza la idoneidad de los contenidos incluidos en la web para fines particulares de quien acceda a la misma. En consecuencia, tanto el acceso a dicha web como el uso que pueda hacerse de la información y contenidos incluidos en las mismas se efectúa bajo la exclusiva responsabilidad de quien lo realice, y '.$nombre_empresa.' no responderá en ningún caso y en ninguna medida por los eventuales perjuicios derivados del uso de la información y contenidos accesibles en la web. Asimismo, '.$nombre_empresa.' no será en ningún caso responsable por productos o servicios prestados u ofertados por otras personas o entidades, o por contenidos, informaciones, comunicaciones, opiniones o manifestaciones de cualquier tipo originados o vertidos por terceros y a las que se pueda acceder a través de la web.

<strong>Exclusión de garantías y responsabilidad por enlaces a otras páginas</strong>

La web puede permitir al usuario su acceso por medio de enlaces a otras páginas web. '.$nombre_empresa.' no responde ni hace suyo el contenido de las páginas web enlazadas, ni garantiza la legalidad, exactitud, veracidad y fiabilidad de la información que incluyan. La existencia de un enlace no supondrá la existencia de relación de ningún tipo entre '.$nombre_empresa.' y la titular del sitio enlazado. '.$nombre_empresa.' no tendrá ningún tipo de responsabilidad por infracciones o daños que se causen al usuario o a terceros por el contenido de las páginas web a las que se encuentre unidas por un enlace. Jurisdicción y ley aplicable. Las condiciones de uso y los servicios ofrecidos en la web se rigen por la Ley Española. '.$nombre_empresa.' no tiene control alguno sobre quien o quienes pueden acceder a su web y donde pueden estar emplazados. A pesar de que '.$nombre_empresa.' es consciente de ello, esto no significa que se someta a las jurisdicciones de países extranjeros; en caso de conflicto o reclamación en relación a la web o cualquiera de los servicios por ella prestados, las partes acuerdan someterse expresamente a los juzgados y tribunales de Madrid (España).

';

}


?>
