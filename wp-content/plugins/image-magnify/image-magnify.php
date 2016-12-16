<?php
/**
 * @package image-magnify
 * @version 1.0
 */
/*
Plugin Name: Image Magnify
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: <strong>Image Magnify</strong> is a lightweight image magnifier plugin for wordpress. It add zoom effect on the hover of the image.
Author: Sazzad Hu
Version: 1.0
Author URI: http://sazzadh.com/
*/

$path_dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));
$path_abs = trailingslashit(str_replace('\\','/',ABSPATH));

define('IMGMAGNIFY_URL', site_url(str_replace( $path_abs, '', $path_dir )));
define('IMGMAGNIFY_DRI', $path_dir);

add_action('wp_enqueue_scripts', 'imgMagnify_script_loader');
function imgMagnify_script_loader(){
	wp_enqueue_style('magnify', IMGMAGNIFY_URL.'css/magnify.css');
	wp_enqueue_script('magnify', IMGMAGNIFY_URL.'js/jquery.magnify.js' , array('jquery'), '', true);
}


add_shortcode('image_magnify', 'imgMagnify_shortcode');
function imgMagnify_shortcode( $atts, $content = null ) {
    $settings = shortcode_atts( array(
        'src' => '',
        'src_big' => '',
		'alt' => '',
		'w' => '',
		'h' => '',
		'class' => '',
    ), $atts );
	
	$output = '';
	$uid = rand();
	
	$src_big = NULL;
	if($settings['src_big'] != ''){ $src_big = ' data-magnify-src="'.$settings['src_big'].'"'; }
	
	$alt = NULL;
	if($settings['alt'] != ''){ $alt = ' alt="'.$settings['alt'].'"'; }
	
	$height = NULL;
	if($settings['h'] != ''){ $height = ' height="'.$settings['h'].'"'; }
	
	$width = NULL;
	if($settings['w'] != ''){ $width = ' width="'.$settings['w'].'"'; }
	
	if($settings['src'] != ''){
		$output .= '<img class="imgMagnify_'.$uid.' '.$settings['class'].'" src="'.$settings['src'].'" '.$src_big.$alt.$height.$width.' />';
	}
	
	if($settings['src_big'] != ''){
		$output .= '<script type="text/javascript">';
			$output .= 'jQuery(document).ready(function($) {';
				$output .= '$(".imgMagnify_'.$uid.'").magnify();';
			$output .= '});';
		$output .= '</script>';
	}
	
	return $output;	
}