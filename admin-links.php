<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php';
require_once 'auth.php';

if(isAppLoggedIn()) { 

$query = "SELECT sources.id,sources.editor,sources.title,sources.link from sources where link != \"\" order by link;";
	   
$result = mysqli_query($db_server, $query);
		if ( !$result->num_rows ) {   # we have bad search results
		  print ("Could not find any sources that match your search terms.");
		} else {	###    we have results back from the SQL--display them now    ###
		?>

		<h4>Sources with Notes</h4>
		<!-- Pagination Stuff -->
		<div class="pages">

			<?php
			$result = mysqli_query($db_server, $query);
			$db_count = mysqli_num_rows($result);
			echo $db_count." total results";
#			$count_query = "SELECT count(sources.id) from sources ".$tmpquery.";";
			#echo $count_query;
#			$db_count = mysqli_fetch_array($result);
			$pages = new Paginator;
			$pages->items_total = $db_count;
			$pages->mid_range = 7;
			$pages->paginate();
			echo $pages->display_pages();
			echo $pages->display_items_per_page();
			$pages->limit;
			$query = substr_replace($query ,"",-1);
			$query .= $pages->limit.";";
#			echo "<br>".$query."<br>";
			$result = mysqli_query($db_server, $query);
#			$result = mysqli_query($db_server, $query);
			?>
	   </div>
	   <!-- End Pagination Stuff -->

	   <?php while ($row = mysqli_fetch_array($result)){
	      $id = $row['id'];
	      $editor = $row['editor'];
	      $title = $row['title'];
	      $link = $row['link'] ?>

	      <ul>
	         <li><?php echo $editor; ?>, <a href="/sources.php?id=<?php echo $id; ?>">
	            <?php echo $title; ?></a>
	            <div class="link">URL:<a href="<?php echo $link; ?>" target="_blank"><?php echo $link; ?></a></div>
	            <?php if(isAppLoggedIn()) { ?>
	               <p class="maintenance">
	                     <script type="text/javascript" language="JavaScript">
	                     function confirmAction(){
	                        var confirmed = confirm("Are you sure? This will remove this source forever!");
	                        return confirmed;
	                     }
	                     </script>
	                  <a href="/admin-sources.php?id=<?php echo $id; ?>">Edit</a> |
	                  <a href="/admin-sources.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
	               </p>
	            <?php } ?>
	         </li>
	      </ul>

	      <?php
	       }	 
	   }##   end of while loop going over results   

} else { ?>
	<p>Sorry, you must <a href="/login.php">log in</a> to view this page.</p>
<?php } ?>


<?php include 'footer.php'; ?>
