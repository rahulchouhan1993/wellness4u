jQuery(document).ready(function($){
    /* Move Fornt page widgets to frontpage panel */
	wp.customize.section( 'sidebar-widgets-course' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-course' ).priority( '20' );
    wp.customize.section( 'sidebar-widgets-about' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-about' ).priority( '30' );
    wp.customize.section( 'sidebar-widgets-promo' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-promo' ).priority( '40' );
    wp.customize.section( 'sidebar-widgets-testimonial' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-testimonial' ).priority( '90' );
    wp.customize.section( 'sidebar-widgets-cta-wide' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-cta-wide' ).priority( '100' );
    wp.customize.section( 'sidebar-widgets-client' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-client' ).priority( '110' );
    wp.customize.section( 'sidebar-widgets-cta' ).panel( 'frontpage_settings' );
    wp.customize.section( 'sidebar-widgets-cta' ).priority( '120' );

    //Scroll to front page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        BlossomStudioscrollToSection( section_id );
    }); 

    $( 'input[name=blossom-studio-flush-local-fonts-button]' ).on( 'click', function( e ) {
        var data = {
            wp_customize: 'on',
            action: 'blossom_studio_flush_fonts_folder',
            nonce: blossom_studio_cdata.flushFonts
        };  
        $( 'input[name=blossom-studio-flush-local-fonts-button]' ).attr('disabled', 'disabled');

        $.post( ajaxurl, data, function ( response ) {
            if ( response && response.success ) {
                $( 'input[name=blossom-studio-flush-local-fonts-button]' ).val( 'Successfully Flushed' );
            } else {
                $( 'input[name=blossom-studio-flush-local-fonts-button]' ).val( 'Failed, Reload Page and Try Again' );
            }
        });
    });
 
    
    /* Home page preview url */
    wp.customize.panel( 'frontpage_settings', function( section ){
        section.expanded.bind( function( isExpanded ) {
            if( isExpanded ){
                wp.customize.previewer.previewUrl.set( blossom_studio_cdata.home );
            }
        });
    });

    $('#sub-accordion-section-header_settings').on( 'click', '.header_settings_text', function(e){
        e.preventDefault();
        wp.customize.control( 'header_layout' ).focus();        
    });

    $('#sub-accordion-section-header_layout_settings').on( 'click', '.header_layouts_text', function(e){
        e.preventDefault();
        wp.customize.control( 'ed_header_search' ).focus();        
    });
});

function BlossomStudioscrollToSection( section_id ){
    var preview_section_id = "banner_section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {
        
        case 'accordion-section-sidebar-widgets-course':
        preview_section_id = "course_section";
        break;

        case 'accordion-section-sidebar-widgets-about':
        preview_section_id = "about_section";
        break;

        case 'accordion-section-sidebar-widgets-promo':
        preview_section_id = "promo_section";
        break;
        
        case 'accordion-section-sidebar-widgets-cta':
        preview_section_id = "cta_section";
        break;
        
        case 'accordion-section-sidebar-widgets-testimonial':
        preview_section_id = "testimonial_section";
        break;

        case 'accordion-section-sidebar-widgets-cta-wide':
        preview_section_id = "cta_wide_section";
        break;

        case 'accordion-section-sidebar-widgets-client':
        preview_section_id = "client_section";
        break;
        
        case 'accordion-section-blog_section':
        preview_section_id = "blog_section";
        break;

        case 'accordion-section-shop_section':
        preview_section_id = "shop_section";
        break;
        
        case 'accordion-section-front_sort':
        preview_section_id = "banner_section";
        break;
    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
}

( function( api ) {

    // Extends our custom "example-1" section.
    api.sectionConstructor['blossom-studio-pro-section'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );