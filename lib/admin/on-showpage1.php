<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
if ( is_admin() or is_user_logged_in() ) {
	$id = null;
?>
		<div class="wrap">
			<h2><?php echo $this->title; ?></h2>
			<?php if( isset( $this->message ) ){ echo $this->message; } ?>
			<form name="Form" id="addlink" method="post" onSubmit="<?php echo $this->check; ?>">
			<?php wp_nonce_field('olivecart_action', 'olivecart_field');?>
			<input type=hidden value="<?php echo $this->action; ?>" name="action" id="action">
			<?php if( isset( $_REQUEST['id'] ) ){ $id = sanitize_text_field( $_REQUEST['id'] ); } ?>
			<input type=hidden value="<?php echo $id; ?>" name="id">
			<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
					<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes($this->pagehook, 'side',$field_value); ?>
					</div>
					<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes($this->pagehook, 'normal',$field_value); ?>
					</div>
				</div>
			</div>
			</form>
		</div>
		<!-- end poststuff -->
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
		});
		//]]>
		</script>
<?php
}
?>