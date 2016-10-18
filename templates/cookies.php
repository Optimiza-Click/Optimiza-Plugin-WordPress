<h2 class="title_migration">Configuración Cookies</h2>
		 
<table class="form-table">		
	<tr>
		<th scope="row">Mostrar mensaje:</th>
		<td>
			<select name="display_message_cookies">
				<option <?php if("y" == $migration_options['display_message_cookies' ]) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['display_message_cookies' ]) echo "selected"; ?> value="n">No</option>
			</select>
		</td>
		<th scope="row">Ubicación del mensaje:</th>
		<td>
			<select name="position_cookies">
				<option <?php if("bottom" == $migration_options['position_cookies']) echo "selected"; ?> value="bottom">Abajo</option>
				<option <?php if("top" == $migration_options['position_cookies' ]) echo "selected"; ?> value="top">Arriba</option>
			</select>
		</td>
		<th scope="row">Ocultar mensaje:</th>
		<td>
			<select name="hide_cookies">
				<option <?php if("aceptar" == $migration_options['hide_cookies' ]) echo "selected"; ?> value="aceptar">Botón Aceptar</option>
				<option <?php if("auto" == $migration_options['hide_cookies' ]) echo "selected"; ?> value="auto">Automáticamente</option>
			</select>
		</td>
		
	</tr>
	</table>
	<table class="form-table">		
	
	<tr>			
		<th scope="row">Texto button cookies:</th>
		<td>
			<input type="text" name="text_button_cookies" value="<?php if($migration_options['text_button_cookies'] == "") echo 'Aceptar'; else echo $migration_options['text_button_cookies' ]; ?>"/>
		</td>
		
		<th scope="row">Texto enlace cookies:</th>
		<td colspan="3">
			<input type="text" name="link_text_cookies" style="width: 100%;" value="<?php if($migration_options['link_text_cookies'] != "") echo $migration_options['link_text_cookies' ]; else echo "condiciones de uso."; ?>" />
		</th>
		
	</tr>
	<tr>
		<th scope="row">Mensaje cookies:</th>
		<td colspan="5">
			<input type="text" name="text_message_cookies" style="width: 100%;" value="<?php if($migration_options['text_message_cookies'] != "") echo $migration_options['text_message_cookies']; else echo "Esta web utiliza cookies. Si sigues navegando entendemos que aceptas las"; ?>" />
		</th>
	</tr>
</table>

<table class="form-table">	
	<tr>
		<th scope="row">Background color:</th>
		<td>
			<input type="color" name="background_color_cookies" value="<?php if($migration_options['background_color_cookies'] == "") echo '#ffffff'; else echo $migration_options['background_color_cookies' ]; ?>"/>
		</td>
		<th scope="row">Font color:</th>
		<td>
			<input type="color" name="font_color_cookies" value="<?php if($migration_options['font_color_cookies'] == "") echo '#000000'; else echo $migration_options['font_color_cookies']; ?>"/>
		</td>
		<th scope="row">Background color button:</th>
		<td>
			<input type="color" name="background_button_cookies" value="<?php if($migration_options['background_button_cookies' ] == "") echo '#000000'; else echo $migration_options['background_button_cookies']; ?>"/>
		</td>
		<th scope="row">Font color button:</th>
		<td>
			<input type="color" name="font_color_button_cookies" value="<?php if($migration_options['font_color_button_cookies' ] == "") echo '#ffffff'; else echo $migration_options['font_color_button_cookies']; ?>"/>
		</td>																			
	</tr>
</table>

<table class="form-table">					
	<tr>
		<th scope="row">Titulo política cookies:</th>
		<td>
			<input type="text" name="title_politica_cookies" id="title_politica_cookies"  value="<?php if($migration_options['title_politica_cookies']  == "") echo "Política de Cookies"; else echo $migration_options['title_politica_cookies' ]; ?>"/>
		</td>
		<th scope="row">Slug política cookies:</th>
		<td>
			<input type="text" name="slug_politica_cookies" id="slug_politica_cookies" value="<?php if($migration_options['slug_politica_cookies']  == "") echo "politica-cookies"; else echo $migration_options['slug_politica_cookies' ]; ?>"/>
		</td>
	</tr>
							
	<tr>
		<th scope="row">Titulo información cookies:</th>
		<td>
			<input type="text" name="title_mas_informacion" id="title_mas_informacion" value="<?php if($migration_options['title_mas_informacion']  == "") echo "Más información sobre las Cookies"; else echo $migration_options['title_mas_informacion' ]; ?>"/>
		</td>
		<th scope="row">Slug información cookies:</th>
		<td>
			<input type="text" name="slug_mas_informacion" id="slug_mas_informacion" value="<?php if($migration_options['slug_mas_informacion']  == "") echo "informacion-cookies"; else echo $migration_options['slug_mas_informacion' ]; ?>"/>
		</td>
	</tr>
	<tr>
		<th scope="row">	
			<input type="button" class="button button-primary" value="Crear páginas sobre las cookies" id="button_cookies_pages" />
		</th>
	</tr>
</table>