<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Studio
 */
    
    /**
     * After Content
     * 
     * @hooked blossom_studio_content_end - 20
     * @hooked blossom_studio_footer_newsletter_section - 30
     * @hooked blossom_studio_instagram_section         - 40
    */
    do_action( 'blossom_studio_before_footer' );
    
    /**
     * Footer
     * 
     * @hooked blossom_studio_footer_start  - 20
     * @hooked blossom_studio_footer_top    - 30
     * @hooked blossom_studio_footer_bottom - 40
     * @hooked blossom_studio_footer_end    - 50
    */
    do_action( 'blossom_studio_footer' );
    
    /**
     * After Footer
     * 
     * @hooked blossom_studio_page_end    - 20
    */
    do_action( 'blossom_studio_after_footer' );

    wp_footer(); ?>

</body>
</html>
