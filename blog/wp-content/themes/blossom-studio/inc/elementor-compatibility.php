<?php 
/**
 * Elementor activation
 */

function blossom_studio_elementor_support(){
	update_option( 'elementor_cpt_support', array( 'blossom-portfolio', 'post','page', 'bs-event', 'bs-program' ) );
	update_option( 'elementor_default_generic_fonts', 'DM Serif Text' );
}
add_action( 'after_switch_theme', 'blossom_studio_elementor_support' );

/**
 * Filter to alter Default Font and Default Color
 */
function blossom_studio_elementor_defaults( $config ) {

	$primary_font    = get_theme_mod( 'primary_font', 'Esteban' );
	$secondary_font  = get_theme_mod( 'secondary_font', 'DM Serif Text' ); 

	$config['default_schemes']['color']['items'] = [
		'1' => '#01B1B1',
		'2' => '#44576B',
		'3' => '#171717',
		'4' => '#01B1B1'
	];

	$config['default_schemes']['typography']['items'] = [
		'1' => array(
			'font_family' => $primary_font,
	        'font_weight' => '400',
		),
		'2' => array(
			'font_family' => $primary_font,
	        'font_weight' => '400',
		),
		'3' => array(
			'font_family' => $primary_font,
	        'font_weight' => '400',
		),
		'4' => array(
			'font_family' => $secondary_font,
	        'font_weight' => '600',
		)];

	$config['i18n']['global_colors'] = __( 'Blossom Studio Color', 'blossom-studio' );
	$config['i18n']['global_fonts']  = __( 'Blossom Studio Fonts', 'blossom-studio' );

	return $config;
}
add_filter('elementor/editor/localize_settings', 'blossom_studio_elementor_defaults', 99 );