<?php 
include 'header.php';
include 'connect.php'; ?>

<h2>Delete Source</h2>

<?php 
$id=$_GET['id'];
$sql = mysqli_query($db_server, "select * from sources where id=$id;");

$source = mysqli_fetch_array($sql);
$title = $source['title'];
?>

<p><?php echo $title; ?> has been removed from the database.</p>

<?php $sql = mysqli_query($db_server, "delete from sources where id=$id;"); ?>


<?php include 'footer.php';
?>