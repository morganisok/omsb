<?php

// Include the textile parser library
require_once 'vendor/autoload.php';
require_once 'vendor/netcarver/textile/src/Netcarver/Textile/Parser.php';

// Create a new Textile object
use Netcarver\Textile\Parser;
$textile = new Parser();

// Parse the textile input
$html = $textile->parse($_POST["textile"]);

// Return the result as a JSON response
echo json_encode(array("success" => true, "html" => $html));

?>
