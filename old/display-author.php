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


<article class="author">
<h4><span class="name"><?php echo $name; ?></span>
	<?php if ($alias) {
				echo '(';
				echo $alias;
				echo ')';
			} ?>
	<?php if ($title) { echo $title; } ?></h4>
<p><?php echo $datemod; 
	echo "&nbsp;";
	echo $from; ?> - <?php echo $to; ?></p>

<div class="bio">
	<?php echo $textile->TextileThis($bio); ?>
</div>

<div class="works">
	<h5>OMSB Records by <?php echo $name; ?></h5>

	<ul>
		<?php
		$sql = mysqli_query($db_server, "select source_id from authorships where author_id=$id;");
		while ($row = mysqli_fetch_array($sql)){

		    $sql2 = mysqli_query($db_server, "select editor,title,id,publication,pub_date from sources where id=$row[0];");
		    $works = mysqli_fetch_array($sql2);

		    $editor = $works['editor'];
		    $title = $works['title'];
		    $id = $works['id'];
		    $pub = $works['publication'];
		    $date = $works['pub_date']; ?>

		    <li>
		    	<?php echo $editor; ?>, <a href="http://omsb.alchemycs.com/display-source.php?id=<?php echo $id; ?>"><?php echo $title; ?></a>
		    	(<?php echo $pub; ?>, <?php echo $date; ?>).
		    </li>

		<?php }

		?>
	</ul>
</article>

</div>

<?php include 'footer.php'; ?>

