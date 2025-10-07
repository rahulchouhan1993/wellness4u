<?php
/**
 * Best Minimalist Theme Customizer
 *
 * @package Best_Minimalist
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function best_minimalist_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_section( 'best_minimalist_featured' , array(
		'title'      => __('Featured Images on Posts?','best-minimalist'),
		'priority'   => 30,
	) );

	$wp_customize->add_setting(
		'best_minimalist_featured',
		array(
			'default'  => false,
			'sanitize_callback' => 'wp_strip_all_tags',

		)
	);
	$wp_customize->add_control(
			'best_minimalist_featured', array(
				'type' => 'checkbox',
				'label'       => esc_html__( 'Add featured images on posts?', 'best-minimalist' ),
				'section'     => 'best_minimalist_featured',
				'settings'    => 'best_minimalist_featured',
				'priority'    => 1,
			)
	);



	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'best_minimalist_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'best_minimalist_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'best_minimalist_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function best_minimalist_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function best_minimalist_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function best_minimalist_customize_preview_js() {
	wp_enqueue_script( 'best-minimalist-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'best_minimalist_customize_preview_js' );
