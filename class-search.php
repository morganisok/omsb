<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';
require_once 'class-authors.php';

use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;
use OMSB\Authors;

class Search_Form {

  private $languages;
  private $countries;
  private $types;
  private $subjects;
  private $authors;

  public function __construct() {
    $this->languages = new Languages;
    $this->countries = new Countries;
    $this->types     = new Types;
    $this->subjects  = new Subjects;
    $this->authors   = new Authors;
  }

  public function display_search_form() {
    if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] ) ) {
      return $this->private_search_form();
    } else {
      return $this->public_search_form();
    }
  }

  public function public_search_form() {

    return
    '<form action="/sources.php" method="get">
      <ul>
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
    return
    '<form action="/sources.php" method="get">
    <div class="form-section">
      <h3>Cataloger Information</h3>
        <ul>
          <li class="half">
            <label for="my_id">MyID</label>
            <input id="my_id" name="my_id" type="text" autofocus>
          </li>
          <li class="half">
            <label for="cataloger">Cataloger Initials</label>
            <input id="cataloger" name="cataloger" type="text">
          </li>
        </ul>
    </div>
    <div class="form-section">
      <h3>Publication Information</h3>
        <ul>
          <li class="whole">
            <label for="editor">Modern Editor/Translator</label>
            <input id="editor" name="editor" type="text">
          </li>
          <li class="whole">
            <label for="title">Title</label>
            <input id="title" name="title" type="text">
          </li>
          <li class="whole">
            <label for="publication">Publication Information</label>
            <input id="publication" name="publication" type="text">
          </li>
          <li class="third">
            <label for="pub_date">Publication Date</label>
            <input id="pub_date" name="pub_date" type="text">
          </li>
          <li class="third">
            <label for="isbn">ISBN</label>
            <input id="isbn" name="isbn" type="text">
          </li>
          <li class="third">
            <label for="text_pages">Text Pages</label>
            <input id="text_pages" name="text_pages" type="text">
          </li>
          <li class="whole">
            <label for="link">Link</label>
            <input id="link" name="link" type="text">
          </li>
        </ul>
    </div>
    <div class="form-section">
      <h3>Original Text Information</h3>
        <ul>
          <li class="whole">
            <label for="text_name">Text Name</label>
            <textarea id="text_name" name="text_name" rows="3"></textarea>
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
            <label for="trans_comment">Translation Comments</label>
            <textarea id="trans_comment" name="trans_comment" rows="3"></textarea>
          </li>
          <li class="half">
            <label for="archive">Archival Reference</label>
            <textarea id="archive" name="archive" rows="3"></textarea>
          </li>
          <li class="half">
            <label for="author">Medieval Author</label>
            <?php $authors = mysqli_query($db_server, "select name,id from authors order by name;"); ?>
            ' . $this->authors->get_author_select() . '
          </li>
          <li class="half">
            <label for "language">Original Language:</label>
            ' . $this->languages->get_select( 'language', true ) . '
          </li>
        </ul>
    </div>
    <div class="form-section">
      <h3>Region Information</h3>
        <ul>
          <li class="half"><label for="region">County/Town/Parish/Village</label>
            <input id="region" name="region" value="" type="text"></li>
          <li class="half"><label for "countries">Geopolitical Region:</label>
            <select name="countries[]" multiple="multiple">
              <?php
              foreach ( $country_array as $tmp )
                print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
              ?>
            </select>
          </li>
        </ul>
    </div>
    <div class="form-section">
      <h3>Finding Aids</h3>
        <ul>
          <li class="half"><label for="type">Record Type</label>
            <select name="type[]" multiple="multiple">
              <?php
              foreach ( $type_array as $tmp )
                print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
              ?>
            </select>
          </li>
          <li class="half"><label for="subject">Subject</label>
            <select name="subject[]" multiple="multiple">
              <?php
              foreach ( $subject_array as $tmp )
                print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
              ?>
            </select>
          </li>
        </ul>
    </div>
    <div class="form-section">
      <h3>Apparatus</h3>
        <ul>
          <li class="checkbox"><input name="app_index" value="1" type="checkbox">Index</li>
          <li class="checkbox"><input name="app_glossary" value="1" type="checkbox">Glossary</li>
          <li class="checkbox"><input name="app_appendix" value="1" type="checkbox">Appendix</li>
          <li class="checkbox"><input name="app_bibliography" value="1" type="checkbox">Bibliography</li>
          <li class="checkbox"><input name="app_facsimile" value="1" type="checkbox">Facsimile</li>
          <li class="checkbox"><input name="app_intro" value="1" type="checkbox">Introduction</li>
          <li class="whole"><label for="comments">Comments</label>
            <textarea id="comments" name="comments" rows="3"></textarea></li>
          <li class="whole"><label for="intro_summary">Introduction Summary</label>
            <textarea id="intro_summary" name="intro_summary" rows="3"></textarea></li>
          <li class="whole"><label for="addenda">Notes</label>
            <textarea id="addenda" name="addenda" rows="3"></textarea></li>
          <li class="checkbox"><input name="live" value="1" type="checkbox">Public Records</li>
          <li class="checkbox"><input name="hidden" value="1" type="checkbox">Hidden Records</li>
        </ul>
    </div>
    </form>';
  }
}
