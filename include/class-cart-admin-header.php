<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_On_Admin_Header {
	function __construct() {
		add_filter( "admin_head", array($this, 'onAdminHeader' ));
    }
    function cartAddCss() {
		return ( strpos( $_SERVER[ "REQUEST_URI" ], "admin.php"     ) ||
			 strpos( $_SERVER[ "REQUEST_URI" ], "edit.php" )
		);
	}
    function onAdminHeader() {
		if( $this->cartAddCss() ) {
			echo '<link rel="stylesheet" href="' .plugins_url( '../css/import.css',__FILE__). '" />'."\n";
			echo '<script type="text/javascript" src="' .plugins_url( '../js/olivecart-admin.js',__FILE__).'"></script>'."\n";
		}
	}
}
new OliveCart_On_Admin_Header();
?>
