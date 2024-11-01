<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
if ( is_admin() or is_user_logged_in() ) {
?>
<table class="wp-list-table fixed posts cartinfo">
<thead>
<tr> 
<th><?php _e('Title','WP-OliveCart');?><input type=hidden name="in_id[]" value="<?php echo $field_value[$method_type]->id;?>"></th>
</tr> 
</thead>
<tr> 
<td><input type="text" value="<?php echo $field_value[$method_type]->name;?>" name="name[]" class="cartinputitem04" /></td> 
</tr>
<thead>
<tr> 
<th><?php _e('Form Select Message','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr> 
<td><input type="text" value="<?php echo $field_value[$method_type]->form;?>" name="form[]" class="cartinputitem04" />
<p> <?php _e(' A comma (,) is used as a separator between data items.(example: yes,no)','WP-OliveCart');?></p>
</td> 
</tr>
<thead>
<tr> 
<th><?php _e('Charge Setup','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr>
<td><input type="text" value="<?php echo $field_value[$method_type]->charge;?>" name="charge[]" class="cartinputitem04" /> 
<p><?php _e('A comma (,) is used as a separator between charge setup.(example: yes=300 no=0 300,0)','WP-OliveCart');?></p>
</td> 
</tr>
<thead>
<tr> 
<th><?php _e('Comment','WP-OliveCart');?></th> 
</tr> 
</thead>
<tr>
<td><textarea name="comment[]" id="textArea1" class="cartinputitem03"><?php echo $field_value[$method_type]->comment;?></textarea></td> 
</table> 
<?php
}
?>