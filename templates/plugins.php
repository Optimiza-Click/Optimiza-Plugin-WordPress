<h2 class="title_migration">Plugins recomendados</h2>
								 
<table class="form-table centered" id="plugins_table">		
	<thead>
		<tr><th>Nombre</th><th>Estado</th><th>Acción</th></tr>
	</thead>
	
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