<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Mail_Access{
	function mail_read( $type=null ){
		if( $type == 'Customer' && isset( $_POST['payment'] )) {
			$payment = sanitize_text_field( $_POST['payment'] );
			$db							=	( new OliveCart_Sqlconnect )->DBcart_read( '',$payment );
			$GLOBALS['Mail_subject'] 	=	$db['set05'];
			$str = $db['set06'];
		}elseif( $type == 'Shop' ){
			$GLOBALS['Mail_subject']	=	get_option('s_subject');
			$GLOBALS['Mail_subject']	=	$this->change_tag( $GLOBALS['Mail_subject'] );
			$str						=	get_option('s_mail_m'); 
		}
		elseif( $type == 'Member' ){
			$GLOBALS['Mail_subject']	=	get_option('p_subject');
			$str						=	get_option('p_mail_m'); 
		}
		return $str;
	}

	function maillist_read_session( $list_tag ){
		$personaldata	=	( new OliveCart_Session )->sission_cart();
		$goukeikakaku 	= 	$cart_in 	=	null;
		foreach ( $personaldata as $key => $val ){
			$item	=	$personaldata[ $key ]['title'];
			$count	=	$personaldata[ $key ]['count'];
			$price	=	$personaldata[ $key ]['price'];
			$option	=	$personaldata[ $key ]['option'];
			$number	=	$personaldata[ $key ]['number'];
			@$total	=	$price * $count;
			$total	=	@number_format( $total );
			$price	= 	@number_format( $price );
			foreach ( $list_tag as $value ){
				$value		=	rtrim( $value );
				$value 		=	preg_replace( '/</',"",$value);
				$value 		=	preg_replace( '/>/',"",$value);
				$value		=	preg_replace("/#S_Number#/sm",$number,$value );
				$value		=	preg_replace("/#S_Name#/sm"  ,$item.$option,$value );
				$value		=	preg_replace("/#S_Price#/sm" ,$price,$value );
				$value		=	preg_replace("/#S_Count#/sm" ,$count,$value );
				$value		=	preg_replace("/#S_Total#/sm" ,$total,$value );
				$cart_in	.=	$value;
			}
		}
		return $cart_in;
	}

	function change_tag( $str=null){
		require( dirname(__FILE__).'/../../conf/cart-form-conf.php');
		$comm						=	null;
		//$pref						=	$_pref[$_POST['customer_pref']];
		//$order_number				=	time();
		$GLOBALS['order_number']	=	time();
		$GLOBALS['order_time']		=	date_i18n('Y年m月d日 H時i分');
		$cart        				=	( new OliveCart_DB_Access )->Cart_calculation();
		$commission 				=	( new OliveCart_Sqlconnect )->DBcommission_read();
				
		if(!$cart['postage']){
			$cart['postage']		=	0; 
		}
		$total						=	@number_format( $cart['total'] );
		$charge						=	@number_format( $cart['charge_total'] );
		$consumption_tax			=	@number_format( $cart['consumption_tax'] );
		for($i =0; $i < 4; $i++){
			if( isset ( $commission[$i]['name'] ) ){
				@$comm		.=	$commission[$i]['name'].' '.$commission[$i]['post_form']."\n";
			}
		}
		if( $_POST ){
			foreach( $_POST as $key=>$value ){ 
				$in[$key] = sanitize_text_field( $value ); 
			}
			$pref	=	$_pref[ $in['customer_pref'] ];
			$str	=	preg_replace( "/#Payment#/sm",$cart['payment_name'],$str );
			$str	=	preg_replace( "/#Commission#/sm",$comm,$str );
			$str	=	preg_replace( "/#Comment#/sm",$in['comment'],$str );
			$str	=	preg_replace( "/#OrderTime#/sm",$GLOBALS['order_time'],$str );
			$str	=	preg_replace( "/#Password#/sm",@$GLOBALS['User_Password'],$str );
			$str	=	preg_replace( "/#OrderNumber#/sm",$GLOBALS['order_number'],$str );
			$str	=	preg_replace( "/#Postage#/sm",$cart['postage'],$str );
			$str	=	preg_replace( "/#Charge#/sm",$charge,$str );
			$str	=	preg_replace( "/#ConsumptionTax#/sm",$consumption_tax,$str );
			$str	=	preg_replace( "/#TotalAll#/sm",$total,$str );
			$str	=	preg_replace( "/#CustomerName#/sm",$in['customer_name'],$str );
			$str	=	preg_replace( "/#CustomerKana#/sm",$in['customer_kana'],$str );
			$str	=	preg_replace( "/#CustomerEmail#/sm",$in['customer_mailaddress1'],$str );
			$str	=	preg_replace( "/#CustomerZip#/sm",$in['customer_zip'],$str );
			$str	=	preg_replace( "/#CustomerAddress#/sm",$pref.$in['customer_address'],$str );
			$str	=	preg_replace( "/#CustomerTel#/sm",$in['customer_tel'],$str );
		}
		if( empty( $in['delivery_name'] ) ){
			$str	=	preg_replace( "/#DeliveryName#/sm",$in['customer_name'],$str );
			$str	=	preg_replace( "/#DeliveryZip#/sm",$in['customer_zip'],$str );
			$str	=	preg_replace( "/#DeliveryAddress#/sm",$pref.$in['customer_address'],$str );
			$str	=	preg_replace( "/#DeliveryTel#/sm",$in['customer_tel'],$str );
		}
		else {
			$pref2	=	$_pref[ $in['delivery_pref'] ];
			$str	=	preg_replace("/#DeliveryName#/sm",$in['delivery_name'],$str );
			$str	=	preg_replace("/#DeliveryZip#/sm",$in['delivery_zip'],$str );
			$str	=	preg_replace("/#DeliveryAddress#/sm",$pref2.$in['delivery_address'],$str );
			$str	=	preg_replace("/#DeliveryTel#/sm",$in['delivery_tel'],$str );
		}
		$str =	preg_replace( '/</',"",$str);
		$str =	preg_replace( '/>/',"",$str);
		return $str;
	}

	function mail_send( $str,$type ){
		$mail					=	null;
		$sendmaill_address1		=	get_option('sendmail_address1');
		$sendmaill_address2 	=	get_option('sendmail_address2');
		$mail					=	$sendmaill_address1;
		$SHOP_MAILADDRESS		=	$mail;
		$str 					=	preg_replace( '/&#010;/',"\n",$str);
		if($sendmaill_address2){
			$mail	=	$sendmaill_address1.','.$sendmaill_address2;
		}
		if( ! $sendmaill_address1 ){
			$mail				=	get_option('admin_email');
			$SHOP_MAILADDRESS	=	$mail;
		}
		if( $type == 'Customer' ){
			$mail				=	null;
			$mail				=	sanitize_text_field( $_POST['customer_mailaddress1'] ); 
		}
			# $return_path = '-f '.SHOP_MAILADDRESS;
 		$blogname				=	wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
 		$headers				=	"From: \"{$blogname}\" <{$SHOP_MAILADDRESS}>\n".
 		"Content-Type: text/plain; charset=\"UTF-8\"\n";
 		
 		wp_mail( $mail,$GLOBALS['Mail_subject'],$str,$headers );
	}

	function Send_mail( $type ){
		$str	=	$this->mail_read( $type );
		if( preg_match("/(.*)#OrderList_Start#(.*)#OrderList_End#(.*)/sm",$str,$list_str ) ){
			$list_tag[]		=	rtrim( $list_str[2] );
			$list_str[1]	=	rtrim( $list_str[1] );
			$list_str[3]	=	rtrim( $list_str[3] );
		}
		elseif( preg_match("/(.*)<OrderList>(.*)<\/OrderList>(.*)/sm",$str,$list_str ) ){
			$list_tag[]		=	rtrim( $list_str[2] );
			$list_str[1]	=	rtrim( $list_str[1] );
			$list_str[3]	=	rtrim( $list_str[3] );
		}
		else {
			die('mail tag error not found OrderList tag');
		}
		$list	=	$this->maillist_read_session( $list_tag ); 
		$str	=	$list_str[1].$list.$list_str[3];
		$str	=	$this->change_tag( $str );
		$this->mail_send( $str,$type );
	}
}
?>