<?php

namespace OMSB;

require_once 'class-list.php';
require_once 'class-database.php';

use OMSB\ListClass;
use OMSB\Database;

class Languages extends ListCLass {

  public $list;

  public $table_name;

  public $db;

  public function __construct() {
    $this->table_name = 'languages';
    $this->db         = new Database;

    $this->list = [
      "Anglo-Norman",
      "Arabic",
      "Armenian",
      "Azestan",
      "Chinese",
      "Cornish",
      "Coptic - Bohairic",
      "Coptic - Sahidic",
      "Croatia",
      "Czech",
      "Dutch",
      "English - Anglo-Saxon / Old English",
      "English - Middle English",
      "English - Scots",
      "Ethiopian",
      "French - Breton",
      "French - Gascon",
      "French - Old French",
      "French - Other",
      "French - Provencal",
      "Georgia",
      "German",
      "German - Middle High German",
      "Greek",
      "Hebrew",
      "Italian",
      "Judeo-Arabic",
      "Latin",
      "Manx",
      "Old Bulgarian",
      "Old Church Slavonic",
      "Old Norse",
      "Old/Middle Irish",
      "Other",
      "Pahlavi",
      "Pazand",
      "Persian",
      "Portuguese",
      "Russian",
      "Scottish Gaelic",
      "Sicilian",
      "Slovenia",
      "Spanish",
      "Spanish - Castilian (Aljamaido)",
      "Spanish - Catalan",
      "Spanish - Medieval",
      "Syriac",
      "Turkish",
      "Welsh",
    ];
  }

}



?>
