/*
jQuery functions for the Admin area
*/
jQuery(document).ready(function($) {

    /* System Status */

    /* Email address validation */

    function isValidEmailAddress( emailAddress ) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    }

    /* Validation border color */

    function validateInput( elem, result ) {

        if( result == 'valid' ) {
            elem.css( 'border-color', '#ddd' );
        } else {
            elem.css( 'border-color', 'red' );
        }
    }

    /* Send Report */

    var cf7s_status_name   = $( '.cf7style-name' ),
        cf7s_status_email  = $( '.cf7style-email' ),
        cf7s_status_message = $( '.cf7style-message' ),
        cf7s_status_submit = $( '.cf7style-status-submit' );

    cf7s_status_submit.on( 'click', function( e ) {
        e.preventDefault();

        $( '.cf7style-input' ).each( function( index, value ) {
            if( $( this ).val() == '' ) {
                validateInput( $( this ), 'error' );
            } else {
                validateInput( $( this ), 'valid' );
            }
        } );

        if( cf7s_status_name.val() !== '' && cf7s_status_email.val() !== '' ) {
            if( ! isValidEmailAddress( cf7s_status_email.val() ) ) {
                console.log( 'error 2' );
                validateInput( cf7s_status_email, 'error' );
            } else {
                validateInput( cf7s_status_email, 'valid' );

                var status = $( '<div />' );

                $( '.cf7style-status-table' ).each( function( index, value ) {
                    var table = $( "<table />" );
                    table.html( $( this ).html() );
                    status.append( table );
                } );

                $.ajax( {
                    'url': ajaxurl,
                    'method': 'POST',
                    'data': {
                        'action': 'cf7_style_send_status_report',
                        'name': cf7s_status_name.val(),
                        'email': cf7s_status_email.val(),
                        'message': cf7s_status_message.val(),
                        'report': status.html()
                    },
                    'beforeSend': function() {
                        cf7s_status_submit.text( 'Sending...' );
                    },
                    'success': function( data ) {
                        if ( $.trim( data ) == 'success' ) {
                            cf7s_status_submit.text( 'Report sent' ).removeClass( 'cf7style-status-submit' ).attr( 'disabled', 'disabled' );
                        } else {
                            cf7s_status_submit.text( 'Something went wrong!' ).removeClass( 'cf7style-status-submit' ).attr( 'disabled', 'disabled' );
                        }
                    }
                } );
            }
  
        } else {
            console.log( 'error 1' );
        }
    } );

    /* Show info */

    $( '.cf7style-status-info' ).on( 'click', function( e ) {
        e.preventDefault();

        $( '.cf7style-status-table' ).toggle();

    } );





    String.prototype.filename = function(extension) {
        var s = this.replace(/\\/g, '/');
        s = s.substring(s.lastIndexOf('/') + 1);
        return extension ? s.replace(/[?#].+$/, '') : s.split('.')[0];
    }

    function changeFont(value) {
        $(".google-fontos").remove();
        if ("none" != value && "undefined" != typeof value) {
            $("head").append('<link class="google-fontos" rel="stylesheet" href="https://fonts.googleapis.com/css?family=' + value + ':100,200,300,400,500,600,700,800,900&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese" />');
            $(".cf7-style.preview-zone p").css("font-family", "'" + value + "', sans-serif");
            $('.preview-form-container .wpcf7').css("font-family", "'" + value + "', sans-serif");
        }
    }

    function scrolling(element) {
        $(window).scroll(function() {
            if ($(window).width() > 1600) {
                var offset = element.find('.panel-header').offset(),
                    cf7styleOffset = $('#cf7_style_meta_box_style_customizer').offset(),
                    diff = $(window).scrollTop() - cf7styleOffset.top;
                if (diff > 0) {
                    element.find('.panel-header').css('top', diff);
                }
                if (diff <= 0) {
                    element.find('.panel-header').css('top', 0);
                }
            }
            if ($(window).scrollTop() > 700) {
                $('.fixed-save-style').show();
            } else {
                $('.fixed-save-style').hide();
            }

        }).trigger('scroll');
    }

    function autoCompleteOtherValues() {
        $("input[type='number']").on("change", function() {
            var value = $(this).val(),
                indexor = $(this).index(),
                allInput = $(this).parent().find("input[type=number]");
            switch (indexor) {
                case 2:
                    allInput.val(value);
                    break;
                case 5:
                    allInput.eq(3).val(value);
                    break;
            }
        });
    }

    function getPreviewElements(previewType) {
        var notElem = (previewType == "hover") ? "" : ",[name*='hover']";
        $('[name^=cf7stylecustom]').not("[name*='unit']" + notElem).each(function() {
            var _t = $(this);
            if (_t.attr('value').length > 0) {
                var elem_name = _t.attr('name'),
                    splitArray = elem_name.substr(15).replace("]", "").split("_"),
                    newElem = splitArray[0],
                    unit = _t.parent().find('select[name*="unit"]').val();
                if (splitArray[0] == "submit") {
                    newElem = "input[type='submit']";
                }
                if (splitArray[0] == "form") {
                    newElem = ".wpcf7";
                }

                unit = (typeof unit == 'undefined' || _t.val() == "") ? "" : unit;
                var newValue = _t.val() + unit;
                if (_t.hasClass('cf7-style-upload-field')) {
                    newValue = 'url(' + _t.val() + ')';
                    if (_t.val() == "") {
                        newValue = _t.val();
                    }
                }
                newElem = (newElem == 'radio') ? 'input[type="radio"]' : (newElem == 'checkbox') ? 'input[type="checkbox"]' : newElem;
                $('.preview-form-container ' + newElem).css(splitArray[1], newValue);
            }
        });
    }

    function selectAllForms(element) {
        element.on("click", function() {
            $(".cf7style_body_select_all input").prop('checked', ($(this).is(":checked")) ? true : false);
        });
    }

    function cf7_slider(elem, slideWidth, animationSpeed, showArrows) {

        var active = elem.find('.active'),
            index = active.index() + 1,
            slide = elem.find('li'),
            sliderViewport = elem.find('ul'),
            arrow = elem.find('.narrow'),
            arrowLeft = elem.find('.narrow.left'),
            arrowRight = elem.find('.narrow.right'),
            totalSlides = elem.find('li').length;

        arrowRight.addClass('visible');
        sliderViewport.css('width', totalSlides * slideWidth);

        if (showArrows == false) {
            elem.mouseenter(function() {
                elem.find('.visible').stop().show();
            }).mouseleave(function() {
                elem.find('.visible').stop().hide();
            });
        }

        arrow.on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var direction = $(this).attr('data-direction');

            if (direction == "left" && index !== 1) {
                sliderViewport.stop(true, true).animate({
                    marginLeft: "+=" + (slideWidth) + "px"
                }, animationSpeed);

                index--;
            }

            if (direction == "right" && index !== totalSlides) {
                sliderViewport.stop(true, true).animate({
                    marginLeft: -(slideWidth * index) + "px"
                }, animationSpeed);

                index++;
            }

            if (index == 1) {
                arrowLeft.hide().removeClass('visible');
                arrowRight.show().addClass('visible');
            }

            if (index == totalSlides) {
                arrowRight.hide().removeClass('visible');
            }

            if (index < totalSlides) {
                arrowRight.show().addClass('visible');
            }

            if (index > 1) {
                arrowLeft.show().addClass('visible');
            }

            slide.removeClass('active').eq(index - 1).addClass('active');
        });
        sliderViewport.css({
            'margin-left': '-' + (index - 1) * slideWidth + 'px'
        });
    }

    function sliderInit(element) {
        cf7_slider(element, 202, 500, true);
        element.find('li').on('click', function() {
            if (!$(this).hasClass('current-saved')) {
                element.find('li').removeClass('current-saved');
                $(this).addClass('current-saved');
                element.find('.overlay em').html('Not Active');
                $(this).find('.overlay em').html('Active');
                $('.cf7style_template').removeAttr('checked');
                $(this).find('.cf7style_template').attr("checked", "checked");
            }
        });
    }

    function showTheOption() {
        $('#form-tag a.button').on('click', function(e) {
            e.preventDefault();
            var _t = $(this);
            var currentElement = $('.' + _t.attr('data-property') + '-panel');
            if (!_t.hasClass('button-primary')) {
                $('.panel').stop(true, true).animate({
                    'opacity': 0
                }, 300, function() {
                    $('.panel').addClass('hidden');
                    currentElement.css('opacity', '0');
                    currentElement.removeClass('hidden');
                    currentElement.stop(true, true).animate({
                        'opacity': 1
                    }, 300);
                });

                $(".element-selector input:eq(0)").prop("checked", true);
            }
            $('#form-tag a.button').removeClass('button-primary');
            _t.addClass('button-primary');
            $('input[name="cf7styleactivepane"]').val(_t.attr('data-property'));
        });

        $('.element-selector input').on('change', function() {
            $('.element-selector input').prop('checked', false);
            $(this).prop('checked', true);
            if ($(this).val() == "hover") {
                $('.panel:visible li').addClass('hidden');
                $('.panel:visible li.hover-element').removeClass('hidden');
                getPreviewElements("hover");
            } else {
                $('.panel:visible li.hover-element').addClass('hidden');
                $('.panel:visible li').not('.hover-element').removeClass('hidden');
                getPreviewElements();
            }
        });
        $('#form-preview').on('change', function() {
            $('.preview-form-container').addClass('hidden');
            $('.preview-form-container').eq($(this).val()).removeClass('hidden');
        });
        $('[name^="cf7stylecustom"]').on("change", function() {
            if ($('input[name="element-type"]:checked').val() == "hover") {
                getPreviewElements('hover');
            } else {
                getPreviewElements();
            }
        });
        $('[name^="cf7stylecustom"]').on("keyup", function() {
            if ($('input[name="element-type"]:checked').val() == "hover") {
                getPreviewElements('hover');
            } else {
                getPreviewElements();
            }
        });
    }

    function removePreviewfields(element) {
        element.remove();
    }

    function disableSubmit(element) {
        element.on('click', function(e) {
            e.preventDefault();
        });
    }

    function addBgImage() {
        var bgFormInput = $('.cf7-style-upload-field');
        bgFormInput.addClass('hidden');
        bgFormInput.each(function() {
            var _t = $(this);
            $('<span class="image-info-box"></span>').insertAfter(_t);
            if (_t.val() != "") {
                _t.parent().find('.image-info-box').text(_t.val().filename('yes'));
            }
        });
        if ($('.upload-btn').length <= 0) {
            $("<a href='javascript: void(0);' class='remove-btn button'>Remove</a>").insertAfter(bgFormInput);
            $("<a href='javascript: void(0);' class='upload-btn button'>Upload</a>").insertAfter(bgFormInput);
        }
        $('.upload-btn').on('click', function() {
            var _t = $(this),
                currentimage = _t.parent().find('.cf7-style-upload-field');
            tb_show('New Banner', 'media-upload.php?type=image&TB_iframe=1');
            window.send_to_editor = function(html) {
                currentimage.val($(html).attr('src'));
                currentimage.trigger('change');
                _t.parent().find('.image-info-box').text($(html).attr('src').filename('yes'));
                tb_remove();
            }
        });
        $('.remove-btn').on('click', function() {
            var _t = $(this),
                currentimage = _t.parent().find('.cf7-style-upload-field');
            currentimage.val(' ');
            currentimage.attr('value', ' ');
            currentimage.trigger('change');
            _t.parent().find('.image-info-box').text('');
        });
    }

    function codeMirrorInit() {
        if ($("#cf7_style_manual_style").length > 0) {
            var editor = CodeMirror.fromTextArea(document.getElementById("cf7_style_manual_style"), {
                lineNumbers: true,
                theme: "default",
                mode: "text/css"
            });
        }
    }
    if ($('.cf7style-no-forms-added').length > 0) {
        $('.generate-preview-button, .generate-preview-option').show();
    } else {
        $('.generate-button-hidden').show();
    }

    $('.generate-preview-button').on('click', function(e) {
        e.preventDefault();

        $('.cf7style-no-forms-added').hide();

        var form_id = $(this).attr('data-attr-id'),
            form_title = $(this).attr('data-attr-title');
        $(this).prop('disabled', true);
        $(this).parents('tr').find('input').prop('checked', true);

        var paragraph = $("<p />");
        $('.preview-form-tag').prepend(paragraph);

        $.ajax({
            'url': ajaxurl,
            'method': 'POST',
            'data': {
                'action': 'cf7_style_generate_preview_dashboard',
                'form_id': form_id,
                'form_title': form_title
            },
            'beforeSend': function() {
                paragraph.text("Loading...");
                $('.multiple-form-generated-preview').hide();
            },
            'success': function(data) {
                if (data) {
                    paragraph.remove();
                    $('.preview-form-tag').append(data);
                    $('.multiple-form-generated-preview').eq($('.multiple-form-generated-preview').length - 1).show();
                    getPreviewElements();
                }
            }
        });
    });

    var previewEl = $(".generate-preview"),
        cf7StylePostType = $(".post-type-cf7_style "),
        selectAll = $('#select_all'),
        fontSelectVar = $('select[name="cf7_style_font_selector"]'),
        sliderWrapper = $('.cf7-style-slider-wrap'),
        previewForm = $('.preview-form-container'),
        options = {
            change: function(event, ui) {
                if ($('input[name="element-type"]:checked').val() == "hover") {
                    getPreviewElements('hover');
                } else {
                    getPreviewElements();
                }
            }
        };

    $('.cf7-style-color-field').wpColorPicker(options);
    /*Scrolling  on settings*/
    if (previewEl.length > 0) {
        scrolling(previewEl);
    }

    if (cf7StylePostType.length > 0) {
        /*codemirror*/
        codeMirrorInit();
        /*backgroundimage*/
        addBgImage();
        /*Autocomplete number fields*/
        autoCompleteOtherValues();
        /*Checkbox for select all the forms*/
        selectAllForms(selectAll);
        /*Change Font*/
        changeFont(fontSelectVar.val());
        fontSelectVar.on("change", function() {
            changeFont($(this).val());
        });
        /*show the right options*/
        showTheOption();
        /*preview changes on the fly*/
        getPreviewElements();
        /*remove nonce*/
        removePreviewfields(previewForm.find('input[type="hidden"]'));
        /*disable submit*/
        disableSubmit(previewForm.find('input[type="submit"]'));
    }
    if (sliderWrapper.length > 0) {
        sliderInit(sliderWrapper);
    }
    $('.close-cf7-panel').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            'url': ajaxurl,
            'method': 'POST',
            'data': {
                'action': 'cf7_style_remove_welcome_box'
            },
            'success': function(data) {
                $('.welcome-container').fadeOut('slow');
            }
        });
    });
}); /*doc.ready end*/
