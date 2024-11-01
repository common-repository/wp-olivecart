<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( is_admin() or is_user_logged_in() ) {
$subject='ご注文メール';
$mail_m='
以下の内容で注文がありました。

◆ご注文内容
ご注文日時 #OrderTime#
ご注文番号 #OrderNumber#
お支払い方法 #Payment#
#Commission#
コメント
#Comment#
-----------------------------------
◆ご注文内容
-----------------------------------
#OrderList_Start#
 商品名:#S_Name#　
 価格:#S_Price#円   
 数量:#S_Count#個　    
 小計:#S_Total#円
#OrderList_End#
===================================
 手数料:#Charge#円
 送料:#Postage#円
 消費税:#ConsumptionTax#円
 合計:#TotalAll#円
-----------------------------------
-----------------------------------

◆お客様情報
-----------------------------------
お名前    :#CustomerName#様
ふりがな  :#CustomerKana#様
E-mail    :#CustomerEmail#
郵便番号  :〒#CustomerZip#
ご住所    :#CustomerAddress#
電話番号  :#CustomerTel#
-----------------------------------

◆お届先情報
-----------------------------------
お名前    :#DeliveryName#様
郵便番号  :〒#DeliveryZip#
ご住所    :#DeliveryAddress#
電話番号  :#DeliveryTel#
-----------------------------------



********************************************
Shoping Cart System by wp-olivecart
********************************************';
}
?>
