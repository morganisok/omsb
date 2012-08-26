<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php';

if (!$_GET){           ####  we display the form to get a search term  ####
?>
	<h2>Search for Medieval Authors</h2>
    <form action="authors.php" method="get">
    <li class="half"><label>Search:</label> <input type="text" name="search" placeholder="type an author's name"/></li>
    <input type="submit" class="button" value="Search" />
    </form>

	<?php
} else {  # we have a search term
	?>

<?php
if ( $_GET['search'] ) {   ####  we have a search term, not a display author  ####

	echo "<h2>Author Search Results</h2>";

	$searchterm = mysqli_real_escape_string($db_server, $_GET['search']); ?>

	<p>You searched for: 
	<?php echo $_GET['search']; ?>
	</p>

	<?php $result = mysqli_query($db_server, "select * from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%';");
	if ( !$result->num_rows ) {
		print ("Could not find that author.  Please try a different search term."); ?>
		    <form action="authors.php" method="get">
		    <li class="half"><label>Search:</label> <input type="text" name="search" placeholder="type an author's name"/></li>
		    <input type="submit" class="button" value="Search" />
		    </form> <?php
	} else {
	?>

	<h4>Search Results:</h4>
	<!-- Pagination Stuff -->
	<div class="pages">
	<?php $result = mysqli_query($db_server, "select count(*) from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%';");
		$db_count = mysqli_fetch_array($result);
		$pages = new Paginator;
		$pages->items_total = $db_count[0];
		$pages->mid_range = 7;
		$pages->paginate();
		echo $pages->display_pages(); 
		echo $pages->display_items_per_page();
		$result = mysqli_query($db_server, "select * from authors where authors.name like '%$searchterm%' or authors.alias like '%$searchterm%' order by authors.name $pages->limit;"); ?>
		</div>
	<!-- End Pagination Stuff -->

	<?php while ($row = mysqli_fetch_array($result)){

		$id = $row['id'];
		$name = $row['name'];
		$alias = $row['alias'];
		$date_begin = $row['date_begin'];
		$date_end = $row['date_end']; ?>

		<ul>
			<li><a href="http://omsb.alchemycs.com/authors.php?id=<?php echo $id; ?>">
				<?php echo $name; ?></a> 
				<?php if ($alias) {
					echo '(';
					echo $alias;
					echo ')';
				} ?>
				<?php echo $date_begin; ?> - <?php echo $date_end; ?>
				<p class="maintenance">
					<script type="text/javascript" language="JavaScript">
					function confirmAction(){
				      var confirmed = confirm("Are you sure? This will remove this author forever.");
				      return confirmed;
					}
					</script>
					<a href="http://omsb.alchemycs.com/admin-author.php?id=<?php echo $id; ?>">Edit</a> | 
					<a href="http://omsb.alchemycs.com/admin-author.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
				</p>
			</li>
		</ul>
	
		<?php
		}# end while
	} # end good search term
} else {           ####  not searching, we will display an author  ####

require_once('classTextile.php'); 
$textile = new Textile(); ?>

<h2>Author Details</h2>

<?php 
$id = mysqli_real_escape_string($db_server, $_GET['id']);
$result = mysqli_query($db_server, "select * from authors where id=$id;");

$author = mysqli_fetch_array($result);
$name = $author['name'];
$alias = $author['alias'];
$title = $author['title'];
$date_type = $author['date_type'];
$date_circa = $author['date_circa'];
$date_begin = $author['date_begin'];
$date_end = $author['date_end'];
$bio = $author['bio'];
?>

<?php if ( !$result->num_rows ) {
  			print ("Could not find that author.  Please try a different search term"); ?>
		    <form action="authors.php" method="get">
		    <li class="half"><label>Search:</label> <input type="text" name="search" placeholder="type an author's name"/></li>
		    <input type="submit" class="button" value="Search" />
		    </form> <?php 
		} else { ?>


<article class="author">
<h4><span class="name"><?php echo $name; ?></span>
        <?php if ($alias) {
                                echo '(';
                                echo $alias;
                                echo ')';
                        } ?>
        <?php if ($title) { echo $title; } ?></h4>
<p><?php echo $date_type; 
        echo "&nbsp;";
        if( $date_circa ) echo "c.&nbsp;";
        echo $date_begin; ?> - <?php echo $date_end; ?></p>

<div class="bio">
        <?php echo $textile->TextileThis($bio); ?>
</div>

<div class="works">
        <h5>OMSB Records by <?php echo $name; ?></h5>

        <ul>
                <?php
                $result = mysqli_query($db_server, "select source_id from authorships where author_id=$id;");
                while ($row = mysqli_fetch_array($result)){

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
    </div>
</article>

<?php } ?>

<?php

} # end if
?>

<?php include 'footer.php';
}
?>

