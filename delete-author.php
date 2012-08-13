<?php 
include 'header.php';
include 'connect.php'; ?>

<h2>Delete Author</h2>

<?php 
$id=$_GET['id'];
$sql = mysqli_query($db_server, "select * from authors where id=$id;");

$author = mysqli_fetch_array($sql);
$name = $author['name'];
?>

<p><?php echo $name; ?> has been removed from the database.</p>

<?php $sql = mysqli_query($db_server, "delete from authors where id=$id;"); ?>


<?php include 'footer.php';
?>