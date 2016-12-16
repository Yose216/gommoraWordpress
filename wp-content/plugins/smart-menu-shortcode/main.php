<?php
/*
Plugin Name: Smart Menu Shortcode
Description: Display wordpress menu with shortcode anywhere in a page, post or template.
Tags: shortcode menu, menu, navigation, shortcode
Author URI: http://www.max99.dk/
Author: Kjeld Hansen
Text Domain: smart_menu_shortcode
Requires at least: 4.0
Tested up to: 4.4.2
Version: 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu','menu_shortcode_admin_menu');
function menu_shortcode_admin_menu() { 
    add_menu_page(
		"Shortcode Menu",
		"Menu",
		8,
		__FILE__,
		"menu_shortcode_admin_menu_list",
		plugins_url( 'img/sticky-icon.png', __FILE__ ) 
	); 
}

function menu_shortcode_admin_menu_list(){
	include 'shortcode-menu-admin.php';
}


function menu_shortcode_admin_head(){
	?>
    <style type="text/css">
    	#adminmenu #toplevel_page_menu-shortcode-main div.wp-menu-image{
			width: 75px;
    		margin-right: 5px;
		}
    </style>
    <?php	
}
add_action('admin_head','menu_shortcode_admin_head');

add_action('wp_head','menu_shortcode_load_js');

function menu_shortcode_load_js(){
	?>
    <style type="text/css">
    	.menu_shortcode{ float:left; }
		
    </style>
    <?php
}

if (!shortcode_exists('menu_shortcode')) {
	add_shortcode('menu_shortcode', 'menu_shortcode_fn');
}

function menu_shortcode_fn($args){
	
	$argsm = array('menu'=>$args[id], 'echo'=>false, 'container_class'=>'', 'menu_class'=>'menu_shortcode', 'after'=>'<span class="catripl"></span>');
	echo wp_nav_menu( $argsm );
}