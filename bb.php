<?php
//header("Content-Type: text/plain");
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: text/html');

$servername = "localhost"; 
    $username = "omsb_qa"; 
    $password = "z1W04Ba1d3Hk&zvj"; 
    $dbname = "omsb_qa"; 
  
    $conn = new mysqli($servername, $username, $password, $dbname); 
    if ($conn->connect_error) { 
          die("Connection failed: " . $conn->connect_error); 
    } 


$conn->set_charset("utf8mb4");
$sql = "SELECT text_name from sources where id = 2146115155;";
$result = $conn->query($sql);

$sql1 = "select editor, title, text_name from sources where binary title like '%lô%';";
$result1 = $conn->query($sql1);

$sql2 = "SELECT title FROM sources where id = -1999749502";
$result2 = $conn->query($sql2);


while($row = $result->fetch_assoc()) {
    var_dump($row);
}

echo "\n";
echo "<br>";
echo "<br>";
echo "\n";

while($row = $result1->fetch_assoc()) {
    var_dump($row);
}

echo "\n";
echo "<br>";
echo "<br>";
echo "\n";


while($row = $result2->fetch_assoc()) {
    var_dump($row);
}

?>