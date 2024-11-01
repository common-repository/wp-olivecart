<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! is_admin() ) {
	if ( !class_exists( 'OliveCart_Previrew' ) ) {
		require_once( dirname(__FILE__).'/class-cart-preview.php');
	}
	if ( !class_exists( 'OliveCart_Step1' ) ) {
		require_once( dirname(__FILE__).'/class-cart-step1.php'  );
	}
	if ( !class_exists( 'OliveCart_Step2' ) ) {
		require_once( dirname(__FILE__).'/class-cart-step2.php'  );
	}
	if ( !class_exists( 'OliveCart_Step3' ) ) {
		require_once( dirname(__FILE__).'/class-cart-step3.php'  );
	}
	if ( !class_exists( 'OliveCart_Step4' ) ) {
		require_once( dirname(__FILE__).'/class-cart-step4.php'  );
	}
	if ( !class_exists( 'OliveCart_Step5' ) ) {
		require_once( dirname(__FILE__).'/class-cart-step5.php'  );
	}
	if ( !class_exists( 'OliveCart_Content' ) ) {
		require_once( dirname(__FILE__).'/class-cart-content.php');
	}
	if ( !class_exists( 'OlvieCart_Widget' ) ) {
		require_once( dirname(__FILE__).'/class-cart-widget.php');
	}
	if ( !class_exists( 'OliveCart_Button' ) ) {
		require_once( dirname(__FILE__).'/class-cart-button.php');
	}
	if ( !class_exists( 'OliveCart_Get_Title' ) ) {
		require_once( dirname(__FILE__).'/class-cart-get-title.php');
	}
	if ( !class_exists( 'OliveCart_Main' ) ) {
		require_once( dirname(__FILE__).'/class-cart-main.php');
	}
	if ( !class_exists( 'OliveCart_Start' ) ) {
		require_once( dirname(__FILE__).'/class-cart-start.php');
		( new OliveCart_Start )->get_pasonaldata(); 
	}
	
}
?>