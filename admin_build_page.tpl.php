<div class="wrap" style="float: left;">
	<?php screen_icon(); ?>
	<h2><?php _e('Import Joomla 1.5 (FG)', 'fgj2wp') ?></h2>
	
	<p><?php _e('This plugin will import sections, categories, posts and medias (images, attachments) from a Joomla database into WordPress.', 'fgj2wp'); ?></p>
	
	<div style="border: 1px solid #cccccc; background: #faebd7; margin: 10px; padding: 2px 10px;">
		<h3><?php _e('WordPress database', 'fgj2wp') ?></h3>
		<?php printf(_n('%d category', '%d categories', $data['cat_count'], 'fgj2wp'), $data['cat_count']); ?><br />
		<?php printf(_n('%d post', '%d posts', $data['posts_count'], 'fgj2wp'), $data['posts_count']); ?><br />
		<?php printf(_n('%d media', '%d medias', $data['media_count'], 'fgj2wp'), $data['media_count']); ?><br />
	</div>
	
	<form action="" method="post">
		<input name="action" type="hidden" value="empty" />
		<?php wp_nonce_field( 'empty', 'fgj2wp_nonce' ); ?>
		
		<table class="form-table">
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="empty" value="<?php _e('Empty WordPress content', 'fgj2wp'); ?>" type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<form action="" method="post">

		<input name="action" type="hidden" value="import" />
		<?php wp_nonce_field( 'import', 'fgj2wp_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Joomla web site parameters', 'fgj2wp'); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><label for="url"><?php _e('URL', 'fgj2wp'); ?></label></th>
				<td><input id="url" name="url" type="text" size="50" value="<?php echo $data['url']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Joomla database parameters', 'fgj2wp'); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><label for="hostname"><?php _e('Hostname', 'fgj2wp'); ?></label></th>
				<td><input id="hostname" name="hostname" type="text" size="50" value="<?php echo $data['hostname']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="port"><?php _e('Port', 'fgj2wp'); ?></label></th>
				<td><input id="port" name="port" type="text" size="50" value="<?php echo $data['port']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="database"><?php _e('Database', 'fgj2wp'); ?></label></th>
				<td><input id="database" name="database" type="text" size="50" value="<?php echo $data['database']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="username"><?php _e('Username', 'fgj2wp'); ?></label></th>
				<td><input id="username" name="username" type="text" size="50" value="<?php echo $data['username']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="password"><?php _e('Password', 'fgj2wp'); ?></label></th>
				<td><input id="password" name="password" type="password" size="50" value="<?php echo $data['password']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="prefix"><?php _e('Joomla Table Prefix', 'fgj2wp'); ?></label></th>
				<td><input id="prefix" name="prefix" type="text" size="50" value="<?php echo $data['prefix']; ?>" /></td>
			</tr>
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('Behavior', 'fgj2wp'); ?></h3></th>
			</tr>
			<tr>
				<th scope="row"><?php _e('Posts with a "read more" split:', 'fgj2wp'); ?></th>
				<td><input id="introtext_in_excerpt" name="introtext_in_excerpt" type="checkbox" value="1" <?php checked($data['introtext_in_excerpt'], 1); ?> /> <label for="introtext_in_excerpt" title="<?php _e("Checked: the Joomla introtext is imported into the excerpt. Unchecked: it is imported into the post content with a «read more» link.", 'fgj2wp'); ?>"><?php _e('Import the text above the "read more" to the excerpt', 'fgj2wp'); ?></label></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Medias:', 'fgj2wp'); ?></th>
				<td><input id="skip_media" name="skip_media" type="checkbox" value="1" <?php checked($data['skip_media'], 1); ?> /> <label for="skip_media" ><?php _e('Skip media', 'fgj2wp'); ?></label></td>
			</tr>
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="submit" value="<?php _e('Import content from Joomla to WordPress', 'fgj2wp'); ?>" type="submit" /></td>
			</tr>
		</table>
	</form>
	
	<form action="" method="post">

		<input name="action" type="hidden" value="modify_links" />
		<?php wp_nonce_field( 'modify_links', 'fgj2wp_nonce' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row" colspan="2"><h3><?php _e('After the migration', 'fgj2wp'); ?></h3></th>
			</tr>
			<tr>
				<th scope="row">&nbsp;</th>
				<td><input class="button-primary" name="submit" value="<?php _e('Modify internal links', 'fgj2wp'); ?>" type="submit" /></td>
			</tr>
		</table>
		
	</form>
	
	<p><?php _e('If you found this plugin useful and it saved you many hours or days, please rate it on <a href="http://wordpress.org/extend/plugins/fg-joomla-to-wordpress/">FG Joomla to WordPress</a>. You can also make a donation using the button below.', 'fgj2wp'); ?></p>
	
	<div style="text-align: center; margin-top:20px;">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHVwYJKoZIhvcNAQcEoIIHSDCCB0QCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYCfk+pSEzhPjuHJZJBiTgPc5tRuxI5mCoiTC7YsLndfLgyMZJhjkKxUg/7bXwXpBfiyDen9vDhq8k6lLpMLJw2VfLUuIi891t7wp8pupdqDU+kbdwkqTV+039savMD/v8Euf867ByQNCxWvUQEbVncwyZRhLAs3ysdSs/xseqiQOTELMAkGBSsOAwIaBQAwgdQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIadERNGX+WwKAgbAw8XgZLPo2N+aDdyyRHB+SOPY/gbvOaXBI31uy9I/AK8hjDgtYF9kuCYNJ7tEmNlACM134XJ/tWQ3qVE0b8q1C8qvNgPcbQLj73u4UmXMl4HvsBnkAVQXEDj+gIJ28zAL50+0BU7F/7Bz4ODj08dVynq0C5G2Imr/nAGHAZxcNsGoFPKr39oxwQwTr1clNqMPVnglISY/Fl3TZzbWTb2uJIKTYbgMViiBgr+KudRP8JaCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTEyMDMwMjIxNTU1MFowIwYJKoZIhvcNAQkEMRYEFP4feOsZexvVsg/wqu6xhw0yCyj6MA0GCSqGSIb3DQEBAQUABIGABCXi0yjm8lEoW5te0kLwPYMuubTz9X4VlEInFhg2wR8Cp4WInZLVxOqXbB9EdjU87f9DbFsvi4iDCGxnu3AojMuEIr2ruG1++p3bQ9LDHso8HKVfYGD945LTKbtABmupT6YzwCg9z/paXRtQsKPx0Qt4ItAk2MlsVSOFDt+W/uA=-----END PKCS7-----
			">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
		</form>
	</div>
	
</div>
