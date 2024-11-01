<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OlvieCart_Widget 
	{
		public function __construct() {
			add_filter('mini_cart',array($this,'minicart'));
		}
		public  function minicart() {
			$personaldata	=	( new OliveCart_Session )->sission_cart();
			echo '<div id="maincart">
				<table id="minicart">
				<tr>
				<th class="thitem">'.__('Items','WP-OliveCart').'</th>
				<th class="thcount"> '.__('Quantity','WP-OliveCart').'</th>
				</tr>
				';
				if ( $personaldata ) {
					$total = null;
					foreach ( $personaldata as $key=>$value ) {
						$item		= 	$personaldata[$key]['title'];
						$count		= 	$personaldata[$key]['count'];
						$price		= 	$personaldata[$key]['price'];
						$option		= 	$personaldata[$key]['option'];
						@$total		+=	$price*$count;
						echo '
						<tr>
						<td class="item">'.$item.' '.$option.'</td>
						<td class="count">'.$count.'</td>
						</tr>
						';
					}
					echo '
					<tr>
					<td colspan="2" class="total">'.__('Total','WP-OliveCart').'¥'.@number_format($total).'</td>
					</tr>
					</table>
					<p><input type="submit" value="'.__('Go to Checkout' ,'WP-OliveCart').'" onClick="OliveCart_Step2();" /></p>
					</div>
					';
				}
				else{
					echo '<tr><td  colspan="2" class="empty">'.__('Your Shopping Cart is Empty','WP-OliveCart').'</td></tr></table></div>';
				}
		}
}
new OlvieCart_Widget;
?>