<?php
/**
 * General Settings
 *
 * @package Blossom_Studio
 */

function blossom_studio_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'blossom-studio' ),
            'description' => __( 'Customize Header, Social, Sharing, SEO, Post/Page, Newsletter, Performance and Miscellaneous settings.', 'blossom-studio' ),
        ) 
    );

    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'blossom-studio' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_header_search', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_header_search',
            array(
                'section'     => 'header_settings',
                'label'       => __( 'Enable Header Search', 'blossom-studio' ),
                'description' => __( 'Enable to show Search button in header.', 'blossom-studio' ),
            )
        )
    );
    
    /** Shopping Cart */
    $wp_customize->add_setting( 
        'ed_shopping_cart', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_shopping_cart',
            array(
                'section'         => 'header_settings',
                'label'           => __( 'Shopping Cart', 'blossom-studio' ),
                'description'     => __( 'Enable to show Shopping cart in the header.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_is_woocommerce_activated'
            )
        )
    );
        
    $wp_customize->add_setting(
        'hr_header1',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'hr_header1',
            array(
                'section'     => 'header_settings',
                'description' => '<hr/>',
            )
        )
    ); 

    /** Phone */
    $wp_customize->add_setting(
        'phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'phone',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Phone', 'blossom-studio' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'phone', array(
        'selector' => '.site-header .header-block span.btn-get-phone',
        'render_callback' => 'blossom_studio_get_phone',
    ) );

    /** Email */
    $wp_customize->add_setting(
        'email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'email',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Email', 'blossom-studio' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'email', array(
        'selector' => '.site-header .header-block span.btn-get-email',
        'render_callback' => 'blossom_studio_get_email',
    ) );

    $wp_customize->add_setting(
        'hr_header2',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'hr_header2',
            array(
                'section'     => 'header_settings',
                'description' => '<hr/>',
            )
        )
    ); 

    $wp_customize->add_setting(
        'header_contact_button',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'header_contact_button',
        array(
            'label'         => __( 'Header Button Label', 'blossom-studio' ),
            'section'       => 'header_settings',
            'type'          => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'header_contact_button', array(
        'selector' => '.site-header .button-wrap span.btn-header-contact',
        'render_callback' => 'blossom_studio_get_header_contact_button',
    ) );

    $wp_customize->add_setting(
        'header_contact_url',
        array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw', 
        )
    );
    
    $wp_customize->add_control(
        'header_contact_url',
        array(
            'label'     => __( 'Header Button URL', 'blossom-studio' ),
            'section'   => 'header_settings',
            'type'      => 'url',
        )
    );
    
    $wp_customize->add_setting(
        'header_settings_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'header_settings_text',
            array(
                'section'     => 'header_settings',
                'description' => sprintf( __( '%1$sClick here%2$s to select the header layout.', 'blossom-studio' ), '<span class="text-inner-link header_settings_text">', '</span>' ),
            )
        )
    );

    /** Header Settings Ends */

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'blossom-studio' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'       => __( 'Enable Social Links', 'blossom-studio' ),
                'description' => __( 'Enable to show social links at header.', 'blossom-studio' ),
            )
        )
    );
    
    $wp_customize->add_setting( 
        new Blossom_Studio_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Blossom_Studio_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',               
                'label'   => __( 'Social Links', 'blossom-studio' ),
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'blossom-studio' ),
                        'description' => __( 'Example: fab fa-facebook-f', 'blossom-studio' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'blossom-studio' ),
                        'description' => __( 'Example: https://facebook.com', 'blossom-studio' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'blossom-studio' ),
                    'field' => 'link'
                )                        
            )
        )
    );
    /** Social Media Settings Ends */

    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'blossom-studio' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Last Update Post Date', 'blossom-studio' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'blossom-studio' ),
            )
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'blossom-studio' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'blossom-studio' ),
            )
        )
    );
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'blossom-studio' ),
        )
    );  
    /** SEO Settings Ends */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'blossom-studio' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );
    
    /** Prefix Archive Page */
    $wp_customize->add_setting( 
        'ed_prefix_archive', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Prefix in Archive Page', 'blossom-studio' ),
                'description' => __( 'Enable to hide prefix in archive page.', 'blossom-studio' ),
            )
        )
    );
    
    /** Blog Post Image Crop */
    $wp_customize->add_setting( 
        'ed_crop_blog', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_crop_blog',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Blog Post Image Crop', 'blossom-studio' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in home, archive and search posts.', 'blossom-studio' ),
            )
        )
    );

    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Enable Blog Excerpt', 'blossom-studio' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'blossom-studio' ),
            )
        )
    );
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 55,
            'sanitize_callback' => 'blossom_studio_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Slider_Control( 
            $wp_customize,
            'excerpt_length',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Excerpt Length', 'blossom-studio' ),
                'description' => __( 'Automatically generated excerpt length (in words).', 'blossom-studio' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 5,
                )                 
            )
        )
    );
    
    $wp_customize->add_setting(
        'blog_main_title',
        array(
            'default'           => __( 'From My Blog', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'blog_main_title',
        array(
            'label'   => __( 'Blog Title', 'blossom-studio' ),
            'section' => 'post_page_settings',
            'type'    => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_main_title', array(
        'selector' => '.blog .page-header .page-title',
        'render_callback' => 'blossom_studio_get_blog_main_title',
    ) );

    $wp_customize->add_setting(
        'blog_main_content',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'blog_main_content',
        array(
            'label'   => __( 'Blog Description', 'blossom-studio' ),
            'section' => 'post_page_settings',
            'type'    => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'blog_main_content', array(
        'selector' => '.blog .page-header .page-content',
        'render_callback' => 'blossom_studio_get_blog_main_content',
    ) );
    
    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Note_Control( 
            $wp_customize,
            'post_note_text',
            array(
                'section'     => 'post_page_settings',
                'description' => sprintf( __( '%s These options affect your individual posts.', 'blossom-studio' ), '<hr/>' ),
            )
        )
    );

    /** Single Post Image Crop */
    $wp_customize->add_setting( 
        'ed_crop_single', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_crop_single',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Single Post Image Crop', 'blossom-studio' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in single post.', 'blossom-studio' ),
            )
        )
    );
    
    /** Hide Author Section */
    $wp_customize->add_setting( 
        'ed_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Author Section', 'blossom-studio' ),
                'description' => __( 'Enable to hide author section.', 'blossom-studio' ),
            )
        )
    );
    
    /** Author Section title */
    $wp_customize->add_setting(
        'author_title',
        array(
            'default'           => __( 'About the Author', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'author_title',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Author Section Title', 'blossom-studio' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'author_title', array(
        'selector' => '.author-section .subtitle',
        'render_callback' => 'blossom_studio_get_author_title',
    ) );

    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Related Posts', 'blossom-studio' ),
                'description' => __( 'Enable to show related posts in single page.', 'blossom-studio' ),
            )
        )
    );
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'You May Also Like', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Posts Section Title', 'blossom-studio' ),
            'active_callback' => 'blossom_studio_post_page_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.additional-post .post-title',
        'render_callback' => 'blossom_studio_get_related_title',
    ) );
    
    $wp_customize->add_setting(
        'related_portfolio_title',
        array(
            'default'           => __( 'Related Projects', 'blossom-studio' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_portfolio_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Portfolio Title', 'blossom-studio' ),
        )
    );

    /** Comments */
    $wp_customize->add_setting(
        'ed_comments',
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Comments', 'blossom-studio' ),
                'description' => __( 'Enable to show Comments in Single Post/Page.', 'blossom-studio' ),
            )
        )
    );
    
    /** Comments Below Post Content */
    $wp_customize->add_setting(
        'toggle_comments',
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'toggle_comments',
            array(
                'section'         => 'post_page_settings',
                'label'           => __( 'Comments Below Post Content', 'blossom-studio' ),
                'description'     => __( 'Enable to show comment section right after post content. Refresh site for changes.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_post_page_ac'
            )
        )
    );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Category', 'blossom-studio' ),
                'description' => __( 'Enable to hide category.', 'blossom-studio' ),
            )
        )
    );
    
    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'blossom-studio' ),
                'description' => __( 'Enable to hide post author.', 'blossom-studio' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Posted Date', 'blossom-studio' ),
                'description' => __( 'Enable to hide posted date.', 'blossom-studio' ),
            )
        )
    );
    
    /** Show Featured Image */
    $wp_customize->add_setting( 
        'ed_featured_image', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_featured_image',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Featured Image', 'blossom-studio' ),
                'description' => __( 'Enable to show featured image in post detail (single post).', 'blossom-studio' ),
            )
        )
    );

    /** Posts(Blog) & Pages Settings Ends */

    /** Newsletter Settings */
    $wp_customize->add_section(
        'newsletter_settings',
        array(
            'title'    => __( 'Newsletter Settings', 'blossom-studio' ),
            'priority' => 65,
            'panel'    => 'general_settings',
        )
    );
    
    if( blossom_studio_is_btnw_activated() ){
        
        /** Enable Newsletter Section */
        $wp_customize->add_setting( 
            'ed_newsletter', 
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Studio_Toggle_Control( 
                $wp_customize,
                'ed_newsletter',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Section', 'blossom-studio' ),
                    'description' => __( 'Enable to show Newsletter Section', 'blossom-studio' ),
                )
            )
        );
        
        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );
        
        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'newsletter_settings',
                'label'       => __( 'Newsletter Shortcode', 'blossom-studio' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'blossom-studio' ),
            )
        ); 

    } else {
        $wp_customize->add_setting(
            'newsletter_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Blossom_Studio_Plugin_Recommend_Control(
                $wp_customize,
                'newsletter_recommend',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Shortcode', 'blossom-studio' ),
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-email-newsletter',//This is the slug of recommended plugin.
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s. After that option related with this section will be visible.', 'blossom-studio' ), '<strong>', '</strong>' ),
                )
            )
        );
    }
    /** Newsletter Settings Ends */
    
    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_settings',
        array(
            'title'    => __( 'Instagram Settings', 'blossom-studio' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );
    
    if( blossom_studio_is_btif_activated() ){
        /** Enable Instagram Section */
        $wp_customize->add_setting( 
            'ed_instagram', 
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Studio_Toggle_Control( 
                $wp_customize,
                'ed_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __( 'Instagram Section', 'blossom-studio' ),
                    'description' => __( 'Enable to show Instagram Section', 'blossom-studio' ),
                )
            )
        );
        
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Blossom_Studio_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'You can change the setting BlossomThemes Social Feed %1$sfrom here%2$s.', 'blossom-studio' ), '<a href="' . esc_url( admin_url( 'admin.php?page=class-blossomthemes-instagram-feed-admin.php' ) ) . '" target="_blank">', '</a>' )
                )
            )
        );        
    }else{
        $wp_customize->add_setting(
            'instagram_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Blossom_Studio_Plugin_Recommend_Control(
                $wp_customize,
                'instagram_recommend',
                array(
                    'section'     => 'instagram_settings',
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-instagram-feed',//This is the slug of recommended plugin.
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Social Feed%2$s. After that option related with this section will be visible.', 'blossom-studio' ), '<strong>', '</strong>' ),
                )
            )
        );
    }

    /** Instagram Settings Ends */

    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'blossom-studio' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );

    /** Shop Page Description */
    $wp_customize->add_setting( 
        'ed_shop_archive_description', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_shop_archive_description',
            array(
                'section'         => 'misc_settings',
                'label'           => __( 'Shop Page Description', 'blossom-studio' ),
                'description'     => __( 'Enable to show Shop Page Description.', 'blossom-studio' ),
                'active_callback' => 'blossom_studio_is_woocommerce_activated'
            )
        )
    );

    $wp_customize->add_setting(
        'error_404_image',
        array(
            'default'           => get_template_directory_uri() . '/images/error.jpg',
            'sanitize_callback' => 'blossom_studio_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'error_404_image',
            array(
                'label'           => __( '404 Image', 'blossom-studio' ),
                'description'     => __( 'Choose the background image for 404 page.', 'blossom-studio' ),
                'section'         => 'misc_settings',
            )
        )
    );

    $wp_customize->add_setting( 
        'ed_portfolio_crop', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_studio_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Studio_Toggle_Control( 
            $wp_customize,
            'ed_portfolio_crop',
            array(
                'section'     => 'misc_settings',
                'label'       => __( 'Portfolio Image Crop', 'blossom-studio' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in portfolio template.', 'blossom-studio' ),
            )
        )
    );
    /** Misc Settings Ends */
}
add_action( 'customize_register', 'blossom_studio_customize_register_general' );