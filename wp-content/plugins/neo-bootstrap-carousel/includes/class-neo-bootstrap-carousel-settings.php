<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Neo_Bootstrap_Carousel_Settings Class
 * 
 * This is used to define NEO Bootstrap Carousel setting.
 * 
 * @link       http://pixelspress.com
 * @since      1.0.0
 *
 * @package    Neo_Bootstrap_Carousel
 * @subpackage Neo_Bootstrap_Carousel/admin
 * @author     PixelsPress <support@pixelspress.com>
 */
class Neo_Bootstrap_Carousel_Settings
{
    
    /**
     * The css animations that's responsible for keeping the values of animations
     * the plugin.
     *
     * @since   1.1.1
     * @access  private
     * @var     Neo_Bootstrap_Carousel_Settings_Css_Animations  $css_animations keep all the animations for the plugin.
     */
    private $css_animations;
    
    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        $this->css_animations = array(
            "Attention Seekers" => array(
                "bounce" => "Bounce",
                "flash" => "Flash",
                "pulse" => "Pulse",
                "rubberBand" => "Rubber Band",
                "shake" => "Shake",
                "swing" => "Swing",
                "tada" => "Tada",
                "wobble" => "Wobble",
                "jello" => "Jello",
            ),
            "Bouncing Entrances" => array(
                "bounceIn" => "bounceIn",
                "bounceInDown" => "bounceInDown",
                "bounceInLeft" => "bounceInLeft",
                "bounceInRight" => "bounceInRight",
                "bounceInUp" => "bounceInUp"
            ),
            "Fading Entrances" => array(
                "fadeIn" => "fadeIn",
                "fadeInDown" => "fadeInDown",
                "fadeInDownBig" => "fadeInDownBig",
                "fadeInLeft" => "fadeInLeft",
                "fadeInLeftBig" => "fadeInLeftBig",
                "fadeInRight" => "fadeInRight",
                "fadeInRightBig" => "fadeInRightBig",
                "fadeInUp" => "fadeInUp",
                "fadeInUpBig" => "fadeInUpBig"
            ),
        );
        
        // Action - Add Settings Menu
        add_action( 'admin_menu', array($this, 'admin_menu'), 12 );

        // Action - Save Settings
        add_action( 'admin_notices', array($this, 'nbc_save_settings' ) );
    }

    /**
     * Add Setting Page Under NEO Bootstrap Carousel Menu.
     * 
     * @since   2.0.0
     */
    public function admin_menu()
    {
        add_submenu_page('edit.php?post_type=neo_carousel', __('Settings', 'neo-bootstrap-carousel'), __('Settings', 'neo-bootstrap-carousel'), 'manage_options', 'neo-bootstrap-carousel-settings', array($this, 'neo_bootstrap_carousel_settings'));
    }

    /**
     * Add Settings Page.
     * 
     * @Since   2.0.0
     */
    public function neo_bootstrap_carousel_settings()
    {
?>
        <div class="wrap">
            <h1><?php _e('Settings', 'neo-bootstrap-carousel'); ?></h1>
            <form id="neo_bootstrap_carousel_setting_form" action="" method="post">
                <input type="hidden" value="1" name="admin_notices">
                <table class="form-table setting-table">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="display_navigation">Display Navigation</label></th>
                            <td>
                                <select id="display_navigation" name="display_navigation">
                                    <option value="yes" <?php if( get_option('_nbc_display_navigation') == "yes" ) { echo 'selected="selected"';} ?>>Yes</option>
                                    <option value="no" <?php if( get_option('_nbc_display_navigation') == "no" ) { echo 'selected="selected"';} ?>>No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="display_direction_controls">Display Direction Arrows</label></th>
                            <td>
                                <select id="display_direction_controls" name="display_direction_controls">
                                    <option value="yes" <?php if( get_option('_nbc_display_direction_controls') == "yes" ) { echo 'selected="selected"';} ?>>Yes</option>
                                    <option value="no" <?php if( get_option('_nbc_display_direction_controls') == "no" ) { echo 'selected="selected"';} ?>>No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="display_caption">Display Caption</label></th>
                            <td>
                                <select id="display_caption" name="display_caption">
                                    <option value="yes" <?php if( get_option('_nbc_display_caption') == "yes" ) { echo 'selected="selected"';} ?>>Yes</option>
                                    <option value="no" <?php if( get_option('_nbc_display_caption') == "no" ) { echo 'selected="selected"';} ?>>No</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="caption_title_animation">Caption Title Animation</label></th>
                            <td>
                                <?php $select_title_dom = ''; ?>
                                <select id="caption_title_animation" name="caption_title_animation">
                                    <?php
                                    foreach( $this->css_animations as $animation_group => $animation_group_value ) {
                                        $select_title_dom .= '<optgroup label="'. $animation_group .'">';
                                            foreach( $animation_group_value as $animation_value => $animation_value_label ) {
                                                $selected = '';
                                                if( get_option('_nbc_caption_title_animation') == $animation_value ) {
                                                    $selected = 'selected="selected"';
                                                }
                                                $select_title_dom .= '<option value="'. $animation_value .'" '. $selected .' >'. $animation_value_label .'</option>';
                                            }
                                        $select_title_dom .= '</optgroup>';
                                    }
                                    echo $select_title_dom;
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="caption_description_animation">Caption Description Animation</label></th>
                            <td>
                                <?php $select_description_dom = ''; ?>
                                <select id="caption_description_animation" name="caption_description_animation">
                                    <?php
                                    foreach( $this->css_animations as $animation_group => $animation_group_value ) {
                                        $select_description_dom .= '<optgroup label="'. $animation_group .'">';
                                            foreach( $animation_group_value as $animation_value => $animation_value_label ) {
                                                $selected = '';
                                                if( get_option('_nbc_caption_description_animation') == $animation_value ) {
                                                    $selected = 'selected="selected"';
                                                }
                                                $select_description_dom .= '<option value="'. $animation_value .'" '. $selected .' >'. $animation_value_label .'</option>';
                                            }
                                        $select_description_dom .= '</optgroup>';
                                    }
                                    echo $select_description_dom;
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="submit"></p>
            </form>
            <div id="copyright"><a href="http://www.pixelspress.com/" target="_blank">Powered by <img src="http://1.gravatar.com/avatar/1424752acdbce820f4c1eb13c907f164?s=96&d=mm&r=g" alt="PixelsPress"></a></div>
        </div>
        <?php
    }

    /**
     * Save Settings.
     * 
     * @since   1.0.0
     */
    public function nbc_save_settings() {
        
        // Admin Notices
        if (isset($_POST['admin_notices'])) {
            
            // Save Navigation Option in WP Option
            ( !empty( $_POST['display_navigation'] ) ) ? update_option( '_nbc_display_navigation', esc_attr( $_POST['display_navigation'] ) ) : '';

            // Save Direction Control Option in WP Option
            ( !empty( $_POST['display_direction_controls'] ) ) ? update_option( '_nbc_display_direction_controls', esc_attr( $_POST['display_direction_controls'] ) ) : '';

            // Save Caption Option in WP Option
            ( !empty( $_POST['display_caption'] ) ) ? update_option( '_nbc_display_caption', esc_attr( $_POST['display_caption'] ) ) : '';
            
            // Save Caption Option in WP Option
            ( !empty( $_POST['caption_title_animation'] ) ) ? update_option( '_nbc_caption_title_animation', esc_attr( $_POST['caption_title_animation'] ) ) : '';
            
            // Save Caption Option in WP Option
            ( !empty( $_POST['caption_description_animation'] ) ) ? update_option( '_nbc_caption_description_animation', esc_attr( $_POST['caption_description_animation'] ) ) : '';
?>
        <div class="updated">
            <p><?php echo __('Settings have been saved.', 'neo-bootstrap-carousel'); ?></p>
        </div>
<?php
        }
    }
}
new Neo_Bootstrap_Carousel_Settings();