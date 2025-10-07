<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Studio
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
        /**
         * Post Thumbnail
         * 
         * @hooked blossom_studio_post_thumbnail
        */
        do_action( 'blossom_studio_before_page_entry_content' );
    
        /**
         * Entry Content
         * 
         * @hooked blossom_studio_entry_content - 15
         * @hooked blossom_studio_entry_footer  - 20
        */
        do_action( 'blossom_studio_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
