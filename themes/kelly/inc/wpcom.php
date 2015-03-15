<?php
/**
 * WordPress.com-specific functions and definitions
 * This file is centrally included from `wp-content/mu-plugins/wpcom-theme-compat.php`
 *
 * @package Kelly
 */
 
 function kelly_theme_colors() {
	global $themecolors;

	/**
	 * Set a default theme color array for WP.com.
	 *
	 * @global array $themecolors
	 */
	if ( ! isset( $themecolors ) ) :
		$themecolors = array(
			'bg' => 'ffffff',
			'border' => 'eeeeee',
			'text' => '5f6d80',
			'link' => 'f35955',
			'url' => 'f35955',
		);
	endif;
}
add_action( 'after_setup_theme', 'kelly_theme_colors' );

/**
 * Adds support for WP.com print styles and responsive videos
 */
function kelly_theme_support() {
	add_theme_support( 'print-style' );
}
add_action( 'after_setup_theme', 'kelly_theme_support' );

//WordPress.com specific styles
function kelly_wpcom_styles() {
	wp_enqueue_style( 'kelly-wpcom', get_template_directory_uri() . '/inc/style-wpcom.css', '052014' );
}
add_action( 'wp_enqueue_scripts', 'kelly_wpcom_styles' );

/*
 * De-queue Google fonts if custom fonts are being used instead
 */
function kelly_dequeue_fonts() {
	if ( class_exists( 'TypekitData' ) && class_exists( 'CustomDesign' ) && CustomDesign::is_upgrade_active() ) {
		$customfonts = TypekitData::get( 'families' );
		if ( $customfonts && $customfonts['site-title']['id'] && $customfonts['headings']['id'] && $customfonts['body-text']['id'] ) {
			wp_dequeue_style( 'kelly-open-sans' );
			wp_dequeue_style( 'kelly-leckerli-one' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'kelly_dequeue_fonts' );