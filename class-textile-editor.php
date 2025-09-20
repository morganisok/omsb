<?php
namespace OMSB;

require_once 'vendor/autoload.php';
require_once 'vendor/netcarver/textile/src/Netcarver/Textile/Parser.php';

use Netcarver\Textile\Parser;

class Textile_Editor {

  private $textile;
  private $is_logged_in;

  public function __construct() {
    $this->textile = new Parser();

    $this->is_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );
  }

  public function render_field( $label, $name, $value ) {
    return
    "<div class='accessible-tabs-container'>

      <ul role='tablist' class='tab-selectors'>
        <li class='active-tab-selector'>{$label}</li>
        <li>Preview</li>
        <li>Formatting Guide</li>
      </ul>

      <div class='tab-contents'>
        <div class='tab-content-active'>
          <textarea id='{$name}' cols='80' rows='15' data-name={$name} name={$name} onchange='textileParser(" . '"' . $name . '"' . ")'>{$value}</textarea>
        </div>
        <div class='text_preview' data-source={$name}>

        </div>
        <div>
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
      </div>
    </div>";

  }

}
