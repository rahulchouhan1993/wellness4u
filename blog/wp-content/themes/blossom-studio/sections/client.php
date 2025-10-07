<?php
/**
 * Client Section
 * 
 * @package Blossom_Studio
 */

if( is_active_sidebar( 'client' ) ){ ?>
<section id="client_section" class="client-section">
	<div class="container">
	    <?php dynamic_sidebar( 'client' ); ?>
	</div>
</section> <!-- .testimonial-section -->
<?php
}