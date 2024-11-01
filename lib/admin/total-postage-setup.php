<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
if ( is_admin() or is_user_logged_in() ) {
?>
<table class="wp-list-table fixed posts cartpostage">
<tr>
<td class="cartpostagetotal"><?php echo $From;?><input type="text" value="<?php if( isset( $total01[0] ) ){ echo $total01[0]; } ?>" name="postage02_1" class="postage02"><?php echo $en;?>
</td> 
<td class="cartpostagetotal"><?php echo $Postage;?><input type="text" value="<?php if( isset( $total01[1] ) ){ echo $total01[1]; }?>"  name="postage02_2" class="postage02"><?php echo $en;?></td> 
</tr> 
<tr> 
<td class="cartpostagetotal"><?php echo $From;?><input type="text" value="<?php  if( isset( $total02[0] ) ){ echo $total02[0]; } ?>"  name="postage03_1" class="postage02"><?php echo $en;?>
</td> 
<td class="cartpostagetotal"><?php echo $Postage;?><input type="text" value="<?php if( isset( $total02[1] ) ){ echo $total02[1]; } ?>"  name="postage03_2" class="postage02"><?php echo $en;?></td> 
</tr> 
</table> 
<?php
}
?>
