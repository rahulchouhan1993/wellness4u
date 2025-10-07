<?php
/**
 * Full CTA Section
 * 
 * @package Blossom_Studio
 */
if( is_active_sidebar( 'cta' ) ){ ?>
<section id="cta_section" class="cta-full-section">
    <?php dynamic_sidebar( 'cta' ); ?>
</section> <!-- .cta-full-section -->
<?php
}