<?php 
	/**
	 * Create Admin Menu
	 */
	function lwst_manage_admin_menu() {
		add_menu_page( 'Theme Settings', 'Theme Settings', 'manage_options', 'lwst_theme_settings', 'cb_lwst_theme_settings_page', get_template_directory_uri() . '/assets/images/icon.png', 1 ); 
	}
	add_action( 'admin_menu', 'lwst_manage_admin_menu' );

	/**
	 * Admin Page
	 */
	function cb_lwst_theme_settings_page() {
		?>
		<section class="section panel" id="poststuff" style="padding-right: 20px;">
			<h1>Inställningar för DN.Kortet</h1>
			<form method="post" enctype="multipart/form-data" action="options.php">

				<?php wp_nonce_field('update-options') ?>
				<input type="hidden" name="action" value="update" />
	            <input type="hidden" name="page_options" value="<?php echo lwst_get_page_option_string(); ?>" />

				<p class="submit">  
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
				</p>  

				<?php lwst_print_options(); ?>

				<p class="submit">  
					<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />  
				</p>  

			</form>
		</section>
		<?php
	}

	function lwst_get_sections() {
		return array(
			array(
				'title' => 'Settings',
				'fields' => array(
					array(
						'type' => 'text',
						'name' => 'test_setting',
						'title' => 'Test Setting',
						'default' => '',
						'description' => 'Default helper text...',
					),
				)
			),
			
		);
	}

	function lwst_print_options() {
		foreach(lwst_get_sections() as $section) : ?>
			<div class="postbox">
				<h3 style="border-bottom: 1px solid #E5E5E5;"><span><?php echo $section['title']; ?></span></h3>
				<div class="inside">
					<table class="form-table">
						<tbody>
							<?php
							foreach($section['fields'] as $field) {
								lwst_print_field($field);
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		<?php endforeach;
	}

	/**
	 * Call this to set default values to databas on theme activation
	 */
	function lwst_set_default_theme_options() {
		foreach(lwst_get_sections() as $section) {
			foreach($section['fields'] as $field) {
				if(isset($field['default'])) {
					$value = get_option( $field['name'] );
					if($value == "" OR empty($value)) {
						update_option( $field['name'], $field['default'] );
					}
				}
			}
		}
	}

	function lwst_get_page_option_string() {
		$str = "";
		foreach(lwst_get_sections() as $section) {
			foreach($section['fields'] as $field) {
				if($field['type'] == 'text_between') {
					foreach($field['fields'] as $f) {
						$str .= "," . $f['name'];
					}
				} else {
					$str .= "," . $field['name'];
				}
				
			}
		}
		return ltrim($str, ',');
	}
	function lwst_print_field($field) {
		switch($field['type']) {
			case 'text' :
			?>
				<tr valign="top">
					<th scope="row"><label title="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>"><?php echo $field['title'] ?></label></th>
					<td>
						<input type="<?php echo $field['type'] ?>" title="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" class="regular-text" value="<?php echo esc_attr( get_option($field['name']) ) ?>"> <small><?php if(isset($field['default'])) echo "Standard: " . $field['default']; ?></small>
						<p class="description"><?php echo $field['description'] ?></p>
					</td>
				</tr>
			<?php
			break;
			case 'textarea' :
			?>
				<tr valign="top">
					<th scope="row"><label title="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>"><?php echo $field['title'] ?></label></th>
					<td>
						<textarea title="<?php echo $field['name'] ?>" id="<?php echo $field['name'] ?>" name="<?php echo $field['name'] ?>" cols="70" rows="3"><?php echo esc_attr( get_option($field['name']) ) ?></textarea> <small><?php if(isset($field['default'])) echo "Standard: " . $field['default']; ?></small>
						<p class="description"><?php echo $field['description'] ?></p>
					</td>
				</tr>
			<?php
			break;
			case 'text_between' :
			?>
				<tr valign="top">
					<th scope="row"><label><?php echo $field['title'] ?></label></th>
					<td>
						<?php foreach($field['fields'] as $f): ?>
							<small><?php echo $f['title'] ?>: </small><input type="<?php echo $f['type'] ?>" title="<?php echo $f['name'] ?>" id="<?php echo $f['name'] ?>" name="<?php echo $f['name'] ?>" class="small-text" value="<?php echo esc_attr( get_option($f['name']) ) ?>">&nbsp;&nbsp;
						<?php endforeach; ?>
					</td>
				</tr>
			<?php
			break;
		}
	}
?>