<?php 
include 'header.php';
include 'connect.php'; ?>

<?php require_once('classTextile.php'); 
$textile = new Textile(); ?>

<h2>Author Details</h2>

<?php 
$id=$_GET['id'];
$sql = mysqli_query($db_server, "select * from authors where id=$id;");

$author = mysqli_fetch_array($sql);
$name = $author['name'];
$alias = $author['alias'];
$title = $author['title'];
$datemod = $author['date_type'];
$from = $author['date_begin'];
$to = $author['date_end'];
$bio = $author['bio'];
?>



<p><span class="name"><?php echo $name; ?></span>
	<?php if ($alias) {
				echo '(';
				echo $alias;
				echo ')';
			} ?>
	<?php if ($title) { echo $title; } ?></p>
<p><?php echo $datemod; 
	echo "&nbsp;";
	echo $from; ?> - <?php echo $to; ?></p>

<div class="bio">
	<?php echo $textile->TextileThis($bio); ?>
</div>

<div class="works">
	<h4>OMSB Records by <?php echo $name; ?></h4>

<?php

#  need to look up author_id in authorship table & return all source ids

$sql = mysqli_query($db_server, "select source_id from authorships where author_id=$id;");
while ($row = mysqli_fetch_array($sql)){

    $sql2 = mysqli_query($db_server, "select editor,title from sources where id=$row[0];");
    $temp2 = mysqli_fetch_array($sql2);

    echo "<pre>";
    print_r($temp2);
    echo "</pre>";
}
#$name = $author['name'];
#  need to loop over each source id & pull info from source_id table

?>

</div>

<?php include 'footer.php'; ?>

