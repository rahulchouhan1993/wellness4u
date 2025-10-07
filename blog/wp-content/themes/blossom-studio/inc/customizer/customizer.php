<?php
/**
 * Blossom Studio Theme Customizer
 *
 * @package Blossom_Studio
 */

/**
 * Requiring customizer panels & sections
*/
$blossom_studio_sections     = array( 'info', 'site', 'appearance', 'layout', 'home', 'general', 'elementor', 'footer' );

foreach( $blossom_studio_sections as $s ){
    require get_template_directory() . '/inc/customizer/' . $s . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blossom_studio_customize_preview_js() {
	wp_enqueue_script( 'blossom-studio-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), BLOSSOM_STUDIO_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'blossom_studio_customize_preview_js' );

function blossom_studio_customize_script(){
    $array = array(
        'home'       => get_permalink( get_option( 'page_on_front' ) ),
        'flushFonts' => wp_create_nonce( 'blossom-studio-local-fonts-flush' ),
    );
    wp_enqueue_style( 'blossom-studio-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), BLOSSOM_STUDIO_THEME_VERSION );
    wp_enqueue_script( 'blossom-studio-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), BLOSSOM_STUDIO_THEME_VERSION, true );
    wp_localize_script( 'blossom-studio-customize', 'blossom_studio_cdata', $array );

    wp_localize_script( 'blossom-studio-repeater', 'blossom_studio_customize',
        array(
            'nonce' => wp_create_nonce( 'blossom_studio_customize_nonce' )
        )
    );
}
add_action( 'customize_controls_enqueue_scripts', 'blossom_studio_customize_script' );

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-recommend.php';

$config_customizer = array(
	'recommended_plugins' => array(
		//change the slug for respective plugin recomendation
        'blossomthemes-toolkit' => array(
			'recommended' => true,
			'description' => sprintf(
				/* translators: %s: plugin name */
				esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'blossom-studio' ), '<strong>BlossomThemes Toolkit</strong>'
			),
		),
	),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'blossom-studio' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'blossom-studio' ),
	'activate_button_label'     => esc_html__( 'Activate', 'blossom-studio' ),
	'deactivate_button_label'   => esc_html__( 'Deactivate', 'blossom-studio' ),
);
Blossom_Studio_Customizer_Notice::init( apply_filters( 'Blossom_Studio_Customizer_Notice_array', $config_customizer ) );

if( ! function_exists( 'blossom_studio_ajax_delete_fonts_folder' ) ) :
/**
 * Reset font folder
 *
 * @access public
 * @return void
 */
function blossom_studio_ajax_delete_fonts_folder() {
	// Check request.
	if ( ! check_ajax_referer( 'blossom-studio-local-fonts-flush', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
	}
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_send_json_error( 'invalid_permissions' );
	}
	if ( class_exists( '\Blossom_Studio_WebFont_Loader' ) ) {
		$font_loader = new \Blossom_Studio_WebFont_Loader( '' );
		$removed = $font_loader->delete_fonts_folder();
		if ( ! $removed ) {
			wp_send_json_error( 'failed_to_flush' );
		}
		wp_send_json_success();
	}
	wp_send_json_error( 'no_font_loader' );
}
endif;
add_action( 'wp_ajax_blossom_studio_flush_fonts_folder', 'blossom_studio_ajax_delete_fonts_folder' );