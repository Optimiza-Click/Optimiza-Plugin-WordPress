<h2 class="title_migration">Configuración Aviso Legal</h2>
					
<table class="form-table">
	<tr>
		<th scope="row">Titulo página aviso legal:</th>
		<td>
			<input type="text" name="title_aviso_legal" id="title_aviso_legal"  value="<?php echo $migration_options['title_aviso_legal' ]; ?>"/>
		</td>
		<th scope="row">Etiqueta aviso legal:</th>
		<td>
			<input type="text" name="slug_aviso_legal" id="slug_aviso_legal" value="<?php echo $migration_options['slug_aviso_legal' ]; ?>"/>
		</td>
	</tr>
	<tr>		
		<th scope="row">Nombre empresa:</th>
		<td>
			<input type="text" name="name_empresa" id="name_empresa" value="<?php echo $migration_options['name_empresa' ]; ?>"/>
		</td>
		<th scope="row">Dirección empresa:</th>
		<td>
			<input type="text" name="address_empresa" id="address_empresa" value="<?php if($migration_options['address_empresa'] == "") echo 'con domicilio social en ';  echo $migration_options['address_empresa' ]; ?>"/>
		</td>
	</tr>
	<tr>				
		<th scope="row">CIF empresa:</th>
		<td>
			<input type="text" name="cif_empresa" id="cif_empresa" value="<?php  if($migration_options['cif_empresa' ] == "") echo 'con CIF nº ';   echo $migration_options['cif_empresa' ]; ?>"/>
		</td>
		<th scope="row">Registro mercantil empresa:</th>
		<td>
			<input type="text" name="register_empresa" id="register_empresa" value="<?php if($migration_options['register_empresa' ] == "") echo 'e inscrita en el Registro Mercantil ';  echo $migration_options['register_empresa']; ?>"/>
		</td>
	</tr>
	<tr>		
		<th scope="row">Dominio empresa:</th>
		<td>
			<input type="text" name="domain_empresa" id="domain_empresa" value="<?php echo $migration_options['domain_empresa' ]; ?>"/>
		</td>
		<th scope="row">E-mail empresa:</th>
		<td>
			<input type="text" name="email_empresa" id="email_empresa" value="<?php echo $migration_options['email_empresa' ]; ?>"/>
		</td>
	</tr>
	<tr>
		<th scope="row">	
			<input type="button" class="button button-primary" value="Crear página de aviso legal" id="button_aviso_legal_page" />
		</th>
	</tr>
</table>