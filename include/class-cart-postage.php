<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Postage {
var $pagehook;
	//load page
	function on_load() {
		$help_message = new OliveCart_Help;
		$current_screen = get_current_screen();
		$admin_screen   = WP_Screen::get($current_screen->id);
		$this->pagehook = $current_screen->id;

		/*Help option*/
		$admin_screen->add_help_tab(
			array(
				'title'    => __('help2','WP-OliveCart'),
				'id'       => 'help_tab',
				'content'  => $help_message->message(),
				'callback' => false
			)
		);
		wp_enqueue_script('postbox');
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
		add_meta_box( 'total_postage_setup' ,__('Total Postage Setup','WP-OliveCart'),
		array(&$this, 'total_postage_setup'),  $this->pagehook, 'normal', 'core');

    }
	function on_action(){
		global $wpdb;
		//wp_nonce_field check_admin_referer
		if( isset( $_POST['action'] ) && ( check_admin_referer( 'olivecart_action', 'olivecart_field' ) ) ){  
			$postage02_1 = sanitize_text_field( $_POST['postage02_1'] );
			$postage02_2 = sanitize_text_field( $_POST['postage02_2'] );
			$postage03_1 = sanitize_text_field( $_POST['postage03_1'] );
			$postage03_2 = sanitize_text_field( $_POST['postage03_2'] );
			$postage_set02 = $postage02_1.','.$postage02_2;
			$postage_set03 = $postage03_1.','.$postage03_2;
			$query =  "UPDATE CART_postage SET postage02='$postage_set02',postage03='$postage_set03' WHERE id=1";
			$wpdb->query($query);
			$this->message  = '<div id="message" class="updated below-h2"><p>'.__('Postage data updated','WP-OliveCart').'</p></div>';
		}
		$mylink  = $wpdb->get_row( "SELECT * FROM CART_postage WHERE id = 1" );
		$this->title      = __('Postage Setup','WP-OliveCart');
		$this->icon       = 'cart';
		return $mylink;
	}
    

    function on_show_page() {
		global $wpdb;
		$field_value 	=	$this->on_action();
		$this->action	=	'OliveCart_Postage_Edit';
		$this->check 	=	'';
		add_meta_box('save_sidebox',__('Save','WP-OliveCart'), array(&$this, 'save_sidebox'), $this->pagehook, 'side', 'core');
		require( dirname(__FILE__).'../../lib/admin/on-showpage1.php');

	}

	function save_sidebox() {
		require( dirname(__FILE__).'../../lib/admin/on-sidebox.php');
	}


	function total_postage_setup($field_value) {
		$total01 = explode(',',$field_value->postage02 );
		$total02 = explode(',',$field_value->postage03 );
		$From    = __('Total:',   'WP-OliveCart');
		$Postage = __('Over   Postage:','WP-OliveCart');
		$en      = __('JPY', 'WP-OliveCart');
		require( dirname(__FILE__).'../../lib/admin/total-postage-setup.php');
	}


}
?>