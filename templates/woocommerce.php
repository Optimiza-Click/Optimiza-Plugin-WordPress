<h2 class="title_migration">Configuración WooCommerce</h2>
				
<table class="form-table woocommerce_table">		
	<tr>
		<th scope="row">Modo catálogo:</th>
		<td>
			<select name="catalog_mode">								
				<option <?php if("n" == $migration_options['catalog_mode' ]) echo "selected"; ?> value="n">No</option>
				<option <?php if("y" == $migration_options['catalog_mode' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>		
		<th scope="row">Ocultar precios:</th>
		<td>
			<select name="catalog_mode_price">								
				<option <?php if("n" == $migration_options['catalog_mode_price' ]) echo "selected"; ?> value="n">No</option>	
				<option <?php if("y" == $migration_options['catalog_mode_price' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>	
	</tr>
	<tr>
		<th scope="row">Modifcar productos por página:</th>
		<td>
			<select name="enable_produts_page">								
				<option <?php if("n" == $migration_options['enable_produts_page' ]) echo "selected"; ?> value="n">No</option>	
				<option <?php if("y" == $migration_options['enable_produts_page' ]) echo "selected"; ?> value="y">Si</option>
			</select>
		</td>	
		<th scope="row">Productos por página:</th>
		<td>
			<input type="text" id="num_produts_page" name="num_produts_page" value="<?php if($migration_options['num_produts_page'] != "") echo $migration_options['num_produts_page']; else echo 12; ?>"/>
		</td>	
	</tr>
</table>