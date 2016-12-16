<?php if (!defined('ABSPATH')) { exit; } // Exit if accessed directly
/**
 * Neo_Bootstrap_Carousel_Meta_Box Class
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * 
 * @link       http://pixelspress.com
 * @since      1.0.0
 *
 * @package    Neo_Bootstrap_Carousel
 * @subpackage Neo_Bootstrap_Carousel/includes
 * @author     PixelsPress <support@pixelspress.com>
 */

class Neo_Bootstrap_Carousel_Meta_Box {
    
    /**
     * The ID of this plugin.
     *
     * @since   1.0.0
     * @access  protected
     * @var     array   $neo_carousel_postmeta
     */
    protected $neo_carousel_postmeta;

    /**
     * Initialize the class and set it's properties.
     *
     * @since   1.0.0
     */
    public function __construct()
    {
        // Creating Meta Box on Add New NEO Bootstrap Carousel Page
        $this->neo_carousel_postmeta = array(
            'id' => 'neo_bootstrap_carousel_metabox_section',
            'title' => __('Slides', 'neo-bootstrap-carousel'),
            'context' => 'normal',
            'screen' => 'neo_carousel',
            'priority' => 'high',
            'context' => 'normal',
            'callback' => 'neo_carousel_output',
            'show_names' => TRUE,
            'closed' => FALSE,
        );
        
        // Add Hook into the 'admin_menu' Action
        add_action('add_meta_boxes', array($this, 'nbc_create_meta_box'));

        // Add Hook into the 'save_post()' Action
        add_action('save_post_neo_carousel', array($this, 'nbc_save_meta_box'));
    }
    
    /**
     * Getter of neo_carousel meta box.
     *
     * @since   1.0.0
     */
    public function get_nbc_postmeta() {
        return $this->neo_carousel_postmeta;
    }
    
    /**
     * Create Meta Box
     *
     * @since   1.0.0 
     */
    public function nbc_create_meta_box() {
        $neo_carousel_postmeta = self::get_nbc_postmeta();
        add_meta_box($neo_carousel_postmeta['id'], $neo_carousel_postmeta['title'], array($this, $neo_carousel_postmeta['callback']), $neo_carousel_postmeta['screen'], $neo_carousel_postmeta['context'], $neo_carousel_postmeta['priority']);
    }
    
    /**
     * Meta Box Output
     *
     * @since   1.0.0 
     * 
     * @param   object  $post   Post Object
     */
    public static function neo_carousel_output($post)
    {
        // Add a nonce field so we can check it for later.
        wp_nonce_field('nbc_meta_box_field', 'nbc_carousel_meta_box_nonce');
        ?>
        <!-- Slider's slides -->
        <div id="nbc-slider-container">
            <ul class="nbc-slides">
                <?php
                if (metadata_exists('post', $post->ID, '_neo_bootstrap_carousel')) {
                    $nbc_slides = get_post_meta($post->ID, '_neo_bootstrap_carousel', TRUE);
                } else {
                    $attachment_ids = get_posts(
                            'post_parent=' . $post->ID . '&'
                            .'numberposts=-1&'
                            .'post_type=attachment&'
                            .'orderby=menu_order&'
                            .'order=ASC&'
                            .'post_mime_type=image&'
                            .'fields=ids&'
                    );
                    $attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
                    $nbc_slides = implode(',', $attachment_ids);
                }

                $attachments = array_filter(explode(',', $nbc_slides));
                $update_meta = FALSE;
                $updated_gallery_ids = array();

                if (!empty($attachments)) {
                    foreach ($attachments as $attachment_id) {
                        $attachment = wp_get_attachment_image($attachment_id, 'thumbnail' );
                        $attachment_meta = get_post( $attachment_id ); // Get post by ID

                        // Skip Empty Attachment
                        if (empty($attachment)) {
                            $update_meta = TRUE;
                            continue;
                        }
                        $row = ''; 
                        $row .= '<li class="slide" data-attachment_id="' . esc_attr($attachment_id) . '">';
                            $row .= '<table>';
                                $row .= '<tbody>';
                                    $row .= '<tr>';
                                        $row .= '<td>'.$attachment.'</td>';
                                        $row .= '<td>';
                                            $row .= '<table>';
                                                $row .= '<tr>';
                                                    $row .= '
                                                    <td><label for="slide_title_' . esc_attr($attachment_id) . '">Title</label></td>
                                                    <td><input type="text" name="slide_title_' . esc_attr($attachment_id) . '" id="slide_title_' . esc_attr($attachment_id) . '" value="' . $attachment_meta->post_title . '" class="form-control"></td>
                                                    ';
                                                $row .= '</tr>';
                                                $row .= '<tr>';
                                                    $row .= '
                                                    <td style="vertical-align: top;"><label for="slide_description_' . esc_attr($attachment_id) . '">Description</label></td>
                                                    <td><textarea name="slide_description_' . esc_attr($attachment_id) . '" id="slide_description_' . esc_attr($attachment_id) . '" class="form-control" rows="3">' . $attachment_meta->post_excerpt . '</textarea></td>
                                                    ';
                                                $row .= '</tr>';
                                            $row .= '</table>';
                                        $row .= '</td>';
                                    $row .= '</tr>';    
                                $row .= '</tbody>';
                            $row .= '</table>';
                            $row .= '<a href="#." class="delete" data-tip="' . esc_attr__('Delete Slide', 'neo-bootstrap-carousel') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                        $row .= '</li>';
                        echo $row;
                        
                        // Rebuild IDs to be Saved
                        $updated_gallery_ids[] = $attachment_id;
                    }

                    // Update NEO Bootstrap Carousel Meta to Set New Slide's IDs
                    if ($update_meta) {
                        update_post_meta($post->ID, '_neo_bootstrap_carousel', implode(',', $updated_gallery_ids));
                    }
                }
                ?>
            </ul>
            <input type="hidden" id="nbc_slides" name="nbc_slides" value="<?php echo esc_attr($nbc_slides); ?>" />
        </div>
        <p class="add-slide hide-if-no-js">
            <a href="#." data-choose="<?php esc_attr_e('Add Slide to Slider', 'neo-bootstrap-carousel'); ?>" data-update="<?php esc_attr_e('Add to Slider', 'neo-bootstrap-carousel'); ?>" data-delete="<?php esc_attr_e('Delete Slide', 'neo-bootstrap-carousel'); ?>" data-text="<?php esc_attr_e('Delete', 'neo-bootstrap-carousel'); ?>"><?php _e('Add Slide to Slider', 'neo-bootstrap-carousel'); ?></a>
        </p>
        <?php
    }
    
    /**
     * Save Meta Box.
     *
     * @since   1.0.0
     */
    public static function nbc_save_meta_box() {
        global $post;

        // Check Nonce Field
        if (!isset($_POST['nbc_carousel_meta_box_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['nbc_carousel_meta_box_nonce'], 'nbc_meta_box_field')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }
        
        // Get Attachment's/Slide's IDs
        $attachment_ids = isset($_POST['nbc_slides']) ? array_filter(explode(',', $_POST['nbc_slides'])) : array();
        
        foreach ($attachment_ids as $id) {
            $carousel_post = array(
                'ID'           => $id,
                'post_title'   => $_POST["slide_title_".$id],
                'post_excerpt' => $_POST["slide_description_".$id],
            );
            // Update the post into the database
            wp_update_post( $carousel_post );
        }
        update_post_meta($post->ID, '_neo_bootstrap_carousel', implode(',', $attachment_ids));
    }
}
new Neo_Bootstrap_Carousel_Meta_Box();