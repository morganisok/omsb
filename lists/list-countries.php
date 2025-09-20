<?php
require_once '../auth.php';
include '../header.php';
require_once '../class-list.php';
require_once '../class-countries.php';

use OMSB\ListClass;

$languages = new OMSB\Countries;

$languages->display_list( 'Geopolitical Regions' );

include 'footer.php';
