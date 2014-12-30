<?php
/*
 * Made by Luyz
 * Facebook: https://www.facebook.com/pvtluis
 * Twitter: https://twitter.com/luis2faria
 * Skype: pvtluyz
 */
error_reporting( 0 );
date_default_timezone_set('Brazil/East');
$ip = $_SERVER['REMOTE_ADDR'];
$error_page = 'error_page.php';
$content_page = 'content_page.php';
if ( !isset( $_SESSION ) ) {
	session_start();
}
$high_ip = array('64.233.191.255','66.102.15.255','66.249.95.255','72.14.255.255','74.125.255.255','209.85.255.255','216.239.63.255','64.4.63.255','65.55.255.255','131.253.47.255','157.60.255.255','207.46.255.255','207.68.207.255','8.12.144.255','66.196.127.255','66.228.191.255','67.195.255.255','68.142.255.255','72.30.255.255','74.6.255.255','98.139.255.255','202.160.191.255','209.191.127.255');
$low_ip = array('64.233.160.0','66.102.0.0','66.249.64.0','72.14.192.0','74.125.0.0','209.85.128.0','216.239.32.0','64.4.0.0','65.52.0.0','131.253.21.0','157.54.0.0','207.46.0.0','207.68.128.0','8.12.144.0','66.196.64.0','66.228.160.0','67.195.0.0','68.142.192.0','72.30.0.0','74.6.0.0','98.136.0.0','202.160.176.0','209.191.64.0');
for ( $i = 0; $i < count( $low_ip ); $i++ ) {
	if ( $ip <= $high_ip[$i] && $low_ip[$i] <= $ip ) {
		define( 'ANTI_DOS_HTTP_HTTPS', true );
		include_once( $content_page );
		exit;
	}
}
if ( $_SESSION['last_session_request'] > ( time() - 2 ) ) {
	if ( empty( $_SESSION['last_request_count'] ) ) {
		$_SESSION['last_request_count'] = 1;
	} elseif ( $_SESSION['last_request_count'] < 5 ) {
		$_SESSION['last_request_count'] = $_SESSION['last_request_count'] + 1;
	} elseif ( $_SESSION['last_request_count'] >= 5 ) {
		$fp = fopen('log_error.txt', 'a+');
		fwrite( $fp, sprintf( 'IP: %s %s%s', $ip, date( '\D\i\a\:\ Y-m-d \H\o\r\a\: H:i:s' ), "\r\n" ) );
		fclose($fp);
		include_once( $error_page );
		exit;
	}
} else {
	$_SESSION['last_request_count'] = 1;
}
$_SESSION['last_session_request'] = time();
define( 'ANTI_DOS_HTTP_HTTPS', true );
include_once( $content_page );
exit;
?>
