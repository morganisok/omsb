<?php 
include 'header.php';
include 'connect.php'; 
require_once 'paginator.class.php';
?>

<script type="text/javascript" language="JavaScript">
function confirmAction(){
      var confirmed = confirm("Are you sure? This will remove this source forever.");
      return confirmed;
}

</script>


<h2>Source Search Results</h2>

<?php $searchterm = $_POST['term']; ?>

<p>You searched for: 
<?php echo $searchterm; ?>
</p>


<h4>Search Results:</h4>
<!-- Pagination Stuff -->
<?php $sql = mysqli_query($db_server, "select count(*) from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%';");
	$db_count = mysqli_fetch_array($sql);
	$pages = new Paginator;
	$pages->items_total = $db_count[0];
	$pages->mid_range = 7;
	$pages->paginate();
	echo $pages->display_pages(); 
	echo $pages->display_items_per_page(); ?>
<!-- End Pagination Stuff -->

<?php $sql = mysqli_query($db_server, "select * from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%' order by sources.editor $pages->limit;");

while ($row = mysqli_fetch_array($sql)){

	$id = $row['id'];
	$editor = $row['editor'];
	$title = $row['title']; ?>

	<ul>
		<li><?php echo $editor; ?>, <a href="http://omsb.alchemycs.com/display-source.php?id=<?php echo $id; ?>">
			<?php echo $title; ?></a> 

			<p class="maintenance">
				<a href="http://omsb.alchemycs.com/edit-source.php?id=<?php echo $id; ?>">Edit</a> | 
				<a href="http://omsb.alchemycs.com/delete-source.php?id=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
			</p>
		</li>
	</ul>


    <?php }
?>

<?php include 'footer.php';
?>

