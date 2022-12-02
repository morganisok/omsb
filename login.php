<?php
require_once('auth.php');
include('header.php');

$is_user_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );

if ( $is_user_logged_in ) {
	$user = ( $_SESSION['user'] );
//	echo '<pre>' . print_r($_SESSION,true) . '</pre>';
	echo 'Welcome ' . $user->user_nicename;
	?>
	<ul class="user-actions">
		<li><a href="admin-sources.php" title="Add a new source">Add a new source.</a></li>
		<li><a href="my-sources.php" title="View your sources">View your sources.</a></li>
		<li><a href="admin-notes.php" title="View sources with notes">View sources with notes.</a></li>
		<li><a href="admin-links.php" title="View online sources">View online sources.</a></li>
		<?php if( in_array( 'administrator', $user->user_roles ) ) { ?>
			<li><a href="admin-authors.php" title="Add a new author">Add a new author.</a></li>
		<?php } ?>
	</ul>
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
