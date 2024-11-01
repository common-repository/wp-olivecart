<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Start{
	function get_cart() { 
		$cart = new OliveCart_Main;
		$in		=	$this->cart_esc_html();
//Html page view
		switch( $in['step'] ) {
			case '1';
				apply_filters('cart-step1', '');
				break;
			case '2';
				apply_filters('cart-step2', '');
				break;
			case '3';
				apply_filters('cart-step3', '');
				break;
			case '4';
				apply_filters('cart-step4', '');
				break;
			case '5';
				apply_filters('cart-step5', '');
				break;
			case '6';
				apply_filters('cart-step6', '');
				break;
			case '7';
				apply_filters('cart-step7', '');
				break;
			case '8';
				apply_filters('cart-step8', '');
				break;
			default;
				 apply_filters('cart-step1', '');
		}
	}
	function cart_esc_html(){
		$in['customer_name']			=	null;
		$in['customer_kana']			=	null;
		$in['customer_zip']				=	null;
		$in['customer_address']			=	null;
		$in['customer_tel']				=	null;
		$in['customer_pref']			=	null;
		$in['customer_mailaddress1']	=	null;
		$in['customer_mailaddress2']	=	null;
		$in['customer_password1']		=	null;
		$in['customer_password2']		=	null;
		$in['user_mailaddress']			=	null;
		$in['user_check']				=	null;
		$in['member']					=	null;
		$in['mode']						=	null;
		$in['step'] 					=	null;
		$in['id'] 						=	null;
		$in['delivery_name']			=	null;
		$in['delivery_zip']				=	null;
		$in['delivery_pref']			=	null;
		$in['delivery_address']			=	null;
		$in['delivery_tel']				=	null;
		$in['comment']					=	null;
		$in['payment']					=	null;
		if( ! isset( $_REQUEST['number'],$_REQUEST['count'] ) ){
			if( $_REQUEST ){
				foreach ( $_REQUEST as $key => $value ){ 
					$_REQUEST[ $key ]	=	str_replace( ',', '', $_REQUEST[ $key ] );
					$_REQUEST[ $key ]	=	str_replace( "¥n", '', $_REQUEST[ $key ] );
					//$_REQUEST[ $key ]	=	esc_html( $_REQUEST[ $key ] );
					$_REQUEST[ $key ]	=	sanitize_text_field( $_REQUEST[ $key ] );
					$in[ $key ] 		= 	$_REQUEST[ $key ];
				}
			}
		}
		return $in;
	}

	function get_pasonaldata(){
		$in		=	$this->cart_esc_html();
	//	if(isset($_GET['mode'])){  $mode = $_GET['mode']; }
		//Cart POST Data session connection
		$session  	=	new OliveCart_Session;
		$session	->	sission_read();
		$session	->	sission_cart();
		
		//Shoping Cart Step2 Cart is empty
		if( isset( $in['mode'] ) ) {
			// $GLOBALS['mode'] = $_REQUEST['mode']; 
			 if( $in['mode']  == 'empty' ) { 
				 //Sission connection delete
				 $session->sission_delete(); 
			}
			//Sql database sission connection reload.
			$session->sission_cart();
		}	
	}
	
}
?>