<?php
require_once 'auth.php';
include 'header.php';
require_once 'class-authors.php';

$authors = new OMSB\Authors;

if ( isset( $_GET['id'] ) && '' !== $_GET['id'] ) {
	$authors->display_author( $_GET['id'] );
} elseif ( isset( $_GET['search'] ) && '' !== $_GET['search'] ) {
	$authors->author_search_results();
} else {
	$authors->author_search_form();
}

include 'footer.php';
