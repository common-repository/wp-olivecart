<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Get_Title{
		public function __construct() {
		add_filter( 'the_title',array($this,'cart_title'),10);
	}
	function cart_title($title){
		if(get_the_ID() == get_option('cart_page_id') && is_singular() && in_the_loop()){
			  $title = $this->get_cart_title();
		}
		return $title;
	}
	function get_cart_title(){
		$in		=	( new OliveCart_Start )->cart_esc_html();
		//change Cart title
		//if(isset( $_REQUEST['step'])){
		switch( $in['step'] ){
			case '1';
				return __('Review your order','WP-OliveCart');
			case '2';
				return __('Please enter your contact details','WP-OliveCart');
			case '3';
				return __('Payment Options & Fees','WP-OliveCart');
			case '4';
				return __('Final Review','WP-OliveCart');;	
			case '5';
				return __('Thank you for your order' ,'WP-OliveCart');;
			default;
				return __('Review your order','WP-OliveCart');
		}
	}
}
new OliveCart_Get_Title;
?>