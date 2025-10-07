<?php
/**
 * Blossom Studio Customizer Partials
 *
 * @package Blossom_Studio
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blossom_studio_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blossom_studio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'blossom_studio_get_banner_title' ) ) :
/**
 * Banner Title
*/
function blossom_studio_get_banner_title(){
    return esc_html( get_theme_mod( 'banner_title', __( 'Step into your wild beautiful life...', 'blossom-studio' ) ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_banner_sub_title' ) ) :
/**
 * Banner Subtitle
*/
function blossom_studio_get_banner_sub_title(){
    return esc_html( get_theme_mod( 'banner_subtitle', __( 'Breath, Relax and be still.', 'blossom-studio' ) ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_banner_content' ) ) :
/**
 * Banner Content
*/
function blossom_studio_get_banner_content(){
    return esc_html( get_theme_mod( 'banner_content' ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_banner_button_one' ) ) :
/**
 * Button One
*/
function blossom_studio_get_banner_button_one(){
    return esc_html( get_theme_mod( 'button_one', __( 'Get started', 'blossom-studio' ) ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_banner_button_two' ) ) :
/**
 * Button Two
*/
function blossom_studio_get_banner_button_two(){
    return esc_html( get_theme_mod( 'button_two', __( 'Know More', 'blossom-studio' ) ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_author_title' ) ) :
/**
 * Display Author Title
*/
function blossom_studio_get_author_title(){
    return esc_html( get_theme_mod( 'author_title', __( 'About the Author', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_blog_main_title' ) ) :
/**
 * Display Blog Title
*/
function blossom_studio_get_blog_main_title(){
    return esc_html( get_theme_mod( 'blog_main_title', __( 'From My Blog', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_blog_main_content' ) ) :
/**
 * Display Blog content
*/
function blossom_studio_get_blog_main_content(){
    return esc_html( get_theme_mod( 'blog_main_content' ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_blog_section_title' ) ) :
/**
 * Blog Section Title
*/
function blossom_studio_get_blog_section_title(){
    return esc_html( get_theme_mod( 'blog_section_title', __( 'Upcoming Classes', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_blog_section_subtitle' ) ) :
/**
 * Blog Section Subtitle
*/
function blossom_studio_get_blog_section_subtitle(){
    return wp_kses_post( wpautop( get_theme_mod( 'blog_section_subtitle' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_blog_btn_label' ) ) :
/**
 * Blog Readmore
*/
function blossom_studio_get_blog_btn_label(){
    return esc_html( get_theme_mod( 'blog_btn_label', __( 'View All Articles', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_product_title' ) ) :
/**
 * Product Section Title
*/
function blossom_studio_get_product_title(){
    return esc_html( get_theme_mod( 'product_title', __( 'Shop My Collections', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_product_subtitle' ) ) :
/**
 * product Section Subtitle
*/
function blossom_studio_get_product_subtitle(){
    return esc_html( get_theme_mod( 'product_subtitle' ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_product_view_all' ) ) :
/**
 * Product Section Readmore
*/
function blossom_studio_get_product_view_all(){
    return esc_html( get_theme_mod( 'product_view_all', __( 'Go To Shop', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_related_title' ) ) :
/**
 * Display Related Post Title
*/
function blossom_studio_get_related_title(){
    return esc_html( get_theme_mod( 'related_post_title', __( 'You May Also Like', 'blossom-studio' ) ) );
}
endif;

if( ! function_exists( 'blossom_studio_get_phone' ) ) :
/**
 * Display Phone
*/
function blossom_studio_get_phone(){
    return esc_html( get_theme_mod( 'phone' ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_email' ) ) :
/**
 * Display email
*/
function blossom_studio_get_email(){
    return esc_html( get_theme_mod( 'email' ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_header_contact_button' ) ) :
/**
 * Display Contact
*/
function blossom_studio_get_header_contact_button(){
    return esc_html( get_theme_mod( 'header_contact_button' ) );    
}
endif;

if( ! function_exists( 'blossom_studio_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function blossom_studio_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span class="copyright">';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'blossom-studio' );
        echo date_i18n( esc_html__( 'Y', 'blossom-studio' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'blossom-studio' );
    }
    echo '</span>'; 
}
endif;