<?php
/* 
Plugin Name: 	Copyright Editor - Easy
Plugin URI: 	https://www.phamhuuthanh.com
Description: 	Easily edit the footer copyright with the Copyright Editor plugin. You can remove the footer copyright or edit it to your liking. Free forever plugin for wordpress website!!
Tags: 			copyright, remove copyright, copyright edit, customized copyright, pht blog, wordpress, plugin
Author: 		Pham Huu Thanh
Author URI: 	https://me.phamhuuthanh.com
Version: 		2.0
License: 		GPL2
Text Domain:    copyright-editor-easy-pht
*/
	add_action('admin_menu', 'ceepht_Config');
	
	// TAO DUONG DAN TREN MENU TRANG QUAN TRI
	if (!function_exists('ceepht_Config')) { 
		function ceepht_Config(){
				add_menu_page( 'Copyright Editor - Easy', 'Copyright Editor', 'manage_options', 'pht-copyright-editor', 'ceepht_pageConfig');
		}
	}
	// NOI DUNG TRANG TUY CHINH
	if (!function_exists('ceepht_pageConfig')) { 
		function ceepht_pageConfig() {
		?>
		<div class="wrap">
		<h1>Copyright Editor - Easy</h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'plugin_options' ); ?>
			<?php do_settings_sections( 'plugin_options' ); ?>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Remove Copyright</th>
				<td><input type="checkbox" name="ceepht-remove" <?php if(get_option('ceepht-remove') != "" ) echo 'checked'; ?> value="1" />
				<br>
				<p class="description"><?php _e('Check to remove the footer copyright') ?></p>
				</td>
				</tr>
			</table>
			<hr/>
			<h2>Edit Copyright</h2>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">New Copyright</th>
				<td><textarea name="ceepht-new" rows="2" cols="60"><?php echo esc_attr( get_option('ceepht-new') ); ?></textarea>
				<br>
				<p class="description">Enter the new copyright content here</p>
				</td>
				</tr>
			</table>
			<hr/>
			<table class="form-table">
				<tr valign="top">
				<th scope="row">Enter the embed code</th>
				<td><textarea name="ceepht-manhung" rows="8" cols="60"><?php echo esc_attr( get_option('ceepht-manhung') ); ?></textarea>
				<br>
				<p class="description">Enter the embed code here. For example: Google Analytics, verification tag, embed code css, js, script code, meta tags....</p>
				</td>
				</tr>
			</table>
			
			<?php submit_button(); ?>
<p class="description">See more installation instructions at: <a href="https://www.phamhuuthanh.com" target="_blank">hướng dẫn sử dụng Copyright Editor</a></p>
		</form>
		</div>
		<?php } 
	}
	// KHAI BAO CAC BIEN
	add_action('admin_init', 'ceepht_admin_init');
	if (!function_exists('ceepht_admin_init')) { 
		function ceepht_admin_init(){
			register_setting( 'plugin_options', 'ceepht-remove');
			register_setting( 'plugin_options', 'ceepht-new');
			register_setting( 'plugin_options', 'ceepht-manhung');
		}
	}
	
	// HIEN THI RA NGOAI WEBSITE
	add_action('template_redirect', 'ceepht_showWeb'); // template_redirect nghĩa la chỉ show ra trong template, ko show trong admin
	if (!function_exists('ceepht_showWeb')) { 
		function ceepht_showWeb(){
			// Them CSS vao Web
			wp_register_style( 'ceepht_style1',  plugin_dir_url( __FILE__ ) . 'css/copyrightedit.css' );
			wp_enqueue_style( 'ceepht_style1' );
			add_action('wp_footer', 'ceepht_footerContent');
		}
	}
	
	/** Thêm mã nhúng **/
	add_action('template_redirect', 'ceepht_Addmanhung'); 
	if (!function_exists('ceepht_Addmanhung')) { 
		function ceepht_Addmanhung(){
			add_action('wp_head', 'ceepht_manhungHeader');
		}
	}
	if (!function_exists('ceepht_manhungHeader')) { 
		function ceepht_manhungHeader() {
			echo wp_specialchars_decode( get_option('ceepht-manhung') );
		}
	}
	/** HIEN THI TUY CHINH **/
	add_action('template_redirect', 'ceepht_showCustom'); 
	if (!function_exists('ceepht_showCustom')) { 
		function ceepht_showCustom(){
			wp_register_script( 'ceepht_script', plugin_dir_url( __FILE__ ) . 'main.js','','1.1', true );
			wp_enqueue_script( 'ceepht_script' );
				
			wp_register_style( 'ceepht_style2',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
			wp_enqueue_style( 'ceepht_style2' );
			
			add_action('wp_footer', 'ceepht_showEditor');
		}
	}
	if (!function_exists('ceepht_showEditor')) {
		function ceepht_showEditor() {

		if(get_option('ceepht-remove') != "") {
			echo '<style> .copyright {display:none} .copyright-footer {display:none} #copyright{display:none} #copyright-footer{display:none}</style>';
		}
		if(get_option('ceepht-new') != ""){
			echo '<script>
					var x = document.getElementsByClassName("copyright");
					var i;
					for (i = 0; i < x.length; i++) {
					x[i].innerHTML= "'.get_option("ceepht-new").'";
					}
				</script>';
			echo '<script>
					var y = document.getElementsByClassName("copyright-footer");
					var i;
					for (i = 0; i < y.length; i++) {
					y[i].innerHTML= "'.get_option("ceepht-new").'";
					}
				</script>';
			echo '<script>
					var z = document.getElementsById("copyright");
					var i;
					for (i = 0; i < z.length; i++) {
					y[i].innerHTML= "'.get_option("ceepht-new").'";
					}
				</script>';
			echo '<script>
					var t = document.getElementsById("copyright-footer");
					var i;
					for (i = 0; i < t.length; i++) {
					y[i].innerHTML= "'.get_option("ceepht-new").'";
					}
				</script>';
		}
		}
	
	}