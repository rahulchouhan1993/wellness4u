<?php
/**
 * VW Health Coaching Theme Customizer
 *
 * @package VW Health Coaching
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_health_coaching_custom_controls() {

    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_health_coaching_custom_controls' );

function vw_health_coaching_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'vw_health_coaching_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'vw_health_coaching_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$VWHealthCoachingParentPanel = new VW_Health_Coaching_WP_Customize_Panel( $wp_customize, 'vw_health_coaching_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__( 'VW Settings', 'vw-health-coaching' ),
		'priority' => 10,
	));

	$wp_customize->add_section( 'vw_health_coaching_left_right', array(
    	'title'      => esc_html__( 'General Settings', 'vw-health-coaching' ),
		'priority'   => 30,
		'panel' => 'vw_health_coaching_panel_id'
	) );

	$wp_customize->add_setting('vw_health_coaching_width_option',array(
        'default' => 'Full Width',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Health_Coaching_Image_Radio_Control($wp_customize, 'vw_health_coaching_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-health-coaching'),
        'description' => __('Here you can change the width layout of Website.','vw-health-coaching'),
        'section' => 'vw_health_coaching_left_right',
        'choices' => array(
            'Full Width' => esc_url(get_template_directory_uri()).'/assets/images/full-width.png',
            'Wide Width' => esc_url(get_template_directory_uri()).'/assets/images/wide-width.png',
            'Boxed' => esc_url(get_template_directory_uri()).'/assets/images/boxed-width.png',
    ))));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('vw_health_coaching_theme_options',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'	        
	) );
	$wp_customize->add_control('vw_health_coaching_theme_options', array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-health-coaching'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-health-coaching'),
        'section' => 'vw_health_coaching_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-health-coaching'),
            'Right Sidebar' => __('Right Sidebar','vw-health-coaching'),
            'One Column' => __('One Column','vw-health-coaching'),
            'Three Columns' => __('Three Columns','vw-health-coaching'),
            'Four Columns' => __('Four Columns','vw-health-coaching'),
            'Grid Layout' => __('Grid Layout','vw-health-coaching')
        ),
	));

	$wp_customize->add_setting('vw_health_coaching_page_layout',array(
        'default' => 'One Column',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control('vw_health_coaching_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-health-coaching'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-health-coaching'),
        'section' => 'vw_health_coaching_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-health-coaching'),
            'Right Sidebar' => __('Right Sidebar','vw-health-coaching'),
            'One Column' => __('One Column','vw-health-coaching')
        ),
	) );

	//Pre-Loader
	$wp_customize->add_setting( 'vw_health_coaching_loader_enable',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','vw-health-coaching' ),
        'section' => 'vw_health_coaching_left_right'
    )));

	$wp_customize->add_setting('vw_health_coaching_preloader_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_health_coaching_preloader_bg_color', array(
		'label'    => __('Pre-Loader Background Color', 'vw-health-coaching'),
		'section'  => 'vw_health_coaching_left_right',
	)));

	$wp_customize->add_setting('vw_health_coaching_preloader_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_health_coaching_preloader_border_color', array(
		'label'    => __('Pre-Loader Border Color', 'vw-health-coaching'),
		'section'  => 'vw_health_coaching_left_right',
	)));

	//Topbar
	$wp_customize->add_section( 'vw_health_coaching_topbar', array(
    	'title'      => __( 'Topbar Settings', 'vw-health-coaching' ),
		'priority'   => 30,
		'panel' => 'vw_health_coaching_panel_id'
	) );

	$wp_customize->add_setting( 'vw_health_coaching_topbar_hide_show',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_topbar_hide_show',
       array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-health-coaching' ),
      'section' => 'vw_health_coaching_topbar'
    )));

    $wp_customize->add_setting('vw_health_coaching_topbar_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_topbar_padding_top_bottom',array(
		'label'	=> __('Topbar Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

    //Sticky Header
	$wp_customize->add_setting( 'vw_health_coaching_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','vw-health-coaching' ),
        'section' => 'vw_health_coaching_topbar'
    )));

    $wp_customize->add_setting('vw_health_coaching_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_navigation_menu_font_size',array(
		'label'	=> __('Menus Font Size','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_navigation_menu_font_weight',array(
        'default' => 'Default',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control('vw_health_coaching_navigation_menu_font_weight',array(
        'type' => 'select',
        'label' => __('Menus Font Weight','vw-health-coaching'),
        'section' => 'vw_health_coaching_topbar',
        'choices' => array(
        	'Default' => __('Default','vw-health-coaching'),
            'Normal' => __('Normal','vw-health-coaching')
        ),
	) );

	$wp_customize->add_setting( 'vw_health_coaching_search_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_search_hide_show', array(
		'label' => esc_html__( 'Show / Hide Search','vw-health-coaching' ),
		'section' => 'vw_health_coaching_topbar'
    )));

    $wp_customize->add_setting('vw_health_coaching_search_icon',array(
		'default'	=> 'fas fa-search',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_search_icon',array(
		'label'	=> __('Add Search Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_topbar',
		'setting'	=> 'vw_health_coaching_search_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_search_close_icon',array(
		'default'	=> 'fa fa-window-close',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_search_close_icon',array(
		'label'	=> __('Add Search Close Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_topbar',
		'setting'	=> 'vw_health_coaching_search_close_icon',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('vw_health_coaching_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_search_font_size',array(
		'label'	=> __('Search Font Size','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_health_coaching_phone', array( 
		'selector' => '#topbar span', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_phone', 
	));

    $wp_customize->add_setting('vw_health_coaching_phone_icon',array(
		'default'	=> 'fas fa-phone',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_phone_icon',array(
		'label'	=> __('Add Phone No. Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_topbar',
		'setting'	=> 'vw_health_coaching_phone_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_phone',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_health_coaching_sanitize_phone_number'
	));	
	$wp_customize->add_control('vw_health_coaching_phone',array(
		'label'	=> __('Add Phone no.','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '+00 123 456 7890', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_email_icon',array(
		'default'	=> 'fas fa-envelope',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_email_icon',array(
		'label'	=> __('Add Email Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_topbar',
		'setting'	=> 'vw_health_coaching_email_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));	
	$wp_customize->add_control('vw_health_coaching_email_address',array(
		'label'	=> __('Add Email Address','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'support@example.com', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_timing_icon',array(
		'default'	=> 'far fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_timing_icon',array(
		'label'	=> __('Add Timing Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_topbar',
		'setting'	=> 'vw_health_coaching_timing_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_timing',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_health_coaching_timing',array(
		'label'	=> __('Add Timing','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Mon to Fri 8:00AM - 2:00PM', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_topbar',
		'type'=> 'text'
	));	
    
	//Slider
	$wp_customize->add_section( 'vw_health_coaching_slidersettings' , array(
    	'title'      => __( 'Slider Section', 'vw-health-coaching' ),
		'priority'   => null,
		'panel' => 'vw_health_coaching_panel_id'
	) );

	$wp_customize->add_setting( 'vw_health_coaching_slider_hide_show',array(
		'default' => 0,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_slider_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider','vw-health-coaching' ),
		'section' => 'vw_health_coaching_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_health_coaching_slider_hide_show',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_slider_hide_show',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'vw_health_coaching_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_health_coaching_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'vw_health_coaching_slider_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'vw-health-coaching' ),
			'description' => __('Slider image size (1500 x 590)','vw-health-coaching'),
			'section'  => 'vw_health_coaching_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting( 'vw_health_coaching_slider_title_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_slider_title_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Title','vw-health-coaching' ),
		'section' => 'vw_health_coaching_slidersettings'
    )));

	$wp_customize->add_setting( 'vw_health_coaching_slider_content_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_slider_content_hide_show',array(
		'label' => esc_html__( 'Show / Hide Slider Content','vw-health-coaching' ),
		'section' => 'vw_health_coaching_slidersettings'
    )));

	$wp_customize->add_setting('vw_health_coaching_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_sliders_button_icon',array(
		'default'	=> 'fa fa-angle-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_sliders_button_icon',array(
		'label'	=> __('Add Slider Button Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_slidersettings',
		'setting'	=> 'vw_health_coaching_sliders_button_icon',
		'type'		=> 'icon'
	)));

	//content layout
	$wp_customize->add_setting('vw_health_coaching_slider_content_option',array(
        'default' => 'Left',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Health_Coaching_Image_Radio_Control($wp_customize, 'vw_health_coaching_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-health-coaching'),
        'section' => 'vw_health_coaching_slidersettings',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/slider-content1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/slider-content2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/slider-content3.png',
    ))));

    //Slider content padding
    $wp_customize->add_setting('vw_health_coaching_slider_content_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_slider_content_padding_top_bottom',array(
		'label'	=> __('Slider Content Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in %. Example:20%','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_slider_content_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_slider_content_padding_left_right',array(
		'label'	=> __('Slider Content Padding Left Right','vw-health-coaching'),
		'description'	=> __('Enter a value in %. Example:20%','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '50%', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_slidersettings',
		'type'=> 'text'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'vw_health_coaching_slider_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_health_coaching_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Slider height
	$wp_customize->add_setting('vw_health_coaching_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_slider_height',array(
		'label'	=> __('Slider Height','vw-health-coaching'),
		'description'	=> __('Specify the slider height (px).','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_slider_speed', array(
		'default'  => 4000,
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'vw_health_coaching_slider_speed', array(
		'label' => esc_html__('Slider Transition Speed','vw-health-coaching'),
		'section' => 'vw_health_coaching_slidersettings',
		'type'  => 'number',
	) );

	//Services
	$wp_customize->add_section( 'vw_health_coaching_service_section' , array(
    	'title'      => __( 'Services Section', 'vw-health-coaching' ),
		'priority'   => null,
		'panel' => 'vw_health_coaching_panel_id'
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_health_coaching_services', array( 
		'selector' => '.catgory-box h2', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_services',
	));

	$categories = get_categories();
	$cat_post = array();
	$cat_post[]= 'select';
	$i = 0;	
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('vw_health_coaching_services',array(
		'default'	=> 'select',
		'sanitize_callback' => 'vw_health_coaching_sanitize_choices',
	));
	$wp_customize->add_control('vw_health_coaching_services',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display services','vw-health-coaching'),
		'description' => __('Image Size (50 x 45)','vw-health-coaching'),
		'section' => 'vw_health_coaching_service_section',
	));

	//Services excerpt
	$wp_customize->add_setting( 'vw_health_coaching_services_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_services_excerpt_number', array(
		'label'       => esc_html__( 'Services Excerpt length','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_service_section',
		'type'        => 'range',
		'settings'    => 'vw_health_coaching_services_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_health_coaching_services_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_services_button_text',array(
		'label'	=> __('Add Services Button Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_service_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_services_button_icon',array(
		'default'	=> 'fa fa-angle-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_services_button_icon',array(
		'label'	=> __('Add Services Button Hover Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_service_section',
		'setting'	=> 'vw_health_coaching_services_button_icon',
		'type'		=> 'icon'
	)));

	//Blog Post
	$wp_customize->add_panel( $VWHealthCoachingParentPanel );

	$BlogPostParentPanel = new VW_Health_Coaching_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'vw-health-coaching' ),
		'panel' => 'vw_health_coaching_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_health_coaching_post_settings', array(
		'title' => __( 'Post Settings', 'vw-health-coaching' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_health_coaching_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_toggle_postdate', 
	));

	$wp_customize->add_setting( 'vw_health_coaching_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','vw-health-coaching' ),
        'section' => 'vw_health_coaching_post_settings'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_toggle_author',array(
		'label' => esc_html__( 'Author','vw-health-coaching' ),
		'section' => 'vw_health_coaching_post_settings'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_toggle_comments',array(
		'label' => esc_html__( 'Comments','vw-health-coaching' ),
		'section' => 'vw_health_coaching_post_settings'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_toggle_time',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_toggle_time',array(
		'label' => esc_html__( 'Time','vw-health-coaching' ),
		'section' => 'vw_health_coaching_post_settings'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_featured_image_hide_show',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_featured_image_hide_show', array(
		'label' => esc_html__( 'Featured Image','vw-health-coaching' ),
		'section' => 'vw_health_coaching_post_settings'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_featured_image_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_featured_image_border_radius', array(
		'label'       => esc_html__( 'Featured Image Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'vw_health_coaching_featured_image_box_shadow', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_featured_image_box_shadow', array(
		'label'       => esc_html__( 'Featured Image Box Shadow','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_post_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    $wp_customize->add_setting( 'vw_health_coaching_excerpt_number', array(
		'default'              => 30,
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_health_coaching_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_health_coaching_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-health-coaching'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-health-coaching'),
		'section'=> 'vw_health_coaching_post_settings',
		'type'=> 'text'
	));

	//Blog layout
    $wp_customize->add_setting('vw_health_coaching_blog_layout_option',array(
        'default' => 'Default',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Health_Coaching_Image_Radio_Control($wp_customize, 'vw_health_coaching_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','vw-health-coaching'),
        'section' => 'vw_health_coaching_post_settings',
        'choices' => array(
            'Default' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout2.png',
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('vw_health_coaching_excerpt_settings',array(
        'default' => 'Excerpt',
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control('vw_health_coaching_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','vw-health-coaching'),
        'section' => 'vw_health_coaching_post_settings',
        'choices' => array(
        	'Content' => __('Content','vw-health-coaching'),
            'Excerpt' => __('Excerpt','vw-health-coaching'),
            'No Content' => __('No Content','vw-health-coaching')
        ),
	) );

	$wp_customize->add_setting('vw_health_coaching_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_post_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_blog_pagination_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_blog_pagination_hide_show',array(
      'label' => esc_html__( 'Show / Hide Blog Pagination','vw-health-coaching' ),
      'section' => 'vw_health_coaching_post_settings'
    )));

	$wp_customize->add_setting( 'vw_health_coaching_blog_pagination_type', array(
        'default'			=> 'blog-page-numbers',
        'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'vw_health_coaching_blog_pagination_type', array(
        'section' => 'vw_health_coaching_post_settings',
        'type' => 'select',
        'label' => __( 'Blog Pagination', 'vw-health-coaching' ),
        'choices'		=> array(
            'blog-page-numbers'  => __( 'Numeric', 'vw-health-coaching' ),
            'next-prev' => __( 'Older Posts/Newer Posts', 'vw-health-coaching' ),
    )));

    // Button Settings
	$wp_customize->add_section( 'vw_health_coaching_button_settings', array(
		'title' => __( 'Button Settings', 'vw-health-coaching' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('vw_health_coaching_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_button_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_health_coaching_button_text', array( 
		'selector' => '.post-main-box a.view-more', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_button_text', 
	));

	$wp_customize->add_setting('vw_health_coaching_button_text',array(
		'default'=> esc_html__( 'READ MORE', 'vw-health-coaching' ),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_button_text',array(
		'label'	=> __('Add Button Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_blog_button_icon',array(
		'default'	=> 'fa fa-angle-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_blog_button_icon',array(
		'label'	=> __('Add Button Hover Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_button_settings',
		'setting'	=> 'vw_health_coaching_blog_button_icon',
		'type'		=> 'icon'
	)));

	// Related Post Settings
	$wp_customize->add_section( 'vw_health_coaching_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'vw-health-coaching' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_health_coaching_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_related_post_title', 
	));

    $wp_customize->add_setting( 'vw_health_coaching_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_related_post',array(
		'label' => esc_html__( 'Related Post','vw-health-coaching' ),
		'section' => 'vw_health_coaching_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_health_coaching_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_related_post_title',array(
		'label'	=> __('Add Related Post Title','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_health_coaching_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'vw_health_coaching_sanitize_float'
	));
	$wp_customize->add_control('vw_health_coaching_related_posts_count',array(
		'label'	=> __('Add Related Post Count','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_related_posts_settings',
		'type'=> 'number'
	));

	// Single Posts Settings
	$wp_customize->add_section( 'vw_health_coaching_single_blog_settings', array(
		'title' => __( 'Single Post Settings', 'vw-health-coaching' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('vw_health_coaching_single_post_meta_field_separator',array(
		'default'=> '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_single_post_meta_field_separator',array(
		'label'	=> __('Add Meta Separator','vw-health-coaching'),
		'description' => __('Add the seperator for meta box. Example: "|", "/", etc.','vw-health-coaching'),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_toggle_tags', array(
		'label' => esc_html__( 'Tags','vw-health-coaching' ),
		'section' => 'vw_health_coaching_single_blog_settings'
    )));

	$wp_customize->add_setting( 'vw_health_coaching_single_blog_post_navigation_show_hide',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_single_blog_post_navigation_show_hide', array(
		'label' => esc_html__( 'Post Navigation','vw-health-coaching' ),
		'section' => 'vw_health_coaching_single_blog_settings'
    )));

	//navigation text
	$wp_customize->add_setting('vw_health_coaching_single_blog_prev_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_single_blog_prev_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'PREVIOUS', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_single_blog_next_navigation_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_single_blog_next_navigation_text',array(
		'label'	=> __('Post Navigation Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'NEXT', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_single_blog_comment_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_single_blog_comment_title',array(
		'label'	=> __('Add Comment Title','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Leave a Reply', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_single_blog_comment_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_single_blog_comment_button_text',array(
		'label'	=> __('Add Comment Button Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_single_blog_comment_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_single_blog_comment_width',array(
		'label'	=> __('Comment Form Width','vw-health-coaching'),
		'description'	=> __('Enter a value in %. Example:50%','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '100%', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_single_blog_settings',
		'type'=> 'text'
	));

    //404 Page Setting
	$wp_customize->add_section('vw_health_coaching_404_page',array(
		'title'	=> __('404 Page Settings','vw-health-coaching'),
		'panel' => 'vw_health_coaching_panel_id',
	));	

	$wp_customize->add_setting('vw_health_coaching_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_404_page_title',array(
		'label'	=> __('Add Title','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_404_page_content',array(
		'label'	=> __('Add Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_404_page_button_text',array(
		'label'	=> __('Add Button Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Return to the home page', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_404_page',
		'type'=> 'text'
	));

	//No Result Page Setting
	$wp_customize->add_section('vw_health_coaching_no_results_page',array(
		'title'	=> __('No Results Page Settings','vw-health-coaching'),
		'panel' => 'vw_health_coaching_panel_id',
	));	

	$wp_customize->add_setting('vw_health_coaching_no_results_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_no_results_page_title',array(
		'label'	=> __('Add Title','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Nothing Found', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_no_results_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_no_results_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_health_coaching_no_results_page_content',array(
		'label'	=> __('Add Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_no_results_page',
		'type'=> 'text'
	));

	//Social Icon Setting
	$wp_customize->add_section('vw_health_coaching_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','vw-health-coaching'),
		'panel' => 'vw_health_coaching_panel_id',
	));	

	$wp_customize->add_setting('vw_health_coaching_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_social_icon_padding',array(
		'label'	=> __('Icon Padding','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_social_icon_width',array(
		'label'	=> __('Icon Width','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_social_icon_height',array(
		'label'	=> __('Icon Height','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_social_icon_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_health_coaching_responsive_media',array(
		'title'	=> __('Responsive Media','vw-health-coaching'),
		'panel' => 'vw_health_coaching_panel_id',
	));

	$wp_customize->add_setting( 'vw_health_coaching_resp_topbar_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_resp_topbar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-health-coaching' ),
      'section' => 'vw_health_coaching_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','vw-health-coaching' ),
      'section' => 'vw_health_coaching_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-health-coaching' ),
      'section' => 'vw_health_coaching_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-health-coaching' ),
      'section' => 'vw_health_coaching_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_health_coaching_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-health-coaching' ),
      'section' => 'vw_health_coaching_responsive_media'
    )));

     $wp_customize->add_setting('vw_health_coaching_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_responsive_media',
		'setting'	=> 'vw_health_coaching_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_res_close_menu_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_res_close_menu_icon',array(
		'label'	=> __('Add Close Menu Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_responsive_media',
		'setting'	=> 'vw_health_coaching_res_close_menu_icon',
		'type'		=> 'icon'
	)));

	//Footer Text
	$wp_customize->add_section('vw_health_coaching_footer',array(
		'title'	=> __('Footer','vw-health-coaching'),
		'description'=> __('This section will appear in the footer','vw-health-coaching'),
		'panel' => 'vw_health_coaching_panel_id',
	));	

	$wp_customize->add_setting('vw_health_coaching_footer_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'vw_health_coaching_footer_background_color', array(
		'label'    => __('Footer Background Color', 'vw-health-coaching'),
		'section'  => 'vw_health_coaching_footer',
	)));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_health_coaching_footer_text', array( 
		'selector' => '#footer-2 .copyright p', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_footer_text', 
	));
	
	$wp_customize->add_setting('vw_health_coaching_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_health_coaching_footer_text',array(
		'label'	=> __('Copyright Text','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2018, .....', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'setting'=> 'vw_health_coaching_footer_text',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('vw_health_coaching_copyright_alingment',array(
        'default' => 'center',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Health_Coaching_Image_Radio_Control($wp_customize, 'vw_health_coaching_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','vw-health-coaching'),
        'section' => 'vw_health_coaching_footer',
        'settings' => 'vw_health_coaching_copyright_alingment',
        'choices' => array(
            'left' => esc_url(get_template_directory_uri()).'/assets/images/copyright1.png',
            'center' => esc_url(get_template_directory_uri()).'/assets/images/copyright2.png',
            'right' => esc_url(get_template_directory_uri()).'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('vw_health_coaching_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','vw-health-coaching' ),
      	'section' => 'vw_health_coaching_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_health_coaching_scroll_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_scroll_top_icon', 
	));

    $wp_customize->add_setting('vw_health_coaching_scroll_top_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Health_Coaching_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_health_coaching_scroll_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','vw-health-coaching'),
		'transport' => 'refresh',
		'section'	=> 'vw_health_coaching_footer',
		'setting'	=> 'vw_health_coaching_scroll_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_health_coaching_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_scroll_to_top_width',array(
		'label'	=> __('Icon Width','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_scroll_to_top_height',array(
		'label'	=> __('Icon Height','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_scroll_to_top_border_radius', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_health_coaching_scroll_top_alignment',array(
        'default' => 'Right',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Health_Coaching_Image_Radio_Control($wp_customize, 'vw_health_coaching_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-health-coaching'),
        'section' => 'vw_health_coaching_footer',
        'settings' => 'vw_health_coaching_scroll_top_alignment',
        'choices' => array(
            'Left' => esc_url(get_template_directory_uri()).'/assets/images/layout1.png',
            'Center' => esc_url(get_template_directory_uri()).'/assets/images/layout2.png',
            'Right' => esc_url(get_template_directory_uri()).'/assets/images/layout3.png'
    ))));

    //Woocommerce settings
	$wp_customize->add_section('vw_health_coaching_woocommerce_section', array(
		'title'    => __('WooCommerce Layout', 'vw-health-coaching'),
		'priority' => null,
		'panel'    => 'woocommerce',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_health_coaching_woocommerce_shop_page_sidebar', array( 'selector' => '.post-type-archive-product #sidebar', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_woocommerce_shop_page_sidebar', ) );

	//Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_health_coaching_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','vw-health-coaching' ),
		'section' => 'vw_health_coaching_woocommerce_section'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_health_coaching_woocommerce_single_product_page_sidebar', array( 'selector' => '.single-product #sidebar', 
		'render_callback' => 'vw_health_coaching_customize_partial_vw_health_coaching_woocommerce_single_product_page_sidebar', ) );

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_health_coaching_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_health_coaching_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Health_Coaching_Toggle_Switch_Custom_Control( $wp_customize, 'vw_health_coaching_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','vw-health-coaching' ),
		'section' => 'vw_health_coaching_woocommerce_section'
    )));

    //Products per page
    $wp_customize->add_setting('vw_health_coaching_products_per_page',array(
		'default'=> 9,
		'sanitize_callback'	=> 'vw_health_coaching_sanitize_float'
	));
	$wp_customize->add_control('vw_health_coaching_products_per_page',array(
		'label'	=> __('Products Per Page','vw-health-coaching'),
		'description' => __('Display on shop page','vw-health-coaching'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'number',
	));

    //Products per row
    $wp_customize->add_setting('vw_health_coaching_products_per_row',array(
		'default'=> 3,
		'sanitize_callback'	=> 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control('vw_health_coaching_products_per_row',array(
		'label'	=> __('Products Per Row','vw-health-coaching'),
		'description' => __('Display on shop page','vw-health-coaching'),
		'choices' => array(
            2 => 2,
			3 => 3,
			4 => 4,
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'select',
	));

	//Products padding
	$wp_customize->add_setting('vw_health_coaching_products_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_products_padding_top_bottom',array(
		'label'	=> __('Products Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_products_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_products_padding_left_right',array(
		'label'	=> __('Products Padding Left Right','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	//Products box shadow
	$wp_customize->add_setting( 'vw_health_coaching_products_box_shadow', array(
		'default'              => '',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_products_box_shadow', array(
		'label'       => esc_html__( 'Products Box Shadow','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products border radius
    $wp_customize->add_setting( 'vw_health_coaching_products_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_products_border_radius', array(
		'label'       => esc_html__( 'Products Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_health_coaching_products_btn_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_products_btn_padding_top_bottom',array(
		'label'	=> __('Products Button Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_products_btn_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_products_btn_padding_left_right',array(
		'label'	=> __('Products Button Padding Left Right','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_products_button_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_products_button_border_radius', array(
		'label'       => esc_html__( 'Products Button Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Products Sale Badge
	$wp_customize->add_setting('vw_health_coaching_woocommerce_sale_position',array(
        'default' => 'right',
        'sanitize_callback' => 'vw_health_coaching_sanitize_choices'
	));
	$wp_customize->add_control('vw_health_coaching_woocommerce_sale_position',array(
        'type' => 'select',
        'label' => __('Sale Badge Position','vw-health-coaching'),
        'section' => 'vw_health_coaching_woocommerce_section',
        'choices' => array(
            'left' => __('Left','vw-health-coaching'),
            'right' => __('Right','vw-health-coaching'),
        ),
	) );

	$wp_customize->add_setting('vw_health_coaching_woocommerce_sale_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_woocommerce_sale_font_size',array(
		'label'	=> __('Sale Font Size','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_woocommerce_sale_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_woocommerce_sale_padding_top_bottom',array(
		'label'	=> __('Sale Padding Top Bottom','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_health_coaching_woocommerce_sale_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_health_coaching_woocommerce_sale_padding_left_right',array(
		'label'	=> __('Sale Padding Left Right','vw-health-coaching'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-health-coaching'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-health-coaching' ),
        ),
		'section'=> 'vw_health_coaching_woocommerce_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_health_coaching_woocommerce_sale_border_radius', array(
		'default'              => '0',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'vw_health_coaching_sanitize_number_range'
	) );
	$wp_customize->add_control( 'vw_health_coaching_woocommerce_sale_border_radius', array(
		'label'       => esc_html__( 'Sale Border Radius','vw-health-coaching' ),
		'section'     => 'vw_health_coaching_woocommerce_section',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

    // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Health_Coaching_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Health_Coaching_WP_Customize_Section' );
}

add_action( 'customize_register', 'vw_health_coaching_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Health_Coaching_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_health_coaching_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Health_Coaching_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'vw_health_coaching_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function vw_health_coaching_customize_controls_scripts() {
  wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_health_coaching_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Health_Coaching_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Health_Coaching_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Health_Coaching_Customize_Section_Pro($manager,'vw_health_coaching_upgrade_pro_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW HEALTH COACHING', 'vw-health-coaching' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-health-coaching' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/health-coaching-wordpress-theme/'),
		)));

		// Register sections.
		$manager->add_section(new VW_Health_Coaching_Customize_Section_Pro($manager,'vw_health_coaching_get_started_link',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENTATION', 'vw-health-coaching' ),
			'pro_text' => esc_html__( 'DOCS', 'vw-health-coaching' ),
			'pro_url'  => admin_url('themes.php?page=vw_health_coaching_guide'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-health-coaching-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-health-coaching-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Health_Coaching_Customize::get_instance();