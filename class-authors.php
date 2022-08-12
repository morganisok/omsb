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

  /*
  * Get a dropdown menu containing names of all the authors.
  */
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

  /*
  * Get a list of all the authors for a single source.
  *
  * @param int $id ID of the source.
  */
  public function get_source_author_details( $id ) {
    $id_query = sprintf( "SELECT author_id from authorships WHERE source_id=%s", intval( $id ) );
    $result   = $this->db->mysqli->query( $id_query );

    if ( ! $result || $result->num_rows === 0 ) {
      return;
    }

    $details = '<ul>';

    $author_ids = $result->fetch_all();

    foreach( $author_ids as $id ) {
      $author = $this->get_author_by_id( $id[0]);

      $details .= "<li><a href='/authors.php?id={$id[0]}'>{$author[0][0]}</a></li>";
    }

    $details .= '</ul>';

    return $details;
  }

  public function get_author_by_id( $id ) {
    $author_query = sprintf( "SELECT name from authors WHERE id=%d", intval( $id ) );
    $result       = $this->db->mysqli->query( $author_query );
    // @todo error handling
    return $result->fetch_all();
  }

}
?>
