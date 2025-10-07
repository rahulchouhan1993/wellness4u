<?php
/**
 * Elementor Setting
 *
 * @package Blossom_Studio
 */

function blossom_studio_customize_register_elementor( $wp_customize ) {
    
    $wp_customize->add_section(
        'elementor_settings',
        array(
            'title'      => __( 'Elementor Settings', 'blossom-studio' ),
            'priority'   => 80,
            'capability' => 'edit_theme_options',
        )
    );
    
    $wp_customize->add_setting(
        'ed_elementor',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_elementor',
            array(
                'section'       => 'elementor_settings',
                'label'         => __( 'Enable Elementor Page Builder in FrontPage', 'blossom-studio' ),
                'description'   => __( 'You can override your Homepage Contents from this Elementor Page Builder', 'blossom-studio' ),
            )
        )
    );   
        
}
add_action( 'customize_register', 'blossom_studio_customize_register_elementor' );