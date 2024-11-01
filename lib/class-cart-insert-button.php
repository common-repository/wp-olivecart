<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
new OliveCart_Insert_Button;
class OliveCart_Insert_Button{
	public function __construct() {
		add_filter( 'the_content', array( $this,'insert_button' )); 
	}
	function insert_button( $content,$id = null ){	
		global $wpdb;
		
		if( ! $id ){
			$id				=	get_the_ID(); 
			if( ! strstr( $content,'<!--cart_button' ) ){
				$content	=	$content.'<!--cart_button-->';
			}
		}
		$query 						=	null;
		$table_name 				=	$wpdb->prefix . 'cart_meta';
		$cart_add_button_position	=	get_option('cart_add_button_position');
		while (1){
			if( preg_match("/(.*)<!--cart_button([0-9a-zA-Z-_]*)-->(.*)/sm",$content,$match) ){
				if( $match[2] ){
					$items_number	=	$match[2];
					$query 			=	"SELECT * FROM ".$table_name." WHERE item_number='$items_number'";
					$GLOBALS['olive_cart_button'][ $id ]	=	true;	
				}
				elseif(!(isset($GLOBALS['olive_cart_button'][ $id ])) && !$match[2]){
					$query	=	"SELECT * FROM ".$table_name." WHERE post_id='$id'";
					$GLOBALS['olive_cart_button'][ $id ]	=	true;				
			}
			
			$option1 = get_option('cart_button_other_option1');
			$result =$wpdb->get_results( $query );
			
			if(!$result){break;}

			foreach( $result as $row ) {
				$cart_option1		=	explode(':',$row->item_option_name);
				$stock				=	explode(':',$row->item_option_stock);
				$items_number		=	$row->meta_id;
				foreach( $stock as $key=>$value ){
					if( $value or $value==='' or $value=='*' ){
				  		$cart_stock[$key] = true; 
				  	}
				 }
  		}
  		if( $cart_option1 ){
  			foreach( $cart_option1 as $key=>$value ){
	  			//cart items stock option 
  		 		if( $stock[ $key ]==='' || $stock[ $key ]=='*' ){ 
	  		 		$stock[ $key ]		=	10;
	  		 	} 
  		 		if( isset($stock[ $key ]) ){
	  		 		$item_count[ $key ]	=	$stock[ $key ];  
	  		 	} 
  		
  		 	}
  		}
  		$button_id = rand();
  		$nonce_url = wp_nonce_url('', 'olivecart_action', 'olivecart_nonce' );
  		$nonce_url	=	preg_replace( '/\?olivecart_nonce=/','',$nonce_url );
  		$button="\n".'<form name="form1'.$button_id.'" data-ajax="false">';
			if($cart_option1[0]){
			$onchange='onChange="change2_'.$button_id.'(this)"';
				$button.='
					<div class="cart_option1"  align="'.$cart_add_button_position.'">
					'.$option1.'
					<select name="selA'.$button_id.'" id="option1_'.$button_id.'" '.$onchange.'>
					<option value="">'.__('Select' ,'WP-OliveCart').'</option>';
				foreach ( $cart_option1 as $key=>$value ){
					if( $item_count[ $key ] ){ 
						$button 	.=	'<option value="'.$key.'">'.$value.'</option>'."\n";
						$all_stock	=	true;
					}
					else{
						$button	.=	'<option disabled="disabled">'.$value.'</option>'."\n";
					}
				}
				$button.='</select></div>';
			}
			
			if( isset( $cart_stock ) ) {
				$button2='';
				$button.='
				<div class="cart_count"  align="'.$cart_add_button_position.'">
				'.__('Quantity' ,'WP-OliveCart').'：
				<select  name="selC'.$button_id.'" id="count_'.$button_id.'">
				<option value="">'.__('Select' ,'WP-OliveCart').'</option>
				</select>
				</div>
				<script type="text/javascript" language="JavaScript">
				';
					if($cart_option1[0]){
						$button.='var bunruiC'.$button_id.'   = new Array();'."\n";
						foreach ($item_count as $key=>$value){
							$button2='';
							$button.='bunruiC'.$button_id.'["'.$key.'"]  = new Array(';
							for ($f =1; $f <= $value ; $f++){ $button2.='"'.$f.'"'.','; }
								$button2 = rtrim($button2, ",");
								$button.=$button2;
								$button.=');'."\n";
						}
						$button.='
						function change2_'.$button_id.'(obj){
							OliveCart_createSelection(form1'.$button_id.'.elements[\'selC'.$button_id.'\'], "'
							.__('Select' ,'WP-OliveCart').
							'", bunruiC'.$button_id.'[obj.value], bunruiC'.$button_id.'[obj.value]);
						}';
					}
					else{
						$button.='
						var bunruiC'.$button_id.'  = new Array(';
							foreach ( $item_count as $key=>$value ){ 
								$all_stock=true;
								$button2=''; 
								for ($f =2; $f <= $value ; $f++){ $button2.='"'.$f.'"'.','; }
								$button2 = rtrim($button2, ",");
								$button.=$button2;
								$button.=');'."\n";
							}
						$button.='
						OliveCart_createSelection(form1'.$button_id.'.elements[\'selC'.$button_id.'\'], "1", bunruiC'.$button_id.', bunruiC'.$button_id.');';
					}
					$button.='</script>';
			}
			if( isset( $all_stock ) ){
						$button.='
						<div class="cart_button" align="'.$cart_add_button_position.'">
						<input type="button" value="'.__('Add to Cart' ,'WP-OliveCart').'" onClick="OliveCart_postIn(\''.$button_id.'\',\''.$items_number.'\',\''.$nonce_url.'\')"  class="add-cart" />
						
						</div>
						</form>
						';	
				}
				else{
					$button='<div class="cart_button" align="'.$cart_add_button_position.'"><p>'.__('SOLD OUT' ,'WP-OliveCart').'</p></div>'."\n";
				}
				$content		=	$match[1].$button.$match[3];
				$stock_total	=	$button = $button2 = $cart_stock = $items_number='';
				$item_count		=	$cart_option1 = $cart_option2 = $match=array();
			}
			else
			{
				break;
			}
		}
	return $content;
	}
}
?>
