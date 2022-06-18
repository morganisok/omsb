<?php
require_once 'auth.php';
include 'header.php';
// include 'connect.php';
// require_once 'vendor/paginator.class.php';
require_once 'class-search.php';

$search = new OMSB\Search_Form;

if ( ! $_GET ) {
	// If we don't have a search term, display the search form
	echo $search->display_search_form();
} else {

}
