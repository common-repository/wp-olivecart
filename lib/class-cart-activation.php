<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Activation {
	function _install () {
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'cart_meta';
  		$sql = "CREATE TABLE " . $table_name . " (
			meta_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint(20) UNSIGNED DEFAULT '0' NOT NULL,
			item_title text,
			item_number text,
			item_option_name text,
			item_option_stock text,
			item_option_price text,
			item_option_charge text,
			item_post_date text,
			page_title text,
			page_content mediumtext,
			UNIQUE KEY meta_id (meta_id)
		) CHARACTER SET 'utf8';";
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		$sql="CREATE TABLE IF NOT EXISTS CART_postage (
			id INT UNSIGNED AUTO_INCREMENT NOT NULL,
			postage01 mediumtext NOT NULL,
			postage02 VARCHAR(100) NOT NULL,
			postage03 VARCHAR(100) NOT NULL,
			PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8";
		dbDelta($sql);
		$sql = "CREATE TABLE IF NOT EXISTS CART_commission (
			id INT UNSIGNED AUTO_INCREMENT NOT NULL,
			name mediumtext NOT NULL,
			form mediumtext NOT NULL,
			charge VARCHAR(100) NOT NULL,
			comment mediumtext NOT NULL,
			PRIMARY KEY (id)
		) DEFAULT CHARACTER SET utf8";
		dbDelta($sql);
		$sql="CREATE TABLE IF NOT EXISTS CART_cartedit (
			id INT UNSIGNED AUTO_INCREMENT NOT NULL,
			set01 VARCHAR(100) NOT NULL,
			set02 VARCHAR(100) NOT NULL,
			set03 VARCHAR(100) NOT NULL,
			set04 mediumtext NOT NULL,
			set05 VARCHAR(100) NOT NULL,
			set06 mediumtext NOT NULL,
			PRIMARY KEY (id)
		)  DEFAULT CHARACTER SET utf8";
		dbDelta($sql);
		$post_value = array(
			'post_author' => 1,
			'comment_status' =>'closed',
			'post_title' => 'ShoppingCart',
			'post_content' => __('Your-Shopping-Cart items' ,'WP-OliveCart'), 
			'post_category' => array(1,5),
			'tags_input' => array('tag1','tag2'),
			'post_status' => 'publish', 
			'post_type' => 'wp_olivecart',
		); 
		
		$page_id1 = get_option('cart_page_id','1');
		if( $page_id1 != '1' ){
			wp_delete_post($page_id1);
			delete_option('cart_page_id');
		}
		$insert_id = wp_insert_post($post_value); //$insert_id is page_id
		update_option('cart_page_id',$insert_id);
		require_once(dirname(__FILE__)."/../mail/shop-mail.php");
		update_option('s_subject',$subject);
		update_option('s_mail_m',$mail_m);
		require_once(dirname(__FILE__)."/../mail/create-mail.php");
		//$wpdb->query($CART_cartedit);
		$query = "INSERT INTO CART_cartedit VALUES(
			'1','銀行振込','','銀行振込はこちらで指定した口座番号にお振込みください。','<p>本日はご注文いただきありがとうございました。</p>','$subject','$mail_m'
		) ON DUPLICATE KEY UPDATE id = 1";
		$wpdb->query($query);
		$query = "INSERT INTO CART_cartedit VALUES(
			'2','郵便振替','','商品を一緒に振込用紙をお送りいたします。','<p>本日はご注文いただきありがとうございました。</p>','$subject','$mail_m'
		) ON DUPLICATE KEY UPDATE id = 2";
		$wpdb->query($query);
		$query = "INSERT INTO CART_cartedit VALUES(
			'3','代金引換','','  代金引き換えはこちらを選択してください。','<p>本日はご注文いただきありがとうございました。</p>','$subject','$mail_m'
		) ON DUPLICATE KEY UPDATE id = 3";
		$wpdb->query($query);
		$query="INSERT INTO CART_postage VALUES(
			'1','','',''
		) ON DUPLICATE KEY UPDATE id=1";
		$wpdb->query($query);
		$query="INSERT INTO CART_commission VALUES(
			'1','配達時間指定','なし,午前中,１２時～１４時,１４時～１６時,１６時～１８時,１８時～２０時,２０時～２１時','',''
		) ON DUPLICATE KEY UPDATE id=1";
		$wpdb->query($query);
		$query="INSERT INTO CART_commission VALUES(
			'2','クール便','使用しない,使用する','0,300','クール便を使用する場合、手数料が300円かかります。'
		) ON DUPLICATE KEY UPDATE id=2";
		$wpdb->query($query);
		$query="INSERT INTO CART_commission VALUES(
			'3','ギフトラッピング','使用しない,使用する','0,300','ラッピングする場合、手数料が300円かかります。'
		) ON DUPLICATE KEY UPDATE id=3";
		$wpdb->query($query);
		$query="INSERT INTO CART_commission VALUES(
			'4','','','',''
		) ON DUPLICATE KEY UPDATE id =4";
		$wpdb->query($query);
		
		$admin_email	= 	get_option('admin_email');
		update_option('cart_button_other_option1','サイズ カラー');
		update_option('sendmail_address1',$admin_email);
  }

}
?>