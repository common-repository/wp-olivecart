<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Button {
	public function __construct() {
		add_filter('cart_button',array($this,'cart_button'));
	}
	function cart_button() {
		echo '
		<div id="loginbutton">
		<input type="submit" value="'.__('Cart Preview' ,'WP-OliveCart').'" onClick="OliveCart_Step2(); "  class="submit-login" />
		</div>
		';
	}
}
new OliveCart_Button;
?>
