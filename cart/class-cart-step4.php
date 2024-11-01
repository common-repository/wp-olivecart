<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Step4 {
	public function __construct() {
		add_filter('cart-step4',array($this,'step4'),10,2);
	}
	function step4() {
		if( isset( $GLOBALS['olivecart_add_on'] )) { return; }
		//REQUEST nonce check
		if( isset($_REQUEST['olivecart_nonce'] ) ) { 
			if( !wp_verify_nonce( $_REQUEST['olivecart_nonce'],'olivecart_action' ) ) {
				return ( new OliveCart_Main ) -> step1();
			}
			else{
				$session_check	=	(new OliveCart_Session)->sission_cart();
				if( empty($session_check) ) { 
					return ( new OliveCart_Main ) -> step1(); 
				}
				$in				=	( new OliveCart_Start ) -> cart_esc_html();
				if( empty($in['customer_mailaddress1'] ) ) {
					return ( new OliveCart_Main ) -> step2(); 
				}
				$cart			=	( new OliveCart_DB_Access ) -> Cart_calculation( );
				$commission		= 	( new OliveCart_Sqlconnect ) -> DBcommission_read();
				$this->html_preview( $in,$cart, $commission);
			}
		}
		else{
			return ( new OliveCart_Main ) -> step1();
		}
	}
	
	function html_preview( $in ,$cart, $commission ){
		require( dirname(__FILE__).'/../conf/cart-form-conf.php');
		echo '<h3>'.__('Review your order','WP-OliveCart').'</h3>';
		echo apply_filters('cart_preview', '1');
		echo '
		<h3>'.__('Contact details:','WP-OliveCart').'</h3>
		<p class="label_order">'.__('First Name','WP-OliveCart').'</p>
		<p>'.$in['customer_name'].'</p>
		<p class="label_order">'.__('Last Name','WP-OliveCart').'</p>
		<p>'.$in['customer_kana'].'</p>
		<p class="label_order"><span class="labelform02">'.__('Postal Code','WP-OliveCart').'</p>
		<p>'.$in['customer_zip'].'</p>
		<p class="label_order">'.__('Address','WP-OliveCart').'</p>
		<p>'.$_pref[ $in['customer_pref'] ].$in['customer_address'].'</p>
		<p class="label_order">'.__('Phone','WP-OliveCart').'</p>
		<p>'.$in['customer_tel'].'</p>
		<p class="label_order">'.__('Email','WP-OliveCart').'</p>
		<p>'.$in['customer_mailaddress1'].'</p>

		<h3>'.__('Shipping details:','WP-OliveCart').'</h3>';

		if ( ! $in['delivery_name'] ) { echo '<p>'.__('Billing address is same as shipping address','WP-OliveCart').'</p>'; }
		else{
			echo '
			<p class="label_order">'.__('Name','WP-OliveCart').'</p>
			<p>'.$in['delivery_name'].'</p>
			<p class="label_order">'.__('Postal Code','WP-OliveCart').'</p>
			<p>'.$in['delivery_zip'].'</p>
			<p class="label_order">'.__('Address','WP-OliveCart').'</p>
			<p>'.$_pref[ $in['delivery_pref'] ].$in['delivery_address'].'</p>
			<p class="label_order">'.__('Phone','WP-OliveCart').'</p>
			<p>'.$in['delivery_tel'].'</p>';
		}

		echo '
		<h3>'.__('Payment Method','WP-OliveCart').'</h3>
		<p>'.$cart['payment_name'].'</p>';
		foreach ( $commission as $row ){
			if( $row['name'] ){
				echo '<h3>'.$row['name'].'</h3><p>'.$row['post_form'].'</p>'."\n";
			}
		}
		echo '
		<h3>'.__('Comment Message','WP-OliveCart').'</h3>
		<p>'.$in['comment'].'</p>
		<p>'.__('This is your final review. Please check all information carefully. If everything is correct, click "submit order".' ,'WP-OliveCart').'</p>
		<form name="Form"  method="post" action="">'.
		wp_nonce_field( 'olivecart_action', 'olivecart_nonce' ).
		'<input type=hidden name="step" value="5">
		<input type=hidden name="customer_name" value="'.$in['customer_name'].'">
		<input type=hidden name="customer_kana" value="'.$in['customer_kana'].'">
		<input type=hidden name="customer_zip" value="'.$in['customer_zip'].'">
		<input type=hidden name="customer_pref" value="'.$in['customer_pref'].'">
		<input type=hidden name="customer_address" value="'.$in['customer_address'].'">
		<input type=hidden name="customer_tel" value="'.$in['customer_tel'].'">
		<input type=hidden name="customer_mailaddress1" value="'.$in['customer_mailaddress1'].'">
		
		<input type=hidden name="delivery_name" value="'.$in['delivery_name'].'">
		<input type=hidden name="delivery_zip" value="'.$in['delivery_zip'].'">
		<input type=hidden name="delivery_pref" value="'.$in['delivery_pref'].'">
		<input type=hidden name="delivery_address" value="'.$in['delivery_address'].'">

		<input type=hidden name="delivery_tel" value="'.$in['delivery_tel'].'"">
		<input type="hidden" name="payment" value="'.$in['payment'].'">';

		foreach ( $commission as $row ){
			if ($row['name'] ){
				echo '<input type="hidden" name="'.$row['commission_no'].'" value="'.$row['in_commission'].'">'."\n";
			}
		}
		echo '
		<input type="hidden" name="comment" value="'.$in['comment'].'">
		</form>
		<div class="submit">
		<p><input type="submit" value="'.__('Back' ,'WP-OliveCart').'" onClick="history.back();" class="previous-page"/> 
		&nbsp;<input type="submit" value="'.__('Submit Order' ,'WP-OliveCart').'" onClick="document.Form.submit();" class="next-page" /> </p>
		</div>';
		
	}	
}
new OliveCart_Step4;
?>