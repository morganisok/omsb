<?php
namespace OMSB;

abstract class ListClass {

  public $list;

  public function __construct() {
    $this->list = $list;
  }

  public function get_select( $name, $multiple = false ) {
    $name_attr     = $multiple ? $name . '[]' : $name;
    $multiple_attr = $multiple ? 'multiple="multiple"' : '';

    $options = '';
    foreach ( $this->list as $item ) {
      $options .= "<option value='{$item}'>{$item}</option>";
    }
    return "<select name='{$name_attr}' {$multiple_attr}>
                {$options}
            </select>";

  }

}
