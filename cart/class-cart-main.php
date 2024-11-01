<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Shopping Cart Basic Core
class OliveCart_Main{
	function step1() { 
		( new OliveCart_Start ) -> cart_esc_html();
		echo apply_filters('cart-step1', null ); 
	}
	function step2(){ 
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step2', null ); 
	}
	function step3() { 
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step3', null ); 
	}
	function step4() {
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step4',  null ); 
	}
	function step5(){
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step5',  null ); 
	}
	function step6(){
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step6',  null ); 
	}
	function step7(){
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step7',  null ); 
	}
	function step8(){
		if( empty( ( new OliveCart_Session )->sission_cart() ) ){ return $this->step1(); }
		echo apply_filters('cart-step8', null ); 
	}
}
?>