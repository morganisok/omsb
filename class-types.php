<?php

namespace OMSB;

require_once 'class-list.php';
require_once 'class-database.php';

use OMSB\ListClass;
use OMSB\Database;

class Types extends ListClass {

  public $list;

  public $table_name;

  public $db;

  public function __construct() {
    $this->table_name = 'types';
    $this->db         = new Database;

    $this->list = [
      "Account Roll",
      "Account Roll - Bailiff/Reeve",
      "Account Roll - Building",
      "Account Roll - Estate",
      "Account Roll - Household",
      "Account Roll - Obedientiary",
      "Account Roll - Port Customs",
      "Bestiary",
      "Biography",
      "Calendar",
      "Cartulary",
      "Charters Deeds",
      "Chronicle Annals",
      "Commentary / Gloss / Exegesis",
      "Contract",
      "Coroner's Roll",
      "Councils - Church",
      "Councils - Secular",
      "Court Roll",
      "Court Roll - Ecclesiastical",
      "Court Roll - Eyre",
      "Court Roll - Gaol Delivery",
      "Court Roll - Sessions of the Peace",
      "Custumal",
      "Dialog",
      "Disputation - Philosophical/Theological",
      "Encyclopedia",
      "Extents and Surveys",
      "Formulary",
      "Genealogy",
      "Glossary / Dictionary",
      "Guild Records",
      "Hagiography",
      "Inquisition - Heresy",
      "Inscription",
      "Inventory",
      "Law - Canon Law",
      "Law - Legislation",
      "Law - Local Ordinances",
      "Law - Treatise/Commentary",
      "Letter",
      "Literature - Drama",
      "Literature - Prose",
      "Literature - Verse",
      "Liturgy",
      "Memoir",
      "Memoir - Family",
      "Miscellany",
      "Monastic Rule",
      "Muster",
      "Obituary",
      "Oration",
      "Other",
      "Papal Bull",
      "Penitential",
      "Petition",
      "Philosophic Work",
      "Prophecy",
      "Proverbs",
      "Register - Bishop",
      "Register - Notarial",
      "Register - Other",
      "Scripture",
      "Sermons",
      "Taxes",
      "Taxes - Clerical Subsidy",
      "Taxes - Lay Subsidy",
      "Taxes - Poll Tax",
      "Theology",
      "Theology - Devotional",
      "Theology - Doctrine",
      "Theology - Mystical Work",
      "Theology - Practical/Instructional",
      "Theology/Philosophy - Summa",
      "Translation",
      "Treatise - Instruction/Advice",
      "Treatise - Other",
      "Treatise - Political",
      "Treatise - Scientific/Medical",
      "Treaty / Diplomatic",
      "Visitations",
      "Will"
    ];
  }

}
?>
