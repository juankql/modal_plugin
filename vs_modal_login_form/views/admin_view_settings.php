<div class="wrap">
	<h2 style="text-align:center;padding-bottom:15px;">Modal Login Plugin Configuration</h2>
	<form action="options.php" method="post" enctype="multipart/form-data">
	<?php
 		settings_fields('modal_login-settings');
	?> 
		<table class="form-table">
			<tr>
				<th scope="row"><label for="vs_menu_item_label"><?php _e('Label for login menu item') ?></label></th>
				<td><input type="text" name="vs_menu_item_label" id="vs_menu_item_label" placeholder="<?php _e('Login') ?>" value="<?php echo esc_attr(get_option('vs_menu_item_label')); ?>" style="width:100%;" ></td>
			</tr>
		</table>
		<?php 
		do_settings_sections('modal_login-settings'); 
		
		submit_button();?>
	</form>
</div>
