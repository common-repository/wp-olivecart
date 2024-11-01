<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OliveCart_Preview_Widget extends WP_Widget {
    public function __construct() {
		$widget_ops= array( 'description'=>__('Shopping Cart Preview','WP-OliveCart')) ;
        parent::__construct(false, $name = __('WP-OliveCart Preview','WP-OliveCart'),$widget_ops);	
    }

    function widget( $args, $instance ) {		
        extract( $args );
        @$title	=	apply_filters('widget_title', $instance['title']);
        @$form = $instance['form'];
        echo $before_widget;
		if ( isset($title) ){ echo $before_title . $title . $after_title; } 
        if(!$form){ apply_filters('cart_button', '');  }
        else{ apply_filters('mini_cart', '');  }
        echo $after_widget;
    
    }
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    function form( $instance ) {
	    $title	=	null;
	    $form	=	null;
	    if( isset($instance['title']) ){		
        	$title = esc_attr($instance['title']);
 		}
 		if( isset($instance['form']) ){
 		 	$form = $instance['form'];
 		 }
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"  /></label></p>
        <p><input class="checkbox" id="<?php echo $this->get_field_id('form'); ?>" name="<?php echo $this->get_field_name('form'); ?>" value="1" type="checkbox" <?php if($form == 1){echo ' checked';} ?>> 
        <label for="<?php echo $this->get_field_id('form'); ?>" ><?php _e('Show Shopping Cart Items','WP-OliveCart')?></label></p>
        <?php 
    }

} 

?>