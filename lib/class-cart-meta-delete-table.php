<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Meta_Delete_Table {
	public function __construct() {
		global $wpdb;
		add_action ('delete_post', array($this, 'dalete_meta'));
		$this->table_name = $wpdb->prefix . 'cart_meta';
	}
	function dalete_meta($post_id) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "DELETE FROM ".$this->table_name." WHERE post_id = %d", $post_id) );
	}

	function get_meta($post_id) {
	#return 'test11344';
		#if (!is_numeric($post_id)) return;
		global $wpdb;
		$get_meta = $wpdb->get_results(
						$wpdb->prepare( "SELECT * FROM ".$this->table_name."  WHERE post_id = %d", $post_id)
					);
		return isset($get_meta[0]) ? $get_meta[0] : null;
	}
}
$olivecart_meta = new OliveCart_Meta_Delete_Table;
?>