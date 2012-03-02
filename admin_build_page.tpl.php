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
				<th scope="row"><label for="url"><?php _e('URL', 'fgj2wp') ?></label></th>
				<td><input id="url" name="url" type="text" size="50" value="<?php echo $data['url']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Joomla database parameters', 'fgj2wp') ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><label for="hostname"><?php _e('Hostname', 'fgj2wp') ?></label></th>
				<td><input id="hostname" name="hostname" type="text" size="50" value="<?php echo $data['hostname']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="port"><?php _e('Port', 'fgj2wp') ?></label></th>
				<td><input id="port" name="port" type="text" size="50" value="<?php echo $data['port']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="database"><?php _e('Database', 'fgj2wp') ?></label></th>
				<td><input id="database" name="database" type="text" size="50" value="<?php echo $data['database']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="username"><?php _e('Username', 'fgj2wp') ?></label></th>
				<td><input id="username" name="username" type="text" size="50" value="<?php echo $data['username']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="password"><?php _e('Password', 'fgj2wp') ?></label></th>
				<td><input id="password" name="password" type="password" size="50" value="<?php echo $data['password']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="prefix"><?php _e('Joomla Table Prefix', 'fgj2wp') ?></label></th>
				<td><input id="prefix" name="prefix" type="text" size="50" value="<?php echo $data['prefix']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Behavior', 'fgj2wp') ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e('Posts with a "read more" split:', 'fgj2wp') ?></th>
				<td><input id="introtext_in_excerpt" name="introtext_in_excerpt" type="checkbox" value="1" <?php checked($data['introtext_in_excerpt'], 1) ?> /> <label for="introtext_in_excerpt" title="<?php _e("Checked: the Joomla introtext is imported into the excerpt. Unchecked: it is imported into the post content with a «read more» link.", 'fgj2wp') ?>"><?php _e('Import the text above the "read more" to the excerpt', 'fgj2wp') ?></label></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Images:', 'fgj2wp') ?></th>
				<td><input id="skip_images" name="skip_images" type="checkbox" value="1" <?php checked($data['skip_images'], 1) ?> /> <label for="skip_images" ><?php _e('Skip images', 'fgj2wp') ?></label></td>
			</tr>
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="submit" value="<?php _e('Import content from Joomla to WordPress', 'fgj2wp') ?>" type="submit" /></td>
			</tr>
		</table>
		
	</form>

</div>
