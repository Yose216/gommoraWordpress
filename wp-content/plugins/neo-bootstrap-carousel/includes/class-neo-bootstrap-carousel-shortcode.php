<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Neo_Bootstrap_Carousel_Shortcode Class
 *
 * This file contains shortcode of 'neo_carousel' post type. 
 * 
 * @link       http://pixelspress.com
 * @since      1.0.0
 *
 * @package    Neo_Bootstrap_Carousel
 * @subpackage Neo_Bootstrap_Carousel/includes
 * @author     PixelsPress <support@pixelspress.com>
 */

class Neo_Bootstrap_Carousel_Shortcode {

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
     * Initialize the class and set it's properties.
     *
     * @since    1.0.0
     * @param    string    $plugin_name     The name of the plugin.
     * @param    string    $version         The version of this plugin.
     */
    public function __construct() {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // Hook-> 'neo_carousel_shortcode' Shortcode
        add_shortcode('neo_carousel_shortcode', array($this, 'neo_carousel'));

        // Hook-> 'edit_form_after_title' Shortcode
        add_action('edit_form_after_title', array($this, 'neo_carousel_helper'));
        
        add_filter( 'the_content', array($this, 'neo_carousel_shortcode_empty_paragraph_fix'));
    }

    public function neo_carousel($atts, $content) {

        // Shortcode Default Array
        $shortcode_args = array(
            'id' => '',
            'interval' => 5000,
            'pause' => 'hover',
            'wrap' => 'true'
        );

        // Extract User Defined Shortcode Attributes
        $shortcode_args = shortcode_atts($shortcode_args, $atts);

        // Get Slider's Slides
        $image_files = get_post_meta(intval($shortcode_args['id']), '_neo_bootstrap_carousel', TRUE);
        $image_files = array_filter(explode(',', $image_files));
        $attachment_title = get_the_title(intval($shortcode_args['id']));
        ?>
        <!-- NEO Bootstrap Carousel -->
        <?php
        $image_html = '<div id="neo-bootstrap-carousel-'.$shortcode_args['id'].'" class="carousel slide">';
            
            // Indicators
            if(get_option('_nbc_display_navigation') == "yes")
            {
                $i = 0;
                $first_active = 'active';
                $image_html .= '<ol class="carousel-indicators" role="listbox">';
                foreach ($image_files as $file) {
                    $image_html .= '<li data-target="#neo-bootstrap-carousel-'.$shortcode_args['id'].'" data-slide-to="'.$i.'"  class="'.$first_active.'"></li>';
                    $first_active = '';
                    $i++;
                }
                $image_html .= '</ol>';
            }
            
            $i = 1;
            $image_html .= '<div class="carousel-inner" role="listbox">';
            $first_active = 'active';
            foreach ($image_files as $file) {
                $attachment_url = wp_get_attachment_url($file, 'thumbnail');
                $attachment_meta = get_post( $file ); // Get post by ID
                $image_html .= '
                    <div class="item '.$first_active.'">
                        <img src="' . $attachment_url . '" alt="' . $attachment_title . '">
                ';
                if(get_option('_nbc_display_caption') == "yes")
                {
                    $image_html .= '<div class="carousel-caption">
                            <h3 data-animation="animated '.  get_option('_nbc_caption_title_animation').'" data-delay="1000" data-dur="1000">'.$attachment_meta->post_title.'</h3>
                            <p data-animation="animated '.  get_option('_nbc_caption_description_animation').'" data-delay="2000" data-dur="1000">'.$attachment_meta->post_excerpt.'</p>
                        </div>
                    </div>';
                }
                $first_active = '';
                $i++;
            }
            $image_html .= '</div>';
            
            if(get_option('_nbc_display_direction_controls') == "yes")
            {
                // Left and right controls
                $image_html .= '<a class="left carousel-control" href="#neo-bootstrap-carousel-'.$shortcode_args['id'].'" role="button">';
                    $image_html .= '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
                    $image_html .= '<span class="sr-only">Previous</span>';
                $image_html .= '</a>';

                $image_html .= '<a class="right carousel-control" href="#neo-bootstrap-carousel-'.$shortcode_args['id'].'" role="button">';
                    $image_html .= '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
                    $image_html .= '<span class="sr-only">Next</span>';
                $image_html .= '</a>';
            }
        $image_html .= '</div>';
        
        ob_start(); ?>
        <!-- Script Adding Settings/Attributes of Shortcode -->
        <script type="text/javascript">
            (function ($) {
                'use strict';
                
                //Function to animate slider captions 
                function doAnimations(elems) {
                    //Cache the animationend event in a variable
                    var animEndEv = 'webkitAnimationEnd animationend';
		
                    elems.each(function () {
			var $this = $(this),
                            $animationType = $this.data('animation');
                        
                        // requires you add [data-delay] & [data-dur] in markup. values are in ms
                        var $animDur = parseInt($this.data('dur'));
                        var $animDelay = parseInt($this.data('delay'));
        
			$this.css({"animation-duration": $animDur + "ms", "animation-delay": $animDelay + "ms", "animation-fill-mode": "both"}).addClass($animationType).one(animEndEv, function () {
                            $this.removeClass($animationType);
			});
                    });
                
                    
                }
                
                $(document).ready(function ($) {
                    var $myCarousel = $('#neo-bootstrap-carousel-<?php echo $shortcode_args['id']; ?>'),
                        $firstAnimatingElems = $myCarousel.find('.item:first').find("[data-animation ^= 'animated']");
                    
                    // Activate Carousel
                    $myCarousel.carousel({
                        interval: <?php echo $shortcode_args['interval']; ?>,
                        pause: "<?php echo $shortcode_args['pause']; ?>",
                        wrap: <?php echo $shortcode_args['wrap']; ?>,
                        keyboard: true
                    });
                    
                    //Animate captions in first slide on page load 
                    doAnimations($firstAnimatingElems);
                    
                    //Pause carousel  
                    $myCarousel.carousel('pause');
                    
                    //Other slides to be animated on carousel slide event 
                    $myCarousel.on('slide.bs.carousel', function (e) {
                        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
                        doAnimations($animatingElems);
                    });
    
                    // Enable Carousel Controls
                    $(".left").click(function (e) {
                        $myCarousel.carousel("prev");
                        e.preventDefault();
                    });
                    $(".right").click(function (e) {
                        $myCarousel.carousel("next");
                        e.preventDefault();
                    });
                });
            })(jQuery);
        </script>
        <?php
        $image_html = ob_get_clean() . $image_html;
        
        return $image_html;
    }

    /**
     * SOC Helper Function
     * 
     * @since   1.0.0
     * 
     * @global  object  $post   Post Object
     * @return  void
     */
    function neo_carousel_helper() {

        global $post;
        if ($post->post_type != 'neo_carousel')
            return;
        echo '<p>' . __('Paste this shortcode into a post or a page: ', 'neo-bootstrap-carousel');
            echo ' <b> [neo_carousel_shortcode id="' . $post->ID . '"] </b>';
        echo '</p>';
    }
    
    /**
     * Filters the content to remove any extra paragraph or break tags
     * caused by shortcodes.
     *
     * @since 1.0.0
     *
     * @param string $content  String of HTML content.
     * @return string $content Amended string of HTML content.
     */
    function neo_carousel_shortcode_empty_paragraph_fix( $content ) {

       $array = array(
           '<p>['    => '[',
           ']</p>'   => ']',
           ']<br />' => ']'
       );
       return strtr( $content, $array );

    }
}
new Neo_Bootstrap_Carousel_Shortcode();