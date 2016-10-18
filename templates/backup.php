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