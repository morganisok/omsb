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

class Source {

  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function create() {

  }

  public function display( $id ) {
    $result = $this->get_source( $id );

    if ( ! $result ) {
      return '<p>No source found with that ID.  Please go back and <a href="sources.php">search again</a>.</p>';
    }

    $source = $result->fetch_array( MYSQLI_ASSOC );

    if ( isset( $_SESSION['user'] ) && ! empty( $_SESSION['user'] ) ) {
      return $this->private_source_detail( $source );
    } else {
      return $this->public_source_detail( $source );
    }

  }

  public function update() {

  }

  public function delete() {

  }

  public function get_source( $id ) {
    $query = sprintf( "SELECT * from sources WHERE id=%s", $this->db->mysqli->real_escape_string( $id ) );
    return $this->db->mysqli->query( $query );
  }

  public function private_source_detail( $source ) {
    echo '<pre>' . print_r($source, true) . '</pre>';
    $authors      = 'need to get a list of authors';
    $languages    = 'list of languages';
    $translations = $this->translations( $source );
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
      <p><span class='label'>Medieval Author(s):</span>&nbsp;{$authors}</p>
      <p><span class='label'>Dates:</span>&nbsp;{$source['date_begin']} - {$source['date_end']}</p>
      <p><span class='label'>Archival Reference:</span>&nbsp;{$source['archive']}</p>
      <p><span class='label'>Original Language(s):</span>&nbsp;{$languages}</p>
      <p><span class='label'>Translation:</span>&nbsp;{$translations}</p>
      <p><span class='label'>Translation Comments:</span>&nbsp;{$source['trans_comment']}</p>
      <h5>Region Information</h5>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <h5>Finding Aids</h5>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <h5>Apparatus</h5>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
      <p><span class='label'>:</span>&nbsp;{$source['']}</p>
    </article>";
  }

  public function public_source_detail( $source ) {

  }

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
    return $list;
  }

}
