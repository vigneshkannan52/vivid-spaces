<?php


$mail_to = $_POST['send_to'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$post_url = $_POST['post_url'];
$site = $_POST['site'];
$message .= "\r\n\r\n" . $post_url;

$headers = 'Content-Type: text/html; charset=utf-8; \n\r From: '. $site .'\n\r';
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$send_message = wp_mail($mail_to, $subject, $message);

if ( $send_message ) {
	echo 'done';
} else {
	echo 'error';
}