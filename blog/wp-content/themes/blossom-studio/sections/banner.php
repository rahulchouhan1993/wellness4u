<?php
/**
 * Banner Section
 * 
 * @package Blossom_Studio
 */

$ed_banner        = get_theme_mod( 'ed_banner_section', 'static_banner' );
$slider_type      = get_theme_mod( 'slider_type', 'latest_posts' ); 
$slider_cat       = get_theme_mod( 'slider_cat' );
$posts_per_page   = get_theme_mod( 'no_of_slides', 3 );
$ed_full_image    = get_theme_mod( 'slider_full_image', false );
$ed_caption       = get_theme_mod( 'slider_caption', true );
$banner_title     = get_theme_mod( 'banner_title', __( 'Step into your wild beautiful life...', 'blossom-studio' ) );
$banner_subtitle  = get_theme_mod( 'banner_subtitle', __( 'Breath, Relax and be still.', 'blossom-studio' ) );
$banner_content   = get_theme_mod( 'banner_content' );
$button_one       = get_theme_mod( 'button_one', __( 'Get Started', 'blossom-studio' ) );
$button_one_url   = get_theme_mod( 'button_one_url', '#' );
$button_two       = get_theme_mod( 'button_two', __( 'Know More', 'blossom-studio' ) );
$button_two_url   = get_theme_mod( 'button_two_url', '#' );
$button_one_new   = get_theme_mod( 'button_one_tab_new', false );
$button_two_new   = get_theme_mod( 'button_two_tab_new', false );
$target_one = $target_two = '';

if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
    <div id="banner_section" class="site-banner<?php if( $ed_banner == 'static_banner' ) echo ' static-cta'; ?><?php if( $ed_banner == 'static_banner' ) echo ' style-one'; ?><?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?><?php echo ' align-right'; ?>"> 
        <div class="container">
            <div class="item"><?php 
                blossom_studio_header_image_markup();
                if( $banner_title || $banner_subtitle || ( $banner_label && $banner_link ) ){
                    echo '<div class="banner-caption">';
                    if( $banner_subtitle ) echo '<div class="sub-title">' . esc_html( $banner_subtitle ) . '</div>';
                    if( $banner_title ) echo '<h2 class="item-title">' . esc_html( $banner_title ) . '</h2>';
                    if( $banner_content ) echo '<div class="banner-text">' . esc_html( $banner_content ) . '</div>';
            		if( ( $button_one && $button_one_url ) || ( $button_two && $button_two_url ) ) {
                        echo '<div class="button-wrap">';
                        if( $button_one && $button_one_url ) {
                            if( $button_one_new ) $target_one = ' target="_blank"';
                            echo '<a href="' . esc_url( $button_one_url ) . '" class="btn-readmore btn-rm-one"' . $target_one . '>' . esc_html( $button_one ) . '</a>';                              
                        }
                        if( $button_two && $button_two_url ) {
                            if( $button_two_new ) $target_two = ' target="_blank"';
                            echo '<a href="' . esc_url( $button_two_url  ) . '" class="btn-readmore btn-rm-two btn-transparent"' . $target_two . '>' . esc_html( $button_two ) . '</a>';
                        }                      
                        echo '</div>';
                    }
                    echo '</div>';
                } ?>
            </div>
        </div>
    </div>
<?php
}elseif( $ed_banner == 'slider_banner' ){
    if( $slider_type == 'latest_posts' || $slider_type == 'cat' ){
        $args = array(
            'post_status'         => 'publish',            
            'ignore_sticky_posts' => true
        );
        
        if( $slider_type === 'cat' && $slider_cat ){
            $args['post_type']      = 'post';
            $args['cat']            = $slider_cat; 
            $args['posts_per_page'] = -1;  
        }else{
            $args['post_type']      = 'post';
            $args['posts_per_page'] = $posts_per_page;
        }
            
        $qry = new WP_Query( $args );
        
        if( $qry->have_posts() ){ ?>
            <div id="banner_section" class="site-banner banner-slider style-one">
                <div class="container">
                    <div class="item-wrap owl-carousel">           
            			<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                        <div class="item">
            				<div class="banner-img">
                                <?php 
                                $image_size = ( $ed_full_image && has_post_thumbnail() ) ? 'full' : 'blossom-studio-slider';
                                if( has_post_thumbnail() ){
                				    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                				}else{ 
                				    blossom_studio_get_fallback_svg( $image_size );//fallback
                                } ?>
                            </div>
                            <?php if( $ed_caption ){ ?>                        
                				<div class="banner-caption">
        							<?php
                                        blossom_studio_category();
                                        the_title( '<h2 class="item-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                        echo '<div class="banner-text">';
                                        the_excerpt();
                                        echo '</div>';
                                        if( ( $button_one && $button_one_url ) || ( $button_two && $button_two_url ) ) {
                                            echo '<div class="button-wrap">';
                                            if( $button_one && $button_one_url ) {
                                                if( $button_one_new ) $target_one = ' target="_blank"';
                                                echo '<a href="' . esc_url( $button_one_url ) . '" class="btn-readmore"' . $target_one . '>' . esc_html( $button_one ) . '</a>';                              
                                            }
                                            if( $button_two && $button_two_url ) {
                                                if( $button_two_new ) $target_two = ' target="_blank"';
                                                echo '<a href="' . esc_url( $button_two_url  ) . '" class="btn-readmore btn-rm-two btn-transparent"' . $target_two . '>' . esc_html( $button_two ) . '</a>';
                                            }                      
                                            echo '</div>';
                                        }                              
                                    ?>
                				</div>
                            <?php } ?>
            			</div>
            			<?php } ?>                        
                    </div>                
                </div>                
            </div>
        <?php
        wp_reset_postdata();
        }
    
    }
}