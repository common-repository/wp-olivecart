<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_DB_Access{
	function Cart_calculation() { 
		//cart total calculation
		$default_charge	=	0;
		$special_charge =	0;
		$total_all		=	0;
		$comm_price		=	0;
		$post_pref		=	0;
		$personaldata	=	( new OliveCart_Session )->sission_cart();
		$fileread		=	new OliveCart_Sqlconnect;
		if( empty($personaldata)){ return false; }
		foreach ( $personaldata as $key=>$value ) { 
				if( $special_charge > $personaldata[ $key ]['charge']){
					$special_charge	=	$special_charge;
				}
				else{
					$special_charge	=	$personaldata[ $key ]['charge'];
				}
			$count	=	$personaldata[ $key ]['count'];
			$price	=	$personaldata[ $key ]['price'];
			@$total	=	$price * $count;
			$total_all	+=	$total; 
			if( $personaldata[ $key ]['charge'] ) {	continue; }
			$default_charge	=	true;
		}
		$cart['total_all']=$total_all;
				#if (isset($_POST['payment'])) {
  		$postage = $fileread->DBpostage_read('',"1");
  		if( isset( $_POST['payment'] ) ){
	  		$payment = sanitize_text_field( $_POST['payment'] ); 
  			$payment = $fileread->DBcart_read('',$payment);//payment Read
  		}
  		$postage_price=explode(',',$postage['postage01']);
  		if( !empty( $_POST['delivery_pref'] ) ){ 
	  		$post_pref = sanitize_text_field( $_POST['delivery_pref'] );
	  		$post_pref = $post_pref - 1; 
	  	}
  		else{ 
	  		$post_pref = sanitize_text_field( $_POST['customer_pref'] );
	  		$post_pref = $post_pref - 1;
	  	}
  		$postage_all_price01   = explode(',',$postage['postage02']);
  		$postage_all_price02   = explode(',',$postage['postage03']);
  		@$postage['postage01'] = $postage_price[$post_pref];
  		if( $postage_all_price01[0] or @$postage_all_price01[1] ){
			if( $total_all >= $postage_all_price01[0] ){
				$postage['postage01'] = $postage_all_price01[1];
			}
		}
		if( $postage_all_price02[0] or @$postage_all_price02[1] ){
			if( $total_all >= $postage_all_price02[0] ){
				$postage['postage01'] = $postage_all_price02[1];
			}
		}
		$commission             = $fileread->DBcommission_read();
		
		$cart['payment_name']   = $payment['set01'];//paymant name
		if($postage['postage01'] < $special_charge ){
			$cart['postage'] = $special_charge;
		}
		elseif( ! $default_charge && isset( $special_charge ) ){
			$cart['postage']	=	$special_charge;
		}
		else{
			$cart['postage']	=	$postage['postage01'];
		}
		$chage_array			=	explode('<>',$payment['set02']);
		if( isset( $chage_array[0] )		) { $chage[]		=	explode(',', $chage_array[0] ); }
		if( isset( $chage_array[1] )		) { $chage[]		=	explode(',', $chage_array[1] ); }
		if( isset( $chage_array[2] )		) { $chage[]		=	explode(',', $chage_array[2] ); }
		if( isset( $chage_array[3] )       	) { $chage[]		=	explode(',', $chage_array[3] ); }
		if( isset( $commission[0]['price'] )) {	@$comm_price	+=	$commission[0]['price']; }
		if( isset( $commission[1]['price'] )) {	@$comm_price		+=	$commission[1]['price']; }
		if( isset( $commission[2]['price'] )) {	@$comm_price		+=	$commission[2]['price']; }
		if( isset( $commission[3]['price'] )) {	@$comm_price		+=	$commission[3]['price']; }
		@$cart1['total']	=	$total_all + $cart['postage'] + $comm_price;//cart total
		if(get_option('consumption_tax')){
			$cart['consumption_tax']	=	floor((get_option('consumption_tax')/100)*$total_all);
			$cart1['total']				=	$cart1['total']+$cart['consumption_tax'];
		}
		sort($chage);
		foreach ($chage as $value){
 			if($value[0] <= $cart1['total']){ 
	 			if( isset( $value[1] ) ){ $cart['payment_charge'] = $value[1]; }
	 		}
 		}
 		if( empty($cart['payment_charge'] )){ $cart['payment_charge']	=	0; }
 		$cart['charge_total']   =	$comm_price + $cart['payment_charge'];
 		$cart['total']          =	$cart1['total'] + $cart['payment_charge'];
		return $cart;
	}
 
}
?>