<?php
/**
 * Plugin Name: Dope Accordion for Elementor
 * Description: Elementor accordion widget with rich content and image/video media grid.
 * Version: 1.0.11
 * Author: DopeAccordion
 * Text Domain: dope-accordion
 * Requires Plugins: elementor
 *
 * Elementor tested up to: 3.29.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'DOPE_ACCORDION_VERSION', '1.0.11' );
define( 'DOPE_ACCORDION_FILE', __FILE__ );
define( 'DOPE_ACCORDION_PATH', __DIR__ );
define( 'DOPE_ACCORDION_URL', plugin_dir_url( __FILE__ ) );

require_once DOPE_ACCORDION_PATH . '/includes/class-dope-accordion-plugin.php';

Dope_Accordion_Plugin::instance();
