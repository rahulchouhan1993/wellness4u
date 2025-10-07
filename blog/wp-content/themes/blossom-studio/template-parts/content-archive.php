<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Studio
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
	<?php 
        /**
         * @hooked blossom_studio_post_thumbnail - 10
        */
        do_action( 'blossom_studio_before_post_entry_content' );
        
        blossom_studio_entry_header_layout_one();
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
