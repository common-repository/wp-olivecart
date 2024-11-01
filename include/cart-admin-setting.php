<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Administrator Setup Menu
if ( is_admin() or is_user_logged_in() ) {
	if ( !class_exists( 'OliveCart_Auto_Email' ) ) {
		require_once( dirname(__FILE__).'/class-cart-auto-email.php' );
	}
	if ( !class_exists( 'OliveCart_Charges' ) ) {
		require_once( dirname(__FILE__).'/class-cart-chages.php' );
	}
	if ( !class_exists( 'OliveCart_End_Message' ) ) {
		require_once( dirname(__FILE__).'/class-cart-end-message.php' );
	}
	if ( !class_exists( 'OliveCart_Options' ) ) {
		require_once( dirname(__FILE__).'/class-cart-options.php' );
	}
	if ( !class_exists( 'OliveCart_Postage' ) ) {
		require_once( dirname(__FILE__).'/class-cart-postage.php' );
	}
	if ( !class_exists( 'OliveCart_Settlement' ) ) {
		require_once( dirname(__FILE__).'/class-cart-settlement.php') ;
	}
	if ( !class_exists( 'OliveCart_Help' ) ) {
		require_once( dirname(__FILE__).'/class-cart-help.php' );
	}
	if ( !class_exists( 'OliveCart_On_Admin_Header' ) ) {
		require_once( dirname(__FILE__).'/class-cart-admin-header.php');
	}
	if ( !class_exists( 'OliveCart_Items' ) ) {
		require_once( dirname(__FILE__).'/class-cart-items.php' );
		add_filter( 'manage_edit-cart_columns',	 array( new OliveCart_Items() ,'manage_posts_columns' ));
		add_action( 'manage_posts_custom_column', array( new OliveCart_Items(),'add_column' ), 10, 2 );
	}

	add_action( 'admin_menu', 'olivecart_setup_menu',20 );
	add_action( 'admin_menu', 'olivecart_remove_menus' );
}

//Add WP-OliveCart Taxonomy
if ( !class_exists( 'OliveCart_Taxonomy' ) ) {
		require_once( dirname(__FILE__).'/class-cart-taxonomy.php');
}

if ( !function_exists( 'olivecart_setup_menu' ) ) {
	function olivecart_setup_menu(){
		global $menu,$submenu;
		$cart_postage		= new  OliveCart_Postage();
		$cart_settlement	= new  OliveCart_Settlement();
		$cart_charges		= new  OliveCart_Charges();
		$cart_end_message	= new  OliveCart_End_Message();
		$cart_auto_email	= new  OliveCart_Auto_Email();
		$cart_options		= new  OliveCart_Options();
		if ( current_user_can('editor') ){ $Role='editor'; }
		elseif ( current_user_can('administrator') ){ $Role='administrator'; }
		else{ $Role = null; }
		if( $Role ){
			$hook1 = add_menu_page(__('Shopping Cart Setup','WP-OliveCart'),'OliveCart_Setup',$Role,'olivecart_postage',array(&$cart_postage, 'on_show_page'),plugins_url( 'images/icon_cart.png',dirname(__FILE__)));
			$hook2 = add_submenu_page('olivecart_postage', __('Settlement Method','WP-OliveCart'), __('Settlement','WP-OliveCart'), $Role,'olivecart_settlement', array(&$cart_settlement, 'on_show_page'));
			$hook3 = add_submenu_page('olivecart_postage', __('Othre Items','WP-OliveCart'), __('Othre Items','WP-OliveCart'),$Role,'olivecart_charges', array(&$cart_charges, 'on_show_page'));
			$hook5 = add_submenu_page('', __('Cart End Message','WP-OliveCart'), __('Cart End Message','WP-OliveCart'), $Role,'olivecart_end_message', array(&$cart_end_message, 'on_show_page'));
			$hook6 = add_submenu_page('', __('Cart Auto Reply Email','WP-OliveCart'), __('Cart Auto Reply Email','WP-OliveCart'), $Role,'olivecart_auto_email', array(&$cart_auto_email, 'on_show_page'));
			$hook9 = add_submenu_page('olivecart_postage', __('Cart Options','WP-OliveCart'), __('Cart Options','WP-OliveCart'), $Role,'olivecart_options', array(&$cart_options, 'on_show_page'));
			add_menu_page('Item info',__('Items ','WP-OliveCart'),$Role, 'edit.php?post_type=cart','',plugins_url( 'images/icon_commodity.png',dirname(__FILE__)));
			add_action( 'load-'.$hook1, array(&$cart_postage,    'on_load'));
			add_action( 'load-'.$hook2, array(&$cart_settlement, 'on_load'));
			add_action( 'load-'.$hook3, array(&$cart_charges,    'on_load'));
			add_action( 'load-'.$hook5, array(&$cart_end_message,'on_load'));
			add_action( 'load-'.$hook6, array(&$cart_auto_email, 'on_load'));
			add_action( 'load-'.$hook9, array(&$cart_options,    'on_load'));
			foreach ( $menu as $key=>$value ){
				if ($menu[$key][0] == 'OliveCart_Setup' ) {
					$menu[$key][0]                       = 'OliveCart';
					$submenu['olivecart_postage'][0][0]  = __( 'Postage','WP-OliveCart' );
				}
			}
  		}
	}
}
if ( !function_exists( 'olivecart_remove_menus' ) ) {
	function olivecart_remove_menus(){
    	remove_menu_page('edit.php?post_type=cart');
		remove_menu_page('edit.php?post_type=wp_olivecart');
	}
}
?>