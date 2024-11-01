<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
if ( is_admin() or is_user_logged_in() ) {
 ?>
<div id="publishing-action">
<input name="save" class="button-primary" id="publish" accesskey="p" value="<?php _e('Save','WP-OliveCart');?>" type="submit">
</div>
<div class="clear"></div>
<?php
}
?>