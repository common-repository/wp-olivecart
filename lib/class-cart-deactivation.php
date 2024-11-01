<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Deactivation {
	function _remove() {
		global $wpdb;
		$page_id1 = get_option('cart_page_id');
		wp_delete_post($page_id1);
		delete_option('cart_page_id');
		delete_option('cart_button_other_option1');
		delete_option('sendmail_address1');
		delete_option('s_subject');
		delete_option('s_mail_m');
	}
}

?>