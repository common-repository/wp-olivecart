<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Step1 {
	public function __construct() {
		add_filter('cart-step1',array($this,'step1'),10,2);
	}

	function step1() {	
		$nonce_url = wp_nonce_url('', 'olivecart_action', 'olivecart_nonce' );
		?>
		<form name="Form4"  method="post" action="">
		<?php wp_nonce_field( 'olivecart_action', 'olivecart_nonce' ); ?>
		<input type=hidden name=mode value="retry">
		<input type=hidden name=step value="1">
		<?php echo  apply_filters('cart_preview', '1'); ?>
		</form>
		<div class="submit">
		<p><input type="submit" value="<?php _e('Update' ,'WP-OliveCart');?>" onClick="document.Form4.submit();"  class="recalc"/> 
		<input type="submit" value="<?php _e('Empty your cart' ,'WP-OliveCart');?>" onClick="location.href =('<?php echo get_option('home');?>?page_id=<?php echo get_option('cart_page_id'); ?>&mode=empty')" class="recalc" />
		<input type="submit" value="<?php _e('Go to Checkout' ,'WP-OliveCart');?>" onClick="location.href =('./<?php echo $nonce_url;?>&page_id=<?php echo get_option('cart_page_id'); ?>&step=2')"  class="submit-order"/></p>
		<p><input type="submit" value="<?php _e('Back to Shopping','WP-OliveCart');?>" onClick="location.href =('<?php echo get_option('home');?>/')" class="back-shopping"/></p>
		</div>
	<?php
	}
}
new OliveCart_Step1;

?>