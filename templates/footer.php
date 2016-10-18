<h2 class="title_migration">Configuración Footer</h2>
					
<table class="form-table">
	<tr>
		<th scope="row">Mostrar footer:</th>
		<td>
			<select name="footer_display">						
				<option <?php if("y" == $migration_options['footer_display' ]) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['footer_display' ]) echo "selected"; ?> value="n">No</option>
			</select>
		</td>
		<th scope="row">Boxed footer:</th>
		<td>
			<select name="boxed_footer">						
				<option <?php if("n" == $migration_options['boxed_footer' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options['boxed_footer' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>
		<th scope="row">Footer fixed Betheme:</th>
		<td>
			<select name="footer_betheme">
				<option <?php if("n" == $migration_options['footer_betheme' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options['footer_betheme' ]) echo "selected"; ?> value="y">Si</option>

			</select>
		</td>
						
	</tr>
	<tr>
		<th scope="row">Background footer:</th>
		<td>
			<input type="color" name="footer_background_color" value="<?php if($migration_options['footer_background_color' ] != "") echo $migration_options['footer_background_color' ]; 
			else echo "#000000" ?>"/>
		</td>
		<th scope="row">Font color footer:</th>
		<td>
			<input type="color" name="footer_font_color" value="<?php if($migration_options['footer_font_color' ] != "") echo $migration_options['footer_font_color' ]; else echo "#ffffff" ?>"/>
		</td>
		<th scope="row">Footer width:</th>
		<td>
			<input type="text" name="footer_width" value="<?php if($migration_options['footer_width' ] != "") echo $migration_options['footer_width' ]; else echo "100%"; ?>"/>
		</td>	
	</tr>
	<tr>
		<th scope="row">Mostrar logo Optimizaclick:</th>
		<td>
			<select name="optimiza_logo_display">
				<option <?php if("y" == $migration_options['optimiza_logo_display' ]) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['optimiza_logo_display' ]) echo "selected"; ?> value="n">No</option>
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
						
						if( $nombre_fichero == $migration_options['optimiza_logo_version' ]) echo "selected"; 
						
						echo ' value="'.$nombre_fichero.'">'.substr($nombre_fichero, 0, -4).'</option>';
					}

			 } ?>
			</select>
		</td>
		<th scope="row">Alt logo Optimizaclick:</th>
		<td>
			<input type="text" name="alt_logo_optimizaclick" value="<?php if($migration_options['alt_logo_optimizaclick' ] == "") echo 'Posicionamiento SEO'; 
			else echo $migration_options['alt_logo_optimizaclick' ]; ?>"/>
		</td>
	</tr>
</table>
					
<div id="prev_logo_optimizaclick" style="background-image: url('<?php echo WP_PLUGIN_URL.'/'.plugin_name.'/img/'.$migration_options['optimiza_logo_version']; ?>')"></div>