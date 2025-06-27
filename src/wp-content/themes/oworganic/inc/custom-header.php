<?php
/**
 * Custom Header functionality for Oworganic
 *
 * @package WordPress
 * @subpackage Oworganic
 * @since Oworganic 1.0
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses oworganic_header_style()
 */
function oworganic_custom_header_setup() {
	$color_scheme        = oworganic_get_color_scheme();
	$default_text_color  = trim( $color_scheme[4], '#' );

	/**
	 * Filter Oworganic custom-header support arguments.
	 *
	 * @since Oworganic 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default_text_color     Default color of the header text.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type string $wp-head-callback       Callback function used to styles the header image and text
	 *                                          displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'oworganic_custom_header_args', array(
		'default-text-color'     => $default_text_color,
		'width'                  => 954,
		'height'                 => 1300,
		'wp-head-callback'       => 'oworganic_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'oworganic_custom_header_setup' );

/**
 * Convert HEX to RGB.
 *
 * @since Oworganic 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */

if ( ! function_exists( 'oworganic_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @since Oworganic 1.0
 *
 * @see oworganic_custom_header_setup()
 */
function oworganic_header_style() {
	return '';
}
endif; // oworganic_header_style

