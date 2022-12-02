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

  private $is_logged_in;

  public function __construct() {
    $this->db        = new Database;
    $this->textile   = new Parser();
    $this->languages = new Languages();
    $this->countries = new Countries();
    $this->types     = new Types();
    $this->subjects  = new Subjects();
    $this->authors   = new Authors();
    $this->results   = new Search_Results();

    $this->is_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );
  }

  /*
  * Create a new source.
  */
  public function create() {
    if ( ! $this->is_logged_in ) {
      return '<p class="error">You do not have permission to do this.</p>';
    }

    $data = $this->sanitize_input();

    $query = "INSERT INTO sources (id,my_id,editor,title,publication,pub_date,isbn,text_pages,trans_english,trans_french,trans_other,trans_none,date_begin,date_end,region,archive,link,app_index,app_glossary,app_appendix,app_bibliography,app_facsimile,app_intro,comments,intro_summary,addenda,live,created_at,updated_at,user_id,trans_comment,text_name,cataloger)
VALUES (
  NULLIF('$data[id]',''),
  '$data[my_id]',
  '$data[editor]',
  '$data[title]',
  '$data[publication]',
  '$data[pub_date]',
  '$data[isbn]',
  '$data[text_pages]',
  '$data[trans_english]',
  '$data[trans_french]',
  '$data[trans_other]',
  '$data[trans_none]',
  '$data[date_begin]',
  '$data[date_end]',
  '$data[region]',
  '$data[archive]',
  '$data[link]',
  '$data[app_index]',
  '$data[app_glossary]',
  '$data[app_appendix]',
  '$data[app_bibliography]',
  '$data[app_facsimile]',
  '$data[app_intro]',
  '$data[comments]',
  '$data[intro_summary]',
  '$data[addenda]',
  '$data[live]',
  '$data[created_at]',
  NULLIF('$data[updated_at]',''),
  '$data[user_id]',
  '$data[trans_comment]',
  '$data[text_name]',
  '$data[cataloger]'
);";


    $result = $this->db->mysqli->query( $query );

    if ( ! $result ) {
      echo '<p class="error">Error updating database.  Please report the following error to the administrator: <pre>' . print_r( $this->db->mysqli->error, true ) . '</pre></p>';
    } else {
      if ( isset( $_POST['id'] ) ) {
        $id = $_POST['id'];
      } else {
        $id = $this->db->mysqli->insert_id;
      }
      $data['id'] = $id;

      $this->update_join_tables( $data, $action = 'insert' );

      echo "<p class='success'>{$_POST['title']} has been added.<br />
      <a href='/sources.php?id={$id}'>View Source</a>.<br .>
      <a href='/admin-sources.php?id={$id}'>Edit Source</a>.</p>";
    }


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

    if ( $this->is_logged_in ) {
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

  /*
  * Update a source.
  */
  public function update() {
    if ( ! $this->is_logged_in ) {
      return '<p class="error">You do not have permission to do this.</p>';
    }

    $id = $_POST['id'];
    if( ! $id ) {
      return '<p class="error">Could not find the source to update.</p>';
    }

    $data    = $this->sanitize_input();
    $updated = date("Y-m-d H:i:s");

    $query = "UPDATE sources set
    my_id				     = '$data[my_id]',
    editor				   = '$data[editor]',
    title				     = '$data[title]',
    publication			 = '$data[publication]',
    pub_date			   = '$data[pub_date]',
    isbn				     = '$data[isbn]',
    text_pages			 = '$data[text_pages]',
    trans_english		 = '$data[trans_english]',
    trans_french		 = '$data[trans_french]',
    trans_other			 = '$data[trans_other]',
    trans_none			 = '$data[trans_none]',
    date_begin		 	 = '$data[date_begin]',
    date_end			   = '$data[date_end]',
    region				   = '$data[region]',
    archive				   = '$data[archive]',
    link				     = '$data[link]',
    app_index        = '$data[app_index]',
    app_glossary		 = '$data[app_glossary]',
    app_appendix		 = '$data[app_appendix]',
    app_bibliography = '$data[app_bibliography]',
    app_facsimile		 = '$data[app_facsimile]',
    app_intro			   = '$data[app_intro]',
    comments			   = '$data[comments]',
    intro_summary		 = '$data[intro_summary]',
    addenda				   = '$data[addenda]',
    live				     = '$data[live]',
    updated_at			 = '$updated',
    user_id				   = '$data[user_id]',
    trans_comment		 = '$data[trans_comment]',
    text_name			   = '$data[text_name]',
    cataloger			   = '$data[cataloger]'
    where id=$id;";

    $result = $this->db->mysqli->query( $query );

    if( $result ) {
      $this->update_join_tables( $data, $action = 'update' );

      echo "<p class='success'>{$data['title']} has been updated.<br />
      <a href='/sources.php?id={$id}'>View Source</a>.<br .>
      <a href='/admin-sources.php?id={$id}'>Edit Source</a>.</p>";
    } else {
      echo '<p class="error">Error updating database.  Please report the following error to the administrator: <pre>' . print_r( $this->db->mysqli->error, true ) . '</pre></p>';
    }
  }

  /*
  * Delete a source.
  */
  public function delete() {
    if ( ! $this->is_logged_in ) {
      return '<p class="error">You do not have permission to do this.</p>';
    }

    echo "<h2>Delete Source</h2>";

    if( strlen( $_GET['delete'] ) > 80 ) {
      die("You submitted a search term that was too long.");
    }

    $id     = $this->db->mysqli->real_escape_string( $_GET['delete'] );
    $result = $this->db->mysqli->query( "select * from sources where id=$id;" );

    if ( ! $result->num_rows ) {
      ?>
      <p class="error">Could not find that source.  <a href="/sources.php">Go to search page.</a></p>
      <?php
    } else {

      $source = $result->fetch_array( MYSQLI_ASSOC );
      $title  = $source['title'];
      $delete = $this->db->mysqli->query( "delete from sources where id=$id;" );

      if ( $this->db->mysqli->affected_rows > 0 ) {
        ?>
        <p class="success"><?php echo htmlspecialchars($title); ?> has been removed from the database.</p>
        <?php
      } else {
        ?>
        <p class="error">Sorry, could not delete that source.</a></p>
        <?php
      }
    }
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
    $admin   = '<p class="maintenance">
      						<script type="text/javascript" language="JavaScript">
      						function confirmAction(){
      					      var confirmed = confirm("Are you sure? This will remove this source forever!");
      					      return confirmed;
      						}
      						</script>
        					<a href="/admin-sources.php?id=' . $source['id'] . '">Edit</a> |
        					<a href="/admin-sources.php?delete=' . $source['id'] . '" onclick="return confirmAction()">Delete</a>
        				</p>';
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
      {$admin}
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
  * @param bool  $format True to return formatted HTML, false for array
  */
  public function get_source_queries( $source_id, $format = true ) {
    return [
      'authors'   => $this->authors->get_source_author_details( $source_id, $format ),
      'languages' => $this->languages->get_source_details( $source_id, $format ),
      'countries' => $this->countries->get_source_details( $source_id, $format ),
      'types'     => $this->types->get_source_details( $source_id, $format ),
      'subjects'  => $this->subjects->get_source_details( $source_id, $format ),
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
  * Used both for adding/editing a source and for logged-in users to search sources.
  *
  * @param bool $edit Whether we are editing a source.  If false, we are searching for sources.
  */
  public function source_form( $edit = true ) {
    $existing = isset( $_GET['id'] );
    $values   = $this->get_field_values();
    $id_field = $existing ? "<input id='id' name='id' type='hidden' value='" . $_GET['id'] . "'>" : '';
    $checked  = $this->get_checked_attributes( $values );

    if ( $edit ) {
      $id     = $existing ? '?id=' . $_GET['id'] : '';
      $inits  = $existing ? $values['cataloger'] : $_SESSION['user']->initials;
      $userid = $values['user_id'];
      $live   = "<li class='checkbox'><input name='live' id='live' value='1' type='checkbox' {$checked['live']}><label for='live'>Make record public</label></li>";
      $action = "admin-sources.php{$id}";
      $method = 'post';
      $button = $existing ? 'Update Source' : 'Create Source';

      $values['cataloger'] = $_SESSION['user']->initials ? $_SESSION['user']->initials : '';

    } else {
      $userid = '';
      $live = "<li class='checkbox'><input name='live' id='live' value='1' type='checkbox'><label for='live'>Public Records</label></li>
                <li class='checkbox'><input name='hidden' id='hidden' value='1' type='checkbox'><label for='hidden'>Hidden Records</label></li>";
      $action = '/sources.php';
      $method = 'get';
      $button = 'Search Sources';
    }

    return "<form action='{$action}' method='{$method}'>
    <div class='form-section'>
      <h3>Cataloger Information</h3>
        <ul>
          <li class='half'>
            <label for='my_id'>MyID</label>
            <input id='my_id' name='my_id' type='text' autofocus value='{$values['my_id']}'>
            <input id='user_id' name='user_id' type='hidden' value='{$userid}'>
            {$id_field}
          </li>
          <li class='half'>
            <label for='cataloger'>Cataloger Initials</label>
            <input id='cataloger' name='cataloger' type='text' value='{$inits}'>
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Publication Information</h3>
        <ul>
          <li class='whole'>
            <label for='editor'>Modern Editor/Translator</label>
            <input id='editor' name='editor' type='text' value='{$values['editor']}'>
          </li>
          <li class='whole'>
            <label for='title'>Title</label>
            <input id='title' name='title' type='text' value='{$values['title']}'>
          </li>
          <li class='whole'>
            <label for='publication'>Publication Information</label>
            <input id='publication' name='publication' type='text' value='{$values['publication']}'>
          </li>
          <li class='third'>
            <label for='pub_date'>Publication Date</label>
            <input id='pub_date' name='pub_date' type='text' value='{$values['pub_date']}'>
          </li>
          <li class='third'>
            <label for='isbn'>ISBN</label>
            <input id='isbn' name='isbn' type='text' value='{$values['isbn']}'>
          </li>
          <li class='third'>
            <label for='text_pages'>Text Pages</label>
            <input id='text_pages' name='text_pages' type='number' value='{$values['text_pages']}'>
          </li>
          <li class='whole'>
            <label for='link'>Link</label>
            <input id='link' name='link' type='text' value='{$values['link']}'>
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Original Text Information</h3>
        <ul>
          <li class='whole'>
            <label for='text_name'>Text Name</label>
            <textarea id='text_name' name='text_name' rows='3'>{$values['text_name']}</textarea>
          </li>
          <li class='half'>
            <label for='date_begin'>Earliest Date</label>
            <input id='date_begin' name='date_begin' type='text' value='{$values['date_begin']}'>
          </li>
          <li class='half'>
            <label for='date_end'>Latest Date</label>
            <input id='date_end' name='date_end' type='text' value='{$values['date_end']}'>
          </li>
          <li class='checkbox'>
            <input name='trans_none' id='trans_none' value='1' type='checkbox' {$checked['trans_none']}><label for='trans_none'>Original language included</label>
          </li>
          <li class='checkbox'>
            <input name='trans_english' id='trans_english' value='1' type='checkbox' {$checked['trans_english']}><label for='trans_english'>Translated into English</label>
          </li>
          <li class='checkbox'>
            <input name='trans_french' id='trans_french' value='1' type='checkbox' {$checked['trans_french']}><label for='trans_french'>Translated into French</label>
          </li>
          <li class='checkbox'>
            <input name='trans_other' id='trans_other' value='1' type='checkbox' {$checked['trans_other']}><label for='trans_other'>Translated into another language</label>
          </li>
          <li class='half'>
            <label for='trans_comment'>Translation Comments</label>
            <textarea id='trans_comment' name='trans_comment' rows='3'>{$values['trans_comment']}</textarea>
          </li>
          <li class='half'>
            <label for='archive'>Archival Reference</label>
            <textarea id='archive' name='archive' rows='3'>{$values['archive']}</textarea>
          </li>
          <li class='half'>
            <label for='author'>Medieval Author</label>
            " . $this->authors->get_author_select( $values['author'] ) . "
          </li>
          <li class='half'>
            <label for 'language'>Original Language:</label>
            " . $this->languages->get_select( 'language', true, $values['language'] ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Region Information</h3>
        <ul>
          <li class='half'><label for='region'>County/Town/Parish/Village</label>
            <input id='region' name='region' value='' type='text' value='{$values['region']}'></li>
          <li class='half'><label for 'countries'>Geopolitical Region:</label>
            " . $this->countries->get_select( 'countries', true, $values['countries'] ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Finding Aids</h3>
        <ul>
          <li class='half'><label for='type'>Record Type</label>
            " . $this->types->get_select( 'type', true, $values['type'] ) . "
          </li>
          <li class='half'><label for='subject'>Subject</label>
            " . $this->subjects->get_select( 'subject', true, $values['subject'] ) . "
          </li>
        </ul>
    </div>
    <div class='form-section'>
      <h3>Apparatus</h3>
        <ul>
          <li class='checkbox'><input name='app_index' id='app_index' value='1' type='checkbox' {$checked['app_index']}><label for='app_index'>Index</label></li>
          <li class='checkbox'><input name='app_glossary' id='app_glossary' value='1' type='checkbox' {$checked['app_glossary']}><label for='app_glossary'>Glossary</label></li>
          <li class='checkbox'><input name='app_appendix' id='app_appendix' value='1' type='checkbox' {$checked['app_appendix']}><label for='app_appendix'>Appendix</label></li>
          <li class='checkbox'><input name='app_bibliography' id='app_bibliography' value='1' type='checkbox' {$checked['app_bibliography']}><label for='app_bibliography'>Bibliography</label></li>
          <li class='checkbox'><input name='app_facsimile' id='app_facsimile' value='1' type='checkbox' {$checked['app_facsimile']}><label for='app_facsimile'>Facsimile</label></li>
          <li class='checkbox'><input name='app_intro' id='app_intro' value='1' type='checkbox' {$checked['app_intro']}><label for='app_intro'>Introduction</label></li>
          <li class='whole'><label for='comments'>Comments</label>
            <textarea id='comments' name='comments' rows='3'>{$values['comments']}</textarea></li>
          <li class='whole'><label for='intro_summary'>Introduction Summary</label>
            <textarea id='intro_summary' name='intro_summary' rows='3'>{$values['intro_summary']}</textarea></li>
          <li class='whole'><label for='addenda'>Notes</label>
            <textarea id='addenda' name='addenda' rows='3'>{$values['addenda']}</textarea></li>
            {$live}
        </ul>
    </div>
    <input type='submit' class='button' value='{$button}' />
    </form>";
  }

  /*
  * Get the values of the source to populate the edit source form.
  *
  */
  public function get_field_values() {
    $empty_values = $this->empty_values();

    if ( !isset( $_GET['id'] ) || '' == $_GET['id'] ) {
      return $empty_values;
    }

    $source = $this->get_source( $_GET['id'] );
    if ( ! $source ) {
      $empty_values['id'] = '';
      return $empty_values;
    }

    $values = $source->fetch_array( MYSQLI_ASSOC );
    $merged = array_merge( $empty_values, $values );

    foreach( $checkboxes as $checkbox ) {
      if ( $merged[ $checkbox ] == 1 ) {
        $merged[ $checkbox ] = 'checked="checked"';
      } else {
        $merged[ $checkbox ] = '';
      }
    }

    $selects_data = $this->get_source_queries( $_GET['id'], false );

    $selects = $this->selects_array( 'table' );
    unset( $selects['authorships'] );
    $selects['authors'] = 'author';

    foreach( $selects as $tablename => $fieldname ) {
      $merged[$fieldname] = $selects_data[$tablename];
    }

    return $merged;
  }

  public function empty_values() {
    $fields = $this->fields_array();

    $checkboxes = $this->checkbox_array();
    foreach( $checkboxes as $fieldname ) {
      $fields[$fieldname] = '';
    }

    $select_fields = $this->selects_array();
    foreach( $select_fields as $fieldname ) {
      $fields[$fieldname] = '';
    }

    return $fields;
  }

  public function get_checked_attributes( $values ) {
    $checkboxes = $this->checkbox_array();
    $checked    = array();
    foreach( $checkboxes as $fieldname ) {
      if ( $values[$fieldname] == 1 ) {
        $checked[$fieldname] = 'checked="checked"';
      } else {
        $checked[$fieldname] = '';
      }
    }

    return $checked;
  }

  /*
  * Sanitize the input before creating or updating a source.
  *
  */
  public function sanitize_input() {
    $fields  = $this->fields_array();
    $bools   = $this->checkbox_array();
    $selects = $this->selects_array( 'fields' );

    foreach( $fields as $field => $value ) {
      if ( isset( $_POST[ $field ] ) && '' !== $_POST[ $field ] ) {
        $fields[ $field ] = $this->db->mysqli->real_escape_string( strip_tags( trim( $_POST[ $field ] ) ) );
      }

      if ( in_array( $field, $bools ) ) {
        $fields[ $field ] = isset( $_POST[ $field ] ) ? 1 : 0;
      }
    }

    foreach( $selects as $field ) {
      if ( isset( $_POST[ $field ] ) && '' !== $_POST[ $field ] ) {
        switch( $field ) {
          case 'author':
              $fields[ $field ] = $this->authors->whitelist( $_POST[ $field ] );
              break;
          case 'countries':
              $fields[ $field ] = $this->countries->whitelist( $_POST[ $field ] );
              break;
          case 'language':
              $fields[ $field ] = $this->languages->whitelist( $_POST[ $field ] );
              break;
          case 'subject':
              $fields[ $field ] = $this->subjects->whitelist( $_POST[ $field ] );
              break;
          case 'type':
              $fields[ $field ] = $this->types->whitelist( $_POST[ $field ] );
              break;
        }
      }
    }

    if ( '' == $fields['id'] ) {
      $fields['created_at'] = date( "Y-m-d H:i:s" );
    } else {
      $fields['updated_at'] = date( "Y-m-d H:i:s" );
    }

    return $fields;

  }

  /*
  * Add or edit data in a join table.
  *
  */
  public function update_join_tables( $data, $action = 'insert' ) {

    $tables = $this->selects_array( 'table' );

    foreach( $tables as $tablename => $fieldname ) {
      if( ! $data[$fieldname] ) {
        continue;
      }
      $name = $tablename == 'authorships' ? 'author_id' : 'name';

      if ( $action == 'update' ) {
        $query  = "delete from $tablename where source_id = $data[id];";
        $result = $this->db->mysqli->query( $query );
        // @todo - some error checking
      }

      $query = "insert into $tablename (source_id, $name, created_at, updated_at) VALUES ";
      foreach ($data[$fieldname] as $f){
        $query .= "(".$data['id'].",\"$f\",\"".date("Y-m-d H:i:s")."\",\"".date("Y-m-d H:i:s")."\")";

        if (next($data[$fieldname])==true) $query .= ",";
      }
      $query .= ";";

      $result = $this->db->mysqli->query( $query );
      // @todo - error checking

    }
  }

  /*
  * Get a list of all the fields.
  *
  */
  public function fields_array() {
    return array(
      "id"               => "",
      "my_id"            => "",
      "editor"           => "",
      "title"            => "",
      "publication"      => "",
      "pub_date"         => "",
      "isbn"             => "",
      "text_pages"       => "",
      "trans_english"    => "",
      "trans_french"     => "",
      "trans_other"      => "",
      "trans_none"       => "",
      "date_begin"       => "",
      "date_end"         => "",
      "region"           => "",
      "archive"          => "",
      "link"             => "",
      "app_index"        => "",
      "app_glossary"     => "",
      "app_appendix"     => "",
      "app_bibliography" => "",
      "app_facsimile"    => "",
      "app_intro"        => "",
      "comments"         => "",
      "intro_summary"    => "",
      "addenda"          => "",
      "live"             => "",
      "user_id"          => "",
      "created_at"       => "",
      "updated_at"       => "",
      "trans_comment"    => "",
      "text_name"        => "",
      "cataloger"        => "",
    );
  }

  /*
  * Get a list of all the fields that are checkboxes.
  *
  */
  public function checkbox_array() {
    return array(
      'trans_english',
      'trans_french',
      'trans_other',
      'trans_none',
      'app_index',
      'app_glossary',
      'app_appendix',
      'app_bibliography',
      'app_facsimile',
      'app_intro',
      'live'
    );
  }

  /*
  * Get a list of all the fields that are selects.
  *
  * @param string $context Whether to get the name of the table or the name of the field
  */
  public function selects_array( $context = 'field' ) {
    if( $context == 'field' ) {
      $selects = array(
        'countries',
        'language',
        'type',
        'subject',
        'author'
      );
    } else {
      $selects = array(
        // table name => field name
        'countries'   => 'countries',
        'languages'   => 'language',
        'types'       => 'type',
        'subjects'    => 'subject',
        'authorships' => 'author',
      );
    }

    return $selects;
  }

}
