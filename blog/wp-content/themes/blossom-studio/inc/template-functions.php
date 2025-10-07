<?php
/**
 * Blossom Studio Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Blossom_Studio
 */

if( ! function_exists( 'blossom_studio_doctype' ) ) :
/**
 * Doctype Declaration
*/
function blossom_studio_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'blossom_studio_doctype', 'blossom_studio_doctype' );

if( ! function_exists( 'blossom_studio_head' ) ) :
/**
 * Before wp_head 
*/
function blossom_studio_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'blossom_studio_before_wp_head', 'blossom_studio_head' );

if( ! function_exists( 'blossom_studio_page_start' ) ) :
/**
 * Page Start
*/
function blossom_studio_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content (Press Enter)', 'blossom-studio' ); ?></a>
    <?php
}
endif;
add_action( 'blossom_studio_before_header', 'blossom_studio_page_start', 20 );

if( ! function_exists( 'blossom_studio_header' ) ) :
/**
 * Header Start
*/
function blossom_studio_header(){ 
    
    $header_array = array( 'one', 'two' );
    $header = get_theme_mod( 'header_layout', 'two' );
    if( in_array( $header, $header_array ) ){            
        get_template_part( 'headers/' . $header );
    }
}
endif;
add_action( 'blossom_studio_header', 'blossom_studio_header', 20 );

if( ! function_exists( 'blossom_studio_content_start' ) ) :
/**
 * Content Start
 * 
*/
function blossom_studio_content_start(){       
    $home_sections = blossom_studio_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){ ?>
        <div id="content" class="site-content">
            <?php if( is_home() || is_archive() || is_search() || ( is_page() && apply_filters( 'blossom_studio_page_title', true ) ) ) blossom_studio_page_header(); ?>
            <?php if( is_singular( 'post' ) ) { ?>
                <div class="breadcrumb-wrapper">
                    <?php blossom_studio_breadcrumb(); ?>
                </div>
            <?php } ?>
            <?php echo '<div class="container">';        
    }
}
endif;
add_action( 'blossom_studio_content', 'blossom_studio_content_start' );

if( ! function_exists( 'blossom_studio_entry_header' ) ) :
/**
 * Entry Header
*/
function blossom_studio_entry_header(){
    ?>
    <header class="entry-header">
        <?php            
            blossom_studio_category();
            
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            endif; 

            if( 'post' === get_post_type() && is_single() ){
                echo '<div class="entry-meta">';
                blossom_studio_posted_by();
                blossom_studio_posted_on();                
                echo '</div>';
            }       
        ?>
    </header>         
    <?php    
}
endif;
add_action( 'blossom_studio_post_entry_content', 'blossom_studio_entry_header', 10 );
add_action( 'blossom_studio_before_single_entry_content', 'blossom_studio_entry_header', 20 );

if ( ! function_exists( 'blossom_studio_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function blossom_studio_post_thumbnail() {
	
    $image_size     = 'thumbnail';
    $ed_featured    = get_theme_mod( 'ed_featured_image', true );
    $ed_crop_blog   = get_theme_mod( 'ed_crop_blog', false );
    $ed_crop_single = get_theme_mod( 'ed_crop_single', false );
    $sidebar        = blossom_studio_sidebar();
    
    if( is_home() ){   
        $image_size = ( $sidebar ) ? 'blossom-studio-blog-classic' : 'blossom-studio-blog-classic-full';     
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
        if( has_post_thumbnail() ){                        
            if( $ed_crop_blog ){
                the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );    
            }else{
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
            }
        }else{
            blossom_studio_get_fallback_svg( $image_size );//fallback    
        }        
        echo '</a></figure>';
    }elseif( is_archive() || is_search() ){
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
        if( has_post_thumbnail() ){
            if( $ed_crop_blog ){
                the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );    
            }else{
                the_post_thumbnail( 'blossom-studio-blog-grid', array( 'itemprop' => 'image' ) );    
            }
        }else{
            blossom_studio_get_fallback_svg( 'blossom-studio-blog-grid' );//fallback
        }
        echo '</a></figure>';
    }elseif( is_singular() ){
        $image_size = 'blossom-studio-single';
        if( is_single() ){
            if( $ed_featured && has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                if( $ed_crop_single ){
                    the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
                }else{
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                }
                echo '</figure>';    
            }
        }elseif( is_page() ){
            if( has_post_thumbnail() ){
                echo '<div class="post-thumbnail">';
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</div>';    
            }            
        }
    }
}
endif;
add_action( 'blossom_studio_before_page_entry_content', 'blossom_studio_post_thumbnail' );
add_action( 'blossom_studio_before_post_entry_content', 'blossom_studio_post_thumbnail', 10 );
add_action( 'blossom_studio_before_single_entry_content', 'blossom_studio_post_thumbnail', 10 );

if( ! function_exists( 'blossom_studio_single_article_meta' ) ) :
/**
 * Entry Header
*/
function blossom_studio_single_article_meta(){  
    ?>
    <div class="article-meta">
        <div class="article-meta-inner">
        <?php if( is_singular( 'post' ) ) blossom_studio_comment_count(); ?>
        </div>         
    </div>         
    <?php    
}
endif;
add_action( 'blossom_studio_single_entry_content', 'blossom_studio_single_article_meta', 10 );

if( ! function_exists( 'blossom_studio_entry_content' ) ) :
/**
 * Entry Content
*/
function blossom_studio_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); ?>

    <div class="entry-content" itemprop="text">
		<?php
			if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                the_content();    
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blossom-studio' ),
    				'after'  => '</div>',
    			) );
            }else{
                the_excerpt();
            }
		?>
	</div><!-- .entry-content -->
    <?php
}
endif;
add_action( 'blossom_studio_page_entry_content', 'blossom_studio_entry_content', 15 );
add_action( 'blossom_studio_post_entry_content', 'blossom_studio_entry_content', 15 );
add_action( 'blossom_studio_single_entry_content', 'blossom_studio_entry_content', 15 );

if( ! function_exists( 'blossom_studio_entry_footer' ) ) :
/**
 * Entry Footer
*/
function blossom_studio_entry_footer(){ ?>
	
    <footer class="entry-footer">
		<?php
			if( is_single() ){
			    blossom_studio_tag();
			}
            
            if( 'post' === get_post_type() && is_home() ){
                blossom_studio_posted_by();                
                blossom_studio_posted_on(); 
            }
            
            if( get_edit_post_link() ){
                edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'blossom-studio' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
            }
		?>
	</footer><!-- .entry-footer -->
	<?php 
}
endif;
add_action( 'blossom_studio_page_entry_content', 'blossom_studio_entry_footer', 20 );
add_action( 'blossom_studio_post_entry_content', 'blossom_studio_entry_footer', 20 );
add_action( 'blossom_studio_single_entry_content', 'blossom_studio_entry_footer', 20 );

if( ! function_exists( 'blossom_studio_navigation' ) ) :
/**
 * Navigation
*/
function blossom_studio_navigation(){
    if( is_single() ) {
        $next_post = get_next_post();
        $prev_post = get_previous_post();

        if( $prev_post || $next_post ) { ?>            
            <nav class="post-navigation pagination" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Post Navigation', 'blossom-studio' ); ?></h2>
                <div class="nav-links">
                    <?php if( $prev_post ){ ?>
                    <div class="nav-previous">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                            <article class="post">
                                <figure class="post-thumbnail">
                                    <?php
                                    $prev_img = get_post_thumbnail_id( $prev_post->ID );
                                    if( $prev_img ){
                                        $prev_url = wp_get_attachment_image_url( $prev_img, 'thumbnail' );
                                        echo '<img src="' . esc_url( $prev_url ) . '" alt="' . the_title_attribute( 'echo=0', $prev_post ) . '">';                                        
                                    }else{
                                        blossom_studio_get_fallback_svg( 'thumbnail' );
                                    }
                                    ?>
                                </figure>
                                <header class="entry-header">
                                    <h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>
                                </header>                               
                            </article>
                            <span class="meta-nav"><?php esc_html_e( 'Previous Post', 'blossom-studio' ); ?></span>
                        </a>                        
                    </div>
                    <?php } ?>
                    <?php if( $next_post ){ ?>
                    <div class="nav-next">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                            <article class="post">
                                <figure class="post-thumbnail">
                                    <?php
                                    $next_img = get_post_thumbnail_id( $next_post->ID );
                                    if( $next_img ){
                                        $next_url = wp_get_attachment_image_url( $next_img, 'thumbnail' );
                                        echo '<img src="' . esc_url( $next_url ) . '" alt="' . the_title_attribute( 'echo=0', $next_post ) . '">';                                        
                                    }else{
                                        blossom_studio_get_fallback_svg( 'thumbnail' );
                                    }
                                    ?>
                                </figure>
                                <header class="entry-header">
                                    <h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
                                </header>                               
                            </article>
                            <span class="meta-nav"><?php esc_html_e( 'Next Post', 'blossom-studio' ); ?>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </nav>        
            <?php
        }
    }else{
            
        the_posts_pagination( array(
            'prev_text'          => __( 'Previous', 'blossom-studio' ),
            'next_text'          => __( 'Next', 'blossom-studio' ),
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'blossom-studio' ) . ' </span>',
        ) );
    }
}
endif;
add_action( 'blossom_studio_after_post_content', 'blossom_studio_navigation', 15 );
add_action( 'blossom_studio_after_posts_content', 'blossom_studio_navigation' );

if( ! function_exists( 'blossom_studio_author' ) ) :
/**
 * Author Section
*/
function blossom_studio_author(){ 
    $ed_author    = get_theme_mod( 'ed_author', false );
    $author_title = get_theme_mod( 'author_title', __( 'About the Author', 'blossom-studio' ) );
    $author_name  = get_the_author();
    if( ! $ed_author && get_the_author_meta( 'description' ) ){ ?>
    <div class="author-section">
		<figure class="author-img"><?php echo get_avatar( get_the_author_meta( 'ID' ), 95 ); ?></figure>
		<div class="author-content-wrap">
            <div class="author-title-wrap">
                <div class="author-name-holder">
    			<?php 
                    if( $author_title ) echo '<span class="subtitle">' . esc_html( $author_title ) . '</span>';
                    if( $author_name ) echo '<h3 class="author-name">' . esc_html( $author_name ) . '</h3>';
                ?>
                </div>	
            </div>
            <div class="author-content">
                <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
            </div>	
		</div>
	</div>
    <?php
    }
}
endif;
add_action( 'blossom_studio_after_post_content', 'blossom_studio_author', 10 );

if( ! function_exists( 'blossom_studio_related_posts' ) ) :
/**
 * Related Posts 
*/
function blossom_studio_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        blossom_studio_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'blossom_studio_after_post_content', 'blossom_studio_related_posts', 35 );

if( ! function_exists( 'blossom_studio_latest_posts' ) ) :
/**
 * Latest Posts
*/
function blossom_studio_latest_posts(){ 
    blossom_studio_get_posts_list( 'latest' );
}
endif;
add_action( 'blossom_studio_latest_posts', 'blossom_studio_latest_posts' );

if( ! function_exists( 'blossom_studio_comment' ) ) :
/**
 * Comments Template 
*/
function blossom_studio_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'blossom_studio_after_post_content', 'blossom_studio_comment', blossom_studio_comment_toggle() );
add_action( 'blossom_studio_after_page_content', 'blossom_studio_comment' );

if( ! function_exists( 'blossom_studio_content_end' ) ) :
/**
 * Content End
*/
function blossom_studio_content_end(){ 
    $home_sections = blossom_studio_get_home_sections(); 
    if( ! ( is_front_page() && ! is_home() && $home_sections ) ){             
            echo '</div><!-- .container -->'; ?>        
        </div><!-- .site-content -->
        <?php
    }
}
endif;
add_action( 'blossom_studio_before_footer', 'blossom_studio_content_end', 20 );

if( ! function_exists( 'blossom_studio_footer_newsletter_section' ) ) :
/**
 * Footer Newsletter Section 
*/
function blossom_studio_footer_newsletter_section(){
    $ed_newsletter = get_theme_mod( 'ed_newsletter', false );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' );
    if( $ed_newsletter && $newsletter ){ ?>
        <section class="footer-newsletter-section">
            <?php echo do_shortcode( wp_kses_post( $newsletter ) ); ?>
        </section> <!-- .client-section -->
    <?php
    }  
}
endif;
add_action( 'blossom_studio_before_footer', 'blossom_studio_footer_newsletter_section', 30 );

if( ! function_exists( 'blossom_studio_instagram_section' ) ) :
/**
 * Instagram Section
*/
function blossom_studio_instagram_section(){ 
    if( blossom_studio_is_btif_activated() ){
        $ed_instagram = get_theme_mod( 'ed_instagram', false );
        if( $ed_instagram ){
            echo '<div class="instagram-section">';
            echo do_shortcode( '[blossomthemes_instagram_feed]' );
            echo '</div>';    
        }
    }
}
endif;
add_action( 'blossom_studio_before_footer', 'blossom_studio_instagram_section', 40 );

if( ! function_exists( 'blossom_studio_footer_start' ) ) :
/**
 * Footer Start
*/
function blossom_studio_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'blossom_studio_footer', 'blossom_studio_footer_start', 20 );

if( ! function_exists( 'blossom_studio_footer_top' ) ) :
/**
 * Footer Top
*/
function blossom_studio_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-top">
    		<div class="container">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }
}
endif;
add_action( 'blossom_studio_footer', 'blossom_studio_footer_top', 30 );

if( ! function_exists( 'blossom_studio_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function blossom_studio_footer_bottom(){ ?>
    <div class="footer-bottom">
		<div class="container">
			<div class="site-info">            
            <?php
                blossom_studio_get_footer_copyright();
                echo esc_html__( ' Blossom Studio | Developed By ', 'blossom-studio' ); 
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'blossom-studio' ) . '</a>.';                
                printf( esc_html__( ' Powered by %s. ', 'blossom-studio' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'blossom-studio' ) ) .'" target="_blank">WordPress</a>' );
                if( function_exists( 'the_privacy_policy_link' ) ){
                    the_privacy_policy_link();
                }
            ?>               
            </div>
            <div class="social-wrap">
                <?php blossom_studio_social_links( false ); ?>
                <?php blossom_studio_footer_navigation(); ?>
            </div>
            <button class="back-to-top">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor" d="M6.101 359.293L25.9 379.092c4.686 4.686 12.284 4.686 16.971 0L224 198.393l181.13 180.698c4.686 4.686 12.284 4.686 16.971 0l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L232.485 132.908c-4.686-4.686-12.284-4.686-16.971 0L6.101 342.322c-4.687 4.687-4.687 12.285 0 16.971z"></path>
                </svg>
            </button><!-- .back-to-top -->
		</div>
	</div>
    <?php
}
endif;
add_action( 'blossom_studio_footer', 'blossom_studio_footer_bottom', 40 );

if( ! function_exists( 'blossom_studio_footer_end' ) ) :
/**
 * Footer End 
*/
function blossom_studio_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'blossom_studio_footer', 'blossom_studio_footer_end', 50 );

if( ! function_exists( 'blossom_studio_page_end' ) ) :
/**
 * Page End
*/
function blossom_studio_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'blossom_studio_after_footer', 'blossom_studio_page_end', 20 );