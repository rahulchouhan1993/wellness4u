<?php
/**
 * Front Page
 * 
 * @package Blossom_Studio
 */

$home_sections = blossom_studio_get_home_sections();  
$ed_elementor  = get_theme_mod( 'ed_elementor', false );
$ed_banner     = get_theme_mod( 'ed_banner_section', 'static_banner' );

if ( 'posts' == get_option( 'show_on_front' ) ) { //Show Static Blog Page
    include( get_home_template() );
}elseif( blossom_studio_is_elementor_activated_post() && $ed_elementor ){ 
    get_header();
    get_template_part('template-parts/content-elementor');
    get_footer();
}elseif( $home_sections || $ed_banner != 'no_banner' ){ 
    get_header();
    if( $ed_banner != 'no_banner' ) get_template_part( 'sections/banner' );
    if( $home_sections ) {
        echo '<div id="content" class="site-content">';
        //If any one section are enabled then show custom home page.
        foreach( $home_sections as $section ){
            get_template_part( 'sections/' . $section );  
        }
        echo '</div>';
    }
    get_footer();
}else {
    //If all section are disabled then show respective page template. 
    include( get_page_template() );
}