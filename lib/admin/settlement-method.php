<?php if ( ! defined( 'ABSPATH' ) ) exit; 
if ( is_admin() or is_user_logged_in() ) {
?>
<table class="wp-list-table fixed posts cartinfo"> 
<input type=hidden name="in_id[]" value="<?php echo $field_value[$method_type]->id;?>"> 
<thead>
<tr> 
<th colspan="2"><?php _e('Title','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr>
<td colspan="2"><input type="text" value="<?php echo $field_value[$method_type]->set01;?>" name="set01[]" class="cartinputitem01" /> 
<a href="?page=olivecart_end_message&id=<?php echo $field_value[$method_type]->id;?>"><?php _e('End Message Setup','WP-OliveCart');?></a> 
 | <a href="?page=olivecart_auto_email&id=<?php echo $field_value[$method_type]->id;?>"><?php _e('Auto Reply Email Setup','WP-OliveCart');?></a> 
</td>

<?php apply_filters('payment_charges', $field_value,$method_type); ?>

<thead>
<tr> 
<th colspan="2"><?php _e('Comment','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr>
<td colspan="2"><textarea name="set03[]" id="textArea1" class="cartinputitem03"><?php echo $field_value[$method_type]->set03;?></textarea></td> 
</tr> 
</table>
<?php
}
?>
