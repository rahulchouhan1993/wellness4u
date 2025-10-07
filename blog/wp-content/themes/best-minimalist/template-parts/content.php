<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Best_Minimalist
 */

?>

<article id="post-<?php the_ID(); ?>"
<?php
if ( ! is_single() ) {
	post_class( 'teaser' );
} else {
	post_class();
}
?>
>
	<?php if ( is_home() || is_front_page() || is_archive() || is_search() ) : ?>
		<?php
		if ( has_post_thumbnail() ) {
			echo '<figure><a href="' . esc_url( get_permalink() ) . '">';
			the_post_thumbnail( 'best-minimalist-teaser' );
			echo '</a></figure>';
		} else {
			echo '<figure><a href="' . esc_url( get_permalink() ) . '"><img src="' . esc_url( get_stylesheet_directory_uri() ) . '/assets/images/thumbnail-missing.png" /></a></figure>';
		}
		?>
	<?php endif; ?>
	<?php if ( is_single() ) : ?>
		<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
			<!--
			* Funtion to check if Breadcrumb navXT plugin is active or not.
			* Theme Reviewer - This is not an absolute nor a malacious code.
			* If https://wordpress.org/plugins/breadcrumb-navxt/ plugin is active, breadcrumb will be shown.
			-->
			<?php
			if ( function_exists( 'bcn_display' ) ) {
					bcn_display();
			}
			?>
		</div>
	<?php endif; ?>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				best_minimalist_posted_on();
				best_minimalist_posted_by();
				?>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
		if ( is_single() ) {
			//$featured = get_theme_mod("best_minimalist_featured");
			if (get_theme_mod("best_minimalist_featured")):
		    ?>
            <div class="featured_post_image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php
            endif;
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'best-minimalist' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
		} else {
			the_excerpt();
		}
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'best-minimalist' ),
					'after'  => '</div>',
				)
			);
		?>
	</div>

	<?php if ( is_single() ) : ?>
		<footer class="entry-footer">
			<?php best_minimalist_entry_footer(); ?>
		</footer>
	<?php endif; ?>
</article>
