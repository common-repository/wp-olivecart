<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_End_Message {
var $pagehook;
	//load page
	function on_load() {
		$help_message = new OliveCart_Help;
		$current_screen = get_current_screen();
		$this->pagehook=$current_screen->id;
		$admin_screen = WP_Screen::get($current_screen->id);
		/*Help option*/
		$admin_screen->add_help_tab(
			array(
				'title'    => __('help','WP-OliveCart'),
				'id'       => 'help_tab',
				'content'  => $help_message->message(),
				'callback' => false
			)
		);
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
		wp_enqueue_script('postbox');
		add_meta_box( 'show_box2'  ,__('Custom Message (HTML Tags)',  'WP-OliveCart'),array(&$this, 'show_box2'),   $this->pagehook, 'normal', 'core');
    }

	function on_action(){
		global $wpdb;
		if(  isset( $_POST['action'] )  and ( check_admin_referer( 'olivecart_action', 'olivecart_field' ) ) ){
			$_POST['set04']	=	$this->chage_tag( $_POST['set04'] );
			//Sanitize $POST $_REQUEST text field
			$id				=	sanitize_text_field( $_REQUEST['id'] );
			$set04			=	sanitize_text_field( $_POST['set04'] );
			$query			=	"update CART_cartedit set set04='$set04' where id='$id'";
			$wpdb->query($query);
			$this->message  = '<div id="message" class="updated below-h2"><p>'.__('Custom messages on cart end page updated','WP-OliveCart').'</p></div>';
		}
		//Sanitize $_REQUEST text field
		$id					=	sanitize_text_field( $_REQUEST['id'] );
		$mylink           	=	$wpdb->get_row( "select * from CART_cartedit where id = '$id'" );
		$this->title      	=	__('Edit custom messages on cart end page','WP-OliveCart');
		$this->action     	=	'edit';
		$this->icon       	=	'cart';
		if( !empty($_POST['set01']) and ( check_admin_referer( 'olivecart_action', 'olivecart_field' ) ) ) {
			$mylink->set04 = apply_filters('pro_end_meesage',1);
			$this->message  = '<div id="message" class="updated below-h2"><p>'.__('The template has been imported.','WP-OliveCart').'</p></div>';
		}
		
		return $mylink;
	}
	function chage_tag( $text ) {
		$text = preg_replace( '/</','&lt;',$text );
		$text = preg_replace( '/>/','&gt;',$text );
		$text = preg_replace( '/\n/','&#010;',$text );
		return $text;
	}
    

    function on_show_page() {
		global $wpdb;
		$field_value = $this->on_action();
		$this->check = '';
		add_meta_box('save_sidebox',__('Save','WP-OliveCart'), array(&$this, 'save_sidebox'), $this->pagehook, 'side', 'core');
		require( dirname(__FILE__).'../../lib/admin/on-showpage1.php');
	}

	function save_sidebox() {
		require( dirname(__FILE__).'../../lib/admin/on-sidebox.php');
	}


	function show_box2($field_value) {
		?>
		<div class="inside">
		<textarea name="set04" id="set04" class="endtaginputitem"><?php if ( isset( $field_value->set04 ) ){ echo $field_value->set04; } ?></textarea>
		</div> 
		<?php
	}

}
?>