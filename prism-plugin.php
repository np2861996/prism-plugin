<?php
/**
 * Plugin Name: Prism Plugin
 * Plugin URI: https://github.com/np2861996/
 * Description: Quick, easy, advance plugin by prism. 
 * Author: nikhil patel
 * Author URI: https://nikhil_patel.net/
 * Text Domain: Prism
 * Version: 1.0.0
 *
 * @package Prism
 * @author nikhil patel
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if (!defined('PRISM_PLUGIN_DIRNAME')) {
    define('PRISM_PLUGIN_DIRNAME', plugin_basename(dirname(__FILE__)));
}
if (!defined('PRISM_PLUGIN_VERSION')) {
    define('PRISM_PLUGIN_VERSION', '1.0.0');
}

// Plugin Path.
if ( ! defined( 'PRISM_PLUGIN_PATH' ) ) {
	define( 'PRISM_PLUGIN_PATH', plugin_dir_url( __FILE__ ) );
}

//css file
function prism_scripts() {
    wp_enqueue_style( 'style-name', PRISM_PLUGIN_PATH.'css/prism-custom.css' );
    wp_enqueue_style( 'style-name1', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css' );
    
    wp_enqueue_style( 'style-lightgallery', 'https://cdn.jsdelivr.net/npm/lightgallery/dist/css/lightgallery.min.css' );
    wp_enqueue_script( 'my-script', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'js-prism', PRISM_PLUGIN_PATH.'js/prism-custom.js' , array( 'jquery' ), '1.0.0', true);
}

add_action( 'wp_enqueue_scripts', 'prism_scripts' );

// Admin File
//require_once 'inc/prism-admin-settings.php';



function custom_product_category_template( $template ) {
    if ( is_product_category() ) {
        // Load the custom template file from the plugin directory
        $custom_template = plugin_dir_path( __FILE__ ) . 'templates/category-product-table.php';

        // Use the custom template if it exists, otherwise use the default template
        if ( file_exists( $custom_template ) ) {
            $template = $custom_template;
        }
    }

    return $template;
}
add_filter( 'template_include', 'custom_product_category_template', 99 );
