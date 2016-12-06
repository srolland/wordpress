<?php
/**
* Basic setup for nonce utilization in Javascript calls from either front or back end interface
* Uses proper escaping and validation to ensure CI pass
* Add to site in functions.php with:
* require_once( get_template_directory() . '/widget_json.php' );
*
* @uses widget_json.php
*/

define( 'PN_CMJ_URI', plugins_url( '', __FILE__ ) );

add_action( 'init', 'cmj_init' );

function cmj_init() {
  add_action( 'wp_enqueue_scripts', 'cmj_enqueues' );
  add_action( 'wp_ajax_json_cmj_test', 'json_cmj_test' );
  add_action( 'wp_ajax_nopriv_json_cmj_test', 'json_cmj_test' );
}

function cmj_enqueues() {
  wp_enqueue_script( 'pn_cmj_js', get_template_directory_uri() . '/widget_json.js' );
}

function json_cmj_test() {
  if ( ! isset( $_POST['nonce'] ) ) {
    return false;
  }
  if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), PN_CMJ_URI ) ) {
    return false;
  }
  $_name = '';
  if ( isset( $_POST['name'] ) ) {
    $_name = trim( sanitize_text_field( wp_unslash( $_POST['name'] ) ) );
  }
  $_output = array( $_name );
  header( 'Content-type: application/javascript' );
  print( json_encode( $_output ) );
  die();
}

class Postmedia_CMJ_Widget extends WP_Widget {

	function __construct() {
		parent::__construct( 'postmedia_cmj_widget', 'CMJ', array( 'description' => __( 'CMJ Widget', 'text_domain' ), ) );
	}

	public function widget( $args, $instance ) {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
		echo ( isset( $args['before_widget'] ) ) ? $args['before_widget'] : '';
    wp_nonce_field( PN_CMJ_URI, 'pn_cmj_nonce' );
    echo '<div id="pn_cmj_message"></div>';
    echo '<input type="text" id="pn_cmj_name" name="pn_cmj_name" value="Cat" />';
    echo '<input type="button" name="pn_cmj_btn" id="pn_cmj_btn" value="Save" />';
		echo ( isset( $args['after_widget'] ) ) ? $args['after_widget'] : '';
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	public function flush_widget_cache() {
	}

}

register_widget('Postmedia_CMJ_Widget');
