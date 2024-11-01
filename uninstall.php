<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') ) exit();

$page_id1 = get_option('cart_page_id');
wp_delete_post($page_id1);
delete_option('cart_page_id');
delete_option('cart_button_other_option1');
delete_option('sendmail_address1');
delete_option('s_subject');
delete_option('s_mail_m');
global $wpdb;
$table_name = $wpdb->prefix . 'cart_meta';
$sql = "DROP TABLE ".$table_name;
$wpdb->query($sql);
$sql = "DROP TABLE CART_postage";
$wpdb->query($sql);
$sql = "DROP TABLE CART_commission";
$wpdb->query($sql);
$sql = "DROP TABLE CART_cartedit";
$wpdb->query($sql);

?>