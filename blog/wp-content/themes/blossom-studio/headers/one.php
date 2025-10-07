<?php
/**
 * Header One
 * 
 * @package Blossom_Studio
 */
 
$ed_search = get_theme_mod( 'ed_header_search', false );
$ed_cart   = get_theme_mod( 'ed_shopping_cart', false ); ?>

<header id="masthead" class="site-header style-one" itemscope itemtype="http://schema.org/WPHeader">
	<div class="header-main">
		<div class="container">
			<?php blossom_studio_site_branding(); ?>
			<div class="nav-wrap">
				<div class="header-left">
					<?php blossom_studio_primary_navigation(); ?>
					<?php if( $ed_search ) blossom_studio_header_search(); ?>
				</div>
				<div class="header-right">
					<?php blossom_studio_contact_button(); ?>
					<?php blossom_studio_secondary_navigation(); ?>
				</div>
			</div>
		</div>
	</div>
</header>

<?php blossom_studio_mobile_header(); ?>