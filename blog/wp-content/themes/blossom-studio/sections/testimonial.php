<?php
/**
 * Testimonial Section
 * 
 * @package Blossom_Studio
 */
	
$testimonial_bg = get_theme_mod( 'testimonial_bg' );
	
if( is_active_sidebar( 'testimonial' ) ){ ?>
<section id="testimonial_section" class="testimonial-section"<?php if( $testimonial_bg ) { ?> style="background-image: url( '<?php echo esc_url( $testimonial_bg ); ?>' );"<?php } ?>>
	<div class="test-overlay"></div>
	<div class="container">
		<div class="section-grid">
	    	<?php dynamic_sidebar( 'testimonial' ); ?>
		</div>
	</div>
</section> <!-- .testimonial-section -->
<?php
}