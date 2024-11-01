<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Step3 {
	public function __construct() {
		add_filter('cart-step3',array($this,'step3'),10,2);
	}
	function step3() {
		if( isset( $GLOBALS['olivecart_add_on'] ) ) { return; }
		//REQUEST nonce check
		if( isset($_REQUEST['olivecart_nonce'] ) ) { 
			if( !wp_verify_nonce( $_REQUEST['olivecart_nonce'],'olivecart_action' ) ) {
				return ( new OliveCart_Main ) -> step1();
			}else{
				$session_check =(new OliveCart_Session)->sission_cart();
				if( empty($session_check) ) { 
					return ( new OliveCart_Main ) -> step1(); 
				}
				$in = ( new OliveCart_Start )->cart_esc_html(); 
				if( empty($in['customer_mailaddress1'] )){
					return ( new OliveCart_Main )->step2(); 
				}
				$this->html_preview( $in );
			}
		}
		else{
			return ( new OliveCart_Main ) -> step1();
		}
	}
	
	function html_preview( $in = null ){
		?>
		<form name="Form"  method="post" action="">
		<?php wp_nonce_field( 'olivecart_action', 'olivecart_nonce' ); ?>
		<input type=hidden name="step" value="4">
		<input type=hidden name="customer_name" value="<?php echo $in['customer_name'];?>">
		<input type=hidden name="customer_kana" value="<?php echo $in['customer_kana'];?>">
		<input type=hidden name="customer_zip" value="<?php echo $in['customer_zip'];?>">
		<input type=hidden name="customer_pref" value="<?php echo $in['customer_pref'];?>">
		<input type=hidden name="customer_address" value="<?php echo $in['customer_address'];?>">
		<input type=hidden name="customer_tel" value="<?php echo $in['customer_tel'];?>">
		<input type=hidden name="customer_mailaddress1" value="<?php echo $in['customer_mailaddress1'];?>">

		<input type=hidden name="delivery_name" value="<?php echo $in['delivery_name'];?>">
		<input type=hidden name="delivery_zip" value="<?php echo $in['delivery_zip'];?>">
		<input type=hidden name="delivery_pref" value="<?php echo $in['delivery_pref'];?>">
		<input type=hidden name="delivery_address" value="<?php echo $in['delivery_address'];?>">
		<input type=hidden name="delivery_tel" value="<?php echo $in['delivery_tel'];?>">
		<h3><?php _e('Payment Method','WP-OliveCart'); ?></h3>
		<?php 
		$count	=	null;
		if( empty( $payment ) ){ $payment = '1';}
		$fileread		=	new OliveCart_Sqlconnect;
		$db_payment		=	$fileread->DBcart_read();
		foreach ( $db_payment as $key ) {
			if ( ! $key['set01'] ) { continue ;}
			if ( $payment == $key['id'] ){ $checked ='checked';	}
			else { $checked = null; }
			if( !$count ){ $checked = 'checked';}
			echo  '
			<div class="payment">
			<label for="payment'.$key['id'].'" class="labelname"><input class="inputitemradio" value="'.$key['id'].'" id="payment'.$key['id'].'" name="payment" type="radio" '.$checked.' />'.$key['set01'].'</label>
			<p>'.$key['set03'].'</p>
			</div>
			';
			$count++;
		}

		$db_commission	=	$fileread->DBcommission_read();
		foreach ( $db_commission as $row ){
			if (!$row['name'] ) { continue ;}
			echo '
			<h3>'.$row['name'].'</h3>
			<div class="op">
			<select name="'.$row['commission_no'].'">
			';
			$count=0;
			foreach ( $row['form2'] as $value ){
		//$selected = '';
		//if ($_POST['commission'] == $value){ $selected ='selected';}
		//else {$selected = '';}
				echo '<option value="'.$count.'" >'.$value.'</option>'."\n";
				$count++;
			}
			echo '
			</select>
			<p>'.$row['comment'].'</p>
			</div>
			';
		}
		?>
		<h3><?php _e('Comment Message','WP-OliveCart');?></h3>
		<div class="op">
		<textarea name="comment" class="inputitem04"></textarea>
		</div>
		</form>
		<div class="submit">
		<p><input type="submit" value="<?php _e('Back','WP-OliveCart');?>" onClick="history.back();"  class="previous-page" /> 
		&nbsp;<input type="submit" value="<?php _e('Continue','WP-OliveCart'); ?>" onClick="document.Form.submit();" class="next-page" /> </p>
		</div>
		<?php
	}
}
new OliveCart_Step3;
?>