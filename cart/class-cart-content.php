<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Content {
	function __construct() {
		add_filter( 'the_content', array($this,'cart_content' ));;
	}
	function cart_content($content){
		$cart_preview= new OliveCart_Start;	
		if(get_the_ID() == get_option('cart_page_id') and is_singular() and in_the_loop()){
			$content = $cart_preview->get_cart();
		}
		return $content;
	}
}
new OliveCart_Content;
?>
