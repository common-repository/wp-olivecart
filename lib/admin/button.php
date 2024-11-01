<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
if ( is_admin() or is_user_logged_in() ) {
?>
<table class="wp-list-table widefat fixed posts cartinfo">
<thead>
<tr> 
<th><?php _e('Title','WP-OliveCart');?></th>
 </tr> 
</thead>
<tr> 
<td><input type="text" value="<?php echo $title;?>" name="title_<?php echo $no;?>" /></td> 
</tr>
<thead>
<tr> 
<th><?php _e('Form Select Message','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr> 
<td><input type="text" value="<?php echo $form;?>" name="form_<?php echo $no;?>" />
<p><?php _e(' A comma (,) is used as a separator between data items.(example: S,M,L)','WP-OliveCart');?></p>
</td> 
</tr>

</table> 
<?php
}
?>