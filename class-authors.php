<?php
namespace OMSB;

require_once 'class-list.php';
require_once 'class-database.php';
require_once 'class-textile-editor.php';
require_once 'vendor/textile/src/Netcarver/Textile/Parser.php';

use OMSB\ListClass;
use OMSB\Database;
use OMSB\Source;
use OMSB\Textile_Editor;
use Netcarver\Textile\Parser;

class Authors extends ListClass {

  public $table_name;

  public $db;

  public function __construct() {
    $this->table_name = 'authors';
    $this->db         = new Database();
    $this->textile    = new Parser();
    $this->editor     = new Textile_Editor();

    $this->is_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );
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

      $details .= "<li><a href='/authors.php?id={$id[0]}'>{$author['name']}</a></li>";
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
    $author_query = sprintf( "SELECT * from authors WHERE id=%d", intval( $id ) );
    $result       = $this->db->mysqli->query( $author_query );
    // @todo error handling
    return $result->fetch_array( MYSQLI_ASSOC );
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

    if ( $edit ) {
      $author = $this->get_author_by_id( $_GET['id'] );
      foreach( $data as $field => $value ) {
        if ( isset( $author[ $field ] ) ) {
          $data[ $field ] = $author[ $field ];
        }
      }
    }

    $title        = $edit ? "Update {$data['name']}" : 'Add a new author';
    $id_param     = '';  // @todo - if this isn't a new author, put "id=$id" here
    $date_checked = $data['date_circa'] ? "checked='checked'" : '';
    $submit_text  = $edit ? 'Update Author' : 'Create Author';
    $bio          = $this->editor->render_field( 'Biographical Information', 'bio', $data['bio'] );

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
            {$bio}
          </li>
        </ul>
        <input type='submit' class='button' value='{$submit_text}' />
    	</form>";
  }

  public function update() {
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

    $query = "UPDATE authors set
        name       = '$data[name]',
        alias      = '$data[alias]',
        title      = '$data[title]',
        updated_at = '".date("Y-m-d H:i:s")."',
        date_type  = '$data[date_type]',
        date_circa = '$data[date_circa]',
        date_begin = '$data[date_begin]',
        date_end   = '$data[date_end]',
        bio        = '$data[bio]'
        where id=$data[id];";

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
    $author = $this->get_author_by_id( $id );

    if ( ! $author ) {
      echo '<p class="error">No author found with id ' . $id . '</p>';
    } else {
      $alias      = $author['alias'] ?? '';
      $title      = $author['title'] ?? '';
      $date_type  = $author['date_type'] ?? '';
      $date_circa = $author['date_circa'] ? 'c.&nbsp;' : '';
      $bio        = $author['bio'] ?? '';
      $works      = $this->get_works_by_author( $id, $author['name'] );

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

      {$works}

      </article>";
    }
  }

  public function get_works_by_author( $id, $name ) {
    $id          = $this->db->mysqli->real_escape_string( $_GET['id'] );
    $query       = "select source_id from authorships where author_id=$id;";
    $result      = $this->db->mysqli->query( $query );
    $authorships = $result->fetch_all( MYSQLI_ASSOC );

    if ( empty( $authorships ) ) {
      return;
    }

    $results = "<div class='works'><ul class='search_results'><h5>OMSB Records by {$name}</h5>";
    foreach ( $authorships as $authorship ) {
      $source_query = sprintf( "SELECT id,title,editor from sources WHERE id=%s", $authorship['source_id'] );
      $result       = $this->db->mysqli->query( $source_query );
      $source       = $result->fetch_all( MYSQLI_ASSOC );
      $admin        = '';
      $script       = '';
      if ( $this->is_logged_in ) {
        $admin = "<span class='maintenance'>
          <a href='/admin-sources.php?id={$source[0]['id']}'>Edit</a> |
          <a href='/admin-sources.php?delete={$source[0]['id']}' onclick='return confirmAction()'>Delete</a>
        </span>";

        $script = '<script type="text/javascript" language="JavaScript">
         function confirmAction(){
            var confirmed = confirm("Are you sure? This will remove this source forever!");
            return confirmed;
         }
         </script>';
      }
      $results .= "<li>{$source[0]['editor']}, <a href='/sources.php?id={$source[0]['id']}'>{$source[0]['title']}</a>{$admin}</li>";
    }
    $results .= "</ul></div>{$script}";
    $results .= "<a href='#content' class='back-to-top'>Back to top</a>";
    return $results;
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
    $fields[ 'date_circa' ] = isset( $_POST[ 'date_circa' ] ) ? 1 : 0;
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

  public function author_search_results() {
    $searchterm = $this->db->mysqli->real_escape_string( strip_tags( trim( $_GET[ 'search' ] ) ) );
    $query      = "select * from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%';";
    $result     = $this->db->mysqli->query( $query );

    if ( ! $result->num_rows ) {
      echo "<p>No author matched your search term. Please try searching again.</p>";
      echo $this->author_search_form;
    } else {
      echo "<h2>Author Search Results</h2>
      <p>You searched for {$_GET['search']}</p>
      <h4>Search Results:</h4>
      <ul>";
      while ( $author = $result->fetch_array( MYSQLI_ASSOC ) ) {
        $alias = $author['alias'] ? "({$author['alias']})" : '';
        $begin = $author['date_begin'] ? $author['date_begin'] : false;
        $end   = $author['date_end'] ? $author['date_end'] : false;
        if ( $begin && $end ) {
          $date = "{$begin} - {$end}";
        } elseif ( $begin && !$end ) {
          $date = $begin;
        } elseif ( !$begin && $end ) {
          $date = $end;
        } else {
          $date = '';
        }

        if ( $this->is_logged_in ) {
          $maintenance = "<p class='maintenance'>
            <script type='text/javascript' language='JavaScript'>
            function confirmAction(){
                var confirmed = confirm('Are you sure? This will remove this author forever.'');
                return confirmed;
            }
            </script>
            <a href='admin-authors.php?id={$author['id']}'>Edit</a> |
            <a href='admin-authors.php?delete={$author['id']}'' onclick='return confirmAction()''>Delete</a>
          </p>";
        } else {
          $maintenance = '';
        }
        echo "<li>
          <a href='authors.php?id={$author['id']}'>{$author['name']}</a> {$alias} {$date}
          {$maintenance}
        </li>";
      }
      echo "</ul>";
    }
  }

  public function delete() {
    if ( ! $this->is_logged_in ) {
      return '<p class="error">You do not have permission to do this.</p>';
    }

    echo "<h2>Delete Author</h2>";

    if( strlen( $_GET['delete'] ) > 80 ) {
      die("You submitted a search term that was too long.");
    }

    $id     = $this->db->mysqli->real_escape_string( $_GET['delete'] );
    $result = $this->db->mysqli->query( "select * from authors where id=$id;" );

    if ( ! $result->num_rows ) {
      ?>
      <p class="error">Could not find that author.  <a href="/authors.php">Go to search page.</a></p>
      <?php
    } else {

      $author = $result->fetch_array( MYSQLI_ASSOC );
      $name   = $author['name'];
      $delete = $this->db->mysqli->query( "delete from authors where id=$id;" );

      if ( $this->db->mysqli->affected_rows > 0 ) {
        ?>
        <p class="success"><?php echo htmlspecialchars($name); ?> has been removed from the database.</p>
        <?php
      } else {
        ?>
        <p class="error">Sorry, could not delete that author.</a></p>
        <?php
      }
    }
  }

}
