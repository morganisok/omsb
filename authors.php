<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php';

if (!$_POST){

?>

    <form action="authors.php" method="post">
     Search: <input type="text" name="term" /><br />
    <input type="submit" name="submit" value="Submit" />
    </form>


<script type="text/javascript" language="JavaScript">
function confirmAction(){
      var confirmed = confirm("Are you sure? This will remove this author forever.");
      return confirmed;
}

</script>

<?php
} else {  # we have a search term
?>

<h2>Author Search Results</h2>

<?php
$searchterm = $_POST['term']; ?>

<p>You searched for: 
<?php echo $searchterm; ?>
</p>


<h4>Search Results:</h4>
<!-- Pagination Stuff -->
<?php $sql = mysqli_query($db_server, "select count(*) from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%';");
	$db_count = mysqli_fetch_array($sql);
	$pages = new Paginator;
	$pages->items_total = $db_count[0];
	$pages->mid_range = 7;
	$pages->paginate();
	echo $pages->display_pages(); 
	echo $pages->display_items_per_page(); ?>
<!-- End Pagination Stuff -->

<?php $sql = mysqli_query($db_server, "select * from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%' order by authors.name $pages->limit;");

while ($row = mysqli_fetch_array($sql)){

	$id = $row['id'];
	$name = $row['name'];
	$alias = $row['alias'];
	$from = $row['date_begin'];
	$to = $row['date_end']; ?>

	<ul>
		<li><a href="http://omsb.alchemycs.com/display-author.php?id=<?php echo $id; ?>">
			<?php echo $name; ?></a> 
			<?php if ($alias) {
				echo '(';
				echo $alias;
				echo ')';
			} ?>
			<?php echo $from; ?> - <?php echo $to; ?>
			<p class="maintenance">
				<a href="http://omsb.alchemycs.com/edit-author.php?id=<?php echo $id; ?>">Edit</a> | 
				<a href="http://omsb.alchemycs.com/delete-author.php?id=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
			</p>
		</li>
	</ul>


    <?php }
?>

<?php include 'footer.php';
}
?>

