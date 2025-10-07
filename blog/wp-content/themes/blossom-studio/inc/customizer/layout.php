<?php
/**
 * Layout Settings
 *
 * @package Blossom_Studio
 */

function blossom_studio_customize_register_layout( $wp_customize ) {
    
    /** Layout Settings */
    $wp_customize->add_panel( 
        'layout_settings',
         array(
            'priority'    => 30,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Layout Settings', 'blossom-studio' ),
            'description' => __( 'Change different page layout from here.', 'blossom-studio' ),
        ) 
    );

    /** Header Layout Settings */
    $wp_customize->add_section(
        'header_layout_settings',
        array(
            'title'    => __( 'Header Layout', 'blossom-studio' ),
            'priority' => 10,
            'panel'    => 'layout_settings',
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'header_layout', 
        array(
            'default'           => 'two',
            'sanitize_callback' => 'blossom_studio_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Radio_Image_Control(
            $wp_customize,
            'header_layout',
            array(
                'section'     => 'header_layout_settings',
                'label'       => __( 'Header Layout', 'blossom-studio' ),
                'description' => __( 'Choose the layout of the header for your site.', 'blossom-studio' ),
                'choices'     => array(
                    'one'   => get_template_directory_uri() . '/images/header/one.jpg',
                    'two'   => get_template_directory_uri() . '/images/header/two.jpg',
                )
            )
        )
    );

    $wp_customize->add_setting(
        'header_layouts_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'header_layouts_text',
            array(
                'section'     => 'header_layout_settings',
                'description' => sprintf( __( '%1$sClick here%2$s to add the header information.', 'blossom-studio' ), '<span class="text-inner-link header_layouts_text">', '</span>' ),
            )
        )
    );

    /** Header Layout End Settings */

    /** Home Page Layout Settings */
    $wp_customize->add_section(
        'general_layout_settings',
        array(
            'title'    => __( 'General Sidebar Layout', 'blossom-studio' ),
            'priority' => 55,
            'panel'    => 'layout_settings',
        )
    );
    
    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_studio_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Radio_Image_Control(
            $wp_customize,
            'page_sidebar_layout',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Page Sidebar Layout', 'blossom-studio' ),
                'description' => __( 'This is the general sidebar layout for pages. You can override the sidebar layout for individual page in respective page.', 'blossom-studio' ),
                'choices'     => array(
                    'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
                    'centered'      => get_template_directory_uri() . '/images/1cc.jpg',
                    'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
                )
            )
        )
    );
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_studio_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Radio_Image_Control(
            $wp_customize,
            'post_sidebar_layout',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Post Sidebar Layout', 'blossom-studio' ),
                'description' => __( 'This is the general sidebar layout for posts & custom post. You can override the sidebar layout for individual post in respective post.', 'blossom-studio' ),
                'choices'     => array(
                    'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
                    'centered'      => get_template_directory_uri() . '/images/1cc.jpg',
                    'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
                )
            )
        )
    );
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => 'right-sidebar',
            'sanitize_callback' => 'blossom_studio_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Radio_Image_Control(
            $wp_customize,
            'layout_style',
            array(
                'section'     => 'general_layout_settings',
                'label'       => __( 'Default Sidebar Layout', 'blossom-studio' ),
                'description' => __( 'This is the general sidebar layout for whole site.', 'blossom-studio' ),
                'choices'     => array(
                    'no-sidebar'    => get_template_directory_uri() . '/images/1c.jpg',
                    'left-sidebar'  => get_template_directory_uri() . '/images/2cl.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/2cr.jpg',
                )
            )
        )
    );

    /** General Sidebar End Settings */
}
add_action( 'customize_register', 'blossom_studio_customize_register_layout' );