<?php
require_once 'auth.php';
include 'header.php';
require_once 'class-database.php';
require_once 'class-results.php';

use OMSB\Database;
use OMSB\Search_Results;

$is_user_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );

if ( $is_user_logged_in ) {
	$database = new Database();
	$results  = new Search_Results();

	$user_id = $_SESSION['user']->omsb_id;
	$query_string = "SELECT sources.id,sources.editor,sources.title,sources.addenda from sources where user_id LIKE " .  $user_id . " order by created_at;";

	$result = $database->mysqli->query( $query_string );

	if ( ! $result || $result->num_rows === 0 ) {
		return '<p class="error">Could not find any sources with notes.</p>';
	}

	$rows = $result->fetch_all( MYSQLI_ASSOC );

	echo '<h3>Sources created by ' . $_SESSION['user']->user_nicename . '</h3>';

	echo $results->display_results( $rows );

} else {
	echo '<p>Sorry, you must <a href="/login.php">log in</a> to view this page.</p>';
}

include 'footer.php';
