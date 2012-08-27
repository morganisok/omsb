<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php'; ?>

<h2>Search</h2>
<?php if (!$_GET){           ####  we display the form to get a search term  #### ?>
	<p>This search form is not fully functional yet - right now, it will look in the text name and title fields for the search terms you enter below.</p>
	<form action="sources.php" method="get">
		<li class="whole"><label>Title:</label>
		<input type="text" name="search" placeholder="search in text name or title" /></li>
    <input type="submit" class="button" value="Search" />
    </form>

<?php } else {  # we have a search term
	?>

	<?php
	if ( $_GET['search'] ) {   ####  we have a search term, not a display source  ####

	echo "<h2>Search Results</h2>";

	$searchterm = mysqli_real_escape_string($db_server, $_GET['search']); ?>

	<p>You searched for: 
	<?php echo $_GET['search']; ?>
	</p>

	<?php $result = mysqli_query($db_server, "select * from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%';");
	if ( !$result->num_rows ) {
		print ("Could not find any sources that match your search terms."); ?>
		<p>This search form is not fully functional yet - right now, it will look in the text name and title fields for the search terms you enter below.</p>
		<form action="sources.php" method="get">
		<li class="whole"><label>Title:</label>
		<input type="text" name="search" placeholder="search in text name or title" /></li>
    <input type="submit" class="button" value="Search" />
    </form>
	<?php } else {
	?>

	<h4>Search Results:</h4>
	<!-- Pagination Stuff -->
	<div class="pages">
	<?php $result = mysqli_query($db_server, "select count(*) from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%';");
		$db_count = mysqli_fetch_array($result);
		$pages = new Paginator;
		$pages->items_total = $db_count[0];
		$pages->mid_range = 7;
		$pages->paginate();
		echo $pages->display_pages(); 
		echo $pages->display_items_per_page();
		$result = mysqli_query($db_server, "select * from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%' order by sources.editor $pages->limit;"); ?>
	</div>
	<!-- End Pagination Stuff -->

	<?php while ($row = mysqli_fetch_array($result)){

		$id = $row['id'];
		$editor = $row['editor'];
		$title = $row['title']; ?>

		<ul>
			<li><?php echo $editor; ?>, <a href="http://omsb.alchemycs.com/sources.php?id=<?php echo $id; ?>">
				<?php echo $title; ?></a> 
				<?php if($isloggedin) { ?>
					<p class="maintenance">
							<script type="text/javascript" language="JavaScript">
							function confirmAction(){
						      var confirmed = confirm("Are you sure? This will remove this source forever!");
						      return confirmed;
							}
							</script>
						<a href="http://omsb.alchemycs.com/admin-source.php?id=<?php echo $id; ?>">Edit</a> | 
						<a href="http://omsb.alchemycs.com/admin-source.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
					</p>
				<?php } ?>
			</li>
		</ul>
		
	 	<?php
		 } # end while
	 }  # end if for good search results
} else {           ####  not searching, we will display a source  ####

	require_once('classTextile.php'); 
	$textile = new Textile(); ?>

	<h2>Source Details</h2>

	<?php 
	$id = mysqli_real_escape_string($db_server, $_GET['id']);
	$result = mysqli_query($db_server, "select * from sources where id=$id;");

	$source = mysqli_fetch_array($result);
		$my_id = $source['my_id'];
		$editor = $source['editor'];
		$title = $source['title'];
		$publication = $source['publication'];
		$pub_date = $source['pub_date'];
		$isbn = $source['isbn'];
		$text_pages = $source['text_pages'];
		$trans_english = $source['trans_english'];
		$trans_french = $source['trans_french'];
		$trans_other = $source['trans_other'];
		$trans_none = $source['trans_none'];
		$date_begin = $source['date_begin'];
		$date_end = $source['date_end'];
		$region = $source['region'];
		$archive = $source['archive'];
		$link = $source['link'];
		$app_index = $source['app_index'];
		$app_glossary = $source['app_glossary'];
		$app_appendix = $source['app_appendix'];
		$app_bibliography = $source['app_bibliography'];
		$app_facsimile = $source['app_facsimile'];
		$app_intro = $source['app_intro'];
		$comments = $source['comments'];
		$intro_summary = $source['intro_summary'];
		$addenda = $source['addenda'];
		$live = $source['live'];
		$created_at = $source['created_at'];
		$updated_at = $source['updated_at'];
		$user_id = $source['user_id'];
		$trans_comment = $source['trans_comment'];
		$text_name = $source['text_name'];
		$cataloger = $source['cataloger'];
	?>


	<?php if($isloggedin) { ?>		
	<!-- private view for logged in users -->
			<article class="source private">

				<h5>Publication Information</h5>
				<p><label>Modern Editor/Translator:</label><?php echo $editor; ?></p>
				<p><label>Book/Article Title:</label> <?php echo $title; ?></p>
				<p><label>Publication Information:</label> <?php echo $publication; ?>, <?php echo $pub_date; ?></p>
				<p><label>ISBN:</label> <?php echo $isbn; ?></p>
				<p><label>Number of pages of primary source text:</label> <?php echo $text_pages; ?></p>
				<p><label>Hyperlink:</label> <?php echo $link; ?></p>

				<h5>Original Text Information</h5>
				<p><label>Text name(s):</label> <?php echo $text_name; ?></p>
				<p><label>Medieval Author(s):</label>
							<ul>
					<?php $authors = mysqli_query($db_server, "select author_id from authorships where source_id=$id;");
					$authorsquery = "select name from authors where id in (";
					while ($row = mysqli_fetch_array($authors)){
						$authorsquery .= "$row[0],";
					}
					$authorsquery = substr($authorsquery,0,-1);
					$authorsquery .= ");";
					$authorsname = mysqli_query($db_server, $authorsquery);
					while ($row = mysqli_fetch_array($authorsname)){
						echo "<li> $row[0] </li>";
					}
					?>
					</ul></p>
				<p><label>Dates:</label> <?php echo $date_begin; ?> - <?php echo $date_end; ?></p>
				<p><label>Archival Reference: </label> <?php echo $archive; ?></p>
				<p><label>Original Language(s):</label>
					<ul>
					<?php $languages = mysqli_query($db_server, "select name from languages where source_id=$id;");
					while ($row = mysqli_fetch_array($languages)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>Translation: </label>
					<ul class="translation">
					<?php if($trans_none) { echo "<li>Original language included</li>"; }
						if($trans_english) { echo "<li>Translated into English</li>"; }
						if($trans_french) { echo "<li>Translated into French</li>"; }
						if($trans_other) { echo "<li>Translated into another language</li>"; } 
						?>
					</ul></p>
				<p><label>Translation Comments:</label> <?php echo $trans_comment; ?></p>

				<h5>Region Information</h5>
				<p><label>Geopolitical Region(s): </label>
					<ul>
					<?php $countries = mysqli_query($db_server, "select name from countries where source_id=$id;");
					while ($row = mysqli_fetch_array($countries)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>County/Region:</label> <?php echo $county; ?></p>

				<h5>Finding Aids</h5>
				<p><label>Record Types:</label>
					<ul>
					<?php $types = mysqli_query($db_server, "select name from types where source_id=$id;");
					while ($row = mysqli_fetch_array($types)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>Subject Headings:</label>
							<ul>
					<?php $subjects = mysqli_query($db_server, "select name from subjects where source_id=$id;");
					while ($row = mysqli_fetch_array($subjects)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>	</p>

			<h5>Apparatus</h5>
				<p><label>Apparatus:</label>
					<ul class="apparatus">
					<?php if($app_index) { echo "<li>Index</li>"; } 
						if($app_glossary) { echo "<li>Glossary</li>"; }
						if($app_appendix) { echo "<li>Appendix</li>"; }
						if($app_bibliography) { echo "<li>Bibliography</li>"; }
						if($app_facsimile) { echo "<li>Facsimile</li>"; }
						if($app_intro) { echo "<li>Introduction</li>"; }
						?>
					</ul></p>
				<div class="comments"><label>Comments:</label> <?php echo $textile->TextileThis($comments); ?> </div>
				<div class="intro-summary"><label>Introduction Summary:</label> <?php echo $textile->TextileThis($intro_summary); ?></div>
				<p><label>Cataloger:</label>
				<p><label>My ID:</label> <?php echo $my_id; ?></p>
				<p><label>Notes: </label> <?php echo $addenda; ?></p>
				<p><?php if($live) {
					echo "This record is viewable by the public";
				} else {
					echo "This record is hidden from the public";
				} ?></p>
				<p><label>Cataloger: </label><?php echo $cataloger; ?></p>
				<p class="maintenance">
						<script type="text/javascript" language="JavaScript">
						function confirmAction(){
					      var confirmed = confirm("Are you sure? This will remove this source forever!");
					      return confirmed;
						}
						</script>
					<a href="http://omsb.alchemycs.com/admin-source.php?id=<?php echo $id; ?>">Edit</a> | 
					<a href="http://omsb.alchemycs.com/admin-source.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
				</p>
	<?php } else { ?>

	<!-- public view for not logged in users -->

			<article class="source">
				<p class="citation">
					<?php echo $editor; ?>,
					<i><?php echo $title; ?></i>
					(<?php echo $publication; ?>,<?php echo $pub_date; ?>). 
					<?php if($isbn) { ?>
						ISBN: 
						<?php echo $isbn; ?>
						<a href="http://worldcat.org/isbn/<?php echo $isbn; ?>" target="_blank">Find this book in a library</a>
					<?php } ?>
					<?php if($link) { ?>
						<a href="<?php echo $link; ?>" target="_blank">Read this source online</a>
					<?php } ?>
				</p>

				<?php if($text_name) { ?>
					<p><label>Text name(s):</label> <?php echo $text_name; ?></p>
				<?php } ?>

				<?php if($text_pages) { ?>
					<p><label>Number of pages of primary source text:</label> <?php echo $text_pages; ?></p>
				<?php } ?>

				<p><label>Author(s):</label>
					<ul>
					<?php $authors = mysqli_query($db_server, "select author_id from authorships where source_id=$id;");
					$authorsquery = "select name from authors where id in (";
					while ($row = mysqli_fetch_array($authors)){
						$authorsquery .= "$row[0],";
					}
					$authorsquery = substr($authorsquery,0,-1);
					$authorsquery .= ");";
					$authorsname = mysqli_query($db_server, $authorsquery);
					while ($row = mysqli_fetch_array($authorsname)){
						echo "<li> $row[0] </li>";
						// TODO: NEED TO GET AUTHOR ID AND MAKE A LINK
					}
					?>
					</ul>
				</p>

				<?php if($date_begin || $date_end) { ?>
					<p><label>Dates:</label> <?php echo $date_begin; ?> - <?php echo $date_end; ?></p>
				<?php } ?>

				<?php if($archive) { ?>
					<p><label>Archival Reference:</label> <?php echo $archive; ?></p>
				<?php } ?>	

				<p><label>Original Language(s):</label>
					<ul>
					<?php $languages = mysqli_query($db_server, "select name from languages where source_id=$id;");
					while ($row = mysqli_fetch_array($languages)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>

				<p><label>Translation:</label>
					<ul class="translation">
					<?php if($trans_none) { echo "<li>Original language included</li>"; }
						if($trans_english) { echo "<li>Translated into English</li>"; }
						if($trans_french) { echo "<li>Translated into French</li>"; }
						if($trans_other) { echo "<li>Translated into another language</li>"; } 
						?>
					</ul>
				</p>

				<?php if($trans_comment) { ?>
					<p><label>Translation Comments:</label> <?php echo $trans_comment; ?></p>
				<?php } ?>

				<p><label>Geopolitical Region(s):</label>
					<ul>
					<?php $countries = mysqli_query($db_server, "select name from countries where source_id=$id;");
					while ($row = mysqli_fetch_array($countries)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>

				<?php if($county) { ?>
					<p><label>County/Region:</label> <?php echo $county; ?></p>
				<?php } ?>

				<p><label>Record Type(s):</label>
					<ul>
					<?php $types = mysqli_query($db_server, "select name from types where source_id=$id;");
					while ($row = mysqli_fetch_array($types)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>
				<p><label>Subject Heading(s):</label>
					<ul>
					<?php $subjects = mysqli_query($db_server, "select name from subjects where source_id=$id;");
					while ($row = mysqli_fetch_array($subjects)){
						echo "<li> $row[0] </li>";
						// some day it might be nice to make all of the subjects link to a search for the subject (might as well do other stuff too)
					} ?>
					</ul>
				</p>
				<p><label>Apparatus:</label>
					<ul class="apparatus">
					<?php if($app_index) { echo "<li>Index</li>"; } 
						if($app_glossary) { echo "<li>Glossary</li>"; }
						if($app_appendix) { echo "<li>Appendix</li>"; }
						if($app_bibliography) { echo "<li>Bibliography</li>"; }
						if($app_facsimile) { echo "<li>Facsimile</li>"; }
						if($app_intro) { echo "<li>Introduction</li>"; }
						?>
					</ul>
				</p>
				<div class="comments"><label>Comments:</label><?php echo $textile->TextileThis($comments); ?></div>
				<div class="intro-summary"><label>Introduction Summary:</label><?php echo $textile->TextileThis($intro_summary); ?></div>
				<p><label>Cataloger:</label><?php echo $cataloger; ?></p>

			</article>
	<?php } 

} # end if
?>

<?php include 'footer.php';
}
?>
