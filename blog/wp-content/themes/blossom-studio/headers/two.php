<?php
/**
 * Header Two
 *
 * @package Blossom_Studio
 */

$ed_cart   = get_theme_mod( 'ed_shopping_cart', false );
$ed_search = get_theme_mod( 'ed_header_search', false ); ?>

<header id="masthead" class="site-header style-two" itemscope itemtype="http://schema.org/WPHeader">
	<?php 
	$phone = get_theme_mod( 'phone' );
    $email = get_theme_mod( 'email' );

	if( $phone || $email || blossom_studio_social_links( false ) || $ed_search || ( blossom_studio_is_woocommerce_activated() && $ed_cart ) || has_nav_menu( 'secondary' ) ) : ?>
		<div class="header-top">
			<div class="container">
				<div class="header-left">
					<?php blossom_studio_header_contact(); ?>
				</div>
				<div class="header-right">
					<?php if( blossom_studio_social_links( false ) ) {
						echo '<div class="header-social">';
						blossom_studio_social_links();
						echo '</div>';
					} ?>
					<?php if( $ed_search ) blossom_studio_header_search(); ?>
					<?php if( blossom_studio_is_woocommerce_activated() && $ed_cart ) blossom_studio_wc_cart_count(); ?>
					<?php blossom_studio_secondary_navigation(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="header-main">
		<div class="container">
			<?php blossom_studio_site_branding(); ?>
			<div class="nav-wrap">
				<div class="header-left">
					<?php blossom_studio_primary_navigation(); ?>
				</div>
				<div class="header-right">
					<?php blossom_studio_contact_button(); ?>
				</div>
			</div>
		</div>
	</div>
</header>

<?php blossom_studio_mobile_header(); ?>