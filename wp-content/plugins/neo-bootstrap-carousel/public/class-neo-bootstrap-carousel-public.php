<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * 
 * @link       http://pixelspress.com
 * @since      1.0.0
 *
 * @package    Neo_Bootstrap_Carousel
 * @subpackage Neo_Bootstrap_Carousel/public
 * @author     PixelsPress <support@pixelspress.com>
 */

class Neo_Bootstrap_Carousel_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
        /**
         * The class is responsible for defining the post type 'neo_carousel'.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-neo-bootstrap-carousel-post-type.php';
        
        /**
         * The class is responsible for defining the metabox for 'neo_carousel' post type.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-neo-bootstrap-carousel-meta-box.php';
        
        /**
         * The class is responsible for defining the shortcode for 'NEO Bootstrap Carousel'.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-neo-bootstrap-carousel-shortcode.php';
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/neo-bootstrap-carousel-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-touch', plugin_dir_url( __FILE__ ) . 'css/bootstrap-touch-carousel.css', array(), '0.8.0', 'all' );
        wp_enqueue_style( $this->plugin_name.'-animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), '3.1.1', 'all' );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/neo-bootstrap-carousel-public.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bootstrap-touch-carousel.js', array( ), '0.8.0', true );
    }
}