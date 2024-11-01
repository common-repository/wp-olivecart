<?php
/*
Plugin Name: WP-OliveCart4
Plugin URI: http://www.wp-olivecart.com
Description: Simple & Easy Free e-commerce plugin.
Version: 1.1.3
Author: Olive Design.
Author URI:
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
load_plugin_textdomain( 'WP-OliveCart',false,dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( dirname(__FILE__).'/lib/cart-lib-setting.php' );
require_once( dirname(__FILE__).'/cart/cart-setting.php' );
require_once( dirname(__FILE__).'/include/cart-admin-setting.php');
add_theme_support( 'post-thumbnails' );

if ( is_admin() ) { 
	register_activation_hook( __FILE__, array( new OliveCart_Activation(),'_install' ) ); 
	register_deactivation_hook( __FILE__,array( new OliveCart_Deactivation(),'_remove' ) );
}


add_action('widgets_init', function(){register_widget('OliveCart_Category_Widget' );});
add_action('widgets_init', function(){register_widget('OliveCart_Preview_Widget' );});

add_action( 'wp_enqueue_scripts','olivecart_add_inline_scripts' );
add_action( 'wp_print_scripts','olivecart_add_scripts' );
add_filter( 'template_include','olivecart_page_template' );


if ( !function_exists( 'olivecart_add_inline_scripts' ) ) {
//add wp-olivecart javascript file.
	function olivecart_add_inline_scripts() {
		wp_enqueue_script( 'olivecart-js',plugins_url( '/js/olivecart.js' , __FILE__ ),array(),'20180920',false );
		$data = 'OliveCartHomeUrl=\''.get_option('home').'\'; OliveCartPermalinkUrl=\''.get_permalink(get_option('cart_page_id')).'\';';
		wp_add_inline_script( 'olivecart-js', $data,'after' );
	}
}
if ( !function_exists( 'olivecart_add_scripts' ) ) {
//add wp-olivecart style css file.
	function olivecart_add_scripts() {
		wp_enqueue_style ( 'olivecart-css',plugins_url( '/cart/css/style-order.css', __FILE__ ) );
	}
}
if ( !function_exists( 'olivecart_page_template' ) ) {
//add wp-olivecart templete file.
	function olivecart_page_template( $template ) {
		if( get_the_ID() == get_option('cart_page_id') || get_the_ID() == get_option('user_login_page') ){
			$new_template = locate_template( array('page.php','single.php','index.php') );
			if ( '' != $new_template ) { return $new_template ; }
		}
		if ( is_tax( 'product_category' ) ){
			$new_template = locate_template( array( 'taxonomy.php','category.php' ,'archive.php','index.php' ) );
			if ( '' != $new_template ) { return $new_template ; }
		}
		return $template;
	}
}

?>