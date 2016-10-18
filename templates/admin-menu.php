<h2 class="title_migration">Configuración Menú de Administración</h2>
									
	<table class="form-table">

	<tr>
		<td colspan="4">Estas opciones <strong>NO</strong> se ocultarán para el usuario:
		
		<select name="user_menu_admin" id="user_menu_admin">
		
		<?php $args = array('orderby' => 'ID','order' => 'ASC' ); 
		$users = get_users( $args ); 
		
		foreach($users as $user)
		{
			echo "<option ";

			if($migration_options['user_menu_admin'] == $user->ID)
				echo " selected='selected' ";
			
			echo "value='".$user->ID."'>".$user->user_login."</option>";
		}
		
		?>
		
		</select>

	</tr>
	
	<?php
	
	global $menu;
	
	$admin_menu = $migration_options["migration_plugin_admin_menu_data"];
	
	$x = 0;

	foreach($menu as $item)
	{		
		if($item[0] != "")
		{
			if($x % 4 == 0)
				echo "<tr>";
			
			if(strpos($item[0], "<span") > 0)
				$name = substr($item[0], 0, strpos($item[0], " "));
			else
				$name = $item[0];
			
			echo "<td><p class='admin_menu_check'><input type='checkbox' ";
			
			if($admin_menu[$item[2]] == 1) echo " checked ";

			echo " class='value_check' />";
			
			echo "<input type='hidden' class='admin_menu_name'  value='".$item[2]."' /> ".$name."</p></td>";
			
			$x++;
			
			if($x % 4 == 0)
				echo "</tr>";	
		}		

	}
	
	?>
	<tr>
		<td colspan="4">	
			<input type="button" class="button button-primary" value="Aplicar cambios" id="save_admin_menu" />
			<input type="button" class="button button-primary" id="checked_checkboxes_btn" value="Marcar todos" /> 
			<input type="button" class="button button-primary" id="unchecked_checkboxes_btn" value="Desmarcar todos" />
		</td>
	</tr>

</table>