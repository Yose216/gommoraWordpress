/* 
 *  Slider's Slides Uploading Via Media Frame
 *  v1.0.0
 */

(function ($) {
    'use strict';

    $(document).ready(function () {

        // NEO Bootstrap Carousel
        var neo_carousel_frame;
        var $nbc_slider_container = $('#nbc-slider-container');
        var $slides_id = $('#nbc_slides');
        var $nbc_slides = $nbc_slider_container.find('ul.nbc-slides');

        $('.add-slide').on('click', 'a', function (event) {
            var $el = $(this);

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if (neo_carousel_frame) {
                neo_carousel_frame.open();
                return;
            }

            // Create Media Frames
            neo_carousel_frame = wp.media.frames.neo_carousel_frame = wp.media({
                // Set the title of the modal.
                title: $el.data('choose'),
                button: {
                    text: $el.data('update')
                },
                states: [
                    new wp.media.controller.Library({
                        title: $el.data('choose'),
                        filterable: 'all',
                        multiple: true
                    })
                ]
            });

            // When a slide is selected, run a callback.
            neo_carousel_frame.on('select', function () {
                var selection = neo_carousel_frame.state().get('selection');
                var attachment_ids = $slides_id.val();
                console.log(selection);
                
                selection.map(function (attachment) {
                    attachment = attachment.toJSON();
                    console.log(attachment);
                    if (attachment.id) {
                        attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                        var attachment_slide = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                        var $html_content;
$html_content = '<li class="slide" data-attachment_id="' + attachment.id + '">';
    $html_content += '<table>';
        $html_content += '<tbody>';
            $html_content += '<tr>';
                $html_content += '<td><img src="' + attachment_slide + '" /></td>';
                $html_content += '<td>';
                    $html_content += '<table>';
                        $html_content += '<tr>';
                            $html_content += '<td><label for="slide_title_' + attachment.id + '">Title</label></td>';
                            $html_content += '<td><input type="text" name="slide_title" id="slide_title_' + attachment.id + '" value="'+ attachment.title +'" class="form-control"></td>';
                        $html_content += '</tr>';
                        $html_content += '<tr>';
                            $html_content += '<td style="vertical-align: top;"><label for="slide_description_' + attachment.id + '">Description</label></td>';
                            $html_content += '<td><textarea name="slide_description" id="slide_description_' + attachment.id + '" class="form-control" rows="3">'+ attachment.caption +'</textarea></td>';
                        $html_content += '</tr>';
                    $html_content += '</table>';
                $html_content += '</td>';
            $html_content += '</tr>';
        $html_content += '</tbody>';
    $html_content += '</table>';
    $html_content += '<a href="#" class="delete" title="' + $el.data('delete') + '"><i class="fa fa-times" aria-hidden="true"></i></a></li>';
$html_content += '</li>';
                        $nbc_slides.append($html_content);
                        
                    }
                });

                $slides_id.val(attachment_ids);
            });

            // Finally, open the modal.
            neo_carousel_frame.open();
        });
        
        // Image Ordering
        $nbc_slides.sortable({
            items: 'li.slide',
            cursor: 'move',
            scrollSensitivity: 40,
            forcePlaceholderSize: true,
            forceHelperSize: false,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'soc-metabox-sortable-placeholder',
            start: function (event, ui) {
                ui.item.css('background-color', '#f6f6f6');
            },
            stop: function (event, ui) {
                ui.item.removeAttr('style');
            },
            update: function () {
                var attachment_ids = '';

                $nbc_slider_container.find( 'li.slide' ).css('cursor', 'default').each(function () {
                    var attachment_id = jQuery(this).attr('data-attachment_id');
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $slides_id.val(attachment_ids);
            }
        });

        // Remove Slides
        $nbc_slider_container.on('click', 'a.delete', function () {
            $(this).closest( 'li.slide' ).remove();

            var attachment_ids = '';

            $nbc_slider_container.find( 'li.slide' ).css('cursor', 'default').each(function () {
                var attachment_id = jQuery(this).attr('data-attachment_id');
                attachment_ids = attachment_ids + attachment_id + ',';
            });

            $slides_id.val(attachment_ids);

            return false;
        });
    });
})(jQuery);