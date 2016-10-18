<h2 class="title_migration">Configuración Login</h2>
					
<table class="form-table">
	<tr>
		<th scope="row">Cambiar estilos login:</th>
		<td>
			<select name="enable_login_styles">								
				<option <?php if("n" == $migration_options[ 'enable_login_styles' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options[ 'enable_login_styles' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">URL logo login:</th>
		<td colspan="2">
			<input type="text" name="url_logo_image" id="url_logo_image"  value="<?php echo $migration_options[ 'url_logo_image']; ?>"/>
		</td>
		<th scope="row">URL background login:</th>
		<td colspan="2">
			<input type="text" name="url_login_image" id="url_login_image"  value="<?php echo $migration_options[ 'url_login_image']; ?>"/>
		</td>
		
	<tr valign="top">	
		<th scope="row">Altura logo login (px):</th>
		<td>
			<input type="number" name="height_login_image" id="height_login_image"  value="<?php echo $migration_options[ 'height_login_image']; ?>"/>	
		</td>
		<th scope="row">Anchura logo login (px):</th>
		<td>
			<input type="number" name="width_login_image" id="width_login_image"  value="<?php echo $migration_options[ 'width_login_image']; ?>"/>
		</td>
		<td>
			<input id="load_dimensions_logo" class="button button-primary" type="button" value="Cargar dimensiones" />	
		</td>
	</tr>	
	</tr>
	</table>
	<table class="form-table">
	<tr>
		<th scope="row">Background color:</th>
		<td>
			<input type="color" name="login_background_color" value="<?php if($migration_options[ 'login_background_color'] == "") echo '#F1F1F1'; 
			else  echo $migration_options[ 'login_background_color']; ?>"/>
		</td>
		<th scope="row">Form color:</th>
		<td>
			<input type="color" name="login_form_color" value="<?php if($migration_options[ 'login_form_color' ] == "") echo '#FFFFFF'; 
			else echo  $migration_options[ 'login_form_color']; ?>"/>
		</td>
		<th scope="row">Button form color:</th>
		<td>
			<input type="color" name="button_form_color" value="<?php if($migration_options[ 'button_form_color' ] == "") echo '#0091CD'; 
			else echo  $migration_options[ 'button_form_color']; ?>"/>
		</td>
	</tr>
	<tr>
		<th scope="row">Form font color:</th>
		<td>
			<input type="color" name="font_form_color" value="<?php if($migration_options[ 'font_form_color' ] == "") echo '#008EC2'; 
			else echo $migration_options[ 'font_form_color' ]; ?>"/>
		</td>
		<th scope="row">Form button font color:</th>
		<td>
			<input type="color" name="font_button_form_color" value="<?php if($migration_options[ 'font_button_form_color' ] == "") echo '#ffffff'; 
			else echo $migration_options[ 'font_button_form_color']; ?>"/>
		</td>
		
	</tr>
	<tr>
		<th scope="row">Habilitar redirección login:</th>
		<td>
			<select name="enable_login_redirect">								
				<option <?php if("n" == $migration_options[ 'enable_login_redirect' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options[ 'enable_login_redirect' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>
		<th scope="row">URL redirección login:</th>
		<td colspan="3">
			<input type="text" name="url_login_redirect" value="<?php echo $migration_options[ 'url_login_redirect']; ?>"/>
		</td>
	</tr>
	<tr>
		<th scope="row">Habilitar redirección logout:</th>
		<td>
			<select name="enable_logout_redirect">								
				<option <?php if("n" == $migration_options[ 'enable_logout_redirect' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options[ 'enable_logout_redirect' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>
		<th scope="row">URL redirección logout:</th>
		<td colspan="3">
			<input type="text" name="url_logout_redirect" value="<?php echo $migration_options[ 'url_logout_redirect']; ?>"/>
		</td>
	</tr>
	
</table>