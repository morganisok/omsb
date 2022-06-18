<?php
require_once( dirname( __FILE__ ) . '/oauth-config.php' );

$redirect_uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

$tmp = null;

// If the user clicked the "log out" button, log them out.
if ( isset( $_POST['action'] ) && 'logout' == $_POST['action'] ) {
  session_start();
	session_destroy();
}

session_start();

// User is requesting a new session.
if ( isset( $_GET['code'] ) && ! isset( $_SESSION['user'] ) ) {

	$curl_post_data = array(
		'grant_type'    => 'authorization_code',
		'code'          => $_GET['code'],
		'redirect_uri'  => $redirect_uri,
		'client_id'     => $client_id,
		'client_secret' => $client_secret
	);

	$curl = curl_init( $server_url . '/oauth/token/' );

	curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt( $curl, CURLOPT_USERPWD, $client_id . ':' . $client_secret );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $curl, CURLOPT_POST, true );
	curl_setopt( $curl, CURLOPT_POSTFIELDS, $curl_post_data );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5' );
	curl_setopt( $curl, CURLOPT_REFERER, 'http://www.example.com/1' );

	$curl_response = curl_exec( $curl );
	$code_response = json_decode( $curl_response );
	curl_close( $curl );

	$tmp = $code_response;

	/*
	 * If there is no error in the return, the following will request the user information from the server
	 */
	$curl = curl_init( $server_url . '/oauth/me/?access_token=' . $tmp->access_token );

	curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
	curl_setopt( $curl, CURLOPT_POST, false );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5' );
	curl_setopt( $curl, CURLOPT_REFERER, 'http://www.example.com/1' );

	$curl_response  = curl_exec( $curl );
	$token_response = json_decode( $curl_response );
	curl_close( $curl );

	$_SESSION['user'] = $token_response;
}
?>
