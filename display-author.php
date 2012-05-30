<?php 
include 'header.php';
include 'connect.php'; ?>

<h2>Author Search Results</h2>

<?php 
$id=$_GET['id'];
$sql = mysql_query("select * from authors where id=$id;");



$author = mysql_fetch_array($sql);

print_r($author);
print($author['name']);


?>




<?php include 'footer.php';
?>

