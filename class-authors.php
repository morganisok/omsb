<?php
namespace OMSB;

require_once 'class-list.php';
require_once 'class-database.php';
require_once 'class-results.php';
require_once 'vendor/textile/src/Netcarver/Textile/Parser.php';

use OMSB\ListClass;
use OMSB\Database;
use OMSB\Results;
use Netcarver\Textile\Parser;

class Authors extends ListClass {

  public $table_name;

  public $db;

  public function __construct() {
    $this->table_name = 'authors';
    $this->db         = new Database();
    $this->results    = new Search_Results();
    $this->textile    = new Parser();
  }

  /*
  * Get a dropdown menu containing names of all the authors.
  */
  public function get_author_select( $value = array() ) {
    $author_query = mysqli_query( $this->db->mysqli, "select name,id from authors order by name;" );

    $options = '<option value=""></option>';

    while ( $row = mysqli_fetch_array( $author_query ) ) {
      if ( !is_array( $value ) ) {
        $selected = '';
      } else {
          $selected = in_array( $row[1], $value ) ? 'selected' : '';
      }

      $options .= "<option {$selected} value='{$row[1]}'>{$row[0]}</option>";
    }

    return "<select name='author[]' multiple='multiple' class='multiselect' placeholder='Type to search...'>
                {$options}
            </select>";
  }

  /*
  * Get a list of all the authors for a single source.
  *
  * @param int $id ID of the source.
  */
  public function get_source_author_details( $id, $format = true ) {
    $id_query = sprintf( "SELECT author_id from authorships WHERE source_id=%s", intval( $id ) );
    $result   = $this->db->mysqli->query( $id_query );

    if ( ! $result || $result->num_rows === 0 ) {
      return;
    }

    $author_ids = $result->fetch_all();

    if ( ! $format ) {
      $values = array();
      foreach ( $author_ids as $item ) {
        $values[] = $item[0];
      }
      return $values;
    }

    $details = '<ul>';

    foreach( $author_ids as $id ) {
      $author = $this->get_author_by_id( $id[0]);

      $details .= "<li><a href='/authors.php?id={$id[0]}'>{$author[0][0]}</a></li>";
    }

    $details .= '</ul>';

    return $details;
  }

  /*
  * Get an author from the ID.
  *
  * @param int $id ID of the author.
  */
  public function get_author_by_id( $id ) {
    $author_query = sprintf( "SELECT name from authors WHERE id=%d", intval( $id ) );
    $result       = $this->db->mysqli->query( $author_query );
    // @todo error handling
    return $result->fetch_all();
  }

  public function whitelist( $input ) {
    foreach( $input as $key => $author ) {
      $input[$key] = intval( $author );
    }

    return $input;
  }

  /*
  * Show the form to create or edit an author.
  *
  * @param bool $edit Whether we are editing an existing author.
  */
  public function author_form( $edit = true ) {
    $data = $this->fields_array();

    $title    = $edit ? 'Update AUTHORNAME' : 'Add a new author';
    $id_param = '';  // @todo - if this isn't a new author, put "id=$id" here
    $date_checked = $data['date_circa'] ? "checked='checked'" : '';
    $submit_text = $edit ? 'Update Author' : 'Create Author';

    echo "<h2>{$title}</h2>
      <form id='admin-author' action='admin-authors.php{$id_param}' method='POST'>
        <ul>
          <li>
            <input id='id' name='id' type='hidden' value='{$data['id']}'>
          </li>
          <li class='whole'>
            <label for='name'>Name</label>
            <input id='name' name='name' type='text' aria-describedby='author-description' value='{$data['name']}' autofocus>
            <p class='description author-description'>Author's name as found in DMA or WorldCat</p>
          </li>
          <li class='whole'>
            <label for='alias'>Alias</label>
            <input id='alias' name='alias' type='text' aria-describedby='alias-description' value='{$data['alias']}'>
            <p class='description alias-description'>Alternate names or spellings</p>
          </li>
          <li class='whole'>
            <label for='title'>Title</label>
            <input id='title' name='title' type='text' aria-describedby='title-description' value='{$data['title']}'>
            <p class='description title-description'>Title, such as Saint, King, Bishop, etc.</p>
          </li>
          <li class='checkbox fourth'>
            <label for='date_circa'>Date circa</label>
            <input id='date_circa' name='date_circa' type='checkbox' value='1' {$date_checked}></li>
          <li class='fourth'><label for='date_type'>Date modifier</label>
            <select id='date_type' name='date_type' value='{$data['date_type']}'>
              <option value='circa'>Circa</option>
              <option value='died'>Died</option>
              <option value='flourished'>Flourished</option>
              <option value='reigned'>Reigned</option>
            </select>
          </li>
          <li class='fourth'>
            <label for='date_begin'>From</label>
            <input id='date_begin' name='date_begin' type='text' value='{$data['date_begin']}'>
          </li>
          <li class='fourth'>
            <label for='date_end'>To</label>
            <input id='date_end' name='date_end' type='text' value='{$data['date_end']}'>
          </li>
          <li class='whole'>
            <label for='bio'>Biographical information</label>
            <textarea id='bio' name='bio' rows='5'>{$data['bio']}</textarea>
          </li>
        </ul>
        <input type='submit' class='button' value='{$submit_text}' />
    	</form>";
  }

  public function update() {

  }

  public function create() {
    $data = $this->sanitize_input();

    $query = "INSERT INTO authors (
        name,
        alias,
        title,
        date_type,
        date_circa,
        date_begin,
        date_end,
        bio
    )
    VALUES (
        '$data[name]',
        '$data[alias]',
        '$data[title]',
        '$data[date_type]',
        '$data[date_circa]',
        '$data[date_begin]',
        '$data[date_end]',
        '$data[bio]'
    );";

    $result = $this->db->mysqli->query( $query );

    if ( ! $result ) {
      echo '<p class="error">Database error.  Please report the following error to the administrator: <pre>' . print_r( $this->db->mysqli->error, true ) . '</pre></p>';
    } else {
      if ( isset( $_POST['id'] ) && '' !== $_POST['id'] ) {
        $id = $_POST['id'];
      } else {
        $id = $this->db->mysqli->insert_id;
      }

      echo "<p class='success'>{$_POST['name']} has been added.<br />
      <a href='/authors.php?id={$id}'>View Author</a>.<br .>
      <a href='/admin-authors.php?id={$id}'>Edit Author</a>.</p>";
    }
  }

  public function display_author( $id ) {
    $id     = mysqli_real_escape_string($db_server, $_GET['id']);
    $query  = "select * from authors where id=$id;";
    $result = $this->db->mysqli->query( $query );

    if ( ! $result ) {
      echo '<p class="error">No author found with id ' . $id . '</p>';
    } else {
      $author = mysqli_fetch_array( $result );

      $alias      = $author['alias'] ?? '';
      $title      = $author['title'] ?? '';
      $date_type  = $author['date_type'] ?? '';
      $date_circa = $author['date_circa'] ? 'c.&nbsp;' : '';
      $bio        = $author['bio'] ?? '';
      $works      = $this->get_works_by_author( $id );

      if ( isset( $author['date_begin'] ) && '' !== $author['date_begin'] && isset( $author['date_end'] ) && '' !== $author['date_end'] ) {
        $date = $author['date_begin'] . ' - ' . $author['date_end'];
      } elseif ( isset( $author['date_begin'] ) && '' !== $author['date_begin'] ) {
        $date = $author['date_begin'];
      } else {
        $date = $author['date_end'];
      }

      echo "
      <h2>Author Details</h2>
      <article class='author'>
      <h4><span class='name'>{$author['name']}</span> {$alias} {$title}</h4>
      <p>{$date_type} {$date}</p>

      <div class='bio'>
          {$this->textile->parse( $bio )}
      </div>

      <div class='works'>
            <h5>OMSB Records by {$name}</h5>
            {$works}
        </div>
      </article>";
    }
  }

  public function get_works_by_author( $id ) {
    $id     = mysqli_real_escape_string($db_server, $_GET['id']);
    $query  = "select source_id from authorships where author_id=$id;";
    $result = $this->db->mysqli->query( $query );
    $rows = $result->fetch_all( MYSQLI_ASSOC );
    return $this->results->display_results( $rows );
  }

  public function fields_array() {
    return array(
      'id' => '',
      'name' => '',
      'alias' => '',
      'title' => '',
      'date_circa' => '',
      'date_type' => '',
      'date_begin' => '',
      'date_end' => '',
      'bio' => '',
    );
  }

  public function sanitize_input() {
    $fields = $this->fields_array();
    foreach( $fields as $field => $value ) {
      if ( isset( $_POST[ $field ] ) && '' !== $_POST[ $field ] ) {
        $fields[ $field ] = $this->db->mysqli->real_escape_string( strip_tags( trim( $_POST[ $field ] ) ) );
      }
    }

    return $fields;
  }

  public function author_search_form() {
    ?>
  	<h2>Search for Medieval Authors</h2>
      <form action="authors.php" method="get">
      <li class="half"><label>Search:</label> <input type="text" name="search" placeholder="type an author's name"/></li>
      <input type="submit" class="button" value="Search" />
      </form>
  	<?php
  }

}
