<?php
include('header.php');
include('connect.php'); 
require_once('auth.php');

if(isAppLoggedIn()) { 

	if (!$_POST && !$_GET) {      ####  new source form  ####
		display_form($db_server,0, "Add a New Source", "Create New Source");
	}

	if ( $_POST ) {      ####  we have only $_POST data -- update DB  ####
		if ( $_POST['id'] ) {          ####  we already have an ID so we are editing  ####
			$id=$_POST['id'];
	        $labels = array( 
				"id" => "id",
				"my_id" => "my_id",
				"editor" => "editor",
				"title" => "title",
				"publication" => "publication",
				"pub_date" => "pub_date",
				"isbn" => "isbn",
				"text_pages" => "text_pages",
				"trans_english" => "trans_english",
				"trans_french" => "trans_french",
				"trans_other" => "trans_other",
				"trans_none" => "trans_none",
				"date_begin" => "date_begin",
				"date_end" => "date_end",
				"region" => "region",
				"archive" => "archive",
				"link" => "link",
				"app_index" => "app_index",
				"app_glossary" => "app_glossary",
				"app_appendix" => "app_appendix",
				"app_bibliography" => "app_bibliography",
				"app_facsimile" => "app_facsimile",
				"app_intro" => "app_intro",
				"comments" => "comments",
				"intro_summary" => "intro_summary",
				"addenda" => "addenda",
				"live" => "live",
				"user_id" => "user_id",
			//	"created_at" => "created_at",
			//	"updated_at" => "updated_at",
				"trans_comment" => "trans_comment",
				"subjects" => "subjects",
				"text_name" => "text_name",
				"cataloger" => "cataloger",
			);

	        foreach($labels as $field => $value)
	        {
	        $good_data[ $field] = 
                strip_tags( trim( $_POST[$field] ) ) ;    
            $good_data[$field] = 
                mysqli_real_escape_string($db_server, $good_data[$field]);
            }
            $query = "UPDATE sources set
  		  		my_id				= '$good_data[my_id]',
				editor				= '$good_data[editor]',
				title				= '$good_data[title]',
				publication			= '$good_data[publication]',
				pub_date			= '$good_data[pub_date]',
				isbn				= '$good_data[isbn]',
				text_pages			= '$good_data[text_pages]',
				trans_english		= '$good_data[trans_english]',
				trans_french		= '$good_data[trans_french]',
				trans_other			= '$good_data[trans_other]',
				trans_none			= '$good_data[trans_none]',
				date_begin			= '$good_data[date_begin]',
				date_end			= '$good_data[date_end]',
				region				= '$good_data[region]',
				archive				= '$good_data[archive]',
				link				= '$good_data[link]',
				app_index			= '$good_data[app_index]',
				app_glossary		= '$good_data[app_glossary]',
				app_appendix		= '$good_data[app_appendix]',
				app_bibliography	= '$good_data[app_bibliography]',
				app_facsimile		= '$good_data[app_facsimile]',
				app_intro			= '$good_data[app_intro]',
				comments			= '$good_data[comments]',
				intro_summary		= '$good_data[intro_summary]',
				addenda				= '$good_data[addenda]',
				live				= '$good_data[live]',
				updated_at			= '".date("Y-m-d H:i:s")."',
				user_id				= '$good_data[user_id]',
				trans_comment		= '$good_data[trans_comment]',
				text_name			= '$good_data[text_name]',
				cataloger			= '$good_data[cataloger]'
				where id=$id;";
			## NEED TO ADD JOIN TABLES ##

     		$result = mysqli_query($db_server,$query)
                or die ("Couldn't execute query:"
                                .mysqli_error($db_server));
	#print_r($query);

	#echo "<pre>";
	#print_r($_POST);
	#echo "</pre>";

			join_table ("countries",   $_POST, $db_server, "update");
			join_table ("languages",   $_POST, $db_server, "update");
			join_table ("types",       $_POST, $db_server, "update");
			join_table ("subjects",    $_POST, $db_server, "update");
			join_table ("authorships", $_POST, $db_server, "update");

	                if(mysqli_affected_rows($db_server) > 0)
	                {
								display_form($db_server,$_POST, "{$_POST['title']} has been updated.", "Submit Changes");
	                }
	                else
								display_form($db_server,$_POST, "No changes made.", "Submit Changes");
				echo "<a href=\"/sources.php?id={$_POST['id']}\">View Source</a>.<br>";

			} else {                    ####  we don't have an ID because we are adding new source  ####
	#echo "We are updating a new source.";
			$labels = array( 
				"id" => "id",
				"my_id" => "my_id",
				"editor" => "editor",
				"title" => "title",
				"publication" => "publication",
				"pub_date" => "pub_date",
				"isbn" => "isbn",
				"text_pages" => "text_pages",
				"trans_english" => "trans_english",
				"trans_french" => "trans_french",
				"trans_other" => "trans_other",
				"trans_none" => "trans_none",
				"date_begin" => "date_begin",
				"date_end" => "date_end",
				"region" => "region",
				"archive" => "archive",
				"link" => "link",
				"app_index" => "app_index",
				"app_glossary" => "app_glossary",
				"app_appendix" => "app_appendix",
				"app_bibliography" => "app_bibliography",
				"app_facsimile" => "app_facsimile",
				"app_intro" => "app_intro",
				"comments" => "comments",
				"intro_summary" => "intro_summary",
				"addenda" => "addenda",
				"live" => "live",
				"user_id" => "user_id",
			//	"created_at" => "created_at",
			//	"updated_at" => "updated_at",
				"trans_comment" => "trans_comment",
				"text_name" => "text_name",
				"cataloger" => "cataloger",
				);

	        foreach($labels as $field => $value)
	        {
	        	$good_data[ $field] = 
     				strip_tags( trim( $_POST[$field] ) ) ;                  
        		$good_data[$field] = 
            		mysqli_real_escape_string($db_server, $good_data[$field]);
      		}

        	$query = "INSERT INTO sources (
				id,
				my_id,
				editor,
				title,
				publication,
				pub_date,
				isbn,
				text_pages,
				trans_english,
				trans_french,
				trans_other,
				trans_none,
				date_begin,
				date_end,
				region,
				archive,
				link,
				app_index,
				app_glossary,
				app_appendix,
				app_bibliography,
				app_facsimile,
				app_intro,
				comments,
				intro_summary,
				addenda,
				live,
				created_at,
				updated_at,
				user_id,
				trans_comment,
				text_name,
				cataloger
			)
			VALUES (
				'$good_data[id]',
				'$good_data[my_id]',
				'$good_data[editor]',
				'$good_data[title]', 
				'$good_data[publication]',
				'$good_data[pub_date]',
				'$good_data[isbn]',
				'$good_data[text_pages]',
				'$good_data[trans_english]',
				'$good_data[trans_french]',
				'$good_data[trans_other]',
				'$good_data[trans_none]',
				'$good_data[date_begin]',
				'$good_data[date_end]', 
				'$good_data[region]',
				'$good_data[archive]',
				'$good_data[link]',
				'$good_data[app_index]',
				'$good_data[app_glossary]',
				'$good_data[app_appendix]',
				'$good_data[app_bibliography]',
				'$good_data[app_facsimile]',
				'$good_data[app_intro]',
				'$good_data[comments]',
				'$good_data[intro_summary]',
				'$good_data[addenda]', 
				'$good_data[live]', 
				'".date("Y-m-d H:i:s")."',
				'".date("Y-m-d H:i:s")."',
				'$good_data[user_id]',
				'$good_data[trans_comment]',
				'$good_data[text_name]',
				'$good_data[cataloger]'
			);";


			$result = mysqli_query($db_server,$query)
				or die ("Couldn't execute query:"
					.mysqli_error($db_server));
			if(mysqli_affected_rows($db_server) > 0)
			{
				$_POST['id'] = mysqli_insert_id($db_server);
				$source_id = $_POST['id'];
	#			display_form($db_server,$_POST, "{$_POST['title']} has been added.", "Submit Changes");
				echo "<a href=\"/sources.php?id={$_POST['id']}\">View Source</a>.<br>";
				echo "<a href=\"/admin-sources.php?id={$_POST['id']}\">Edit Source</a>.";

	#echo "<pre>";
	#print_r($_POST);
	#echo "</pre>";

				join_table("countries", $_POST, $db_server, "insert");
				join_table("languages", $_POST, $db_server, "insert");
				join_table("types", $_POST, $db_server, "insert");
				join_table("subjects", $_POST, $db_server, "insert");
				join_table("authorships", $_POST, $db_server, "insert");

			}
			else
				display_form($db_server, $_POST, "No source added", "Submit Changes");
		}
	} elseif ( $_GET ) {         ####  we have $_GET data -- edit or delete source ####
		if ( $_GET['delete'] ) {    ## we are going to delete this source really quickly! ##
			echo "<h2>Delete Source</h2>";

			$id=mysqli_real_escape_string($db_server, $_GET['delete']);
			$result = mysqli_query($db_server, "select * from sources where id=$id;");

			if ( !$result->num_rows ) {
	  			print ("Could not find that source. <br>");
	  			print ("<a href=\"/sources.php\">Go to Search Page</a>.");
			} else {

				$source = mysqli_fetch_array($result);
				$title = $source['title'];
				?>

				<?php
				$result = mysqli_query($db_server, "delete from sources where id=$id;");
				if(mysqli_affected_rows($db_server) > 0) {
				?>
					<p><?php echo $title; ?> has been removed from the database.</p>
					<?php
				} else {
					print ("Sorry, we couldn't delete that source.");
				}  # end successful delete
			}  # end valid search result

		} elseif( $_GET['id'] && !$_POST ) {                    ####  we have _GET['id'] & no _POST -- display edit source form with ID's info  #####0
			#echo "We are editing an old source.";
			$id=mysqli_real_escape_string($db_server, $_GET['id']);
			$result = mysqli_query($db_server, "select * from sources where id=$id;");

			if ( !$result->num_rows ) {
	  			print ("Could not find that source. <br>"); 
	  			print ("<a href=\"/sources.php\">Go to Search Page</a>.");
			} else {
				$source = mysqli_fetch_array($result);
				$id = $source['id'];
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
				## ADD JOIN TABLES

	#echo "<pre>";
	#print_r($source);
	#echo "</pre>";

				join_table("countries",   $source, $db_server, "update");
				join_table("languages",   $source, $db_server, "update");
				join_table("types",       $source, $db_server, "update");
				join_table("subjects",    $source, $db_server, "update");
				join_table("authorships", $source, $db_server, "update");


				display_form($db_server, $source, "Edit Source", "Submit Changes");

			}  # end valid search result
		} else {  #### we don't have a valid GET request!  ####
		    echo "You sent a request the server could not understand; please try again.";
	        echo "<!--No, I don't understand that banter at all!-->";
		}	 # end if -- edit or delete
	}  # end _GET data
}   ####  end logged in  ####
else { ?>
	<p>Sorry, you must <a href="/login.php">log in</a> to view this page.</p>
<?php }


####  function to display the form  ####
function display_form($db_server, $data, $legend, $button){
	#<form id="sources"  action='/admin-sources.php<?php if ( $data['id'] ) echo "?id=$data[id]";?
#:>' method='POST'>
?>
	<form id="sources"  action='admin-sources.php<?php if ( $data['id'] ) echo "?id=$data[id]";?>' method='POST'>
		<h2><?php echo $legend; ?></h2>
		<fieldset>
			<legend>Cataloger Information</legend>
  				<input id="id" name="id" type="hidden" value=<?php echo $data['id'];?>></li>
				<li class="half"><label for="my_id">MyID</label>
					<input id="my_id" name="my_id" value="<?php echo $data['my_id'];?>" type="text" placeholder="00.00" autofocus></li>
				<li class="half"><label for="cataloger">Cataloger Initials</label>
					<input id="cataloger" name="cataloger" value="<?php echo $data['cataloger'];?>" type="text"></li>
		</fieldset>
		<fieldset>
			<legend>Publication Information</legend>
				<li class="whole"><label for="editor">Modern Editor/Translator</label>
					<input id="editor" name="editor" value="<?php echo $data['editor'];?>" type="text" placeholder="Surname [comma, space] forename of authors or editors"  maxlength="255"></li>
				<li class="whole"><label for="title">Title</label>
					<input id="title" name="title" value="<?php echo $data['title'];?>" type="text" placeholder="Article or chapter title (in quotation marks), or book title" maxlength="255"></li>
				<li class="whole"><label for="publication">Publication Information</label>
					<input id="publication" name="publication" value="<?php echo $data['publication'];?>" type="text" placeholder="series or journal name, publication city and publisher, etc." maxlength="255"></li>	
				<li class="third"><label for="pub_date">Publication Date</label>
					<input id="pub_date" name="pub_date" value="<?php echo $data['pub_date'];?>" type="text" maxlength="20"></li>	
				<li class="third"><label for="isbn">ISBN</label>
					<input id="isbn" name="isbn" value="<?php echo $data['isbn'];?>" type="text" placeholder="include only numbers and letters, no dashes or spaces" maxlength="13"></li>	
				<li class="third"><label for="text_pages">Text Pages</label>
					<input id="text_pages" name="text_pages" value="<?php echo $data['text_pages'];?>" type="text" maxlength="5"></li>
				<li class="whole"><label for="link">Link</label>
					<input id="link" name="link" value="<?php echo $data['link'];?>" type="text" placeholder="URL of complete text, include http://" maxlength="255"></li>
		</fieldset>
		<fieldset>
			<legend>Original Text Information</legend>
				<li class="whole"><label for="text_name">Text Name</label>
					<textarea id="text_name" name="text_name" rows="5" placeholder="Name of the text and any variants in name or spelling"><?php echo $data['text_name'];?></textarea></li>
				<li class="half"><label for="date_begin">Earliest Date</label>
					<input id="date_begin" name="date_begin" value="<?php echo $data['date_begin'];?>" type="text" maxlength="4"></li>
				<li class="half"><label for="date_end">Latest Date</label>
					<input id="date_end" name="date_end" value="<?php echo $data['date_end'];?>" type="text" maxlength="4"></li>
				<li class="checkbox"><input name="trans_none" value="1" type="checkbox" <?php if ( $data['trans_none'] ) echo "checked";?>>Original language included</li>
				<li class="checkbox"><input name="trans_english" value="1" type="checkbox" <?php if ( $data['trans_english'] ) echo "checked";?>>Translated into English</li>
				<li class="checkbox"><input name="trans_french" value="1" type="checkbox"<?php if ( $data['trans_french'] ) echo "checked";?>>Translated into French</li>
				<li class="checkbox"><input name="trans_other" value="1" type="checkbox"<?php if ( $data['trans_other'] ) echo "checked";?>>Translated into another language</li>
				<li class="half"><label for="trans_comment">Translation Comments</label>
					<textarea id="trans_comment" name="trans_comment" rows="4" placeholder="Other information about the translation, such as whether it appears on facing page of original text, whether translations are only offered for some of the text, or whether a translation of poetry is in verse or prose." maxlength="255"><?php echo $data['trans_comment'];?></textarea></li>
				<li class="half"><label for="archive">Archival Reference</label>
					<textarea id="archive" name="archive" rows="4" placeholder="Archive, record office or library where original documents are located; include shelf no/class/call no. if known." maxlength="255"><?php echo
$data['archive'];?></textarea></li>
				<li class="half"><label for="author">Medieval Author</label>
					<select name="authorships[]" multiple="multiple">
						<?php

						$authors_query = mysqli_query($db_server, "select name,id from authors order by name;");
						$i = 0;
						while ($row = mysqli_fetch_array($authors_query)){
							$author_array[$i] = array( $row[1], $row[0] );
							$i++;
						}

						$author_selected_query = mysqli_query($db_server, "select author_id from authorships where source_id=$data[id];");
						$i = 0;
						while ($row = mysqli_fetch_array($author_selected_query)){
							$author_selected_lookup_query = mysqli_query($db_server, "select name from authors where id=$row[0];");
							$val = mysqli_fetch_array($author_selected_lookup_query);
							$author_selected[$i] = array( $row[0], $val[0] );
							$i++;
						}

						if(!$author_selected) {
							$author_new = $author_array;
						} else { 
							$author_new = array_merge($author_selected, $author_array);
							$author_new = array_map("unserialize", array_unique(array_map("serialize", $author_new)));
						}


#echo "<pre>";
#echo "---|";
##print_r("$data[id];");
#print_r($author_new);
#echo "|---";
##print_r($data[id]);


						$i = 0;
						while ( $i < count($author_new) ){
							if ( $i < count($author_selected) )
								print ("                <option selected=\"selected\" value=\"".$author_new[$i][0]."\">".$author_new[$i][1]."</option>\n");
							else
								print ("                <option value=\"".$author_new[$i][0]."\">".$author_new[$i][1]."</option>\n");
							$i++;
						}

						?>


					</select>
				</li>
<?php
#$d = get_table_array("languages", $data['id'], $db_server);
#echo "<pre>";
#echo "---|";
#print_r($d);
#echo "|---";
##print_r($data[id]);
#echo "</pre>";




include "languages.php";
include "countries.php";
include "types.php";
include "subjects.php";
?>
				<li class="half"><label for "languages">Original Language:</label>
					<select name="languages[]" multiple="multiple">
                  <?php $i=0;   ####    getting the data from the DB table
                  $result = mysqli_query($db_server, "select name from languages where source_id=$data[id];");
                  while ($row = mysqli_fetch_array($result)){
                     $language_selected[$i] = $row[0];
                     $i++;
                  }
                  if ( !$language_selected )
                     $language_new = $language_array;
                  else
                     $language_new = array_unique( array_merge($language_selected, $language_array) );
 
                  $i = 0;  ####    outputting from the total array ####
                  while ( $i < count($language_new) ){
                     if ( $i < count($language_selected) )
                        print ("                <option selected=\"selected\" value=\"".$language_new[$i]."\">".$language_new[$i]."</option>\n");
                     else
                        print ("                <option value=\"".$language_new[$i]."\">".$language_new[$i]."</option>\n");
                     $i++;
                  } ?>
					</select>
				</li>
		</fieldset>
		<fieldset>
			<legend>Region Information</legend>
				<li class="half"><label for="region">County/Town/Parish/Village</label>
					<input id="region" name="region" value="<?php echo $data['region'];?>" type="text" maxlength="255"></li>
				<li class="half"><label for "countries">Geopolitical Region:</label>
					<select name="countries[]" multiple="multiple">
						<?php $i=0;   ####    getting the data from the DB table
						$result = mysqli_query($db_server, "select name from countries where source_id=$data[id];");
                  while ($row = mysqli_fetch_array($result)){
							$country_selected[$i] = $row[0];
							$i++;
						}
						if ( !$country_selected )
							$country_new = $country_array;
						else
							$country_new = array_unique( array_merge($country_selected, $country_array) );

						$i = 0;  ####    outputting from the total array ####
						while ( $i < count($country_new) ){
							if ( $i < count($country_selected) )
								print ("						<option selected=\"selected\" value=\"".$country_new[$i]."\">".$country_new[$i]."</option>\n");
							else
								print ("						<option value=\"".$country_new[$i]."\">".$country_new[$i]."</option>\n");
							$i++;
						} ?>
					</select>
				</li>
		</fieldset>
		<fieldset>
			<legend>Finding Aids</legend>
				<li class="half"><label for="type">Record Type</label>
					<select name="types[]" multiple="multiple">
                  <?php $i=0;   ####    getting the data from the DB table
                  $result = mysqli_query($db_server, "select name from types where source_id=$data[id];");
                  while ($row = mysqli_fetch_array($result)){
                     $type_selected[$i] = $row[0];
                     $i++;
                  }
                  if ( !$type_selected )
                     $type_new = $type_array;
                  else
                     $type_new = array_unique( array_merge($type_selected, $type_array) );
  
                  $i = 0;  ####    outputting from the total array ####
                  while ( $i < count($type_new) ){
                     if ( $i < count($type_selected) )
                        print ("                <option selected=\"selected\" value=\"".$type_new[$i]."\">".$type_new[$i]."</option>\n");
                     else
                        print ("                <option value=\"".$type_new[$i]."\">".$type_new[$i]."</option>\n");
                     $i++;
                  } ?>
					</select>
				</li>
				<li class="half"><label for="subject">Subject</label>
					<select name="subjects[]" multiple="multiple">
                  <?php $i=0;   ####    getting the data from the DB table
                  $result = mysqli_query($db_server, "select name from subjects where source_id=$data[id];");
                  while ($row = mysqli_fetch_array($result)){
                     $subject_selected[$i] = $row[0];
                     $i++;
                  }
                  if ( !$subject_selected )
                     $subject_new = $subject_array;
                  else
                     $subject_new = array_unique( array_merge($subject_selected, $subject_array) );
 
                  $i = 0;  ####    outputting from the total array ####
                  while ( $i < count($subject_new) ){
                     if ( $i < count($subject_selected) )
                        print ("                <option selected=\"selected\" value=\"".$subject_new[$i]."\">".$subject_new[$i]."</option>\n");
                     else
                        print ("                <option value=\"".$subject_new[$i]."\">".$subject_new[$i]."</option>\n");
                     $i++;
                  } ?>
					</select>
				</li>
		</fieldset>
		<fieldset>
			<legend>Apparatus</legend>
				<li class="checkbox"><input name="app_index" value="1" type="checkbox" <?php if ( $data['app_index'] ) echo "checked";?>>Index</li>
				<li class="checkbox"><input name="app_glossary" value="1" type="checkbox" <?php if ( $data['app_glossary'] ) echo "checked";?>>Glossary</li>
				<li class="checkbox"><input name="app_appendix" value="1" type="checkbox" <?php if ( $data['app_appendix'] ) echo "checked";?>>Appendix</li>
				<li class="checkbox"><input name="app_bibliography" value="1" type="checkbox" <?php if ( $data['app_bibliography'] ) echo "checked";?>>Bibliography</li>
				<li class="checkbox"><input name="app_facsimile" value="1" type="checkbox" <?php if ( $data['app_facsimile'] ) echo "checked";?>>Facsimile</li>
				<li class="checkbox"><input name="app_intro" value="1" type="checkbox" <?php if ( $data['app_intro'] ) echo "checked";?>>Introduction</li>
				<p><a href="#" onclick="toggle_visibility('format');">Text formatting instructions for Comments and Introduction Summary >></a></p>
                                        <script type="text/javascript">
                                        <!--
                                            function toggle_visibility(id) {
                                               var e = document.getElementById(id);
                                               if(e.style.display == 'block')
                                                  e.style.display = 'none';
                                               else
                                                  e.style.display = 'block';
                                            }
                                        //-->
                                        </script>
                                <div id="format">
                                    <h4>Basic Formatting:</h4>
                                    <table>
                                      <tr>
                                        <th>You type:</td>
                                        <th>Looks like:</td>
                                      </tr><tr>
                                        <td>_italics_</td>
                                        <td><i>italics</i></td>
                                      </tr><tr>
                                        <td>*bold*</td>
                                        <td><b>bold</b></td>
                                      </tr><tr>
                                        <td>"Google":http://google.com</td>
                                        <td><a href="http://google.com">Google</a></td>
                                      </tr><tr>
                                        <td>* an item <br /> * another item <br />  * and another </td>
                                        <td><ul><li>an item</li><li>another item</li><li>and another</li></ul></td>
                                      </tr><tr>
                                        <td># item one <br /> # item two <br /> # item three </td>
                                        <td><ol><li>item one</li><li>item two</li><li>item three</li></ol></td>
                                      </tr>
                                    </table>
                                </div>
				<li class="whole"><label for="comments">Comments</label>
					<textarea id="comments" name="comments" rows="10"><?php echo $data['comments'];?></textarea></li>
				<li class="whole"><label for="intro_summary">Introduction Summary</label>
					<textarea id="intro_summary" name="intro_summary" rows="10"><?php echo $data['intro_summary'];?></textarea></li>
				<li class="whole"><label for="addenda">Notes</label>
					<textarea id="addenda" name="addenda" rows="5" placeholder="These are private notes and will not be seen by the public."><?php echo $data['addenda'];?></textarea></li>
				<li class="checkbox"><input name="live" value="1" type="checkbox" <?php if ( $data['live'] ) echo "checked";?>>Make record public</li>

		<input type="submit" class="button" value="<?php echo $button;?>" />
	</form>
<?php
}



function get_table_array($table, $id, $db_server){
	if ( $table == 'authorships' ) $name = "author_id";
	else $name = "name";
	$result = mysqli_query($db_server,"select $name from $table where source_id = $id;");
	while ($row = mysqli_fetch_array($result)){
		$temp[$i]=$row[0];
		$i++;
	}
	return $temp;
}

function join_table($table, $data, $db_server, $action){
#echo "<pre>";   print_r($table);          echo "</pre>";
#echo "<pre>";   print_r($data[$table]);   echo "</pre>";
	if ( $table == 'authorships' )
		$name = "author_id";
	else
		$name = "name";
$data2 = $data[$table];  # jpk, no idea why we need this, but the next() below fails if we don't have it!!
	if ($data[$table]){
		if ( $action == 'update' ){
# TODO -- pull data from mysql table, compare 2 arrays & return(); if needed
# arraydiff is broken if first elements are the same.
#			$result = mysqli_query($db_server,"select $name from $table where source_id = $data[id];");
#			$i=0;
#			while ($row = mysqli_fetch_array($result)){
#				$temp[$i]=$row[0];
#				$i++;
#			}
#			$diff = array_diff($temp, $data[$table]);
#echo "count: ";
#			print_r(count($diff));
#echo "<br>";
#			if ( count($diff) ) {
#				echo "arrays are different.";
#			} else {
#				echo "arrays are the same.";
#				return;
#			}

			$query = "delete from $table where source_id = $data[id];";
			$result = mysqli_query($db_server,$query)
				or die ("Couldn't execute delete:"
				.mysqli_error($db_server));
#echo "<pre>del q: "; print_r($query); echo " #</pre>";
		}
		$query = "insert into $table (source_id, $name, created_at, updated_at) VALUES ";
		foreach ($data[$table] as $f){
			$query .= "(".$data[id].",\"$f\",\"".date("Y-m-d H:i:s")."\",\"".date("Y-m-d H:i:s")."\")";
#         $query .= "(".$data[id].",\"$f\")";

			if (next($data[$table])==true) $query .= ",";
		}
		$query .= ";";
#echo "<pre>ins q: "; print_r($query); echo " #</pre>";
		$result = mysqli_query($db_server,$query)
			or die ("Couldn't execute insert:"
			.mysqli_error($db_server));
	}
}


