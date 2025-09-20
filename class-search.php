<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';
require_once 'class-authors.php';
require_once 'class-source.php';

use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;
use OMSB\Authors;
use OMSB\Source;

class Search_Form {

  private $languages;
  private $countries;
  private $types;
  private $subjects;
  private $authors;
  private $source;

  public function __construct() {
    $this->languages = new Languages;
    $this->countries = new Countries;
    $this->types     = new Types;
    $this->subjects  = new Subjects;
    $this->authors   = new Authors;
    $this->source    = new Source;
  }

  public function display_search_form() {
    if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) ) ) {
      return $this->private_search_form();
    } else {
      return $this->public_search_form();
    }
  }

  public function public_search_form() {

    return
    '<form action="/sources.php" method="get">
      <input type="submit" class="button" value="Search Sources" />
      <ul>
        <li class="whole">
          <label for="text_title">Text Name</label>
          <input id="text_title" name="text_title" placeholder="Medieval or modern title of the work">
        </li>
        <li class="whole">
          <label for="editor">Modern Editor/Translator</label>
          <input id="editor" name="editor" type="text">
        </li>
        <li class="checkbox whole">
          <input name="link" id="link" value="1" type="checkbox"><label for="link">Limit search to sources available online</label>
        </li>
        <li class="half">
          <label for="date_begin">Earliest Date</label>
          <input id="date_begin" name="date_begin" type="text">
        </li>
        <li class="half">
          <label for="date_end">Latest Date</label>
          <input id="date_end" name="date_end" type="text">
        </li>
        <li class="checkbox fourth">
          <input name="trans_none" id="trans_none" value="1" type="checkbox"><label for="trans_none">Original language included</label>
        </li>
        <li class="checkbox fourth">
          <input name="trans_english" id="trans_english" value="1" type="checkbox"><label for="trans_english">Translated into English</label>
        </li>
        <li class="checkbox fourth">
          <input name="trans_french" id="trans_french" value="1" type="checkbox"><label for="trans_french">Translated into French</label>
        </li>
        <li class="checkbox fourth">
          <input name="trans_other" id="trans_other" value="1" type="checkbox"><label for="trans_other">Translated into another language</label>
        </li>
        <li class="half">
          <label for "language">Original Language:</label>
          ' . $this->languages->get_select( 'language', true ) . '
        </li>
        <li class="half">
          <label for="region">County/Town/Parish/Village</label>
          <input id="region" name="region" type="text">
        </li>
        <li class="half">
          <label for "countries">Geopolitical Region:</label>
          ' . $this->countries->get_select( 'countries', true ) . '
        </li>
        <li class="half">
        <label for="type">Record Type</label>
          ' . $this->types->get_select( 'type', true ) . '
        </li>
        <li class="half"><label for="subject">Subject</label>
          ' . $this->subjects->get_select( 'subject', true ) . '
        </li>
      </ul>
      <input type="submit" class="button" value="Search Sources" />
    </form>';
  }

  public function private_search_form() {
    return $this->source->source_form( false );
  }
}
