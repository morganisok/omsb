<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php';
require_once 'auth.php';


if (!$_GET){           ####  we display the blank form to get a search term  ####
	echo "<h2>Search</h2>";
	search_form($db_server);
} else {  # we have GET data from the URL
	if ( $_GET['id'] ) {   ####  we have a _GET['id']--display that id's info  ####

	require_once('classTextile.php'); 
	$textile = new Textile(); ?>

	<h2>Source Details</h2>

	<?php 
	$id = mysqli_real_escape_string($db_server, $_GET['id']);
	$result = mysqli_query($db_server, "select * from sources where id=$id;");

	if ( !$result->num_rows ) {
		print ("Could not find that source.  Please try a different search term"); ?>
		<form action="sources.php" method="get">
		<li class="half"><label>Search:</label> <input type="text" name="search" placeholder="type a search text"/></li>
		<input type="submit" class="button" value="Search" />
		</form> <?php 
	} else {

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


	<?php if(isAppLoggedIn()) { ?>		
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
				<p><label>County/Region:</label> <?php echo $region; ?></p>

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
					<a href="/admin-sources.php?id=<?php echo $id; ?>">Edit</a> | 
					<a href="/admin-sources.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
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

				<?php if($region) { ?>
					<p><label>County/Region:</label> <?php echo $region; ?></p>
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
	<?php	}
		}
	} else {		####    end display _GET['id'] information    ####
		######      we have a search from url's $_GET; we are going to display the results from the search    ######
		include 'sql_array.php';

		echo "<h2>Search Results</h2>";
		####    here we begin our query--we leave off after sources to be able to add more tables to select from   ####
		$query = "SELECT sources.id,sources.editor,sources.title from sources";
	   
		$terms = array_filter($_GET);   ##  stripping out the un-valued elements
   		$tables = "";
   		$join_queries = "";
   		$reg_queries = "";
#		print_r($terms);
		####    we have to address these join tables queries first    ####
		if ( $terms['author'] || $terms['countries'] || $terms['language'] || $terms['subject'] || $terms['type'] ) {
			foreach ( $terms as $key => $val ){
				switch($key) {
					case 'author':
						$join['author'] = $terms['author'];
					    unset($terms['author']);
						break;
					case 'countries':
						$join['countries'] = $terms['countries'];
					    unset($terms['countries']);
						break;
					case 'language':
						$join['language'] = $terms['language'];
					    unset($terms['language']);
						break;
					case 'subject':
						$join['subject'] = $terms['subject'];
					    unset($terms['subject']);
						break;
					case 'type':
						$join['type'] = $terms['type'];
					    unset($terms['type']);
						break;
				}
				}
		}

		$i=0;
		foreach( $join as $key => $val){	  ##  looping over the $_GET array
	   		$j=0;	
	   		if ( count($val) > 1 )
	   			$join_queries .= "(";
   			if ( is_array($val) ) {
				foreach( $val as $key2 => $val2){	##  looping over the sub-arrays from $_GET (eg--from the join tables)
					$j++;	
		   			sql_query($key,$val2,$query);   #### STOP jpk ## TODO: deal with AND issues 
					if ( $j <> count($val)) $join_queries .= " OR ";
			   	}
		   		$i++;	
				if ( $i <> count($join)) $join_queries .= " aND ";
		   	} else {
		   		echo "something bad";
		   	}
	   		if ( count($val) > 1 )
	   			$join_queries .= ")";

		}
		$i=0;
		foreach( $terms as $key => $val){	  ##  looping over the $_GET array
#echo "terms: ".count($terms)." (".$key.")\n";
#echo "i:     ".$i."\n";
#echo "-- terms:\n";
#print_r($terms);
#echo "--\n";

	   		$i++;	
	   		$j=0;	
   			if ( is_array($val) ) {
   				echo "something else bad";

				foreach( $val as $key2 => $val2){	##  looping over the sub-arrays from $_GET (eg--from the join tables)

					$j++;	
		   			sql_query($key,$val2,$query);   #### STOP jpk ## TODO: deal with AND issues 
					if ( $j <> count($val)) $join_queries .= " OR ";
			   	}
#				if ( $i+1 <> count($terms)) $join_queries .= " aND ";
#		   		$i++;	
		   	} else {
#echo $key."=".$val."<br>";
				if ( $key != "page" && $key != "ipp" ) {
		   			sql_query($key,$val,$query);
					if ( $i <> count($terms)) $reg_queries .= " AnD ";
#		   			$tmpquery .= "sources.".$key." like '%".$val."%' ";
#  					echo $key; 
#  					echo $val;
#			   		$i++;	
				}
			}
		}
#		}
		if ( !(empty($join_queries) && empty($reg_queries)) )
			$query .= $tables." where ";
#		echo "count of join: ".count($join); 
#		if ( count($join) > 1 )
#			$query .= "(".$join_queries.")";
#		else
			$query .= $join_queries;

		if ( !empty ($join_queries) && !empty ($reg_queries))
			$query .= " AND ";
		if ( !empty ($reg_queries))
			$query .= $reg_queries;
#		$query .= " where ".$tmpquery;
#		if( $page && $ipp )
#			$query .= " LIMIT ".($page-1)*$ipp.",".$ipp;
		$query .= ";";
#	 	echo $_SERVER[PHP_SELF];
#	 	echo $_SERVER['QUERY_STRING'];
#		print_r($terms);
#		echo "--";




#	   print_r($_GET);
#	   print_r(array_keys($_GET));

	   $searchterm = mysqli_real_escape_string($db_server, $query);
#	   $searchterm = mysqli_real_escape_string($db_server, $_GET['title']);
	   ?>


		<p>You searched for:<br>
			<?php
#		foreach( $_GET as $key => $val){	
#				if( !empty($val) ){
#					if ( $key != "page" && $key != "ipp" )
#						echo $key."=".$val."<br>"; 
#				}
#		}
			echo $searched;
		# echo $_GET['title']; ?>
		</p>

		<?php $result = mysqli_query($db_server, $query);
		if ( !$result->num_rows ) {   # we have bad search results
		  print ("Could not find any sources that match your search terms.");
		  search_form($db_server);
		} else {	###    we have results back from the SQL--display them now    ###
		?>

		<h4>Search Results:</h4>
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
	      $title = $row['title']; ?>

	      <ul>
	         <li><?php echo $editor; ?>, <a href="/sources.php?id=<?php echo $id; ?>">
	            <?php echo $title; ?></a>
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
	       }	 ##   end of while loop going over results   ##
	    }	###    end of if for valid sql results & displaying them    ###
	}		#####     end of displaying search results    #####
}?>

<?php include 'footer.php';

############################################### function search_form ##########################################
function search_form($db_server) {
	include "languages.php";
	include "countries.php";
	include "types.php";
	include "subjects.php";
?>

	<form action="/sources.php" method="get">

		<?php if(isAppLoggedIn()) { ?>
			<!-- Form for logged in users -->
					<fieldset>
						<legend>Cataloger Information</legend>
							<li class="half"><label for="my_id">MyID</label>
								<input id="my_id" name="my_id" type="text" autofocus></li>
							<li class="half"><label for="cataloger">Cataloger Initials</label>
								<input id="cataloger" name="cataloger" type="text"></li>
					</fieldset>
					<fieldset>
						<legend>Publication Information</legend>
							<li class="whole"><label for="editor">Modern Editor/Translator</label>
								<input id="editor" name="editor" type="text"></li>
							<li class="whole"><label for="title">Title</label>
								<input id="title" name="title" type="text"></li>
							<li class="whole"><label for="publication">Publication Information</label>
								<input id="publication" name="publication" type="text"></li>	
							<li class="third"><label for="pub_date">Publication Date</label>
								<input id="pub_date" name="pub_date" type="text"></li>	
							<li class="third"><label for="isbn">ISBN</label>
								<input id="isbn" name="isbn" type="text"></li>	
							<li class="third"><label for="text_pages">Text Pages</label>
								<input id="text_pages" name="text_pages" type="text"></li>
							<li class="whole"><label for="link">Link</label>
								<input id="link" name="link" type="text"></li>
					</fieldset>
					<fieldset>
						<legend>Original Text Information</legend>
							<li class="whole"><label for="text_name">Text Name</label>
								<textarea id="text_name" name="text_name" rows="3"></textarea></li>
							<li class="half"><label for="date_begin">Earliest Date</label>
								<input id="date_begin" name="date_begin" type="text"></li>
							<li class="half"><label for="date_end">Latest Date</label>
								<input id="date_end" name="date_end" type="text"></li>
							<li class="checkbox"><input name="trans_none" value="1" type="checkbox">Original language included</li>
							<li class="checkbox"><input name="trans_english" value="1" type="checkbox">Translated into English</li>
							<li class="checkbox"><input name="trans_french" value="1" type="checkbox">Translated into French</li>
							<li class="checkbox"><input name="trans_other" value="1" type="checkbox">Translated into another language</li>
							<li class="half"><label for="trans_comment">Translation Comments</label>
								<textarea id="trans_comment" name="trans_comment" rows="3"></textarea></li>
							<li class="half"><label for="archive">Archival Reference</label>
								<textarea id="archive" name="archive" rows="3"></textarea></li>
							<li class="half"><label for="author">Medieval Author</label>
								<?php $authors = mysqli_query($db_server, "select name,id from authors order by name;"); ?>
								<select name="author[]" multiple="multiple">
										<?php while ($row = mysqli_fetch_array($authors)){ ?>
											<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
										<?php } ?>
								</select>
							</li>
							<li class="half"><label for "language">Original Language:</label>
								<select name="language[]" multiple="multiple">
									<?php
									foreach ( $language_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
					</fieldset>
					<fieldset>
						<legend>Region Information</legend>
							<li class="half"><label for="region">County/Town/Parish/Village</label>
								<input id="region" name="region" value="<?php echo $data['region'];?>" type="text"></li>
							<li class="half"><label for "countries">Geopolitical Region:</label>
								<select name="countries[]" multiple="multiple">
									<?php
									foreach ( $country_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
					</fieldset>
					<fieldset>
						<legend>Finding Aids</legend>
							<li class="half"><label for="type">Record Type</label>
								<select name="type[]" multiple="multiple">
									<?php
									foreach ( $type_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
							<li class="half"><label for="subject">Subject</label>
								<select name="subject[]" multiple="multiple">
									<?php
									foreach ( $subject_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
					</fieldset>
					<fieldset>
						<legend>Apparatus</legend>
							<li class="checkbox"><input name="app_index" value="1" type="checkbox">Index</li>
							<li class="checkbox"><input name="app_glossary" value="1" type="checkbox">Glossary</li>
							<li class="checkbox"><input name="app_appendix" value="1" type="checkbox">Appendix</li>
							<li class="checkbox"><input name="app_bibliography" value="1" type="checkbox">Bibliography</li>
							<li class="checkbox"><input name="app_facsimile" value="1" type="checkbox">Facsimile</li>
							<li class="checkbox"><input name="app_intro" value="1" type="checkbox">Introduction</li>
							<li class="whole"><label for="comments">Comments</label>
								<textarea id="comments" name="comments" rows="3"></textarea></li>
							<li class="whole"><label for="intro_summary">Introduction Summary</label>
								<textarea id="intro_summary" name="intro_summary" rows="3"></textarea></li>
							<li class="whole"><label for="addenda">Notes</label>
								<textarea id="addenda" name="addenda" rows="3"></textarea></li>
							<li class="checkbox"><input name="live" value="1" type="checkbox">Public Records</li>
					</fieldset>
		<?php } else { ?>
			<!-- Form for not logged in users -->
					<fieldset>
						<legend>Search for modern editions of medieval primary sources</legend>
							<li class="whole"><label for="text_title">Text Name</label> <!-- this field needs to search in both text_name and title fields -->
								<input id="text_title" name="text_title" placeholder="Medieval or modern title of the work"></li>
							<li class="half"><label for="author">Medieval Author</label>
								
								<p>You can find all records by an author using the <a href="/authors.php">Medieval author search</a>.</p></li>
							<li class="half"><label for="editor">Modern Editor/Translator</label>
								<input id="editor" name="editor" type="text"></li>
							<li class="checkbox"><input name="link" value="1" type="checkbox">Limit search to sources available online</li><!-- if this is checked, only return records where there is something in the link field -->
							<li class="half"><label for="date_begin">Earliest Date</label>
								<input id="date_begin" name="date_begin" type="text"></li>
							<li class="half"><label for="date_end">Latest Date</label>
								<input id="date_end" name="date_end" type="text"></li>
							<li class="checkbox"><input name="trans_none" value="1" type="checkbox">Original language included</li>
							<li class="checkbox"><input name="trans_english" value="1" type="checkbox">Translated into English</li>
							<li class="checkbox"><input name="trans_french" value="1" type="checkbox">Translated into French</li>
							<li class="checkbox"><input name="trans_other" value="1" type="checkbox">Translated into another language</li>
							<li class="half"><label for "language">Original Language:</label>
								<select name="language[]" multiple="multiple">
									<?php
									foreach ( $language_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
							<li class="half"><label for="region">County/Town/Parish/Village</label>
								<input id="region" name="region" value="<?php echo $data['region'];?>" type="text"></li>
							<li class="half"><label for "countries">Geopolitical Region:</label>
								<select name="countries[]" multiple="multiple">
									<?php
									foreach ( $country_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
							<li class="half"><label for="type">Record Type</label>
								<select name="type[]" multiple="multiple">
									<?php
									foreach ( $type_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
							<li class="half"><label for="subject">Subject</label>
								<select name="subject[]" multiple="multiple">
									<?php
									foreach ( $subject_array as $tmp )
										print ("                <option value=\"".$tmp."\">".$tmp."</option>\n");
									?>
								</select>
							</li>
		<?php } ?>
	<input type="submit" class="button" value="Search Sources" />
    </form>

<?php }  ### end function ###
?>
