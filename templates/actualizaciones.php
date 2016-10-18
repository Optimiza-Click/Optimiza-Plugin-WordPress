<h2 class="title_migration">Configuración Actualizaciones</h2>
				
<table class="form-table">
	<tr>
		<th scope="row">Notificaciones del núcleo:</th>
		<td>
			<select name="updates_core">
				<option <?php if("y" == $migration_options['updates_core']) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['updates_core']) echo "selected"; ?> value="n">No</option>
			</select>
		</td>
		<th scope="row">Notificaciones de plugins:</th>
		<td>
			<select name="updates_plugins">
				<option <?php if("y" == $migration_options['updates_plugins']) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['updates_plugins']) echo "selected"; ?> value="n">No</option>
			</select>
		</td>
		<th scope="row">Notificaciones de temas:</th>
		<td>
			<select name="updates_themes">
				<option <?php if("y" == $migration_options['updates_themes']) echo "selected"; ?> value="y">Si</option>
				<option <?php if("n" == $migration_options['updates_themes']) echo "selected"; ?> value="n">No</option>
			</select>
		</td>
	</tr>
</table>