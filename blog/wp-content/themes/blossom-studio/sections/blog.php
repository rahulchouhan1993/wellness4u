<?php
/**
 * Blog Section
 * 
 * @package Blossom_Studio
 */

$ed_blog_section    = get_theme_mod( 'ed_blog_section', true );
$section_title      = get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'blossom-studio' ) );
$sub_title          = get_theme_mod( 'blog_section_subtitle' );
$readmore           = get_theme_mod( 'blog_readmore', __( 'Read More', 'blossom-studio' ) );
$ed_crop_blog       = get_theme_mod( 'ed_crop_blog', false );
$btn_label          = get_theme_mod( 'blog_btn_label', __( 'View All Articles', 'blossom-studio' ) );
$btn_link           = get_option( 'page_for_posts' );

$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $ed_blog_section && ( $section_title || $sub_title || $qry->have_posts() ) ){ ?>

<section id="blog_section" class="blog-section">
	<div class="container">
        
        <?php if( $section_title || $sub_title ){ ?>
            <header class="section-header">	
                <?php 
                    if( $section_title ) echo '<h2 class="section-title">' . esc_html( $section_title ) . '</h2>';
                    if( $sub_title ) echo '<div class="section-desc">' . wp_kses_post( wpautop( $sub_title ) ) . '</div>'; 
                ?>
    		</header>
        <?php } ?>
        
        <?php if( $qry->have_posts() ){ ?>
            <div class="section-grid">
    			<?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
                    <article>
        				<figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                            <?php 
                                if( has_post_thumbnail() ){
                                    if( $ed_crop_blog ){
                                        the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) );
                                    }else{
                                        the_post_thumbnail( 'blossom-studio-blog-section', array( 'itemprop' => 'image' ) );
                                    }
                                }else{ 
                                    blossom_studio_get_fallback_svg( 'blossom-studio-blog-section' );//fallback
                                }                            
                            ?>                        
                            </a>
                        </figure>
    					<header class="entry-header">
    						<div class="entry-meta"><?php blossom_studio_category(); ?></div>
    						<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    					</header>
        			</article>			
        			<?php 
                } ?>
    		</div>        
        <?php } 
        wp_reset_postdata(); ?>

        <?php if( $btn_label && $btn_link ) : ?>
            <div class="button-wrap">
                <a href="<?php the_permalink( $btn_link ); ?>" class="btn-readmore btn-transparent">
                    <span class="btn-blog-readmore"><?php echo esc_html( $btn_label ); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.977" height="11.414" viewBox="0 0 17.977 11.414">
                        <g transform="translate(-217 -21.794)">
                            <path d="M150.5,37.864h16.676" transform="translate(67.004 -10.363)" fill="none" stroke="var(--primary-color)"
                                stroke-linecap="round" stroke-width="1" />
                            <path d="M164.582,32.845l5,5-5,5" transform="translate(64.895 -10.344)" fill="none" stroke="var(--primary-color)"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                        </g>
                    </svg>
                </a>
            </div>
        <?php endif; ?>
	</div>
</section>
<?php 
}