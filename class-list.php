<?php
namespace OMSB;

require_once 'class-database.php';

use OMSB\Database;

abstract class ListClass {

  public $lists;

  public $table_name;

  public $db;

  public function __construct() {
    $this->list       = $list;
    $this->table_name = $table_name;
    $this->db         = new Database;
  }

  public function get_select( $name, $multiple = false, $value = array() ) {
    $name_attr     = $multiple ? $name . '[]' : $name;
    $multiple_attr = $multiple ? 'multiple="multiple" class="multiselect"' : '';

    $options = '';
    foreach ( $this->list as $item ) {
      if ( !is_array( $value ) ) {
        $selected = '';
      } else {
          $selected = in_array( $item, $value ) ? 'selected' : '';
      }

      $options .= "<option value='{$item}' {$selected}>{$item}</option>";
    }
    return "<select name='{$name_attr}' {$multiple_attr} placeholder='Type to search...'>
                {$options}
            </select>";

  }

  public function get_source_details( $id, $format = true ) {
    $details = '';

    $query  = sprintf( "SELECT name from %s WHERE source_id=%s", $this->db->mysqli->real_escape_string( $this->table_name ), $this->db->mysqli->real_escape_string( $id ) );
    $result = $this->db->mysqli->query( $query );
    $list   = $result->fetch_all();

    if ( ! $format ) {
      $values = array();
      foreach ( $list as $item ) {
        $values[] = $item[0];
      }
      return $values;
    }

    if ( is_array( $list ) && !empty( $list ) ) {
      $details = '<ul>';
      foreach ( $list as $item ) {
        $details .= "<li>{$item[0]}</li>";
      }
      $details .= '</ul>';
    }

    return $details;
  }

  public function whitelist( $input ) {
    foreach( $input as $key => $value ) {
      if ( ! in_array( $value, $this->list ) ) {
        unset( $key[ $value ] );
      }
    }
    return $input;
  }

  public function display_list( $title ) {
    $list = "<h2>List of {$title}</h2>";
    $list .= '<ul>';
    foreach( $this->list as $item ) {
      $list .= "<li>{$item}</li>";
    }
    $list .= '</ul>';

    echo $list;
  }

}
