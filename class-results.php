<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';
require_once 'class-authors.php';
require_once 'class-database.php';

use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;
use OMSB\Authors;
use OMSB\Database;

class Search_Results {

  private $db;


  public function __construct() {
    $this->db        = new Database;
    $this->languages = new Languages();
    $this->countries = new Countries();
    $this->types     = new Types();
    $this->subjects  = new Subjects();
    $this->authors   = new Authors();

    $this->join_queries = '';
    $this->reg_queries  = '';
    $this->tables       = '';

    $this->is_logged_in = isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] && ! isset( $_SESSION['user']->error ) );
  }

  /*
  * Perform a search query based on user's search terms.
  */
  public function search() {
    $query_string = "SELECT sources.id,sources.editor,sources.title from sources";

    $terms = array_filter( $_GET );
    $join  = array();

    // Add join queries to the query string.
    if ( $this->ar( $terms, 'author' ) || $this->ar( $terms, 'countries' ) || $this->ar( $terms, 'language' ) || $this->ar( $terms, 'subject' ) || $this->ar( $terms, 'type' ) ) {
        foreach ( $terms as $key => $val ){
            switch($key) {
              case 'author':
                  $join['author'] = $terms['author'];
                  unset( $terms['author'] );
                  break;
              case 'countries':
                  $join['countries'] = $terms['countries'];
                  unset( $terms['countries'] );
                  break;
              case 'language':
                  $join['language'] = $terms['language'];
                  unset( $terms['language'] );
                  break;
              case 'subject':
                  $join['subject'] = $terms['subject'];
                  unset( $terms['subject'] );
                  break;
              case 'type':
                  $join['type'] = $terms['type'];
                  unset( $terms['type'] );
                  break;
            }
        }
    }

    // Build the queries for the join tables.
    $i=0;
    foreach( $join as $key => $val ) {
        $j=0;
        if ( count($val) > 1 ) {
            $this->join_queries .= "(";
        }
        if ( is_array($val) ) {
          foreach( $val as $key2 => $val2 ) {
            $j++;
              $this->build_query_segment($key,$val2,$query_string);
            if ( $j <> count($val)) $this->join_queries .= " OR ";
          }
            $i++;
          if ( $i <> count($join)) $this->join_queries .= " AND ";
        } else {
          return '<p class="error">Unable to build search query.  Please change your search terms and try again.</p>';
        }
        if ( count($val) > 1 )
          $this->join_queries .= ")";
    }

    // Build the regular queries.
    $i=0;
    foreach( $terms as $key => $val){	  ##  looping over the $_GET array

        $i++;
        $j=0;
        if ( is_array($val) ) {
          return '<p class="error">Unable to build search query.  Please change your search terms and try again.</p>';
          // this never happens because we just returned
          // foreach( $val as $key2 => $val2 ) {
          //   $j++;
          //     $this->build_query_segment($key,$val2,$query_string);
          //   if ( $j <> count($val)) $this->join_queries .= " OR ";
          // }

        } else {

            $this->build_query_segment($key,$val,$query_string);
            if ( $i <> count($terms) && $i !== 1 ) {
              $this->reg_queries .= " AND ";
            }

      }
    }

    // Put all the queries together.
    if ( !( empty( $this->join_queries ) && empty( $this->reg_queries ) ) ) {
      $query_string .= $this->tables." where ";
      $query_string .= $this->join_queries;
    }

    if ( !empty ( $this->join_queries ) && !empty ( $this->reg_queries ) ) {
      $query_string .= " AND ";
    }

    if ( !empty ( $this->reg_queries ) ) {
      $query_string .= $this->reg_queries;
    }

    if( $this->ar( $_GET, 'hidden' ) && $_GET['hidden'] == 1 ) {
      if( stripos( $query, 'where') === false ){ // if we don't have any other critiera, we need to include where in the SQL query
        $query_string .= ' where ';
      }
      $query_string .= " sources.live!=1 "; // I don't know why we have the extra trailing AND in the query, but we don't need to add it here again.
    } elseif( ! $this->is_logged_in )  {
      $query_string .= " AND sources.live=1 ";
    }

    $query_string .= ";";

    $result = $this->db->mysqli->query( $query_string );

    if ( ! $result || $result->num_rows === 0 ) {
      return $this->display_search_terms() . '<p class="error">No results found for these search terms.</p>';
    }

    $rows = $result->fetch_all( MYSQLI_ASSOC );

    return $this->display_results( $rows );

  }

  /*
  * Given the search results, display them to the user in a list.
  *
  * @param array $rows Array of search results
  */
  public function display_results( $rows ) {
    $results = $this->display_search_terms();

    $number   = count( $rows );
    $results .= "<p class='results_count'>{$number} results found</p>";

    $results .= '<ul class="search_results">';
    foreach ( $rows as $source ) {
      $admin  = '';
      $script = '';
      if ( $this->is_logged_in ) {
        $admin = "<span class='maintenance'>
          <a href='/admin-sources.php?id={$source['id']}'>Edit</a> |
          <a href='/admin-sources.php?delete={$source['id']}' onclick='return confirmAction()'>Delete</a>
        </span>";

        $script = '<script type="text/javascript" language="JavaScript">
         function confirmAction(){
            var confirmed = confirm("Are you sure? This will remove this source forever!");
            return confirmed;
         }
         </script>';
      }
      $results .= "<li>{$source['editor']}, <a href='/sources.php?id={$source['id']}'>{$source['title']}</a>{$admin}</li>";
    }
    $results .= "</ul>{$script}";
    return $results;
  }

  /*
  * Display a list of the user's search terms
  */
  public function display_search_terms() {
    $terms = '<ul class="search_terms">You searched for:';
    foreach( $_GET as $key => $value ) {
      if( '' !== $value ) {
        $clean_key = ucfirst( str_replace( '_', ' ', $key ) );

        if ( is_array( $value ) ) {
          if ( 'author' === $key ) {
            $authors = array();
            foreach( $value as $id ) {
              $author = $this->authors->get_author_by_id( $id );
              $authors[] = $author[0][0];
            }
            //echo '<pre>' . print_r( $authors, true) . '</pre>';
            $clean_value = implode( '; ', $authors );
          } else {
            $clean_value = implode( ', ', $value );
          }
        } else {
          $clean_value = str_replace( '+', ' ', $value );
        }

        $terms .= "<li>{$clean_key} = {$clean_value}</li>";
      }
    }

    return $terms;
  }

  /*
  * Build a segment of a search result based on GET parameters
  *
  * @param string $key  The table column name.
  * @param string $val  The table column value.
  * @param string $query_string The current query string.
  */
  public function build_query_segment( $key, $val, $query_string ) {

          switch ( $key ) {
          case 'my_id':
                  $this->reg_queries .= "sources.my_id like \"%$val%\"";
                  break;
          case 'cataloger':
                  $this->reg_queries .= "sources.cataloger like \"%$val%\"";
                  break;
          case 'editor':
                  $this->reg_queries .= "sources.editor like \"%$val%\"";
                  break;
          case 'title':
                  $this->reg_queries .= "sources.title like \"%$val%\"";
                  break;
          case 'text_title':
                  $this->reg_queries .= "(sources.text_name like \"%$val%\" OR sources.title like \"%$val%\")";
                  break;
          case 'publication':
                  $this->reg_queries .= "sources.publication like \"%$val%\"";
                  break;
          case 'pub_date':
                  $this->reg_queries .= "sources.pub_date like \"%$val%\"";
                  break;
          case 'isbn':
                  $this->reg_queries .= "sources.isbn like \"%$val%\"";
                  break;
          case 'text_pages':
                  $this->reg_queries .= "sources.text_pages like \"%$val%\"";
                  break;
          case 'link':
                  $this->reg_queries .= "sources.link like \"%$val%\"";
                  break;
          case 'text_name':
                  $this->reg_queries .= "sources.text_name like \"%$val%\"";
                  break;
          case 'date_begin':
                  $this->reg_queries .= "sources.date_begin >= $val";
                  break;
          case 'date_end':
                  $this->reg_queries .= "sources.date_end <= $val";
                  break;
          case 'trans_none':
                  $this->reg_queries .= "sources.trans_none like $val";
                  break;
          case 'trans_english':
                  $this->reg_queries .= "sources.trans_english like $val";
                  break;
          case 'trans_french':
                  $this->reg_queries .= "sources.trans_french like $val";
                  break;
          case 'trans_other':
                  $this->reg_queries .= "sources.trans_other like $val";
                  break;
          case 'trans_comment':
                  $this->reg_queries .= "sources.trans_comment like \"%$val%\"";
                  break;
          case 'archive':
                  $this->reg_queries .= "sources.archive like \"%$val%\"";
                  break;
          case 'author':
                  if ( strpos($this->tables,"authorships") === false )
                          $this->tables .= ",authorships";
                  $this->join_queries .= "authorships.source_id=sources.id AND authorships.author_id like \"%$val%\"";
                                  break;
          case 'language':
                  if ( strpos($this->tables,"languages") === false )
                          $this->tables .= ",languages";
                  $this->join_queries .= "languages.source_id=sources.id AND languages.name like \"%$val%\"";
                  break;
          case 'region':
                  $this->reg_queries .= "sources.region like \"%$val%\"";
                  break;
          case 'countries':
                  if ( strpos($this->tables,"countries") === false )
                          $this->tables .= ",countries";
                  $this->join_queries .= "countries.source_id=sources.id AND countries.name like \"%$val%\"";
                  break;
          case 'type':
                  if ( strpos($this->tables,"types") === false )
                          $this->tables .= ",types";
                  $this->join_queries .= "types.source_id=sources.id AND types.name like \"%$val%\"";
                  break;
          case 'subject':
                  if ( strpos($this->tables,"subjects") === false )
                          $this->tables .= ",subjects";
                  $this->join_queries .= "subjects.source_id=sources.id AND subjects.name like \"%$val%\"";
                  break;
          case 'app_index':
                  $this->reg_queries .= "sources.app_index like \"%$val%\"";
                  break;
          case 'app_glossary':
                  $this->reg_queries .= "sources.app_glossary like \"%$val%\"";
                  break;
          case 'app_appendix':
                  $this->reg_queries .= "sources.app_appendix like \"%$val%\"";
                  break;
          case 'app_bibliography':
                  $this->reg_queries .= "sources.app_bibliography like \"%$val%\"";
                  break;
          case 'app_facsimile':
                  $this->reg_queries .= "sources.app_facsimile like \"%$val%\"";
                  break;
          case 'app_intro':
                  $this->reg_queries .= "sources.app_intro like \"%$val%\"";
                  break;
          case 'comments':
                  $this->reg_queries .= "sources.comments like \"%$val%\"";
                  break;
          case 'intro_summary':
                  $this->reg_queries .= "sources.intro_summary like \"%$val%\"";
                  break;
          case 'addenda':
                  $this->reg_queries .= "sources.addenda like \"%$val%\"";
                  break;
          case 'live':
                  $this->reg_queries .= "sources.live like \"%$val%\"";
                  break;
  	}

  }

  /*
  * Check if an array key has a non-empty value
  *
  * @param array $array  The array
  * @param string $val   The value to look for in the array
  */
  public function ar( $array, $key ) {
    return isset( $array[ $key ] ) && '' !== $array[ $key ];
  }

}
