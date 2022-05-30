<?php
require_once('auth.php');
include('header.php');


if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] ) ) {
	$user = ( $_SESSION['user'] );
	echo 'Welcome ' . $user->user_login;

	?>
	<form action="/login.php" method="post">
			<input type="hidden" name="action" value="logout"/>
			<button type="submit">Log Out</button>
	</form>
	<?php
} else {
	?>
	<form action="<?php echo $server_url; ?>/oauth/authorize/" method="get">
			<input type="hidden" name="state" value="abcd123"/>
			<input type="hidden" name="scope" value="basic"/>
			<input type="hidden" name="response_type" value="code"/>
			<input type="hidden" name="client_id" value="<?php echo $client_id; ?>"/>
			<input type="hidden" name="redirect_uri" value="<?php echo $redirect_uri; ?>"/>
			<button type="submit">Log In with WordPress</button>
	</form>
	<?php
}



include ('footer.php');
