<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Step2 {
	public function __construct() {
		add_filter('cart-step2',array($this,'step2'),10);
	}

	function step2() {
		require( dirname(__FILE__).'/../conf/cart-form-conf.php');
		if( isset( $GLOBALS['olivecart_add_on'] ) ) { return; } 
		//REQUEST nonce check
		if( isset($_REQUEST['olivecart_nonce'] ) ) { 
			if( !wp_verify_nonce( $_REQUEST['olivecart_nonce'],'olivecart_action' ) ) {
				return ( new OliveCart_Main ) -> step1();
			}
			else{
				//Session Check
				$session_check =(new OliveCart_Session)->sission_cart();
				if( empty($session_check) ) { 
					return ( new OliveCart_Main ) -> step1(); 
				}
				$in		=	( new OliveCart_Start )->cart_esc_html();
				//POST DATA CHECK
				$error	=	( new OliveCart_Error_Check )->postdata_check($_indispen,array() );
				if( $in['delivery_name'] || $in['delivery_zip'] || $in['delivery_pref'] || $in['delivery_address']  || $in['delivery_tel'] ) {
					$error	=	( new OliveCart_Error_Check )->deliver_check( $_deliver,$error );
				}
				if( !$error  && $_POST ){ 
					return apply_filters('cart-step3', '1');
				}
				$this->html_preview($error,$in);
			}
		}
		else{
			//exit;
			return ( new OliveCart_Main ) -> step1();
		}

	}
	
	function html_preview( $error=null,$in=null ){
		require( dirname(__FILE__).'/../conf/cart-form-conf.php');
		?>
		<form name=Form  method="post">
			
		<?php wp_nonce_field( 'olivecart_action', 'olivecart_nonce' ); ?>
		
		<h3><?php _e('Contact address','WP-OliveCart'); $ab=get_locale();?> </h3>
		<div class="member-register">
		<?php
		if ( $error  ) {
			echo '<div class="error"><p>'.__('Error Required field is missing ','WP-OliveCart').'</p></div>';
		}
		?>
		<dl class="customer-info">
		<dt class="customer-info-title"><?php _e('First Name','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_name" class="inputitem02" value="<?php echo $in['customer_name'];?>" />
		<?php
		if ( isset ( $error['customer_name'] ) ) {
			echo '<br /><span class="error-txt">'. __('Missing First Name field. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Last Name','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_kana" class="inputitem02" value="<?php echo $in['customer_kana']; ?>" />
		<?php
		if ( isset( $error['customer_kana'] ) ) {
			echo '<br /><span class="error-txt">'. __('Missing Last Name field. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Postal Code','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input">
		<input type="text"  id="PostalCode1" name="customer_zip" class="postal" value="<?php echo $in['customer_zip']; ?>" />
		<?php echo apply_filters('zip_serch1', ''); 

		if ( isset( $error['customer_zip'] ) ) {
			echo  '<br /><span class="error-txt">'. __('Missing Postal Code. Please correct and try again.','WP-OliveCart').'</span>';
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Prefecture','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input">
		<?php
		//if(	get_locale() == 'ja') {
		echo '<select name="customer_pref" id="pref1" class="pref-s">';
		$count=0;
		foreach ($_pref as $value ) { 
			if( $count == $in['customer_pref'] ) { echo "<option value=\"$count\" selected>$value</option> \n"; }
			else { echo  "<option value=\"$count\">$value</option> \n"; }
			$count++;
		}
		echo '</select> ';
		/*}
		else{
			echo '<input type="text"  id="PostalCode1" name="customer_zip" class="postal" value="'.$in['customer_zip'].'" />';
		}*/
		if ( isset( $error['customer_pref'] ) ) {
			echo '<br /><span class="error-txt">'. __('Missing prefecture. Please correct and try again.','WP-OliveCart').'</span>';
		} 
		
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Address','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_address" class="inputitem02" id="olivecart-area1" value="<?php echo $in['customer_address'];?>" />
		<?php
		if ( isset( $error['customer_address'] )  ) {
			echo '<br /><span class="error-txt">'. __('Missing Address. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Phone','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_tel" class="inputitem02" value="<?php echo $in['customer_tel'];?>"  placeholder="000-000-0000"/>
		<?php
		if ( isset( $error['customer_tel'] ) ) { 
			echo '<br /><span class="error-txt">'. __('Missing phone number. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Email','WP-OliveCart')?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_mailaddress1" class="inputitem02" value="<?php echo $in['customer_mailaddress1'];?>" />
		<?php
		if ( isset( $error['customer_mailaddress1'] )  ||  ( isset( $error['customer_mailaddress1'] ) ) ) {
			echo '<br/><span class="error-txt">'. __('Missing email address. Please correct and try again.','WP-OliveCart').'</span>';
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Confirm Email','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input"><input type="text" name="customer_mailaddress2" class="inputitem02" value="<?php echo $in['customer_mailaddress2']; ?>" placeholder="<?php _e('(Check Emailaddress)','WP-OliveCart');?>" />
		<?php
		if ( isset( $error['customer_mailaddress2'] ) ) {
			echo '<br/><span class="error-txt">'. __('Missing confirm email. Please correct and try again.','WP-OliveCart').'</span>';
		} 
		?>
		</dd>
		</dl>
		</div>
		<h3><?php _e('Shipping address','WP-OliveCart'); ?></h3>

		<!--お届け先ここから-->     
		<div class="member-register">
		<dl class="customer-info">
		<dt class="customer-info-title"><?php _e('Name','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text" name="delivery_name" class="inputitem02" value="<?php echo $in['delivery_name'];?>"  placeholder="<?php _e('Shipping address and billing address are different','WP-OliveCart');?>"/>
		<?php
		if ( isset ( $error['delivery_name'] ) ) {
			echo '<br /><span class="error-txt">'. __('Missing First Name field. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Postal Code','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text"  id="PostalCode2" name="delivery_zip" class="postal" value="<?php echo $in['delivery_zip'];?>" />
		<?php echo apply_filters('zip_serch2', '');
		if ( isset( $error['delivery_zip'] ) ) {
			echo  '<br /><span class="error-txt">'. __('Missing Postal Code. Please correct and try again.','WP-OliveCart').'</span>';
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Prefecture','WP-OliveCart'); ?></dt>
		<dd class="customer-info-input"><select name="delivery_pref" id="pref2" class="pref-s">';
		<?php
		$count=0;
		foreach ($_pref as $value ) { 
			if( $count == $in['delivery_pref'] ) { echo "<option value=\"$count\" selected>$value</option> \n"; }
			else { echo  "<option value=\"$count\">$value</option> \n"; }
			$count++;
		}
		?>
		</select> 
		<?php
		if ( isset( $error['delivery_pref'] ) ) {
			echo '<br /><span class="error-txt">'. __('Missing prefecture. Please correct and try again.','WP-OliveCart').'</span>';
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Address','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text" name="delivery_address" class="inputitem02"  id="olivecart-area2" value="<?php echo $in['delivery_address']; ?>" />
		<?php
		if ( isset( $error['delivery_address'] )  ) {
			echo '<br /><span class="error-txt">'. __('Missing Address. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		<dt class="customer-info-title"><?php _e('Phone','WP-OliveCart');?></dt>
		<dd class="customer-info-input"><input type="text" name="delivery_tel" class="inputitem02" value="<?php echo $in['delivery_tel'];?>"  placeholder="000-000-0000"/>
		<?php
		if ( isset( $error['delivery_tel'] ) ) { 
			echo '<br /><span class="error-txt">'. __('Missing phone number. Please correct and try again.','WP-OliveCart').'</span>'; 
		}
		?>
		</dd>
		</dl>
		</div>
		<!--ここまで-->
		</form>
		<div class="submit">
		<p><input type="submit" value="<?php _e('Back','WP-OliveCart'); ?>" onClick="history.back();"  class="previous-page" /> 
		&nbsp;
		<input type="submit" value="<?php _e('Continue','WP-OliveCart'); ?>" onClick="document.Form.submit();"  class="next-page"/> 
		</p>
		</div>
		<?php
	}
}
new OliveCart_Step2;

?>