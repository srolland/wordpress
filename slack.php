<?php
/**
* Send a message into a Slack channel when an event fires in Wordpress
*/

/**
* Slack messenger function
* Note that one parameter is passed in this particular usage (order ID from Woocommerce), but this is specific to the implementation
* @param $_param1 mixed A parameter passed from the add_action hook
* @param $_param2 mixed A parameter passed from the add_action hook
* @param $_param3 mixed A parameter passed from the add_action hook
* @param $_param4 mixed A parameter passed from the add_action hook
*/
function cmj_slack_notification( $_param1, $_param2 = null, $_param3 = null, $_param4 = null ) {
  // The Slack user name for the person the messages should come from.
  // Create a new user in Slack if you like or use an existing one.
	$_username = 'myname';
  // Name of the channel you want messages to appear in (without a preceding hashtag - just the channel name).
	$_channel = 'orders';
  // The message you want to send.
	$_msg = 'New order to ship #' . intval( $_param1 );
  // This script uses the simple token authentication. If you need something more have fun with OAuth https://api.slack.com/docs/oauth
  // Your Slack API token: https://api.slack.com/docs/oauth-test-tokens
	$_token = 'whatever-your-token-is';
	$_url = 'https://slack.com/api/chat.postMessage'
		. '?token=' . $_token
		. '&username=' . $_username
		. '&channel=' . $_channel
		. '&text=' . urlencode( $_msg );
	$_json = file_get_contents( $_url ); // you can use the Wordpress function wp_remote_get() instead if you prefer
  return $_json;
}

/**
* The hook the function to an action
* In this case, a Slack message is being set to fire when payment for a Woocommerce order has been received.
*
*/
add_action( 'woocommerce_payment_complete', 'cmj_slack_notification', 10, 1 );
