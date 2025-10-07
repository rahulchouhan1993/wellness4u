<?php
/**
 * Shop Section
 * 
 * @package Blossom_Studio
 */

$ed_shop_section    = get_theme_mod( 'ed_shop_section', false );
$product_title 		= get_theme_mod( 'product_title', __( 'Shop My Recommendations', 'blossom-studio' ) );
$product_subtitle 	= get_theme_mod( 'product_subtitle' );
$label    	   		= get_theme_mod( 'product_view_all', __( 'Go To Shop', 'blossom-studio' ) );

$shop_section_one   = get_theme_mod( 'shop_section_one' );
$shop_section_two   = get_theme_mod( 'shop_section_two' );
$shop_section_three = get_theme_mod( 'shop_section_three' );
$shop_section_four  = get_theme_mod( 'shop_section_four' );
$shop_sections      = array( $shop_section_one, $shop_section_two, $shop_section_three, $shop_section_four );
$shop_sections      = array_diff( array_unique( $shop_sections), array( '' ) );

if( $ed_shop_section && blossom_studio_is_woocommerce_activated() ){ ?>
	<?php 
	$args = array();
	
	if( $shop_sections ) :
	    $args = array(
	        'post_type'      => 'product',
	        'posts_per_page' => -1,
	        'post__in'       => $shop_sections,
	        'orderby'        => 'post__in'   
	    );
    endif;

    $qry = new WP_Query( $args );

	if( $qry->have_posts() ) : ?>
		<section id="shop_section" class="shop-section">
			<div class="container">
				<?php if( $product_title || $product_subtitle ){ ?>
		            <header class="section-header">	
		                <?php 
		                    if( $product_title ) echo '<h2 class="section-title">' . esc_html( $product_title ) . '</h2>';
		                    if( $product_subtitle ) echo '<div class="section-desc">' . esc_html( $product_subtitle ) . '</div>'; 
		                ?>
		    		</header>
		        <?php } ?>
		    </div>
		    <?php
            if( $qry->have_posts() ){ ?> 
	            <div class="section-grid">
	                <?php
	                    while( $qry->have_posts() ){
	                        $qry->the_post(); global $product; ?>
	                        <article class="product">
	                        	<?php
	                                $stock = get_post_meta( get_the_ID(), '_stock_status', true );
	                                
	                                if( $stock == 'outofstock' ){
	                                    echo '<span class="outofstock">' . esc_html__( 'Sold Out', 'blossom-studio' ) . '</span>';
	                                }else{
	                                    woocommerce_show_product_sale_flash();    
	                                }
                                ?>	                            
	                            <figure class="post-thumbnail">
	                                <a href="<?php the_permalink(); ?>" rel="bookmark">
	                                    <?php 
	                                    if( has_post_thumbnail() ){
	                                        the_post_thumbnail( 'blossom-studio-shop' );    
	                                    }else{
	                                        blossom_studio_get_fallback_svg( 'blossom-studio-shop' );
	                                    }
	                                    ?>
	                                </a>
	                            </figure>
                                <header class="entry-header">
	                                <?php                            
		                            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );                                
		                            woocommerce_template_single_price(); //price
		                            ?>
		                        </header>
	                        </article>
	                        <?php
	                    }
	                ?>
	            </div>
	            <?php if( $label && ( wc_get_page_id( 'shop' ) ) ){ ?>
		            <div class="button-wrap">
		            	<div class="container">
			    			<a href="<?php the_permalink( wc_get_page_id( 'shop' ) ); ?>" class="btn-readmore btn-transparent">
			    				<span class="btn-shop-readmore"><?php echo esc_html( $label ); ?></span>
				    			<svg xmlns="http://www.w3.org/2000/svg" width="17.977" height="11.414" viewBox="0 0 17.977 11.414"><g transform="translate(-217 -21.794)"><path d="M150.5,37.864h16.676" transform="translate(67.004 -10.363)" fill="none" stroke="var(--primary-color)" stroke-linecap="round" stroke-width="1"></path><path d="M164.582,32.845l5,5-5,5" transform="translate(64.895 -10.344)" fill="none" stroke="var(--primary-color)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"></path></g></svg>
				    		</a>
			    		</div>
		    		</div>
		        <?php } ?>
                <?php
                wp_reset_postdata();
            } ?>
		</section> <!-- .shop-section -->
	<?php endif; 
}