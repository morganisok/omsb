<?php
require_once '../auth.php';
include '../header.php';
require_once '../class-list.php';
require_once '../class-types.php';

use OMSB\ListClass;

$languages = new OMSB\Types;

$languages->display_list( 'Record Types' );

include 'footer.php';
