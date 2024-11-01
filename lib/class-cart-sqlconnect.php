<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Sqlconnect
{
/*Databaseserver mysql connection*/
	function DBstock_update(){
		global $wpdb;
		$new_stock 	=	null;
		$personaldata	=	( new OliveCart_Session )->sission_cart();
		$this->table_name	=	$wpdb->prefix . 'cart_meta';
		foreach( $personaldata as $key=>$value ){
			$new_stock	=	$stock	=	'';
			list( $number,$array_no )	=	explode(':',$key);
			if( ! $array_no ){ $array_no=0; }
			$db	=	$wpdb->get_row( "SELECT * FROM ".$this->table_name. " WHERE meta_id='$number'");	
			@$stock	=	explode(':',$db->item_option_stock);
			
			if( ( $stock[ $array_no ] > 0 ) && ( $stock[ $array_no ] >= $personaldata[ $key ]['count'] ) ) {
				$stock[ $array_no ]	=	$stock[ $array_no ] - $personaldata[ $key ]['count'];
				foreach ( $stock as $key2 => $value2 ){ $new_stock .= $value2.':';}
				$new_stock  =	rtrim( $new_stock, ":" );
				$wpdb->query( "UPDATE ".$this->table_name. " SET item_option_stock='$new_stock' WHERE meta_id='$number'" );
			}
		}
	}
	function DBcart_read( $db_type = null,$id = null) {
		global $wpdb;
		$db    =  null;
		if( $db_type == 'edit' ){
			for ( $i =0; $i < count( $_POST['set01'] ) ; $i++ ) {
				$set01	=	sanitize_text_field( $_POST['set01'][ $i ] );
				$set02	=	sanitize_text_field( $_POST['set02'][ $i ] );
				$set03	=	sanitize_text_field( $_POST['set03'][ $i ] );
				$setid	=	sanitize_text_field( $_POST['id'][ $i ] );
				$wpdb->query( "UPDATE `CART_cartedit` SET set01='$set01',set02='$set02',set03='$set03' WHERE id='$setid'" );
			}
			$db='edit';
		}
		elseif( $db_type == 'tag_edit' ){
			$set04	=	sanitize_text_field(  $_POST['set04'] );
			$set04	=	preg_replace( '/\'/mi',"’",$set04 );
			$wpdb->query( "UPDATE `CART_cartedit` SET set04='$set04' WHERE id='$id'" );
		}
		else{
			if( ! empty( $id ) ){
				$db				=	$wpdb->get_row( "SELECT * FROM `CART_cartedit` WHERE id = '$id'", ARRAY_A);
				$db['set04']	=	preg_replace( '/’/mi',"'",$db['set04'] ); 
			}
			else{
				$result			=	$wpdb->get_results("SELECT * FROM `CART_cartedit`", ARRAY_A);
				foreach ($result as $row){
					$db[]		=	$row;
				}
			}
		}
		return $db;
	}

	function DBpostage_read( $type=null,$id=null ) {
		global $wpdb;
		$id    = esc_sql( $id );
		#$link  = $this->DB_access();
		if( $type == 'edit' ){
			for ( $i =0; $i < count( $_POST['postage01'] ) ; $i++ ) {
				$set01	=	sanitize_text_field( $_POST['postage01'][ $i ] );
				$set02	=	sanitize_text_field( $_POST['postage02'][ $i ] );
				$set03	=	sanitize_text_field( $_POST['postage03'][ $i ] );
				$setid	=	sanitize_text_field( $_POST['postageid'][ $i ] );
				$wpdb->query("UPDATE `CART_postage` SET postage01='$set01',postage02='$set02',postage03='$set03' where id='$setid'");
			}
			$db='edit';
		}
		else{
			if(isset($id)){
				$db	=	$wpdb->get_row( "SELECT * FROM `CART_postage`  WHERE id = '$id'", ARRAY_A);
			}
			else{
				$db	=	$wpdb->get_row( "SELECT * FROM `CART_postage`", ARRAY_A);
			}
		}
		return $db;
	}
	function DBcommission_read( $type=null,$id=null ) {
		global $wpdb;
		$id	=	esc_sql($id);
		#$link  = $this->DB_access();
		if($type=='edit'){
			for ( $i =0; $i < count( $_POST['name'] ) ; $i++ ){
				$name    = sanitize_text_field( $_POST['name'][ $i ] );
				$form    = sanitize_text_field( $_POST['form'][ $i ] );
				$charge  = sanitize_text_field( $_POST['charge'][ $i ] );
				$comment = sanitize_text_field( $_POST['comment'][ $i ] );
				$setid   = sanitize_text_field( $_POST['id'][$i]);
				$wpdb->query("UPDATE `CART_commission` SET name='$name',form='$form',charge='$charge',comment='$comment' WHERE id='$setid'");
			}
			$db	=	'edit';
		}
		else{
			$result	=	$wpdb->get_results( "SELECT * FROM `CART_commission`", ARRAY_A );
			foreach ( $result as $row ){
				$row['form2']			=	explode(',',$row['form']);
				$row['charge2']			=	explode(',',$row['charge']);
				$row['commission_no']	=	'commission_no'.$row['id'];
				if( isset( $_POST[ $row['commission_no'] ] ) ){
					$i					=	sanitize_text_field($_POST[$row['commission_no']]);
					$row['in_commission']	=	$i;
					@$row['price']			=	$row['charge2'][ $i ];
					$row['post_form']		=	$row['form2'][ $i ];
				}
				
				$db[]	=	$row;
			}
		}
		return $db;
	}
}

?>