<?php 
include 'header.php';
include 'connect.php'; ?>

<h2>Author Search Results</h2>

<?php $searchterm = $_POST['term']; ?>

<p>You searched for: 
<?php echo $searchterm; ?>
</p>


<h4>Search Results:</h4>
<?php $sql = mysqli_query($db_server, "select * from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%' order by authors.name;");

while ($row = mysqli_fetch_array($sql)){

	$id = $row['id'];
	$name = $row['name'];
	$alias = $row['alias'];
	$from = $row['date_begin'];
	$to = $row['date_end']; ?>

	<ul>
		<li><a href="http://omsb.alchemycs.com/display-author.php?id='<?php echo $id; ?>'">
			<?php echo $name; ?></a> 
			<?php if ($alias) {
				echo '(';
				echo $alias;
				echo ')';
			} ?>
			<?php echo $from; ?> - <?php echo $to; ?>
		</li>
	</ul>


    <?php }
?>

<?php include 'footer.php';
?>

