<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OliveCart_Category_Widget extends WP_Widget {

	public function __construct() {
		 $widget_ops= array( 'description'=>__('Item Categories List','WP-OliveCart')) ;
		 parent::__construct(false, __('Item Categories','WP-OliveCart'),$widget_ops);
		 wp_reset_query();
	}
	function widget($args, $instance) {
 		extract( $args );
 		$title = apply_filters('widget_title', $instance['title']);
 		$arg = array(
			'orderby' 		=> '',
			'show_count' 	=> '',
			'pad_counts' 	=> '',
			'hierarchical'	=> '',
			'taxonomy' 		=> 'product_category',
			'title_li'		=> ''
		);
		echo $before_widget; 
		if ( $title ){ echo $before_title . $title . $after_title;} 
        echo '<ul>';
        wp_list_categories($arg); 
        echo '</ul>';
		echo $after_widget;
	  }
	 function update( $new_instance, $old_instance ) {
	  	$instance['title']= strip_tags(stripslashes($new_instance['title']));
		return $instance;
	}
 	function form($instance =null) {
 		@$title	= 	esc_attr($instance['title']);
 		echo '
 		<p><label for="'.$this->get_field_id('title').'">'.__('Title:').'
 		 <input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" />
 		 </label></p>';
	}
}

?>