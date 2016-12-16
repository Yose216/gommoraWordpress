<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://pixelspress.com
 * @since             1.0.0
 * @package           Neo_Bootstrap_Carousel
 *
 * @wordpress-plugin
 * Plugin Name:       NEO Bootstrap Carousel
 * Plugin URI:        http://pixelspress.com
 * Description:       A clean, simple & robust implementation of the Twitter Bootstrap Carousel in WordPress site in elegant way.
 * Version:           1.1.1
 * Author:            PixelsPress
 * Author URI:        http://pixelspress.com
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:       neo-bootstrap-carousel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-neo-bootstrap-carousel-activator.php
 */
function activate_neo_bootstrap_carousel() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-neo-bootstrap-carousel-activator.php';
    Neo_Bootstrap_Carousel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-neo-bootstrap-carousel-deactivator.php
 */
function deactivate_neo_bootstrap_carousel() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-neo-bootstrap-carousel-deactivator.php';
    Neo_Bootstrap_Carousel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_neo_bootstrap_carousel' );
register_deactivation_hook( __FILE__, 'deactivate_neo_bootstrap_carousel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-neo-bootstrap-carousel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_neo_bootstrap_carousel() {
    $plugin = new Neo_Bootstrap_Carousel();
    $plugin->run();
}
run_neo_bootstrap_carousel();