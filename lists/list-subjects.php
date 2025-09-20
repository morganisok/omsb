<?php
require_once '../auth.php';
include '../header.php';
require_once '../class-list.php';
require_once '../class-subjects.php';

use OMSB\ListClass;

$languages = new OMSB\Subjects;

$languages->display_list( 'Subject Headings' );

include '../footer.php';
