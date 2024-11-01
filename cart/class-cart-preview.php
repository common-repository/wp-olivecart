<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Previrew{
   	public function __construct() {
		add_filter('cart_preview',array($this,'cart_design'),10);
	}
	function cart_design( $in = null ) {
		$out =null;
		$cart['payment_charge'] =	null;
		$cart['postage']		=	null;
		if( isset ( $_POST['payment'] ) ){
			$cart			=	( new OliveCart_DB_Access  )->Cart_calculation( );
		}
		$personaldata		=	( new OliveCart_Session    )->sission_cart();
		$commission			= 	( new OliveCart_Sqlconnect )->DBcommission_read();
		$total_all			=	null;
		if ( $personaldata ) {
			foreach ( $personaldata as $key=>$value ) {
				$item		= 	$personaldata[ $key ]['title'];
				$count		= 	$personaldata[ $key ]['count'];
				$price		= 	$personaldata[ $key ]['price'];
				$option		= 	$personaldata[ $key ]['option'];
				$post_id	= 	$personaldata[ $key ]['post_id'];
				@$total		=	$price * $count;
				$total_all += 	$total;
				//Get Thumbnail
				$image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), true);
				$image= $image_url[0];
				$pluginDirUrl = plugins_url( '/', __FILE__ );
				if(empty($image))	{ $image = $pluginDirUrl.'images/noimage350.jpg'; }
				$numbe_view = '<input name="count[]" type="number" min="0" value="'.$count.'" class="inputitem01" />';
				if( isset($_REQUEST['step'] ) ) {
					if( $_REQUEST['step'] == '4' || $_REQUEST['step'] == '6' ) {
						$numbe_view = $count;
					}
				}
				$out .=  '
				<div class="cart-order-item">
					<div class="cart-item-image"><img src="'.$image.'"/></div>
					<div class="cart-item-detile">
						<div class="cart-item-name">'.$item.' '.$option.'</div>
						<div class="cart-item-unit-price">'.__('Price' ,'WP-OliveCart').'：￥'.@number_format( $price ).'</div>
						<div class="cart-item-quantity">'.__('Quantity' ,'WP-OliveCart').'：'.$numbe_view.'</div>
						<div class="cart-item-total">'.__('Subtotal' ,'WP-OliveCart').'：￥'.@number_format( $total ).'</div>
					</div>
					<input type=hidden name=number[] value="'.$key.'">
					<div class="clear"></div>
				</div>';
			}
			$charge_f = "";
			if(  $cart['payment_charge']  ) {
				$out .= '<div class="order-chage">';
				$charge_f = true;
				//$total_all	+=	$cart['payment_charge'];
				$out .= '
				<div class="order-chage-title">'.$cart['payment_name'].__(':charge commission','WP-OliveCart').'</div>
				<div class="cart-chage">￥'.@number_format( $cart['payment_charge'] ).'</div>';
			}
			foreach ( $commission  as $row ) {
				if(! empty( $row['price'] ) ) {
					//$total_all	+=	$row['price'];
					if(empty($charge_f)){
						$out .= '<div class="order-chage">';
						$charge_f = true;
					}
					$out .= '
						<div class="order-chage-title">'.$row['name'].__(':charge commission','WP-OliveCart').'</div>
						<div class="cart-chage">￥'.@number_format( $row['price'] ).'</div>';
				}
			}
			
			if(  $cart['postage']  ) { 
				
				//$total_all	+=	$cart['postage'];
				if(empty($charge_f)){
						$out .= '<div class="order-chage">';
						$charge_f = true;
				}
				$out .= '	
				<div class="order-chage-title">'.__('Postage ' ,'WP-OliveCart').'</div>
				<div class="cart-chage">￥'.@number_format( $cart['postage'] ).'</div>';
			}
			
			if( get_option('consumption_tax')  ){
				$consumption_tax	=	floor( ( get_option('consumption_tax') / 100) * $total_all );
				$total_all			=	$total_all + $consumption_tax;
				if(empty($charge_f)){
						$out .= '<div class="order-chage">';
						$charge_f = true;
				}
				$out .= '
				<div class="order-chage-title">'.__('Consumption Tax' ,'WP-OliveCart').'</div>
				<div class="cart-chage">￥'.@number_format($consumption_tax).'</div>';
			}
			if(  $charge_f  ){ $out .= '</div>'; }
			if( isset( $cart['total'] ) ){$total_all=$cart['total'];}
			$out .= '
				<div class="order-summary">
				<div class="order-summary-title">'.__('Total' ,'WP-OliveCart').'</div>
				<div class="cart-total">￥'.@number_format( $total_all).'</div>
				</div>';
		}
		else {
			$out .='
			<div class="order-summary">
			<div class="order-summary-title">'.__('Total' ,'WP-OliveCart').'</div>
			<div class="cart-empty">'.__('Your Shopping Cart is Empty' ,'WP-OliveCart').'</div>
			</div>';
		}
		return $out;
	}
}
new OliveCart_Previrew();
?>