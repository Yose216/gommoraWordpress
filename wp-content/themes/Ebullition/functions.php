	<?php 
require TEMPLATEPATH.'/Framework/theme.php';
$theme = new Theme(array(
	'menu' => array(
			'nav' => 'navigation'
			
		)
	));
 
wp_enqueue_style( 'ebullition-style', get_stylesheet_uri());
wp_enqueue_style( 'ebullition-bootstrap', get_stylesheet_directory_uri().'/css/bootstrap.min.css',array(), '3.3.5');
wp_enqueue_style( 'ebullition-fontawesome', get_stylesheet_directory_uri().'/css/font-awesome.min.css',array(), '4.4.0');
wp_enqueue_script( 'ebullition-script-all', get_template_directory_uri() . '/js/bootstrap.min.js');
wp_enqueue_script( 'ebullition-lettering', get_template_directory_uri() . '/js/jquery.lettering.min.js');
wp_enqueue_script( 'ebullition-javascript-jquery', get_template_directory_uri() . '/js/jquery.js' );
wp_enqueue_script( 'ebullition-javascript-elevateZoom', get_template_directory_uri() . '/js/jquery.imageLens.js' );
wp_enqueue_script( 'ebullition-javascript', get_template_directory_uri() . '/js/scripts.js' );




/*<?php if (!defined('ABSPATH')) die('Restricted Area');
function wpc_unregister_job_listing_type() {
	unregister_taxonomy('job_listing_type'); // Specify the taxonomy to unregister
}
add_action('init', 'wpc_unregister_job_listing_type');*/

?>