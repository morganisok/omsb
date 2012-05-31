<?php 
include 'header.php';
include 'connect.php'; ?>

<?php require_once('classTextile.php'); 
$textile = new Textile(); ?>

<h2>Author Details</h2>

<?php 
$id=$_GET['id'];
$sql = mysql_query("select * from authors where id=$id;");

$author = mysql_fetch_array($sql);
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


<?php include 'footer.php';
?>

