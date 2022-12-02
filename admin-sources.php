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

  if ( ! empty( $_POST ) ) {
    // We are submitting a form, so update or create a source
    if ( isset( $_POST['id'] ) && '' !== $_POST['id'] ) {
      $source->update();
    } else {
      $source->create();
    }
  } elseif ( ! empty( $_GET ) ) {
    // Delete a source or show the form to edit a source
    if ( isset( $_GET['delete'] ) && '' !== $_GET['delete'] ) {
      $source->delete();
    } elseif( isset( $_GET['id'] ) ) {
      echo $source->source_form( true );
    }
  }


} else {
  echo '<p class="error">You must be logged in to view this page.</p>';
}

include 'footer.php';
