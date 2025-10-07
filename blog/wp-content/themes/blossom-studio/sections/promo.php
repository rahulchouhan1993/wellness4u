<?php
/**
 * Promo Section
 * 
 * @package Blossom_Studio
 */
if( is_active_sidebar( 'promo' ) ){ ?>
<section id="promo_section" class="promo-section">
	<div class="container">
		<div class="section-grid">
    		<?php dynamic_sidebar( 'promo' ); ?>
		</div>
	</div>
</section><!-- .promo-section -->
<?php
}