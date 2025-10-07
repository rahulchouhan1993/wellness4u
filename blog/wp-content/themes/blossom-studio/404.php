<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package Blossom_Studio
 */

$error_404_image = get_theme_mod( 'error_404_image', get_template_directory_uri() . '/images/error.jpg' );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<header class="page-header">
					<div class="header-title-wrap">
						<span class="sub-title"><?php esc_html_e( 'Page not Found', 'blossom-studio' ); ?></span>
						<h1 class="page-title"><?php esc_html_e( '404 Error', 'blossom-studio' ); ?></h1>
						<div class="page-content">
							<p><?php esc_html_e( 'The page you\'re looking for might moved, deleted or even not exited.', 'blossom-studio' ); ?></p>
						</div><!-- .page-content -->
					</div>
					<div class="button-wrap"><a class="btn-readmore" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'GO TO HOMEPAGE', 'blossom-studio' ); ?></a></div>
				</header><!-- .page-header -->
				<figure class="error-img">
                    <img src="<?php echo esc_url( $error_404_image ); ?>" alt="<?php esc_attr_e( 'error image', 'blossom-studio' ); ?>">
                </figure>
				<div class="error-404-search">
					<div class="error-search-title"><?php esc_html_e( 'TRYING SEARCHING', 'blossom-studio' ); ?></div>
					<?php get_search_form(); ?>
                </div>
			</section><!-- .error-404 -->
		</main><!-- #main -->
	    
	    <?php
	    /**
	     * @see blossom_studio_latest_posts
	    */
	    do_action( 'blossom_studio_latest_posts' ); 
	    ?>
	</div><!-- #primary -->
    
<?php    
get_footer();