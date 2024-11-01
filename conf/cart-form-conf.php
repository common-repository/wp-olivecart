<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( !is_admin() or !is_user_logged_in() ) {
//requied form 1=yes 0=no
$_indispen	=	array(
	'customer_name'			=>	'1',
	'customer_kana'			=>	'0',
	'customer_tel'			=>	'1',
	'customer_zip'			=>	'1',
	'customer_pref'			=>	'1',
	'customer_address'		=>	'1',
	'customer_mailaddress1'	=>	'1',
	'customer_mailaddress2'	=>	'1'
);

$_deliver=array(
	'delivery_name'		=>	'1',
	'delivery_zip'		=>	'1',
	'delivery_pref'		=>	'1',
	'delivery_address'	=>	'1',
	'delivery_tel'		=>	'1'
);

/*Japanese Pref Setting*/
$_pref		=	array(
'選択してください',
'北海道',
'青森県',
'岩手県',
'宮城県',
'秋田県',
'山形県',
'福島県',
'茨城県',
'栃木県',
'群馬県',
'埼玉県',
'千葉県',
'東京都',
'神奈川県',
'山梨県',
'長野県',
'新潟県',
'富山県',
'石川県',
'福井県',
'岐阜県',
'静岡県',
'愛知県',
'三重県',
'滋賀県',
'京都府',
'大阪府',
'兵庫県',
'奈良県',
'和歌山県',
'鳥取県',
'島根県',
'岡山県',
'広島県',
'山口県',
'徳島県',
'香川県',
'愛媛県',
'高知県',
'福岡県',
'佐賀県',
'長崎県',
'熊本県',
'大分県',
'宮崎県',
'鹿児島県',
'沖縄県'
);
}
?>