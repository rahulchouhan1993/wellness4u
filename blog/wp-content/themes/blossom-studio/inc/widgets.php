<?php
/**
 * Blossom Studio Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Blossom_Studio
 */

function blossom_studio_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'blossom-studio' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'blossom-studio' ),
        ),
        'course' => array(
            'name'        => __( 'Course Level Section', 'blossom-studio' ),
            'id'          => 'course', 
            'description' => __( 'Add "Blossom: Icon Text" widget for course level section.', 'blossom-studio' ),
        ),
        'about' => array(
            'name'        => __( 'About Section', 'blossom-studio' ),
            'id'          => 'about', 
            'description' => __( 'Add "Blossom: Featured Page Widget" for about section.', 'blossom-studio' ),
        ),
        'promo' => array(
            'name'        => __( 'Featured Area Section', 'blossom-studio' ),
            'id'          => 'promo', 
            'description' => __( 'Add "Text" widget For Title and description. For Boxes, add "Blossom: Image Text". The recommended image size is 259x346px.', 'blossom-studio' ),
        ),
        'cta' => array(
            'name'        => __( 'Full CTA Section', 'blossom-studio' ),
            'id'          => 'cta', 
            'description' => __( 'Add "Blossom: Call To Action" widget for call to action full section.', 'blossom-studio' ),
        ),
        'testimonial' => array(
            'name'          => __( 'Testimonial Section', 'blossom-studio' ),
            'id'            => 'testimonial', 
            'description'   => __( 'Add "Text" widget For Title and description. For testimonial, add "Blossom: Testimonial" widget for testimonial section.', 'blossom-studio' ),
        ),
        'cta-wide' => array(
            'name'        => __( 'Wide CTA Section', 'blossom-studio' ),
            'id'          => 'cta-wide', 
            'description' => __( 'Add "Blossom: Call To Action" widget for wide call to action section.', 'blossom-studio' ),
        ),
        'client' => array(
            'name'        => __( 'Client Section', 'blossom-studio' ),
            'id'          => 'client', 
            'description' => __( 'Add "Blossom: Client Logo Widget" for client section. The recommended image size for this section is 252px by 145px.', 'blossom-studio' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'blossom-studio' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'blossom-studio' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'blossom-studio' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'blossom-studio' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'blossom-studio' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'blossom-studio' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'blossom-studio' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'blossom-studio' ),
        )
    );

    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }
}
add_action( 'widgets_init', 'blossom_studio_widgets_init' );