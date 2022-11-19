<?php
require_once 'auth.php';
include 'header.php';
require_once 'class-source.php';

$source  = new OMSB\Source;

if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) ) ) {

  if ( empty( $_POST ) && empty( $_GET ) ) {
		// Display an empty form to create a new source.
    echo $source->source_form( true );
	}

  if ( !empty( $_POST ) ) {
    if ( isset( $_POST['id'] ) && '' !== $_POST['id'] ) {
      $source->update();
    } else {
      $source->create();
    }
  } elseif ( !empty( $_GET ) ) {
    if ( isset( $_GET['delete'] ) && '' !== $_GET['delete'] ) {
      $source->delete();
    } elseif( isset( $_GET['id'] ) ) {
      echo $source->source_form( true );
    }
  }


} else {
  echo '<p class="error">You must be logged in to view this page.</p>';
}
