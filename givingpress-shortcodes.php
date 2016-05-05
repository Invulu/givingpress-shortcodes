<?php
/**
 * Plugin Name: GivingPress Shortcodes
 * Plugin URI: http://givingpress.com
 * Description: A set of simple, beautiful shortcodes for use with the GivingPress nonprofit website platform.
 * Version: 1.2
 * Author: GivingPress
 * Author URI: http://givingpress.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package GivingPress Shortcodes
 * @since GivingPress Shortcodes 1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'givingpress_shortcodes_init' ) ) {

	function givingpress_shortcodes_init() {

		// Include Shortcode Functions.
		include_once plugin_dir_path( __FILE__ ) . 'givingpress-shortcodes-functions.php';

	}
}
	add_action( 'init', 'givingpress_shortcodes_init', 20 );

if ( ! function_exists( 'givingpress_shortcodes_enqueue_scripts' ) ) {

	function givingpress_shortcodes_enqueue_scripts() {

		// Enqueue Styles.
		wp_enqueue_style( 'givingpress-shortcodes', plugin_dir_url( dirname( __FILE__ ) ) . '/givingpress-shortcodes/css/givingpress-shortcodes.css', array(), '1.0' );
		wp_enqueue_style( 'font-awesome', plugin_dir_url( dirname( __FILE__ ) ) . '/givingpress-shortcodes/css/font-awesome.css', array( 'givingpress-shortcodes' ), '1.0' );

		// IE Conditional Styles.
		global $wp_styles;
		$wp_styles->add_data( 'givingpress-shortcodes-ie8', 'conditional', 'lt IE 9' );

		// Resgister Scripts.
		wp_register_script( 'givingpress-modal', plugin_dir_url( dirname( __FILE__ ) ) . '/givingpress-shortcodes/js/jquery.modal.min.js', array( 'jquery' ), '20130729' );

		// Enqueue Scripts.
		wp_enqueue_script( 'givingpress-shortcodes-script', plugin_dir_url( dirname( __FILE__ ) ) . '/givingpress-shortcodes/js/jquery.shortcodes.js', array( 'jquery', 'givingpress-modal', 'jquery-ui-accordion', 'jquery-ui-dialog' ), '20130729', true );

		// Enqueue jQuery UI Tabs code only if not in the Customizer.
		// http://core.trac.wordpress.org/ticket/23225.
		global $wp_customize;
		if ( ! isset( $wp_customize ) ) {
			wp_enqueue_script( 'givingpress-tabs', plugin_dir_url( dirname( __FILE__ ) ) . '/givingpress-shortcodes/js/tabs.js', array( 'jquery', 'jquery-ui-tabs' ), '20130609', true );
		}

	}
}
add_action( 'wp_enqueue_scripts', 'givingpress_shortcodes_enqueue_scripts' );
