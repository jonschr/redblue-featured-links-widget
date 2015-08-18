<?php
/*
* Plugin Name: Red Blue Featured Links Widget
* Plugin URI: http://www.paulund.co.uk
* Description: A widget that allows you to upload media from a widget (Credit: Paul Underwood at http://www.paulund.co.uk for the framework I used)
* Version: 1.0
* Author: Jon Schroeder
* Author URI: http://redblue.us
* License: GPL2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License,
version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
/**
 * Register the Widget
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "rb_linked_content_widget" );' ) );

class rb_linked_content_widget extends WP_Widget {
    
   //* Constructor
   public function __construct() {
      $widget_ops = array(
         'classname' => 'rb_linked_content',
         'description' => 'Widget that lets you add some linked content including an image.'
      );

      parent::__construct( 'rb_linked_content', 'Genesis - Featured Linked Content', $widget_ops );

      add_action( 'admin_enqueue_scripts', array( $this, 'upload_scripts' ) );
   }

   //* Load javascript for the uploader
   public function upload_scripts() {
      wp_enqueue_script( 'media-upload' );
      wp_enqueue_script( 'thickbox' );
      wp_enqueue_script( 'upload_media_widget', plugin_dir_url(__FILE__) . 'upload-media.js', array( 'jquery' ) );

      wp_enqueue_style( 'thickbox' );
   }

   /**
   * Outputs the HTML for this widget.
   *
   * @param array  An array of standard parameters for widgets in this theme
   * @param array  An array of settings for this widget instance
   * @return void Echoes it's output
   **/
   public function widget( $args, $instance ) {
      extract( $args );
      
      $title = apply_filters( 'widget_title', $instance[ 'title' ] );
      $image = $instance[ 'image' ];
      $link = $instance[ 'link' ];
      $content = $instance[ 'content' ];
      
      echo $before_widget;

      if ( $link )
         printf( '<a href="%s">', $link );

      if ( $image )
         printf( '<img src="%s" />', $image );
      
      if ( $title )
         printf( '<h4 class="widgettitle widget-title">%s</h4>', $title );

      if ( $content )
         echo $content;

      if ( $link )
         echo '</a>';

      echo $after_widget;
   }

   /**
   * Deals with the settings when they are saved by the admin. Here is
   * where any validation should be dealt with.
   *
   * @param array  An array of new settings as submitted by the admin
   * @param array  An array of the previous settings
   * @return array The validated and (if necessary) amended settings
   **/
   public function update( $new_instance, $old_instance ) {

      // update logic goes here
      $updated_instance = $new_instance;
      return $updated_instance;
   }

   /**
   * Displays the form for this widget on the Widgets page of the WP Admin area.
   *
   * @param array  An array of the current settings for this widget
   * @return void
   **/
   public function form( $instance ) {
   
      $link = '';
      if ( isset( $instance[ 'link' ] ) ) {
         $link = $instance[ 'link' ];
      }

      $image = '';
      if( isset( $instance[ 'image' ] ) ) {
         $image = $instance[ 'image' ];
      }

      $title = '';
      if ( isset( $instance[ 'title' ] ) ) {
         $title = $instance[ 'title' ];
      }

      $content = '';
      if ( isset( $instance[ 'content' ] ) ) {
         $content = $instance[ 'content' ];
      }
      ?>

      <p>
         <label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'URL:' ); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
         <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
         <input class="upload_image_button" type="button" value="Upload Image" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_name( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
         <input class="widefat" rows="8" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" type="text" value="<?php echo esc_attr( $content ); ?>" />
      </p>



      

      <?php
   }
}
?>