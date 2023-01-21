<?php
require_once 'auth.php';
include 'header.php';
require_once 'class-search.php';
require_once 'class-results.php';
require_once 'class-source.php';

$search  = new OMSB\Search_Form;
$results = new OMSB\Search_Results;
$source  = new OMSB\Source;

if ( ! $_GET ) {
	// If we don't have a search term, display the search form.
	echo '<h2>Search for Sources</h2>';
	echo $search->display_search_form();
} else {
	if ( isset( $_GET['id'] ) ) {
		// Display a single source.
		echo '<h2>Source Details</h2>';
		echo $source->display( $_GET['id'] );
	} else {
		// Display search results.
		echo '<h2>Search Results</h2>';
		echo $source->display_results();
	}
}

include 'footer.php';
