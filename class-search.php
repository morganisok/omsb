<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';

use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;

class Search_Form {

  public function display_search_form() {
    if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] ) ) {
      return $this->private_search_form();
    } else {
      return $this->public_search_form();
    }
  }

  public function public_search_form() {
    $languages = new Languages;
    $countries = new Countries;
    $types     = new Types;
    $subjects  = new Subjects;

    return
    '<form action="/sources.php" method="get">
        <li class="whole">
          <label for="text_title">Text Name</label>
          <input id="text_title" name="text_title" placeholder="Medieval or modern title of the work">
        </li>
        <li class="half">
          <label for="author">Medieval Author</label>
          <p>You can find all records by an author using the <a href="/authors.php">Medieval author search</a>.</p>
        </li>
        <li class="half">
          <label for="editor">Modern Editor/Translator</label>
          <input id="editor" name="editor" type="text">
        </li>
        <li class="checkbox">
          <input name="link" value="1" type="checkbox"><label for="link">Limit search to sources available online</label>
        </li>
        <li class="half">
          <label for="date_begin">Earliest Date</label>
          <input id="date_begin" name="date_begin" type="text">
        </li>
        <li class="half">
          <label for="date_end">Latest Date</label>
          <input id="date_end" name="date_end" type="text">
        </li>
        <li class="checkbox">
          <input name="trans_none" value="1" type="checkbox"><label for="trans_none">Original language included</label>
        </li>
        <li class="checkbox">
          <input name="trans_english" value="1" type="checkbox"><label for="trans_english">Translated into English</label>
        </li>
        <li class="checkbox">
          <input name="trans_french" value="1" type="checkbox"><label for="trans_french">Translated into French</label>
        </li>
        <li class="checkbox">
          <input name="trans_other" value="1" type="checkbox"><label for="trans_other">Translated into another language</label>
        </li>
        <li class="half">
          <label for "language">Original Language:</label>
          ' . $languages->get_select( 'language', true ) . '
        </li>
        <li class="half">
          <label for="region">County/Town/Parish/Village</label>
          <input id="region" name="region" type="text">
        </li>
        <li class="half">
          <label for "countries">Geopolitical Region:</label>
          ' . $countries->get_select( 'countries', true ) . '
        </li>
        <li class="half">
        <label for="type">Record Type</label>
          ' . $types->get_select( 'type', true ) . '
        </li>
        <li class="half"><label for="subject">Subject</label>
          ' . $subjects->get_select( 'subject', true ) . '
        </li>
        <input type="submit" class="button" value="Search Sources" />
      </form>';
  }

  public function private_search_form() {

  }
}
