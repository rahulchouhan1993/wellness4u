<?php
/**
 * Toolkit Filters
 *
 * @package foodie
 */

if( ! function_exists( 'blossom_studio_default_image_text_size' ) ) :
    function blossom_studio_default_image_text_size(){
        return 'blossom-studio-promo';
    }
endif;
add_filter( 'bttk_it_img_size', 'blossom_studio_default_image_text_size' );

if( ! function_exists( 'blossom_studio_default_testimonial_size' ) ) :
    function blossom_studio_default_testimonial_size(){
        return 'full';
    }
endif;
add_filter( 'bttk_testimonial_icon_img_size', 'blossom_studio_default_testimonial_size' );

if( ! function_exists( 'blossom_studio_cta_button_alignment' ) ) :
    function blossom_studio_cta_button_alignment(){
        $cta_ba_array = array(
            'right'     => __( 'Right', 'blossom-studio' ),
            'centered'  => __( 'Centered', 'blossom-studio' ),
            'left'      => __( 'Left', 'blossom-studio' ),
        );

        return $cta_ba_array;
    }
endif;
add_filter( 'blossomthemes_cta_button_alignment', 'blossom_studio_cta_button_alignment' );

if( ! function_exists( 'blossom_studio_featured_page_widget_filter' ) ) :
/**
 * Filter for Featured page widget
*/
function blossom_studio_featured_page_widget_filter( $html, $args, $instance ){ 
    $read_more         = !empty( $instance['readmore'] ) ? $instance['readmore'] : __( 'Read More', 'blossom-studio' );      
    $show_feat_img     = !empty( $instance['show_feat_img'] ) ? $instance['show_feat_img'] : '' ;  
    $show_page_content = !empty( $instance['show_page_content'] ) ? $instance['show_page_content'] : '' ;        
    $show_readmore     = !empty( $instance['show_readmore'] ) ? $instance['show_readmore'] : '' ;        
    $page_list         = !empty( $instance['page_list'] ) ? $instance['page_list'] : 1 ;
    $image_alignment   = !empty( $instance['image_alignment'] ) ? $instance['image_alignment'] : 'left' ;
    if( !isset( $page_list ) || $page_list == '' ) return;
    
    $post_no = get_post( $page_list ); 
    
    $target = 'target="_blank"';
    if( isset($instance['target']) && $instance['target']!='' ) {
        $target = 'target="_self"';
    }
    
    if( $post_no ){
        setup_postdata( $post_no );
        ob_start(); ?>
        <div class="widget-featured-holder <?php echo esc_attr($image_alignment);?>">
            <div class="featured-holder-wrap">
                <?php
                if( ( has_post_thumbnail( $post_no ) ) && $show_feat_img ){ ?>
                <div class="img-holder">
                    <a <?php echo $target;?> href="<?php the_permalink( $post_no ); ?>">
                        <?php 
                        $featured_img_size = apply_filters( 'featured_img_size', 'full' );
                        if( has_post_thumbnail( $post_no ) ) echo get_the_post_thumbnail( $post_no, $featured_img_size ); ?>
                    </a>
                </div>
                <?php } ?>
                <div class="text-holder">
                    <?php 
                    echo is_page_template( 'templates/about.php' ) ? '<h1 class="widget-title">' : $args['before_title']; //Done for SEO
                    echo esc_html( $post_no->post_title );
                    echo is_page_template( 'templates/about.php' ) ? '</h1>' : $args['after_title'];
                    ?>
                    <div class="featured_page_content">
                        <?php 
                        if( isset( $show_page_content ) && $show_page_content!='' ){
                            echo apply_filters( 'the_content', $post_no->post_content );                                
                        }else{
                            echo apply_filters( 'the_excerpt', get_the_excerpt( $post_no ) );                                
                        }
                        
                        if( isset( $show_readmore ) && $show_readmore!='' ){ ?>
                            <a href="<?php the_permalink( $post_no ); ?>" <?php echo $target;?> class="btn-readmore"><?php echo esc_html( $read_more );?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>           
            </div>         
        </div>                    
        <?php    
        $html = ob_get_clean();
        wp_reset_postdata();
        return $html;
    }
}
endif;
add_filter( 'blossom_featured_page_widget_filter', 'blossom_studio_featured_page_widget_filter', 10, 3 );

if( ! function_exists( 'blossom_studio_testimonial_widget_filter' ) ) :
/**
 * Filter for Featured page widget
*/
function blossom_studio_testimonial_widget_filter( $html, $args, $instance ){ 
    
    $obj = new BlossomThemes_Toolkit_Functions();
    $name        = ! empty( $instance['name'] ) ? $instance['name'] : '' ;        
    $designation = ! empty( $instance['designation'] ) ? $instance['designation'] : '' ;        
    $testimonial = ! empty( $instance['testimonial'] ) ? $instance['testimonial'] : '';
    $image       = ! empty( $instance['image'] ) ? $instance['image'] : '';

    if( $image ){
        /** Added to work for demo testimonial compatible */
        $attachment_id = $image;
        if ( !filter_var( $image, FILTER_VALIDATE_URL ) === false ) {
            $attachment_id = $obj->bttk_get_attachment_id( $image );
        }

        $icon_img_size = apply_filters('bttk_testimonial_icon_img_size','thumbnail');
    }

    ob_start(); 
    ?>
    
        <div class="bttk-testimonial-holder">
            <div class="bttk-testimonial-inner-holder">
                <?php if( $image ){ ?>
                    <div class="img-holder">
                        <?php echo wp_get_attachment_image( $attachment_id, $icon_img_size, false, array( 'alt' => esc_attr( $name )));?>
                    </div>
                <?php }?>
    
                <div class="text-holder">  
                    <?php echo $args['before_title'] . $args['after_title']; ?>                                             
                    <?php if( $testimonial ) echo '<div class="testimonial-content">' . wpautop( wp_kses_post( $testimonial ) ) . '</div>'; ?>
                    <div class="testimonial-meta">
                       <?php 
                            if( $name ) echo '<span class="name">' . esc_html( $name ) . '</span>';
                            if( isset( $designation ) && $designation!='' ){
                                echo '<span class="designation">' . esc_html( $designation ) . '</span>';
                            }
                        ?>
                    </div>   
                </div>
            </div>
        </div>
    <?php 
    $html = ob_get_clean();   
    return $html;
}
endif;
add_filter( 'blossom_testimonial_widget_filter', 'blossom_studio_testimonial_widget_filter', 10, 3 );

if( ! function_exists( 'blossom_studio_client_logo_widget_filter' ) ) :
/**
 * Filter for Featured page widget
*/
function blossom_studio_client_logo_widget_filter( $html, $args, $instance ){ 
    $obj       = new BlossomThemes_Toolkit_Functions();
    $title     = ! empty( $instance['title'] ) ? $instance['title'] : '' ;        
    $content   = ! empty( $instance['content'] ) ? $instance['content'] : '';
    $icon      = ! empty( $instance['icon'] ) ? $instance['icon'] : '';
    $image     = ! empty( $instance['image'] ) ? $instance['image'] : '';
    $link      = ! empty( $instance['link'] ) ? $instance['link'] : '';
    $more_text = ! empty( $instance['more_text'] ) ? $instance['more_text'] : '';
    $target = 'target="_blank"';
    if( isset($instance['target']) && $instance['target']!='' ){
        $target = 'target="_self"';
    }

    if( $image ){
        /** Added to work for demo content compatible */
        $attachment_id = $image;
        if ( !filter_var( $image, FILTER_VALIDATE_URL ) === false ) {
            $attachment_id = $obj->bttk_get_attachment_id( $image );
        }
        $icon_img_size = apply_filters( 'bttk_icon_img_size', 'thumbnail' );
    }

    ob_start(); 
    ?>
    
        <div class="rtc-itw-holder">
            <div class="rtc-itw-inner-holder">
                <div class="text-holder">
                <?php 
                    if( $title ) echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance ) . $args['after_title'];                
                    if( $content ) echo '<div class="content">'.wpautop( wp_kses_post( $content ) ).'</div>';
                    if( isset( $link ) && $link!='' && isset( $more_text ) && $more_text!='' ){
                        echo '<a '.$target.' class="btn-readmore" href="'.esc_url($link).'">'.esc_html($more_text).'<svg xmlns="http://www.w3.org/2000/svg" width="17.977" height="11.414" viewBox="0 0 17.977 11.414">
                        <g transform="translate(-217 -21.794)">
                            <path d="M150.5,37.864h16.676" transform="translate(67.004 -10.363)" fill="none" stroke="var(--primary-color)"
                                stroke-linecap="round" stroke-width="1" />
                            <path d="M164.582,32.845l5,5-5,5" transform="translate(64.895 -10.344)" fill="none" stroke="var(--primary-color)"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                        </g>
                    </svg></a>';
                    }
                ?>                              
                </div>
                <?php if( $image ){ ?>
                    <div class="icon-holder">
                        <?php echo wp_get_attachment_image( $attachment_id, $icon_img_size, false, array( 'alt' => esc_attr( $title )));?>
                    </div>
                <?php }elseif( $icon ){ ?>
                    <div class="icon-holder">
                        <span class="<?php echo esc_attr( $icon ); ?>"></span>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php 
    $html = ob_get_clean();   
    return $html;
}
endif;
add_filter( 'blossom_icontext_widget_filter', 'blossom_studio_client_logo_widget_filter', 10, 3 );