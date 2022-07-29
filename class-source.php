<?php
namespace OMSB;

require_once 'class-languages.php';
require_once 'class-countries.php';
require_once 'class-types.php';
require_once 'class-subjects.php';
require_once 'class-authors.php';
require_once 'class-database.php';
require_once 'vendor/textile/src/Netcarver/Textile/Parser.php';


use OMSB\Languages;
use OMSB\Countries;
use OMSB\Types;
use OMSB\Subjects;
use OMSB\Authors;
use OMSB\Database;
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
    $authors      = $this->authors->get_source_author_details( $source['id'] );
    $languages    = $this->languages->get_source_details( $source['id'] );
    $countries    = $this->countries->get_source_details( $source['id'] );
    $translations = $this->translations( $source );
    $types        = $this->types->get_source_details( $source['id'] );
    $subjects     = $this->subjects->get_source_details( $source['id'] );
    $apparatus    = $this->apparatus( $source );
    $live         = $source['live'] ? 'This record is visible to the public' : 'This record is hidden from the public';
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
      <p><span class='label'>Geopolitical Region(s):</span>&nbsp;{$countries}</p>
      <p><span class='label'>County/Region:</span>&nbsp;{$source['region']}</p>
      <h5>Finding Aids</h5>
      <p><span class='label'>Record Types:</span>&nbsp;{$types}</p>
      <p><span class='label'>Subject Headings:</span>&nbsp;{$subjects}</p>
      <h5>Apparatus</h5>
      <p><span class='label'>Apparatus:</span>&nbsp;{$apparatus}</p>
      <p><span class='label'>Comments:</span>&nbsp;{$this->textile->parse( $source['comments'] )}</p>
      <p><span class='label'>Introduction Summary:</span>&nbsp;{$this->textile->parse( $source['intro_summary'] )}</p>
      <p><span class='label'>Cataloger:</span>&nbsp;{$source['cataloger']}</p>
      <p><span class='label'>My ID:</span>&nbsp;{$source['my_id']}</p>
      <p><span class='label'>Notes:</span>&nbsp;{$source['addenda']}</p>
      <p>{$live}</p>
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
    if ( '' !== $list ) {
      $list = '<ul class="translations">' . $list . '</ul>';
    }
    return $list;
  }

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

}
