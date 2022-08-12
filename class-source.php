<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';
require_once 'class-authors.php';
require_once 'class-database.php';
require_once 'class-results.php';
require_once 'vendor/textile/src/Netcarver/Textile/Parser.php';


use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;
use OMSB\Authors;
use OMSB\Database;
use OMSB\Results;
use Netcarver\Textile\Parser;

class Source {

  private $db;

  private $textile;

  public function __construct() {
    $this->db        = new Database;
    $this->textile   = new Parser();
    $this->languages = new Languages();
    $this->countries = new Countries();
    $this->types     = new Types();
    $this->subjects  = new Subjects();
    $this->authors   = new Authors();
    $this->results   = new Search_Results();
  }

  public function create() {

  }

  /*
  * Single source view.
  *
  * @param int $id ID of the source
  */
  public function display( $id ) {
    $result = $this->get_source( $id );

    if ( ! $result ) {
      return '<p>No source found with that ID.  Please go back and <a href="sources.php">search again</a>.</p>';
    }

    $source = $result->fetch_array( MYSQLI_ASSOC );

    if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) ) ) {
      return $this->private_source_detail( $source );
    } else {
      return $this->public_source_detail( $source );
    }

  }

  /*
  * Search results list view.
  */
  public function display_results() {
    echo $this->results->search();
  }

  public function update() {

  }

  public function delete() {

  }

  /*
  * Database query to fetch a single source.
  *
  * @param int $id ID of the source
  */
  public function get_source( $id ) {
    $query = sprintf( "SELECT * from sources WHERE id=%s", $this->db->mysqli->real_escape_string( $id ) );
    return $this->db->mysqli->query( $query );
  }


  /*
  * Display the source details to a logged-in user.
  *
  * @param array $source Array of source details.
  */
  public function private_source_detail( $source ) {
    $live    = $source['live'] ? 'This record is visible to the public' : 'This record is hidden from the public';
    $queries = $this->get_source_queries( $source['id'] );

    return "<article class='source private'>
      <h5>Publication Information</h5>
      <p><span class='label'>Modern Editor/Translator:</span>&nbsp;{$source['editor']}</p>
      <p><span class='label'>Book/Article Title:</span>&nbsp;{$source['title']}</p>
      <p><span class='label'>Publication Information:</span>&nbsp;{$source['publication']}</p>
      <p><span class='label'>ISBN:</span>&nbsp;{$source['isbn']}</p>
      <p><span class='label'>Number of pages of primary source text:</span>&nbsp;{$source['text_pages']}</p>
      <p><span class='label'>URL:</span>&nbsp;{$source['link']}</p>
      <h5>Original Text Information</h5>
      <p><span class='label'>Text name(s):</span>&nbsp;{$source['text_name']}</p>
      <p><span class='label'>Medieval Author(s):</span>&nbsp;{$queries['authors']}</p>
      <p><span class='label'>Dates:</span>&nbsp;{$source['date_begin']} - {$source['date_end']}</p>
      <p><span class='label'>Archival Reference:</span>&nbsp;{$source['archive']}</p>
      <p><span class='label'>Original Language(s):</span>&nbsp;{$queries['languages']}</p>
      <p><span class='label'>Translation:</span>&nbsp;{$this->translations( $source )}</p>
      <p><span class='label'>Translation Comments:</span>&nbsp;{$source['trans_comment']}</p>
      <h5>Region Information</h5>
      <p><span class='label'>Geopolitical Region(s):</span>&nbsp;{$queries['countries']}</p>
      <p><span class='label'>County/Region:</span>&nbsp;{$source['region']}</p>
      <h5>Finding Aids</h5>
      <p><span class='label'>Record Types:</span>&nbsp;{$queries['types']}</p>
      <p><span class='label'>Subject Headings:</span>&nbsp;{$queries['subjects']}</p>
      <h5>Apparatus</h5>
      <p><span class='label'>Apparatus:</span>&nbsp;{$this->apparatus( $source )}</p>
      <p><span class='label'>Comments:</span>&nbsp;{$this->textile->parse( $source['comments'] )}</p>
      <p><span class='label'>Introduction Summary:</span>&nbsp;{$this->textile->parse( $source['intro_summary'] )}</p>
      <p><span class='label'>Cataloger:</span>&nbsp;{$source['cataloger']}</p>
      <p><span class='label'>My ID:</span>&nbsp;{$source['my_id']}</p>
      <p><span class='label'>Notes:</span>&nbsp;{$source['addenda']}</p>
      <p>{$live}</p>
    </article>";
  }

  /*
  * Display the source details to a logged-out user.
  *
  * @param array $source Array of source details.
  */
  public function public_source_detail( $source ) {
    $live = $source['live'] ? 'This record is visible to the public' : 'This record is hidden from the public';

    if( ! $live ) {
      return "<p class='error'>Sorry, you must be logged in to view this source.</p>";
    }

    $queries = $this->get_source_queries( $source['id'] );

    return "<article class='source public'>
      <p class='citation'>
        {$source['editor']}, <i>{$source['title']} ({$source['publication']})</i>
      </p>
      <p><span class='label'>Text name(s):</span>&nbsp;{$source['text_name']}</p>
      <p><span class='label'>Number of pages of primary source text:</span>&nbsp;{$source['text_pages']}</p>
      <p><span class='label'>Author(s):</span>&nbsp;{$queries['authors']}</p>
      <p><span class='label'>Dates:</span>&nbsp;{$source['date_begin']} - {$source['date_end']}</p>
      <p><span class='label'>Archival Reference:</span>&nbsp;{$source['archive']}</p>
      <p><span class='label'>Original Language(s):</span>&nbsp;{$queries['languages']}</p>
      <p><span class='label'>Translation:</span>&nbsp;{$this->translations( $source )}</p>
      <p><span class='label'>Translation Comments:</span>&nbsp;{$source['trans_comment']}</p>
      <p><span class='label'>Geopolitical Region(s):</span>&nbsp;{$queries['countries']}</p>
      <p><span class='label'>County/Region:</span>&nbsp;{$source['region']}</p>
      <p><span class='label'>Record Types:</span>&nbsp;{$queries['types']}</p>
      <p><span class='label'>Subject Headings:</span>&nbsp;{$queries['subjects']}</p>
      <p><span class='label'>Apparatus:</span>&nbsp;{$this->apparatus( $source )}</p>
      <p><span class='label'>Comments:</span>&nbsp;{$this->textile->parse( $source['comments'] )}</p>
      <p><span class='label'>Introduction Summary:</span>&nbsp;{$this->textile->parse( $source['intro_summary'] )}</p>
      <p><span class='label'>Cataloger:</span>&nbsp;{$source['cataloger']}</p>
    </article>";
  }

  /*
  * Get all the source details from other database tables.
  *
  * @param array $source Array of source details.
  */
  public function get_source_queries( $source_id ) {
    return [
      'authors'   => $this->authors->get_source_author_details( $source_id ),
      'languages' => $this->languages->get_source_details( $source_id ),
      'countries' => $this->countries->get_source_details( $source_id ),
      'types'     => $this->types->get_source_details( $source_id ),
      'subjects'  => $this->subjects->get_source_details( $source_id ),
    ];
  }

  /*
  * Generate a list of translation details for a source.
  *
  * @param array $source Array of source details.
  */
  public function translations( $source ) {
    $list = '';
    if ( $source['trans_english'] ) {
      $list .= '<li>Translated into English.</li>';
    }
    if ( $source['trans_french'] ) {
      $list .= '<li>Translated into French.</li>';
    }
    if ( $source['trans_other'] ) {
      $list .= '<li>Translated into another language (see translation comments).</li>';
    }
    if ( $source['trans_none'] ) {
      $list .= '<li>Original language included.</li>';
    }
    if ( '' !== $list ) {
      $list = '<ul class="translations">' . $list . '</ul>';
    }
    return $list;
  }

  /*
  * Generate a list of apparatus details for a source.
  *
  * @param array $source Array of source details.
  */
  public function apparatus( $source ) {
    $list = '';
    if ( $source['app_index'] ) {
      $list .= '<li>Index</li>';
    }
    if ( $source['app_glossary'] ) {
      $list .= '<li>Glossary</li>';
    }
    if ( $source['app_appendix'] ) {
      $list .= '<li>Appendix</li>';
    }
    if ( $source['app_bibliography'] ) {
      $list .= '<li>Bibliography</li>';
    }
    if ( $source['app_facsimile'] ) {
      $list .= '<li>Facsimile</li>';
    }
    if ( $source['app_intro'] ) {
      $list .= '<li>Introduction</li>';
    }
    if ( '' !== $list ) {
      $list = '<ul class="apparatus">' . $list . '</ul>';
    }
    return $list;
  }

  /*
  * Display the form with all of the source fields.
  *
  * Used both for editing a source and for logged-in users to search sources.
  *
  * @param bool $edit Whether we are editing a source.  If false, we are searching for sources.
  */
  public function source_form( $edit = true ) {
    if ( $edit ) {
      $id     = isset( $_GET['id'] ) ? '?id=' . $_GET['id'] : '';
      $action = "admin-sources.php{$id}";
      $method = 'post';
    } else {
      $action = '/sources.php';
      $method = 'get';
    }
    return "<form action='{$action}' method='{$method}'>
    <div class='form-section'>
      <h3>Cataloger Information</h3>
        <ul>
          <li class='half'>
            <label for='my_id'>MyID</label>
            <input id='my_id' name='my_id' type='text' autofocus>
          </li>
          <li class='half'>
            <label for='cataloger'>Cataloger Initials</label>
            <input id='cataloger' name='cataloger' type='text'>
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Publication Information</h3>
        <ul>
          <li class='whole'>
            <label for='editor'>Modern Editor/Translator</label>
            <input id='editor' name='editor' type='text'>
          </li>
          <li class='whole'>
            <label for='title'>Title</label>
            <input id='title' name='title' type='text'>
          </li>
          <li class='whole'>
            <label for='publication'>Publication Information</label>
            <input id='publication' name='publication' type='text'>
          </li>
          <li class='third'>
            <label for='pub_date'>Publication Date</label>
            <input id='pub_date' name='pub_date' type='text'>
          </li>
          <li class='third'>
            <label for='isbn'>ISBN</label>
            <input id='isbn' name='isbn' type='text'>
          </li>
          <li class='third'>
            <label for='text_pages'>Text Pages</label>
            <input id='text_pages' name='text_pages' type='text'>
          </li>
          <li class='whole'>
            <label for='link'>Link</label>
            <input id='link' name='link' type='text'>
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Original Text Information</h3>
        <ul>
          <li class='whole'>
            <label for='text_name'>Text Name</label>
            <textarea id='text_name' name='text_name' rows='3'></textarea>
          </li>
          <li class='half'>
            <label for='date_begin'>Earliest Date</label>
            <input id='date_begin' name='date_begin' type='text'>
          </li>
          <li class='half'>
            <label for='date_end'>Latest Date</label>
            <input id='date_end' name='date_end' type='text'>
          </li>
          <li class='checkbox'>
            <input name='trans_none' value='1' type='checkbox'><label for='trans_none'>Original language included</label>
          </li>
          <li class='checkbox'>
            <input name='trans_english' value='1' type='checkbox'><label for='trans_english'>Translated into English</label>
          </li>
          <li class='checkbox'>
            <input name='trans_french' value='1' type='checkbox'><label for='trans_french'>Translated into French</label>
          </li>
          <li class='checkbox'>
            <input name='trans_other' value='1' type='checkbox'><label for='trans_other'>Translated into another language</label>
          </li>
          <li class='half'>
            <label for='trans_comment'>Translation Comments</label>
            <textarea id='trans_comment' name='trans_comment' rows='3'></textarea>
          </li>
          <li class='half'>
            <label for='archive'>Archival Reference</label>
            <textarea id='archive' name='archive' rows='3'></textarea>
          </li>
          <li class='half'>
            <label for='author'>Medieval Author</label>
            " . $this->authors->get_author_select() . "
          </li>
          <li class='half'>
            <label for 'language'>Original Language:</label>
            " . $this->languages->get_select( "language", true ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Region Information</h3>
        <ul>
          <li class='half'><label for='region'>County/Town/Parish/Village</label>
            <input id='region' name='region' value='' type='text'></li>
          <li class='half'><label for 'countries'>Geopolitical Region:</label>
            " . $this->countries->get_select( 'countries', true ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Finding Aids</h3>
        <ul>
          <li class='half'><label for='type'>Record Type</label>
            " . $this->types->get_select( 'type', true ) . "
          </li>
          <li class='half'><label for='subject'>Subject</label>
            " . $this->subjects->get_select( 'subject', true ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Apparatus</h3>
        <ul>
          <li class='checkbox'><input name='app_index' value='1' type='checkbox'>Index</li>
          <li class='checkbox'><input name='app_glossary' value='1' type='checkbox'>Glossary</li>
          <li class='checkbox'><input name='app_appendix' value='1' type='checkbox'>Appendix</li>
          <li class='checkbox'><input name='app_bibliography' value='1' type='checkbox'>Bibliography</li>
          <li class='checkbox'><input name='app_facsimile' value='1' type='checkbox'>Facsimile</li>
          <li class='checkbox'><input name='app_intro' value='1' type='checkbox'>Introduction</li>
          <li class='whole'><label for='comments'>Comments</label>
            <textarea id='comments' name='comments' rows='3'></textarea></li>
          <li class='whole'><label for='intro_summary'>Introduction Summary</label>
            <textarea id='intro_summary' name='intro_summary' rows='3'></textarea></li>
          <li class='whole'><label for='addenda'>Notes</label>
            <textarea id='addenda' name='addenda' rows='3'></textarea></li>
          <li class='checkbox'><input name='live' value='1' type='checkbox'>Public Records</li>
          <li class='checkbox'><input name='hidden' value='1' type='checkbox'>Hidden Records</li>
        </ul>
    </div>
    <input type='submit' class='button' value='Search Sources' />
    </form>";
  }

}
