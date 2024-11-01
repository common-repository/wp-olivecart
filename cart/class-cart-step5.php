<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Step5 {
	public function __construct() {
		add_filter('cart-step5',array($this,'step5'),10,2);
	}
	function step5() {
		if( isset( $GLOBALS['olivecart_add_on'] )) { return; }
		//REQUEST nonce check
		if( isset($_REQUEST['olivecart_nonce'] ) ) { 
			if( !wp_verify_nonce( $_REQUEST['olivecart_nonce'],'olivecart_action' ) ) {
				return ( new OliveCart_Main ) -> step1();
			}
			else{
				$session_check =(new OliveCart_Session)->sission_cart();
				if( empty($session_check) ) { 
					return ( new OliveCart_Main ) -> step1(); 
				}
				$in	=( new OliveCart_Start  )	->	cart_esc_html();
				if( empty($in['customer_mailaddress1'] )){
					return ( new OliveCart_Main )->step2(); 
				}
				( new OliveCart_Mail_Access )		->	Send_mail('Customer');
				( new OliveCart_Mail_Access )		->	Send_mail('Shop');
				( new OliveCart_Sqlconnect  ) 	 	->	DBstock_update();
				( new OliveCart_Session     )		->	sission_delete();
				$print = (new OliveCart_Sqlconnect)	->	DBcart_read('',$in['payment']);
				$print = $this->chage_tag( $print );
				$this->html_preview( $print );
				}
		}else{
			return ( new OliveCart_Main ) -> step1();
		}
	}
	function chage_tag( $text ) {
		$text = preg_replace( '/&lt;/',"<",$text);
		$text = preg_replace( '/&gt;/',">",$text);
		$text = preg_replace( '/&#010;/',"\n",$text );
		return $text;
	}
	
	function html_preview( $print ){
		echo '
		<div class="comment1">
		<p>'.__('Order Number' ,'WP-OliveCart').'['.$GLOBALS['order_number'].']</p>
		'.$print['set04'].'
		</div>';
	}
}
new OliveCart_Step5;
?>