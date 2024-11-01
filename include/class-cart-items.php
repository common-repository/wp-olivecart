<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Items{
	function manage_posts_columns( $columns ) {
		$columns['items_title']		= __('Item Title' ,'WP-OliveCart');
		$columns['items_number']	= __('Item Number' ,'WP-OliveCart');
		$columns['thumbnail']		= __('Thumbnail');
		$columns['date']			= __('Date');
		unset( $columns['comments'] );
		unset( $columns['date'] );
		return $columns;
	}
	function add_column( $column_name,$post_id ) {
		global $wpdb;
		//get custom field value
		$this->table_name = $wpdb->prefix . 'cart_meta';
		$mylink           = $wpdb->get_row( "SELECT * FROM ".$this->table_name. " WHERE post_id = '$post_id'" );
		if( $column_name == 'items_title' ) {
			if( isset( $mylink->item_title ) ) { $stitle = $mylink->item_title; }
		}
		if( $column_name == 'items_number' ) {
			if( isset( $mylink->item_number ) ) { $stitle = $mylink->item_number; }
		}
		//get thumbnail 
    	if ( 'thumbnail' == $column_name ) {
    		$thum = get_the_post_thumbnail( $post_id, array(50,50), 'thumbnail' );
		}
    	if ( isset( $stitle ) && $stitle ) { echo esc_attr($stitle);}
		else if ( isset( $thum ) && $thum ) { echo $thum;}
		else { echo __('None');}
	}
}


