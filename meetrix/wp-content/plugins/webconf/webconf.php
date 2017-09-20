<?php
/*
Plugin Name: Conference Plugin
Description: A simple WP plugin for WebRTC based conference
Version:     1.0.0
Author:      Xolusa
*/
	
	add_filter('wp_footer', 'start_conf');

	function start_conf(){
			echo '<br><h3 align="center">Welcome to conference</h3>';
			include plugin_dir_path(__FILE__).'/inc/conf.php';
		} 

//add to admin panel
 
/*add_action( 'admin_menu', 'conference_menu' );

function conference_menu(){

  $page_title = 'Conference';
  $menu_title = 'Conference';
  $capability = 'manage_options'; 
  $menu_slug  = 'conf-info';
  $function   = 'conf_page';
  $icon_url   = 'dashicons-media-video';
  $position   = 4;

  add_menu_page( $page_title,
                 $menu_title, 
                 $capability, 
                 $menu_slug, 
                 $function, 
                 $icon_url, 
                 $position );
}

function conf_page(){
		echo '<br><h3 align="center">Welcome to conference</h3>';
		//echo get_template_directory_uri().'<br>';
		//echo plugin_dir_path(__FILE__);
		include plugin_dir_path(__FILE__).'/inc/conf.php';
	}
?>
*/



