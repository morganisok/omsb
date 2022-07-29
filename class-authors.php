<?php
namespace OMSB;

require_once 'class-list.php';
require_once 'class-database.php';

use OMSB\ListClass;
use OMSB\Database;

class Authors extends ListClass {

  public $table_name;

  public $db;

  public function __construct() {
    $this->table_name = 'authors';
    $this->db         = new Database;
  }

  public function get_author_select() {
    $author_query = mysqli_query( $this->db->mysqli, "select name,id from authors order by name;" );

    $options = '';

    while ( $row = mysqli_fetch_array( $author_query ) ) {
      $options .= "<option value='{$row[1]}'>{$row[0]}</option>";
    }

    return "<select name='author[]' multiple='multiple'>
                {$options}
            </select>";
  }

  public function get_source_author_details( $id ) {

    $id_query = sprintf( "SELECT author_id from authorships WHERE source_id=%s", $this->db->mysqli->real_escape_string( $id ) );
    $result   = $this->db->mysqli->query( $id_query );

    if ( ! $result || $result->num_rows === 0 ) {
      return;
    }

    $details = '<ul>';

    $author_ids = $result->fetch_all();

    foreach( $author_ids as $id ) {
      $author_query = sprintf( "SELECT name from authors WHERE id=%d", $this->db->mysqli->real_escape_string( $id[0] ) );
      $result       = $this->db->mysqli->query( $author_query );
      $author       = $result->fetch_all();

      $details .= "<li><a href='/authors.php?id={$id[0]}'>{$author[0][0]}</a></li>";
    }

    $details .= '</ul>';

    return $details;
  }

}
?>
