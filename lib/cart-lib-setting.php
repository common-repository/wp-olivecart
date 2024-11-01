<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Plugin install or uninstall hook
if ( is_admin()) { 
	if ( !class_exists( 'OliveCart_Activation' ) ) {
		require_once( dirname(__FILE__).'/class-cart-activation.php');
	}
	if ( !class_exists( 'OliveCart_Deactivation' ) ) {
		require_once( dirname(__FILE__).'/class-cart-deactivation.php');
	}
}

if ( !class_exists( 'OliveCart_Category_Widget' ) ) {
	require_once( dirname(__FILE__).'/class-cart-category-widget.php');
}
if ( !class_exists( 'OliveCart_Preview_Widget' ) ) {
	require_once( dirname(__FILE__).'/class-cart-preview-widget.php');
}
if ( !class_exists( 'OliveCart_Sqlconnect' ) ) {
	require_once( dirname(__FILE__).'/class-cart-sqlconnect.php');
}
if ( !class_exists( 'OliveCart_DB_Access' ) ) {
	require_once( dirname(__FILE__)."/class-cart-db-access.php");
}
if ( !class_exists( 'OliveCart_Error_Check' ) ) {
	require_once( dirname(__FILE__).'/class-cart-error-check.php');
}
if ( !class_exists( 'OliveCart_Mail_Access' ) ) {
	require_once( dirname(__FILE__).'/cart/class-cart-mail-access.php');
}
if ( !class_exists( 'OliveCart_Insert_Button' ) ) {
	require_once( dirname(__FILE__).'/class-cart-insert-button.php');
}
if ( !class_exists( 'OliveCart_Add_Meta_Table' ) ) {
	require_once( dirname(__FILE__).'/class-cart-add-meta-table.php');
}
if ( !class_exists( 'OliveCart_Meta_Save_Table' ) ) {
	require_once( dirname(__FILE__).'/class-cart-meta-save-table.php');
}
if ( !class_exists( 'OliveCart_Meta_Delete_Table' ) ) {
	require_once( dirname(__FILE__).'/class-cart-meta-delete-table.php');
}
if ( !class_exists( 'OliveCart_Session' ) ) {
	require_once( dirname(__FILE__).'/cart/class-cart-session.php');
}


if ( !function_exists( 'get_cart_button' ) ) {
//option insert cart button false
	function get_cart_button( $id=null ){
		if( ! $id ){ $id =	get_the_ID();}
		if( !isset( $GLOBALS['olive_cart_button'][ $id ] ) ) {
			$insertButton	=	new OliveCart_Insert_Button;
			echo $insertButton->insert_button( '<!--cart_button-->',$id );		
		}
	}
}

?>