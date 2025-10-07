<?php
/**
 * CTA Wide Section
 * 
 * @package Blossom_Studio
 */

if( is_active_sidebar( 'cta-wide' ) ){ ?>
<section id="cta_wide_section" class="cta-wide-section">
	<div class="container">
    	<?php dynamic_sidebar( 'cta-wide' ); ?>
    </div>
</section> <!-- .testimonial-section -->
<?php
}