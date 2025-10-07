<?php
/**
 * Best Minimalist functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Best_Minimalist
 */

if ( ! function_exists( 'best_minimalist_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function best_minimalist_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Best Minimalist, use a find and replace
		 * to change 'best-minimalist' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'best-minimalist', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'best-minimalist-teaser', 391, 250, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'best-minimalist' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'best_minimalist_custom_background_args', array(
					'default-color' => 'f9fafc',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo', array(
				'height'      => 65,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'best_minimalist_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function best_minimalist_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'best_minimalist_content_width', 640 );
}
add_action( 'after_setup_theme', 'best_minimalist_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function best_minimalist_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'best-minimalist' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'best-minimalist' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<div class="widget-title-style"><h4 class="widget-title">',
			'after_title'   => '</h4></div>',
		)
	);
}
add_action( 'widgets_init', 'best_minimalist_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function best_minimalist_scripts() {
	wp_enqueue_style( 'best-minimalist-style', get_stylesheet_uri() );

	wp_enqueue_style( 'best-minimalist-font-icons', get_template_directory_uri() . '/assets/css/minimalist.css', false );

	wp_enqueue_script( 'best-minimalist-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'best-minimalist-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	// Loading screen reader text.
	wp_localize_script(
		'best-minimalist-navigation', 'best_minimalist_ScreenReaderText', array(
			'expand'   => __( 'Expand child menu', 'best-minimalist' ),
			'collapse' => __( 'Collapse child menu', 'best-minimalist' ),
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'best_minimalist_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Load Custom Dashboard
//include get_template_directory() . '/inc/dashboard.php';


/**
 * Modify Excerpt Lenght.
 *
 * @param Length $length -- The new string length value.
 */
function best_minimalist_excerpt_length( $length ) {
	if ( ! is_admin() ) {
		return 45;
	}
}
add_filter( 'excerpt_length', 'best_minimalist_excerpt_length', 999 );


/**
 * Modify The Excerpt More.
 *
 * @param More $more -- The new Read More string value.
 */
function best_minimalist_excerpt_more( $more ) {
	global $post;
	if ( is_admin() ) {
		return $more; }
	return '&#46;&#46;&#46;';
}
add_filter( 'excerpt_more', 'best_minimalist_excerpt_more' );


/**
 * We're going to pop off the paged breadcrumb and add in our own thing.
 *
 * @param best_minimalist_trail $trail the breadcrumb_trail object after it has been filled.
 */
function best_minimalist_remove_current_item( $trail ) {
	// Check to ensure the breadcrumb we're going to play with exists in the trail.
	if ( isset( $trail->breadcrumbs[0] ) && $trail->breadcrumbs[0] instanceof bcn_breadcrumb ) {
		$types = $trail->breadcrumbs[0]->get_types();
		// Make sure we have a type and it is a current-item.
		if ( is_array( $types ) && in_array( 'current-item', $types ) ) {
			// Shift the current item off the front.
			array_shift( $trail->breadcrumbs );
		}
	}
}
add_action( 'bcn_after_fill', 'best_minimalist_remove_current_item' );
