<?php
/*
Template Name: Cron
*/ 
?>
<?php 
// Load WP components, no themes.
define('WP_USE_THEMES', false);
require_once("../../../wp-load.php");


$to = 'thiago@oni.com.br';
$subject = 'The subject';
$body = 'The email body content';
$headers = array('Content-Type: text/html; charset=UTF-8');
 
$sent_message  = wp_mail( $to, $subject, $body, $headers );
//display message based on the result.
if ( $sent_message ) {
    // The message was sent.
    echo 'The test message was sent. Check your email inbox.';
} 
else {
    // The message was not sent.
    echo 'The message was not sent!';
}
 ?>