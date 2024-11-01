<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Meta_Save_Table {
	public function __construct() {
		global $wpdb;
		add_action ('save_post', array($this, 'save_meta'));
		$this->table_name = $wpdb->prefix . 'cart_meta';
	}
	function save_meta($post_id) {
	if (!isset($_POST['olivecart_submit'])) return; 

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  return;
		global $wpdb;
		global $post;

	//Does not exist in revision
		if ($post->ID != $post_id) return;

		//Sanitize $_POST text field
		$content   =	preg_replace("/</sm",'&lt;',$_POST['content']); 
		$content   =	preg_replace("/>/sm",'&gt;',$content);
		$content   =	preg_replace("/\\n/sm",'&#010;',$content);
		$temp_page_content	=	sanitize_text_field( $content );
		$temp_item_title	=	sanitize_text_field( $_POST['item_title'] );
		$temp_item_number	=	sanitize_text_field( $_POST['item_number'] );
		$temp_page_title	=	sanitize_text_field( $_POST['post_title'] );
		$array_count 		=	count( $_POST['item_option_stock'] );
		for( $i = 0; $i < $array_count; $i++ ){
			if( $i == ( $array_count - 1 )  ){ $add = ''; } else { $add = ':'; }
			//Sanitize $_POST text option field
			$temp_item_option_name   .=	sanitize_text_field( $_POST['item_option_name'][ $i ]  ).$add;
			$temp_item_option_stock  .=	sanitize_text_field( $_POST['item_option_stock'][ $i ] ).$add;
			$temp_item_option_price  .=	sanitize_text_field( $_POST['item_option_price'][ $i ] ).$add;
		}
		
		//Japanese convert
		$temp_item_option_name		=	mb_convert_kana( $temp_item_option_name, "a" );
		$temp_item_option_stock   	=	mb_convert_kana( $temp_item_option_stock,"a" );
		$temp_item_option_price   	=	mb_convert_kana( $temp_item_option_price,"a" );
		
		//Delete ,,
		$temp_item_option_name		=	preg_replace("/\,/sm",'',$temp_item_option_name);
		$temp_item_option_stock   	=	preg_replace("/\,/sm",'',$temp_item_option_stock);
		$temp_item_option_price   	=	preg_replace("/\,/sm",'',$temp_item_option_price);
		
		$date_array					=	getdate();
		$temp_item_post_date		=	$date_array['year'].'/'.$date_array['mon'].'/'.$date_array['mday'];
	//Save array to database
		$set_arr = array(
			'page_title'			=> $temp_page_title,
			'page_content'			=> $temp_page_content,
			'item_title'			=> $temp_item_title,
			'item_number' 			=> $temp_item_number,
			'item_option_name' 		=> $temp_item_option_name,
			'item_option_stock' 	=> $temp_item_option_stock,
			'item_option_price' 	=> $temp_item_option_price,
			'item_option_charge' 	=> $temp_item_option_charge,
			'item_post_date' 		=> $temp_item_post_date
		);
		$get_id = $wpdb->get_var(
	            	$wpdb->prepare( "SELECT post_id FROM ".$this->table_name."  WHERE post_id = %d", $post_id)
				);
		if ($get_id) {
			$wpdb->update( $this->table_name, $set_arr, array('post_id' => $post_id));
		} else {
			$set_arr['post_id'] = $post_id;;
			$wpdb->insert( $this->table_name, $set_arr);
		}
		$wpdb->show_errors();
	}	
}
new OliveCart_Meta_Save_Table;
?>