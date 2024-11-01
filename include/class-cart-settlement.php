<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Settlement {
var $pagehook;
	//load page
	function on_load() {
		$help_message = new OliveCart_Help;
		$current_screen = get_current_screen();
		$this->pagehook=$current_screen->id;
		$admin_screen = WP_Screen::get($current_screen->id);
		/*Help option*/
		$admin_screen->add_help_tab(
			array(
				'title'    => __('help','WP-OliveCart'),
				'id'       => 'help_tab',
				'content'  => $help_message->message(),
				'callback' => false
			)
		);
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
		wp_enqueue_script('postbox');
		add_meta_box( 'settlement_method1'  ,__('Settlement Method No1',  'WP-OliveCart'),
		array(&$this, 'settlement_method1'),   $this->pagehook, 'normal', 'core');
		add_meta_box( 'settlement_method2'  ,__('Settlement Method No2','WP-OliveCart'),
		array(&$this, 'settlement_method2'), $this->pagehook, 'normal', 'core');
		add_meta_box( 'settlement_method3',  __('Settlement Method No3' ,'WP-OliveCart'),
		array(&$this, 'settlement_method3'),  $this->pagehook, 'normal', 'core');


    }

	function on_action(){	
		global $wpdb;
		//wp_nonce_field check_admin_referer
		if( isset( $_POST['action'] ) && ( check_admin_referer( 'olivecart_action', 'olivecart_field' ) ) ){
			for ($i =0; $i < count($_POST['set01']) ; $i++){
				if( isset( $_POST['set01'][$i] ) ){ $set01 = sanitize_text_field( $_POST['set01'][$i] ); }
				@$set02  = sanitize_text_field( $_POST['chage1_1'][$i] ).','.sanitize_text_field( $_POST['chage1_2'][$i] ).'<>';
				@$set02 .= sanitize_text_field( $_POST['chage2_1'][$i] ).','.sanitize_text_field( $_POST['chage2_2'][$i] ).'<>';
				@$set02 .= sanitize_text_field( $_POST['chage3_1'][$i] ).','.sanitize_text_field( $_POST['chage3_2'][$i] ).'<>';
				@$set02 .= sanitize_text_field( $_POST['chage4_1'][$i] ).','.sanitize_text_field( $_POST['chage4_2'][$i] );
				$set03   = sanitize_text_field( $_POST['set03'][$i] );
				$setid   = sanitize_text_field( $_POST['in_id'][$i] );
				$setid   = sanitize_text_field( $setid );
				$query   = "update CART_cartedit set set01='$set01',set02='$set02',set03='$set03' where id='$setid'";
				$wpdb->query($query);
			}
			$this->message = '<div id="message" class="updated below-h2">
			<p>'.__('Settlement Method Setup data updated','WP-OliveCart').'</p>
			</div>';
		}

		$mylink =$wpdb->get_results('SELECT * FROM CART_cartedit');
		$this->title      = __('Settlement Method Setup','WP-OliveCart');
		$this->action     = 'edit';
		$this->icon       = 'cart';
		return $mylink;
	}
    

    function on_show_page() {
		global $wpdb;
		$field_value = $this->on_action();
		$this->check = '';
		add_meta_box('save_sidebox',__('Save','WP-OliveCart'), array(&$this, 'save_sidebox'), $this->pagehook, 'side', 'core');
		require( dirname(__FILE__).'../../lib/admin/on-showpage1.php');
	}

	function save_sidebox() {
		require( dirname(__FILE__).'../../lib/admin/on-sidebox.php');
	}

	function settlement_method1($field_value) {
		$method_type='0';
		require( dirname(__FILE__).'../../lib/admin/settlement-method.php');
	}
	function settlement_method2($field_value) {
		$method_type='1';
		require( dirname(__FILE__).'../../lib/admin/settlement-method.php');
	}
	function settlement_method3($field_value) {
		$method_type='2';
		require( dirname(__FILE__).'../../lib/admin/settlement-method.php');
	}


}

?>