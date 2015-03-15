<?php
/**
 * kelly functions and definitions
 *
 * @package kelly
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1200; /* pixels */

if ( ! function_exists( 'kelly_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function kelly_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on kelly, use a find and replace
	 * to change 'kelly' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kelly', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'kelly-featured-image', 1200, 9999, false );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'kelly' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'kelly_custom_background_args', array(
		'default-color' => 'ffffff',
	) ) );
	
	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
}
endif; // kelly_setup
add_action( 'after_setup_theme', 'kelly_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function kelly_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 1', 'kelly' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 2', 'kelly' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar 3', 'kelly' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'kelly_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function kelly_scripts() {
	wp_enqueue_style( 'kelly-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'kelly-open-sans' );
	wp_enqueue_style( 'kelly-leckerli-one' );
	
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );

	wp_enqueue_script( 'kelly-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'kelly-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'kelly-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'kelly_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Register Google Fonts
 */
function kelly_google_fonts() {

	$protocol = is_ssl() ? 'https' : 'http';

	/*	translators: If there are characters in your language that are not supported
		by Open Sans, translate this to 'off'. Do not translate into your own language. */

	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'kelly' ) ) {

		wp_register_style( 'kelly-open-sans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,700" );

	}
	
	/*	translators: If there are characters in your language that are not supported
		by Leckerli One, translate this to 'off'. Do not translate into your own language. */

	if ( 'off' !== _x( 'on', 'Leckerli One font: on or off', 'kelly' ) ) {

		wp_register_style( 'kelly-leckerli-one', "$protocol://fonts.googleapis.com/css?family=Leckerli+One" );

	}

}
add_action( 'init', 'kelly_google_fonts' );

/**
 * Enqueue Google Fonts for custom headers
 */
function kelly_admin_scripts( $hook_suffix ) {

	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'kelly-open-sans' );
	wp_enqueue_style( 'kelly-leckerli-one' );

}
add_action( 'admin_enqueue_scripts', 'kelly_admin_scripts' );