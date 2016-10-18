<h2 class="title_migration">Configuración Seguridad</h2>
								 
<table class="form-table">		
	<tr>
		<th colspan="2">
			<input type="button" class="button button-primary" value="Cambiar permisos de ficheros" id="button_permissions_files" />
		</th>
		<th scope="row">Recaptcha en login:</th>
		<td>
			<select name="recaptcha_google_activate">								
				<option <?php if("n" == $migration_options[ 'recaptcha_google_activate' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options[ 'recaptcha_google_activate' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>						
	</tr>
	<tr>
		<th scope="row">Clave del sitio (Recaptcha):</th>
		<td>
			<input type="text" id="recaptcha_site_key" name="recaptcha_site_key" value="<?php echo $migration_options[ 'recaptcha_site_key' ]; ?>"/>
		</td>
		<th scope="row">Clave secreta (Recaptcha):</th>
		<td>
			<input type="text" id="recaptcha_secret_key" name="recaptcha_secret_key" value="<?php echo $migration_options[ 'recaptcha_secret_key' ]; ?>"/>
		</td>			
	</tr>				
</table>