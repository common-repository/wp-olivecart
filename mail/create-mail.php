<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( is_admin() or is_user_logged_in() ) {
$subject='ご注文いただきありがとうございます。';
$mail_m='●ご注文いただきありがとうございます（〈ショップ名〉）
 
#CustomerName#　さま
 
このたびは〈ショップ名〉にご注文いただきありがとうございます。
 
ご注文は、確かに、下記の内容にて承りました。
どうぞご確認ください。
ご不明な点ご質問等ございましたら、お気軽にお問合せ下さいますよう
お願いいたします。

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
 消費税:#ConsumptionTax#円
 送料:#Postage#円
 合計:#TotalAll#円
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
 

 
 
 
***********************************
〈ショップ名〉
〈ショップ　URL〉
〈ショップ　メールアドレス〉
〈ショップ　TEL〉
***********************************';
}
?>
