<?php

namespace OMSB;

require_once 'class-list.php';

use OMSB\ListClass;

class Countries extends ListClass {

  public $list;

  public function __construct() {
    $this->list = [
      "Africa",
      "Algeria",
      "Americas",
      "Armenia",
      "Asia",
      "Austria",
      "Balkans",
      "Belgium",
      "Bohemia",
      "British Isles",
      "Bulgaria",
      "Byzantium",
      "China",
      "Crete",
      "Croatia",
      "Czech Republic",
      "Denmark",
      "Egypt",
      "England",
      "Europe",
      "Finland",
      "Flanders",
      "France",
      "Georgia",
      "Germany",
      "Greece",
      "Holy Roman Empire",
      "Hungary",
      "Iberian Peninsula",
      "Iceland",
      "India",
      "Ireland",
      "Italy",
      "Middle East",
      "Netherlands",
      "New World",
      "Norway",
      "Persia",
      "Poland",
      "Portugal",
      "Prussia",
      "Russia",
      "Scandinavia",
      "Scotland",
      "Sicily",
      "Slovenia",
      "Spain",
      "Sweden",
      "Switzerland",
      "Tunisia",
      "Turkey",
      "Ukraine",
      "Wales",
      "Yugoslavia"
    ];
  }
}
?>
