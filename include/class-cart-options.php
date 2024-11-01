<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class OliveCart_Options {
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
				'content'  =>  $help_message->message(),
				'callback' => false
			)
		);
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
		wp_enqueue_script('postbox');
		
		add_meta_box( 'show_box3' ,__('Add to Cart Button Option',  'WP-OliveCart'),
		array(&$this, 'show_box3'),   $this->pagehook, 'normal', 'core');

		add_meta_box( 'show_box5' ,__('Mail Setup',  'WP-OliveCart'),
		array(&$this, 'show_box5'),   $this->pagehook, 'normal', 'core');
    }

    function on_show_page() {
	    $field_value = null;
		if( isset( $_POST['action'] ) and ( check_admin_referer( 'olivecart_action', 'olivecart_field' ) ) )  {
			//if(!$_POST['cart_button_other_option1']){ $_POST['option_max']=1; }
			$cart_button_other_option1	=	sanitize_text_field( $_POST['cart_button_other_option1'] );
			$cart_add_button_position	=	sanitize_text_field( $_POST['cart_add_button_position'] );
			$sendmail_address1			=	sanitize_text_field( $_POST['sendmail_address1'] );
			update_option( 'cart_button_other_option1',$cart_button_other_option1 );
			update_option( 'cart_add_button_position',$cart_add_button_position );
			update_option( 'sendmail_address1',$sendmail_address1 );
			if( isset( $_POST['consumption_tax'] ) )   {
				$consumption_tax		=	sanitize_text_field( $_POST['consumption_tax'] );
				update_option('consumption_tax',$consumption_tax); 
			}
			if( isset( $_POST['sendmail_address2'] ) ) {
				$sendmail_address2		=	sanitize_text_field( $_POST['sendmail_address2'] );
				update_option( 'sendmail_address2',$sendmail_address2 );
			}
			$this->message  = '<div id="message" class="updated below-h2"><p>'.__('Cart Options Updated','WP-OliveCart').'</p></div>';
		}
		$this->title	=	__('Cart Options','WP-OliveCart');
		$this->icon		=	'cart';
		$this->action	=	'edit';
		$this->check	=	'';
		add_meta_box('save_sidebox',__('Save','WP-OliveCart'), array(&$this, 'save_sidebox'), $this->pagehook, 'side', 'core');
		require( dirname(__FILE__).'../../lib/admin/on-showpage1.php');
	}

	function save_sidebox() {
		require( dirname(__FILE__).'../../lib/admin/on-sidebox.php');
	}


	function show_box3() {
		$select5	=	null;
		$select6	=	null;
		$select7	=	null;

		$title1 					= get_option('cart_button_other_option1');
		$cart_add_button_position	= get_option('cart_add_button_position');
		if( $cart_add_button_position == 'left' ){ $select5='selected'; }
		elseif( $cart_add_button_position == 'right' ){ $select6='selected'; }
		else{ $select7='selected'; }


		?>
		<div class="inside">
		<a name="change_option"></a>
		<p><?php _e('Button Position',  'WP-OliveCart');?></p>
		<select name="cart_add_button_position">
		<option value="left" <?php echo $select5;?>><?php _e('left','WP-OliveCart');?></option>
		<option value="right" <?php echo $select6;?>><?php _e('right','WP-OliveCart');?></option>
		<option value="center" <?php echo $select7;?>><?php _e('center','WP-OliveCart');?></option>
		</select>
		<p><?php _e('Other Options Title',  'WP-OliveCart');?></p>
		<input type="text" value="<?php echo $title1;?>" name="cart_button_other_option1" class="cartinputitem04" />
		</div>

		<?php
	}
	function show_box5() {
		$sendmail_address1 = get_option('sendmail_address1');
		$sendmail_address2 = get_option('sendmail_address2');
		?>
		<div class="inside">
		
		<p><?php _e('SendMail Address',  'WP-OliveCart');?></p>
		<input type="text" value="<?php echo $sendmail_address1;?>" name="sendmail_address1" class="cartinputitem04" />
		<?php echo  apply_filters('sendmail_address2',$sendmail_address2); ?>
		<p><a href="?page=olivecart_auto_email&id=shop_mail"><?php _e('Edit shop mail contents',  'WP-OliveCart');?></a></p>
		<?php echo  apply_filters('lost_mail',''); ?>
		</div>

		<?php
	}

}
?>