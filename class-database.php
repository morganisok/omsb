<?php

namespace OMSB;

class Database {

  public $mysqli;

  public function __construct() {
    include 'dbcreds.php';
    $mysqli = new \mysqli( $db_hostname, $db_username, $db_password, 'omsb_db' );
    
    $mysqli->set_charset("utf8mb4");

    if( $mysqli ) {
      $this->mysqli = $mysqli;
    } else {
      die( 'Unable to connect to database' );
    }
  }

}
