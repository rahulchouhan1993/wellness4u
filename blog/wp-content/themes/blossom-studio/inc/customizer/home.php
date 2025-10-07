<?php
/**
 * Front Page Settings
 *
 * @package Blossom_Studio
 */

function blossom_studio_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'blossom-studio' ),
            'description' => __( 'Static Home Page settings.', 'blossom-studio' ),
        ) 
    );  
    
    $wp_customize->get_section( 'header_image' )->panel                    = 'frontpage_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'blossom-studio' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'blossom_studio_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'blossom_studio_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'blossom_studio_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'static_banner',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'       => __( 'Banner Options', 'blossom-studio' ),
                'description' => __( 'Choose banner as static image/video or as a slider.', 'blossom-studio' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'no_banner'        => __( 'Disable Banner Section', 'blossom-studio' ),
                    'static_banner'    => __( 'Static/Video CTA Banner', 'blossom-studio' ),
                    'slider_banner'    => __( 'Banner as Slider', 'blossom-studio' ),
                ),
                'priority' => 5 
            )            
        )
    );
    
    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => __( 'Breath, Relax and be still.', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Sub Title', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_subtitle', array(
        'selector' => '.site-banner .banner-caption .sub-title',
        'render_callback' => 'blossom_studio_get_banner_sub_title',
    ) );

    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => __( 'Step into your wild beautiful life...', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.site-banner .banner-caption .item-title',
        'render_callback' => 'blossom_studio_get_banner_title',
    ) );

    /** Sub Title */
    $wp_customize->add_setting(
        'banner_content',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_content',
        array(
            'label'           => __( 'Content', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_content', array(
        'selector' => '.site-banner .banner-caption .banner-text',
        'render_callback' => 'blossom_studio_get_banner_content',
    ) );
    
    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'           => 'latest_posts',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'   => __( 'Slider Content Style', 'blossom-studio' ),
                'section' => 'header_image',
                'choices' => array(
                    'latest_posts' => __( 'Latest Posts', 'blossom-studio' ),
                    'cat'          => __( 'Category', 'blossom-studio' ),
                ),
                'active_callback' => 'blossom_studio_banner_ac' 
            )
        )
    );
    
    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'blossom_studio_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Slider_Control( 
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Number of Slides', 'blossom-studio' ),
                'description' => __( 'Choose the number of slides you want to display', 'blossom-studio' ),
                'choices'     => array(
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1,
                ),
                'active_callback' => 'blossom_studio_banner_ac'                 
            )
        )
    );
    
    /** HR */
    $wp_customize->add_setting(
        'hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'hr',
            array(
                'section'     => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    ); 
    
    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Auto', 'blossom-studio' ),
                'description' => __( 'Enable slider auto transition.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );
    
    /** Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'slider_loop',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Loop', 'blossom-studio' ),
                'description' => __( 'Enable slider loop.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );
    
    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Caption', 'blossom-studio' ),
                'description' => __( 'Enable slider caption.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );
    
    /** Full Image */
    $wp_customize->add_setting(
        'slider_full_image',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'slider_full_image',
            array(
                'section'         => 'header_image',
                'label'           => __( 'Full Image', 'blossom-studio' ),
                'description'     => __( 'Enable to use full size image in slider.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );
    
    /** Slider Animation */
    $wp_customize->add_setting(
        'slider_animation',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'slider_animation',
            array(
                'label'       => __( 'Slider Animation', 'blossom-studio' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'bounceOut'      => __( 'Bounce Out', 'blossom-studio' ),
                    'bounceOutLeft'  => __( 'Bounce Out Left', 'blossom-studio' ),
                    'bounceOutRight' => __( 'Bounce Out Right', 'blossom-studio' ),
                    'bounceOutUp'    => __( 'Bounce Out Up', 'blossom-studio' ),
                    'bounceOutDown'  => __( 'Bounce Out Down', 'blossom-studio' ),
                    'fadeOut'        => __( 'Fade Out', 'blossom-studio' ),
                    'fadeOutLeft'    => __( 'Fade Out Left', 'blossom-studio' ),
                    'fadeOutRight'   => __( 'Fade Out Right', 'blossom-studio' ),
                    'fadeOutUp'      => __( 'Fade Out Up', 'blossom-studio' ),
                    'fadeOutDown'    => __( 'Fade Out Down', 'blossom-studio' ),
                    'flipOutX'       => __( 'Flip OutX', 'blossom-studio' ),
                    'flipOutY'       => __( 'Flip OutY', 'blossom-studio' ),
                    'hinge'          => __( 'Hinge', 'blossom-studio' ),
                    'pulse'          => __( 'Pulse', 'blossom-studio' ),
                    'rollOut'        => __( 'Roll Out', 'blossom-studio' ),
                    'rotateOut'      => __( 'Rotate Out', 'blossom-studio' ),
                    'rubberBand'     => __( 'Rubber Band', 'blossom-studio' ),
                    'shake'          => __( 'Shake', 'blossom-studio' ),
                    ''               => __( 'Slide', 'blossom-studio' ),
                    'slideOutLeft'   => __( 'Slide Out Left', 'blossom-studio' ),
                    'slideOutRight'  => __( 'Slide Out Right', 'blossom-studio' ),
                    'slideOutUp'     => __( 'Slide Out Up', 'blossom-studio' ),
                    'slideOutDown'   => __( 'Slide Out Down', 'blossom-studio' ),
                    'swing'          => __( 'Swing', 'blossom-studio' ),
                    'tada'           => __( 'Tada', 'blossom-studio' ),
                    'zoomOut'        => __( 'Zoom Out', 'blossom-studio' ),
                    'zoomOutLeft'    => __( 'Zoom Out Left', 'blossom-studio' ),
                    'zoomOutRight'   => __( 'Zoom Out Right', 'blossom-studio' ),
                    'zoomOutUp'      => __( 'Zoom Out Up', 'blossom-studio' ),
                    'zoomOutDown'    => __( 'Zoom Out Down', 'blossom-studio' ),                    
                ),
                'active_callback' => 'blossom_studio_banner_ac'                                 
            )
        )
    );
    
    /** Slider Speed */
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default'           => 5000,
            'sanitize_callback' => 'blossom_studio_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Slider_Control( 
            $wp_customize,
            'slider_speed',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Speed', 'blossom-studio' ),
                'description' => __( 'Controls the speed of slider in miliseconds.', 'blossom-studio' ),
                'choices'     => array(
                    'min'  => 1000,
                    'max'  => 20000,
                    'step' => 500,
                ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );

    $wp_customize->add_setting(
        'button_one',
        array(
            'default'           => __( 'Get started', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'button_one',
        array(
            'label'           => __( 'Button One Label', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'button_one', array(
        'selector' => '.site-banner .banner-caption .button-wrap .btn-rm-one',
        'render_callback' => 'blossom_studio_get_banner_button_one',
    ) );
    
    /** Banner Link */
    $wp_customize->add_setting(
        'button_one_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'button_one_url',
        array(
            'label'           => __( 'Banner One Link', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'url',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );
    
    $wp_customize->add_setting(
        'button_one_tab_new',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'button_one_tab_new',
            array(
                'section'       => 'header_image',
                'label'         => __( 'Button One Open in New tab', 'blossom-studio' ),
                'description'   => __( 'Enable to open button one link in new window.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );

    $wp_customize->add_setting(
        'button_two',
        array(
            'default'           => __( 'Know More', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'button_two',
        array(
            'label'           => __( 'Button Two Label', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'button_two', array(
        'selector' => '.site-banner .banner-caption .btn-rm-two',
        'render_callback' => 'blossom_studio_get_banner_button_two',
    ) );

    $wp_customize->add_setting(
        'button_two_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'button_two_url',
        array(
            'label'           => __( 'Banner Two Link', 'blossom-studio' ),
            'section'         => 'header_image',
            'type'            => 'url',
            'active_callback' => 'blossom_studio_banner_ac'
        )
    );

    $wp_customize->add_setting(
        'button_two_tab_new',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'button_two_tab_new',
            array(
                'section'       => 'header_image',
                'label'         => __( 'Button Two Open in New tab', 'blossom-studio' ),
                'description'   => __( 'Enable to open button two link in new window.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_banner_ac'
            )
        )
    );

    /** Slider Settings Ends */  

    /** Featured Area Section */
    $wp_customize->add_section(
        'promo',
        array(
            'title'    => __( 'Featured Area Section', 'blossom-studio' ),
            'priority' => 40,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'promo_bg',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'promo_bg',
           array(
               'label'           => __( 'Choose Background', 'blossom-studio' ),
               'description'     => __( 'Choose the background image. Please use image of PNG format.', 'blossom-studio' ),
               'section'         => 'promo',
               'priority'    => -1
           )
       )
    );
    
    $wp_customize->add_setting(
        'promo_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'promo_note_text',
            array(
                'section'     => 'promo',
                'description' => __( '<hr/>Add "Text" widget For Title and description. For Boxes, add "Blossom: Image Text". The recommended image size is 259x346px.', 'blossom-studio' ),
                'priority'    => -1
            )
        )
    );

    $promo_section = $wp_customize->get_section( 'sidebar-widgets-promo' );
    if ( ! empty( $promo_section ) ) {

        $promo_section->panel     = 'frontpage_settings';
        $promo_section->priority  = 40;
        $wp_customize->get_control( 'promo_note_text' )->section = 'sidebar-widgets-promo';
        $wp_customize->get_control( 'promo_bg' )->section    = 'sidebar-widgets-promo';
    }  

    /** Promo Settings Ends */  

    /** Testimonial Section */
    $wp_customize->add_section(
        'testimonial',
        array(
            'title'    => __( 'Testimonial Section', 'blossom-studio' ),
            'priority' => 90,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'testimonial_bg',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'testimonial_bg',
           array(
               'label'           => __( 'Choose Background', 'blossom-studio' ),
               'description'     => __( 'Choose the background image for testimonial section.', 'blossom-studio' ),
               'section'         => 'promo',
               'priority'    => -1
           )
       )
    );
    
    $wp_customize->add_setting(
        'testimonial_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'testimonial_note_text',
            array(
                'section'     => 'testimonial',
                'description' => __( '<hr/>Add "Text" widget For Title and description. For testimonial, add "Blossom: Testimonial" widget for testimonial section.', 'blossom-studio' ),
                'priority'    => -1
            )
        )
    );

    $testimonial_section = $wp_customize->get_section( 'sidebar-widgets-testimonial' );
    if ( ! empty( $testimonial_section ) ) {

        $testimonial_section->panel     = 'frontpage_settings';
        $testimonial_section->priority  = 90;
        $wp_customize->get_control( 'testimonial_note_text' )->section = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_bg' )->section    = 'sidebar-widgets-testimonial';
    }  
    
    /** Testimonial Section Ends */

    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'blossom-studio' ),
            'priority' => 170,
            'panel'    => 'frontpage_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_blog_section',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'     => 'blog_section',
                'label'       => __( 'Enable Section', 'blossom-studio' ),
                'description' => __( 'Enable to show blog section.', 'blossom-studio' ),
            )
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'Latest Articles', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Title', 'blossom-studio' ),
            'type'    => 'text',
            'active_callback' => 'blossom_studio_blog_section_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector' => '.blog-section .section-header h2.section-title',
        'render_callback' => 'blossom_studio_get_blog_section_title',
    ) );

    /** Blog description */
    $wp_customize->add_setting(
        'blog_section_subtitle',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_subtitle',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Description', 'blossom-studio' ),
            'type'    => 'textarea',
            'active_callback' => 'blossom_studio_blog_section_ac',
        )
    ); 

    $wp_customize->selective_refresh->add_partial( 'blog_section_subtitle', array(
        'selector' => '.blog-section .section-header .section-desc',
        'render_callback' => 'blossom_studio_get_blog_section_subtitle',
    ) );
    
    $wp_customize->add_setting(
        'blog_btn_label',
        array(
            'default'           => __( 'View All Articles', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_btn_label',
        array(
            'label'           => __( 'Button Label', 'blossom-studio' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_blog_section_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_btn_label', array(
        'selector' => '.blog-section span.btn-blog-readmore',
        'render_callback' => 'blossom_studio_get_blog_btn_label',
    ) );

    $wp_customize->add_setting(
        'blog_section_bg',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'blog_section_bg',
           array(
               'label'           => __( 'Section Background', 'blossom-studio' ),
               'description'     => __( 'Choose the background image. Recommended image format is PNG Format.', 'blossom-studio' ),
               'section'         => 'blog_section',
               'active_callback' => 'blossom_studio_blog_section_ac',
           )
       )
    );

    /** Blog Section Ends */

    /** Shop Section */
    $wp_customize->add_section(
        'shop_section',
        array(
            'title'    => __( 'Shop Section', 'blossom-studio' ),
            'panel'    => 'frontpage_settings',
            'priority' => 180,
            'active_callback' => 'blossom_studio_is_woocommerce_activated',
        )
    );

    $wp_customize->add_setting(
        'ed_shop_section',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_shop_section',
            array(
                'section'     => 'shop_section',
                'label'       => __( 'Enable Section', 'blossom-studio' ),
                'description' => __( 'Enable to show shop section.', 'blossom-studio' ),
            )
        )
    );

    /** Shop Title  */
    $wp_customize->add_setting(
        'product_title',
        array(
            'default'           => __( 'Shop My Collections', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'product_title',
        array(
            'label'           => __( 'Section Title', 'blossom-studio' ),
            'description'     => __( 'Add title for shop section.', 'blossom-studio' ),
            'section'         => 'shop_section',
            'active_callback' => 'blossom_studio_shop_section_ac',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'product_title', array(
        'selector' => '.shop-section .container h2.section-title',
        'render_callback' => 'blossom_studio_get_product_title',
    ) );

    /** Shop Title  */
    $wp_customize->add_setting(
        'product_subtitle',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'product_subtitle',
        array(
            'label'           => __( 'Section Subtitle', 'blossom-studio' ),
            'description'     => __( 'Add description for shop section.', 'blossom-studio' ),
            'section'         => 'shop_section',
            'type'            => 'text',
            'active_callback' => 'blossom_studio_shop_section_ac',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'product_subtitle', array(
        'selector' => '.shop-section .container .section-desc',
        'render_callback' => 'blossom_studio_get_product_subtitle',
    ) );

    /** Popular Products View All  */
    $wp_customize->add_setting(
        'product_view_all',
        array(
            'default'           => __( 'Go To Shop', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );
    
    $wp_customize->add_control(
        'product_view_all',
        array(
            'label'           => __( 'Button Label', 'blossom-studio' ),
            'description'     => __( 'Add view more label for shop section.', 'blossom-studio' ),
            'section'         => 'shop_section',
            'active_callback' => 'blossom_studio_shop_section_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'product_view_all', array(
        'selector' => '.shop-section .button-wrap .btn-shop-readmore',
        'render_callback' => 'blossom_studio_get_product_view_all',
    ) );

    /** Product One */
    $wp_customize->add_setting(
        'shop_section_one',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'shop_section_one',
            array(
                'label'           => __( 'Select Product One', 'blossom-studio' ),
                'section'         => 'shop_section',
                'choices'         => blossom_studio_get_posts( 'product' ),
                'active_callback' => 'blossom_studio_shop_section_ac',  
            )
        )
    );
    
    /** Product Two */
    $wp_customize->add_setting(
        'shop_section_two',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'shop_section_two',
            array(
                'label'           => __( 'Select Product Two', 'blossom-studio' ),
                'section'         => 'shop_section',
                'choices'         => blossom_studio_get_posts( 'product' ), 
                'active_callback' => 'blossom_studio_shop_section_ac',
            )
        )
    );
    
    /** Product Three */
    $wp_customize->add_setting(
        'shop_section_three',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'shop_section_three',
            array(
                'label'           => __( 'Select Product Three', 'blossom-studio' ),
                'section'         => 'shop_section',
                'choices'         => blossom_studio_get_posts( 'product' ), 
                'active_callback' => 'blossom_studio_shop_section_ac', 
            )
        )
    );

    /** Product Four */
    $wp_customize->add_setting(
        'shop_section_four',
        array(
            'default'           => '',
            'sanitize_callback' => 'blossom_studio_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Studio_Select_Control(
            $wp_customize,
            'shop_section_four',
            array(
                'label'           => __( 'Select Product Four', 'blossom-studio' ),
                'section'         => 'shop_section',
                'choices'         => blossom_studio_get_posts( 'product' ),  
                'active_callback' => 'blossom_studio_shop_section_ac',
            )
        )
    );

    /** Shop Section Ends */  
      
}
add_action( 'customize_register', 'blossom_studio_customize_register_frontpage' );