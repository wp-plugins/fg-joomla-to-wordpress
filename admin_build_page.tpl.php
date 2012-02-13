<div class="wrap" style="float: left;">
	<?php screen_icon(); ?>
	<h2><?php _e('Import Joomla 1.5 (FG)', 'fgj2wp') ?></h2>
	
	<p><?php _e('This plugin will import sections, categories, posts and images from a Joomla database into WordPress.', 'fgj2wp') ?></p>
	
	<form action="" method="post">
		<input name="action" type="hidden" value="empty" />
		<?php wp_nonce_field( 'empty', 'fgj2wp_nonce' ); ?>
		
		<table class="form-table">
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="empty" value="<?php _e('Empty WordPress content', 'fgj2wp') ?>" type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<form action="" method="post">

		<input name="action" type="hidden" value="import" />
		<?php wp_nonce_field( 'import', 'fgj2wp_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Joomla web site parameters', 'fgj2wp') ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e('URL', 'fgj2wp') ?></th>
				<td><input name="url" type="text" size="50" value="<?php echo $data['url']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Joomla database parameters', 'fgj2wp') ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e('Hostname', 'fgj2wp') ?></th>
				<td><input name="hostname" type="text" size="50" value="<?php echo $data['hostname']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Port', 'fgj2wp') ?></th>
				<td><input name="port" type="text" size="50" value="<?php echo $data['port']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Database', 'fgj2wp') ?></th>
				<td><input name="database" type="text" size="50" value="<?php echo $data['database']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Username', 'fgj2wp') ?></th>
				<td><input name="username" type="text" size="50" value="<?php echo $data['username']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Password', 'fgj2wp') ?></th>
				<td><input name="password" type="password" size="50" value="<?php echo $data['password']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Joomla Table Prefix', 'fgj2wp') ?></th>
				<td><input name="prefix" type="text" size="50" value="<?php echo $data['prefix']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="submit" value="<?php _e('Import content from Joomla to WordPress', 'fgj2wp') ?>" type="submit" /></td>
			</tr>
		</table>
		
	</form>

</div>
