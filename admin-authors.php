<?php
require_once 'auth.php';
include 'header.php';
require_once 'class-authors.php';

$authors = new OMSB\Authors;

if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) ) ) {

  if ( empty( $_POST ) && empty( $_GET ) ) {
    $user = ( $_SESSION['user'] );
    if ( in_array( 'administrator', $user->user_roles ) ) {
      // Display an empty form to create a new author.
      echo $authors->author_form( false );
    } else {
      echo '<p class="error">You do not have sufficient permissions to create new authors</p>';
    }

	}

  if ( ! empty( $_POST ) ) {
    // We are submitting a form, so update or create an author
    if ( isset( $_POST['id'] ) && '' !== $_POST['id'] ) {
      $authors->update();
    } else {
      $authors->create();
    }
  } elseif ( ! empty( $_GET ) ) {
    // Delete a source or show the form to edit a source
    if ( isset( $_GET['delete'] ) && '' !== $_GET['delete'] ) {
      $authors->delete();
    } elseif( isset( $_GET['id'] ) ) {
      echo $authors->author_form( true );
    }
  }


} else {
  echo '<p class="error">You must be logged in to view this page.</p>';
}

include 'footer.php';
