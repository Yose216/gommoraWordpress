<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Neo_Bootstrap_Carousel_Post_Type Class
 * 
 * This class is used to create custom post type for NEO Bootstrap Carousel.
 *
 * @link       http://pixelspress.com
 * @since      1.0.0
 *
 * @package    Neo_Bootstrap_Carousel
 * @subpackage Neo_Bootstrap_Carousel/includes
 * @author     PixelsPress <support@pixelspress.com>
 */

class Neo_Bootstrap_Carousel_Post_Type
{
    /**
     * Initialize the class and set it's properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        // Add Hook into the 'init()' Action
        add_action('init', array($this, 'neo_bootstrap_carousel_init'));
        
        // Add Hook into the 'init()' action
        add_action('admin_init', array($this, 'neo_bootstrap_carousel_admin_init'));
    }

    /**
     * WordPress core launches at 'init' points
     *          
     * @since   1.0.0
     */
    public function neo_bootstrap_carousel_init()
    {
        $this->create_post_type();

        // Flush Rewrite Rules 
        flush_rewrite_rules();
    }

    /**
     * Create_post_type function.
     *
     * @since   1.0.0
     */
    public function create_post_type()
    {
        if (post_type_exists("neo_carousel"))
            return;

        /**
         * Post Type -> NEO Bootstrap Carousel
         */
        $singular = __('Slider', 'neo-bootstrap-carousel');
        $plural = __('Sliders', 'neo-bootstrap-carousel');

        // Post Type -> NEO Bootstrap Carousel -> Labels
        $slider_labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'menu_name' => __('NEO Bootstrap Carousel', 'neo-bootstrap-carousel'),
            'all_items' => sprintf(__('All %s', 'neo-bootstrap-carousel'), $plural),
            'add_new' => __('Add New', 'neo-bootstrap-carousel'),
            'add_new_item' => sprintf(__('Add %s', 'neo-bootstrap-carousel'), $singular),
            'edit' => __('Edit', 'neo-bootstrap-carousel'),
            'edit_item' => sprintf(__('Edit %s', 'neo-bootstrap-carousel'), $singular),
            'new_item' => sprintf(__('New %s', 'neo-bootstrap-carousel'), $singular),
            'view' => sprintf(__('View %s', 'neo-bootstrap-carousel'), $singular),
            'view_item' => sprintf(__('View %s', 'neo-bootstrap-carousel'), $singular),
            'search_items' => sprintf(__('Search %s', 'neo-bootstrap-carousel'), $plural),
            'not_found' => sprintf(__('No %s found', 'neo-bootstrap-carousel'), $plural),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'neo-bootstrap-carousel'), $plural),
            'parent' => sprintf(__('Parent %s', 'neo-bootstrap-carousel'), $singular)
        );
        
         // Post Type -> NEO Bootstrap Carousel -> Rewrite Parameter
        $rewrite = array(
            'slug' => _x('neo-carousel', 'NEO Bootstrap Carousel permalink - resave permalinks after changing this', 'neo-bootstrap-carousel'),
            'with_front' => FALSE,
            'feeds' => FALSE,
            'pages' => FALSE,
            'hierarchical' => FALSE,
        );

        // Post Type -> NEO Bootstrap Carousel -> Arguments
        $slider_args = array(
            'labels' => $slider_labels,
            'description' => sprintf(__('This is where you can create and manage %s.', 'neo-bootstrap-carousel'), $plural),
            'public' => TRUE,
            'show_ui' => TRUE,
            'menu_icon' => 'dashicons-slides',
            'capability_type' => 'post',
            'map_meta_cap' => TRUE,
            'publicly_queryable' => TRUE,
            'exclude_from_search' => TRUE,
            'hierarchical' => FALSE,
            'rewrite' => $rewrite,
            'query_var' => TRUE,
            'can_export' => TRUE,
            'supports' => array('title'),
            'has_archive' => TRUE,
            'show_in_nav_menus' => TRUE,
        );
        
        // Register NEO Bootstrap Carousel Post Type
        register_post_type("neo_carousel", apply_filters("register_post_type_neo_carousel", $slider_args));
    }
    
    /**
     * A function hook that the WP core launches at 'admin_init' points
     * 
     * @since   1.0.0
     */
    public function neo_bootstrap_carousel_admin_init() {

        // Hook - Shortcode -> Add New Column
        add_filter('manage_neo_carousel_posts_columns', array($this, 'neo_carousel_columns'));

        // Hook - Shortcode -> Add Value to New Column
        add_action('manage_neo_carousel_posts_custom_column', array($this, 'neo_carousel_columns_value'));
    }

    /**
     * Add custom column for 'NEO Bootstrap Column' shortcode 
     *
     * @since   1.0.0
     * @param   $columns   Custom Column 
     *  
     * @return  $columns   Custom Column
     */
    public function neo_carousel_columns($columns) {
        $columns['shortcode'] = __('Shortcode', 'neo-bootstrap-carousel');
        return $columns;
    }

    /**
     * Add custom column's value
     *
     * @since   1.0.0
     * @param   $name   custom column's name
     *  
     * @return  void
     */
    public function neo_carousel_columns_value($name) {
        global $post;
        switch ($name) {
            case 'shortcode':
                echo ' <b> [neo_carousel_shortcode id="' . $post->ID . '"] </b>';
                break;
        }
    }
}
new Neo_Bootstrap_Carousel_Post_Type();