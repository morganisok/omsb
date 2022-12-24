<?php
namespace OMSB;

require_once 'vendor/textile/src/Netcarver/Textile/Parser.php';

use Netcarver\Textile\Parser;

class Textile_Editor {

  public function __construct() {
    $this->textile    = new Parser();

    $this->is_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );
  }

  public function render_field( $label, $name, $value ) {
    return
    "<label for='{$name}'>{$label}</label>
    <textarea id='{$name}' cols='80' rows='20' class='panel textile-input' data-name={$name} onchange='textileParser(" . '"' . $name . '"' . ")'>{$value}</textarea>
    <div class='panel text-preview' data-source={$name}></div>
    <div class='formatting-guide'>
      <h4>Basic Formatting:</h4>
      <table>
        <tbody><tr>
          <th>You type:
          </th><th>Looks like:
        </th></tr><tr>
          <td>_italics_</td>
          <td><i>italics</i></td>
        </tr><tr>
          <td>*bold*</td>
          <td><b>bold</b></td>
        </tr><tr>
          <td>\"Google\":http://google.com</td>
          <td><a href=\"http://google.com\">Google</a></td>
        </tr><tr>
          <td>* an item <br> * another item <br>  * and another </td>
          <td><ul><li>an item</li><li>another item</li><li>and another</li></ul></td>
        </tr><tr>
          <td># item one <br> # item two <br> # item three </td>
          <td><ol><li>item one</li><li>item two</li><li>item three</li></ol></td>
        </tr>
      </tbody></table>
    </div>
    ";

  }

}
