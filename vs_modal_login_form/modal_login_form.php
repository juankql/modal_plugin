<?php
/*
Plugin Name: Menu item modal login form
Plugin URI: 
Description: The main goal of this plugin is to add a menu item with a link to a modal login window. 
Version: 0.1.0
Author : Ing. Juan Carlos Quevedo Lussón
Author email: juankql@gmail.com
Author URI: 
License: GPLv3 or later 
*/

if(!class_exists('WP_Menu_Modal_Login')) {

class WP_Menu_Modal_Login
{
	public function __construct(){
		add_action( 'admin_menu', array($this, 'vs_view_menu') );
		add_action( 'admin_init', array($this,'vs_register_settings') );
		add_action( 'wp_footer', array($this, 'vs_footer') );
		add_action( 'wp_enqueue_scripts', array($this, 'vs_enqueue_scripts') ); 
		add_filter( 'wp_nav_menu_items', array($this,'wp_nav_menu_items'), 10, 2 );

	}
	
	/**
	 * Add modal with login form in the page footer
	 * ===========================================
	 */
	public function vs_footer () {
	 	echo '<div class="modal" id="login_form_modal" tabindex="-1" role="dialog" aria-labelledby="Login Form" aria-hidden="true" >
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        '.wp_login_form(array('echo' => false)).'
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						      </div>
						    </div>
						  </div>
						</div>
						';	
	}
	
	/**
	 * Enqueue the bootstrap style and script
	 * ===========================================
	 */
	public function vs_enqueue_scripts() {
		wp_enqueue_style('bootstrap4css', plugins_url('/',__FILE__).'bootstrap-4.0.0-alpha.5-dist/css/bootstrap.min.css', array(), '4.0.0-alpha5');  
		wp_enqueue_script('bootstrap4js', plugins_url('/',__FILE__).'bootstrap-4.0.0-alpha.5-dist/js/bootstrap.min.js', array('jquery'), '4.0.0-alpha5'); 
	}
	
	/**
	 * Add login/logout menu item in the menu.
	 * ===========================================
	 */
	public function wp_nav_menu_items($items, $args) {
		//Loading in the settings the label for the menu iten
		$menu_item_label = esc_attr(get_option('vs_menu_item_label'));
		//If user is logged in.
	    if ( is_user_logged_in()) {
	        $items .= '<li><a href="'. wp_logout_url() .'" >Log Out</a></li>';
	    } 
	    // if user isn't logged in
	    elseif ( !is_user_logged_in() ) {
	        $items .= '<li><a class="login_link" data-toggle="modal" data-target="#login_form_modal" >'.$menu_item_label.'</a></li>';
	    }
	    return $items;	
	}
	
    /**
	 * Create admin settings view for the plugin
	 * ===========================================
	 */
	public function vs_admin_view_settings(){
		// Checking if the user has priviledges for managing options else show a warning.
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		include('views/admin_view_settings.php');
		
	}
	
	/**
	 * Specify admin settings view for the plugin
	 * ===========================================
	 */	
	public function vs_view_menu() {
			add_options_page( 'Modal Login Plugin Configuration', 'Modal Login', 'manage_options', 'modal_login-settings', array($this,'vs_admin_view_settings') );
	}

	/**
	 * Registrate settings for the plugin
	 * ===========================================
	 */
	public function vs_register_settings() {
		register_setting( 'modal_login-settings', 'vs_menu_item_label' );
	}

}

new WP_Menu_Modal_Login();
}

