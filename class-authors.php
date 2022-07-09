<?php
namespace OMSB;

require_once 'class-database.php';

use OMSB\Database;

class Authors {

  public $list;

  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function get_author_select() {
    $author_query = mysqli_query( $this->db->mysqli, "select name,id from authors order by name;" );

    while ( $row = mysqli_fetch_array( $author_query ) ) {
      $options .= "<option value='{$row[1]}'>{$row[0]}</option>";
    }

    return "<select name='author[]' multiple='multiple'>
                {$options}
            </select>";
  }

}
?>
