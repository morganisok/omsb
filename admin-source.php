<?php include('header.php');
        include ('connect.php'); 


if (!$_POST && !$_GET) {      ####  new source form  ####
	display_form($db_server,0, "Add a New Source", "Create New Source");
}

if ( $_POST && !$_GET ) {      ####  we have only $_POST data -- update DB  ####
echo "<pre>";
#print_r($_POST);
echo "</pre>";
	if ( $_POST['id'] ) {          ####  we already have an ID so we are editing  ####
echo "We are in edit.";
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
						publication		= '$good_data[publication]',
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

echo "<pre>";
print_r($_POST);
echo "</pre>";

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

		} else {                    ####  we don't have an ID because we are adding new source  ####
echo "We are updating a new source.";

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
							user_id,
							trans_comment,
							text_name,
							cataloger
							)
							VALUES (
								'$_POST[id]',
								'$_POST[my_id]',
								'$_POST[editor]',
								'$_POST[title]', 
								'$_POST[publication]',
								'$_POST[pub_date]',
								'$_POST[isbn]',
								'$_POST[text_pages]',
								'$_POST[trans_english]',
								'$_POST[trans_french]',
								'$_POST[trans_other]',
								'$_POST[trans_none]',
								'$_POST[date_begin]',
								'$_POST[date_end]', 
								'$_POST[region]',
								'$_POST[archive]',
								'$_POST[link]',
								'$_POST[app_index]',
								'$_POST[app_glossary]',
								'$_POST[app_appendix]',
								'$_POST[app_bibliography]',
								'$_POST[app_facsimile]',
								'$_POST[app_intro]',
								'$_POST[comments]',
								'$_POST[intro_summary]',
								'$_POST[addenda]', 
								'$_POST[live]', 
								'$_POST[user_id]',
								'$_POST[trans_comment]',
								'$_POST[text_name]',
								'$_POST[cataloger]'
							);";
	

		$result = mysqli_query($db_server,$query)
			or die ("Couldn't execute query:"
				.mysqli_error($db_server));
		if(mysqli_affected_rows($db_server) > 0)
		{
			$_POST['id'] = mysqli_insert_id($db_server);
			$source_id = $_POST['id'];
			display_form($db_server,$_POST, "{$_POST['title']} has been added.", "Submit Changes");
			echo "<a href=\"sources.php?id={$_POST['id']}\">View Source</a>.";

echo "<pre>";
print_r($_POST);
echo "</pre>";


join_table("countries", $_POST, $db_server, "insert");
join_table("languages", $_POST, $db_server, "insert");
join_table("types", $_POST, $db_server, "insert");
join_table("subjects", $_POST, $db_server, "insert");
join_table("authorships", $_POST, $db_server, "insert");

#				// Insert Geopolitical Regions into database
#						$countries=$_POST['countries'];
#						if ($countries){
#							$query2 = "insert into countries (source_id, name) VALUES ";
#						 foreach ($countries as $c){
#						 	$query2 .= "($source_id,\"$c\")";
#						 	if (next($countries)==true) $query2 .= ",";
#						 }
#						 	 	$query2 .= ";";
#							$result = mysqli_query($db_server,$query2)
#								or die ("Couldn't execute query:"
#									.mysqli_error($db_server));
#						 }


#				// Insert Languagess into database
#						$language=$_POST['language'];
#						if ($language){
#							$query3 = "insert into languages (source_id, name) VALUES ";
#						 foreach ($language as $l){
#						 	$query3 .= "($source_id,\"$l\")";
#						 	if (next($language)==true) $query3 .= ",";
#						 }
#						 	 	$query3 .= ";";
#							$result = mysqli_query($db_server,$query3)
#								or die ("Couldn't execute query:"
#									.mysqli_error($db_server));
#						 }

#				// Insert Record Types into database
#						$type=$_POST['type'];
#						if ($type){
#							$query4 = "insert into types (source_id, name) VALUES ";
#						 foreach ($type as $t){
#						 	$query4 .= "($source_id,\"$t\")";
#						 	if (next($type)==true) $query4 .= ",";
#						 }
#						 	 	$query4 .= ";";
#							$result = mysqli_query($db_server,$query4)
#								or die ("Couldn't execute query:"
#									.mysqli_error($db_server));
#						 }


#				// Insert Subjects into database
#						$subject=$_POST['subject'];
#						if ($subject){
#							$query5 = "insert into subjects (source_id, name) VALUES ";
#						 foreach ($subject as $s){
#						 	$query5 .= "($source_id,\"$s\")";
#						 	if (next($subject)==true) $query5 .= ",";
#						 }
#						 	 	$query5 .= ";";
#							$result = mysqli_query($db_server,$query5)
#								or die ("Couldn't execute query:"
#									.mysqli_error($db_server));		
#						 }

#				// Insert Authors into database
#						$author=$_POST['author'];
#						if ($author){
#							$query6 = "insert into authorships (source_id, author_id) VALUES ";
#						 foreach ($author as $a){
#						 	$query6 .= "($source_id,\"$a\")";
#						 	if (next($author)==true) $query6 .= ",";
#						 }
#						 	 	$query6 .= ";";
#							$result = mysqli_query($db_server,$query6)
#								or die ("Couldn't execute query:"
#									.mysqli_error($db_server));								
#						 }
		}
		else
			display_form($db_server, $_POST, "No source added", "Submit Changes");
	}
} 


if ( $_GET ) {         ####  we have $_GET data -- edit or delete source ####
echo "We are having GET data.";
	if ( $_GET['delete'] ) {    ## we are going to delete this source really quickly! ##
		echo "<h2>Delete Source</h2>";

		$id=mysqli_real_escape_string($db_server, $_GET['delete']);
		$result = mysqli_query($db_server, "select * from sources where id=$id;");

		if ( !$result->num_rows ) {
  			print ("Could not find that source. <br>");
  			print ("<a href=\"sources.php\">Go to Search Page</a>.");
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

	} else {                    ####  we have _GET['id'] -- we are going to edit the source  #####0

echo "We are updating the DB.";

		$id=mysqli_real_escape_string($db_server, $_GET['id']);
		$result = mysqli_query($db_server, "select * from sources where id=$id;");

		if ( !$result->num_rows ) {
  			print ("Could not find that source. <br>"); 
  			print ("<a href=\"sources.php\">Go to Search Page</a>.");
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

echo "<pre>";
print_r($source);
echo "</pre>";

join_table("countries",   $source, $db_server, "update");
join_table("languages",   $source, $db_server, "update");
join_table("types",       $source, $db_server, "update");
join_table("subjects",    $source, $db_server, "update");
join_table("authorships", $source, $db_server, "update");


				display_form($db_server, $source, "Edit Source", "Submit Changes");
				}  # end valid search result
		} # end if -- edit or delete
	}  # end _GET data

####  function to display the form  ####
function display_form($db_server, $data, $legend, $button){
?>
	<form id="sources"  action='admin-source.php' method='POST'>
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
					<input id="editor" name="editor" value="<?php echo $data['editor'];?>" type="text" placeholder="Surname [comma, space] forename of authors or editors"></li>
				<li class="whole"><label for="title">Title</label>
					<input id="title" name="title" value="<?php echo $data['title'];?>" type="text" placeholder="Article or chapter title (in quotation marks), or book title"></li>
				<li class="whole"><label for="publication">Publication Information</label>
					<input id="publication" name="publication" value="<?php echo $data['publication'];?>" type="text" placeholder="series or journal name, publication city and publisher, etc."></li>	
				<li class="third"><label for="pub_date">Publication Date</label>
					<input id="pub_date" name="pub_date" value="<?php echo $data['pub_date'];?>" type="text"></li>	
				<li class="third"><label for="isbn">ISBN</label>
					<input id="isbn" name="isbn" value="<?php echo $data['isbn'];?>" type="text"></li>	
				<li class="third"><label for="text_pages">Text Pages</label>
					<input id="text_pages" name="text_pages" value="<?php echo $data['text_pages'];?>" type="text"></li>
				<li class="whole"><label for="link">Link</label>
					<input id="link" name="link" value="<?php echo $data['link'];?>" type="text" placeholder="URL of complete text"></li>
		</fieldset>
		<fieldset>
			<legend>Original Text Information</legend>
				<li class="whole"><label for="text_name">Text Name</label>
					<textarea id="text_name" name="text_name" value="<?php echo $data['text_name'];?>" rows="5" placeholder="Name of the text and any variants in name or spelling"></textarea></li>
				<li class="half"><label for="date_begin">Earliest Date</label>
					<input id="date_begin" name="date_begin" value="<?php echo $data['date_begin'];?>" type="text"></li>
				<li class="half"><label for="date_end">Latest Date</label>
					<input id="date_end" name="date_end" value="<?php echo $data['date_end'];?>" type="text"></li>
				<li class="checkbox"><input name="trans_none" value="1" type="checkbox" <?php if ( $data['trans_none'] ) echo "checked";?>>Original language included</li>
				<li class="checkbox"><input name="trans_english" value="1" type="checkbox" <?php if ( $data['trans_english'] ) echo "checked";?>>Translated into English</li>
				<li class="checkbox"><input name="trans_french" value="1" type="checkbox"<?php if ( $data['trans_french'] ) echo "checked";?>>Translated into French</li>
				<li class="checkbox"><input name="trans_other" value="1" type="checkbox"<?php if ( $data['trans_other'] ) echo "checked";?>>Translated into another language</li>
				<li class="half"><label for="trans_comment">Translation Comments</label>
					<textarea id="trans_comment" name="trans_comment" value="<?php echo $data['trans_comment'];?>" rows="4" placeholder="Other information about the translation, such as whether it appears on facing page of original text, whether translations are only offered for some of the text, or whether a translation of poetry is in verse or prose."></textarea></li>
				<li class="half"><label for="archive">Archival Reference</label>
					<textarea id="archive" name="archive" value="<?php echo $data['archive'];?>" rows="4" placeholder="Archive, record office or library where original documents are located; include shelf no/class/call no. if known."></textarea></li>
				<li class="half"><label for="author">Medieval Author</label>
					<?php $authors = mysqli_query($db_server, "select name,id from authors order by name;"); ?>
					<select name="authorships[]" multiple="multiple">
							<?php while ($row = mysqli_fetch_array($authors)){ ?>
								<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
							<?php } ?>
					</select>
				</li>
				<li class="half"><label for "language">Original Language:</label>
					<select name="languages[]" multiple="multiple">
						<option value="Anglo-Norman">Anglo-Norman</option>
						<option value="Arabic">Arabic</option>
						<option value="Azestan">Azestan</option>
						<option value="Chinese">Chinese</option>
						<option value="Cornish">Cornish</option>
						<option value="Czech">Czech</option>
						<option value="Dutch">Dutch</option>
						<option value="English - Anglo-Saxon / Old English">English - Anglo-Saxon / Old English</option>
						<option value="English - Middle English">English - Middle English</option>
						<option value="English - Scots">English - Scots</option>
						<option value="Ethiopian">Ethiopian</option>
						<option value="French - Breton">French - Breton</option>
						<option value="French - Gascon">French - Gascon</option>
						<option value="French - Old French">French - Old French</option>
						<option value="French - Other">French - Other</option>
						<option value="French - Provencal">French - Provencal</option>
						<option value="German">German</option>
						<option value="German - Middle High German">German - Middle High German</option>
						<option value="Greek">Greek</option>
						<option value="Hebrew">Hebrew</option>
						<option value="Italian">Italian</option>
						<option value="Latin">Latin</option>
						<option value="Manx">Manx</option>
						<option value="Old Norse">Old Norse</option>
						<option value="Old/Middle Irish">Old/Middle Irish</option>
						<option value="Other">Other</option>
						<option value="Pahlavi">Pahlavi</option>
						<option value="Pazand">Pazand</option>
						<option value="Persian">Persian</option>
						<option value="Portuguese">Portuguese</option>
						<option value="Russian">Russian</option>
						<option value="Scottish Gaelic">Scottish Gaelic</option>
						<option value="Spanish">Spanish</option>
						<option value="Spanish - Catalan">Spanish - Catalan</option>
						<option value="Spanish - Medieval">Spanish - Medieval</option>
						<option value="Turkish">Turkish</option>
						<option value="Welsh">Welsh</option>
					</select>
				</li>
		</fieldset>
		<fieldset>
			<legend>Region Information</legend>
				<li class="half"><label for="region">County/Town/Parish/Village</label>
					<input id="region" name="region" value="<?php echo $data['region'];?>" type="text"></li>
				<li class="half"><label for "countries">Geopolitical Region:</label>
					<select name="countries[]" multiple="multiple">
						 <option value="Africa">Africa</option>
						 <option value="Algeria">Algeria</option>
						 <option value="Armenia">Armenia</option>
						 <option value="Asia">Asia</option>
						 <option value="Austria">Austria</option>
						 <option value="Balkans">Balkans</option>
						 <option value="Belgium">Belgium</option>
						 <option value="Bohemia">Bohemia</option>
						 <option value="British Isles">British Isles</option>
						 <option value="Bulgaria">Bulgaria</option>
						 <option value="Byzantium">Byzantium</option>
						 <option value="China">China</option>
						 <option value="Crete">Crete</option>
						 <option value="Czech Republic">Czech Republic</option>
						 <option value="Denmark">Denmark</option>
						 <option value="Egypt">Egypt</option>
						 <option value="England">England</option>
						 <option value="Europe">Europe</option>
						 <option value="Finland">Finland</option>
						 <option value="Flanders">Flanders</option>
						 <option value="France">France</option>
						 <option value="Germany">Germany</option>
						 <option value="Greece">Greece</option>
						 <option value="Holy Roman Empire">Holy Roman Empire</option>
						 <option value="Hungary">Hungary</option>
						 <option value="Iberian Peninsula">Iberian Peninsula</option>
						 <option value="Iceland">Iceland</option>
						 <option value="India">India</option>
						 <option value="Ireland">Ireland</option>
						 <option value="Italy">Italy</option>
						 <option value="Middle East">Middle East</option>
						 <option value="Netherlands">Netherlands</option>
						 <option value="New World">New World</option>
						 <option value="Norway">Norway</option>
						 <option value="Persia">Persia</option>
						 <option value="Poland">Poland</option>
						 <option value="Portugal">Portugal</option>
						 <option value="Prussia">Prussia</option>
						 <option value="Russia">Russia</option>
						 <option value="Scandinavia">Scandinavia</option>
						 <option value="Scotland">Scotland</option>
						 <option value="Spain">Spain</option>
						 <option value="Sweden">Sweden</option>
						 <option value="Switzerland">Switzerland</option>
						 <option value="Tunisia">Tunisia</option>
						 <option value="Turkey">Turkey</option>
						 <option value="Ukraine">Ukraine</option>
						 <option value="Wales">Wales</option>
						 <option value="Yugoslavia">Yugoslavia</option>
					</select>
				</li>
		</fieldset>
		<fieldset>
			<legend>Finding Aids</legend>
				<li class="half"><label for="type">Record Type</label>
					<select name="types[]" multiple="multiple">
						<option value="Account Roll">Account Roll</option>
						<option value="Account Roll - Bailiff/Reeve">Account Roll - Bailiff/Reeve</option>
						<option value="Account Roll - Building">Account Roll - Building</option>
						<option value="Account Roll - Estate">Account Roll - Estate</option>
						<option value="Account Roll - Household">Account Roll - Household</option>
						<option value="Account Roll - Obedientiary">Account Roll - Obedientiary</option>
						<option value="Account Roll - Port Customs">Account Roll - Port Customs</option>
						<option value="Biography">Biography</option>
						<option value="Cartulary">Cartulary</option>
						<option value="Charters, Deeds">Charters, Deeds</option>
						<option value="Chronicle, Annals">Chronicle, Annals</option>
						<option value="Commentary / Gloss / Exegesis">Commentary / Gloss / Exegesis</option>
						<option value="Contract">Contract</option>
						<option value="Coroner's Roll">Coroner's Roll</option>
						<option value="Councils - Church">Councils - Church</option>
						<option value="Councils - Secular">Councils - Secular</option>
						<option value="Court Roll">Court Roll</option>
						<option value="Court Roll - Ecclesiastical">Court Roll - Ecclesiastical</option>
						<option value="Court Roll - Eyre">Court Roll - Eyre</option>
						<option value="Court Roll - Gaol Delivery">Court Roll - Gaol Delivery</option>
						<option value="Court Roll - Sessions of the Peace">Court Roll - Sessions of the Peace</option>
						<option value="Custumal">Custumal</option>
						<option value="Dialog">Dialog</option>
						<option value="Disputation - Philosophical/Theological">Disputation - Philosophical/Theological</option>
						<option value="Extents and Surveys">Extents and Surveys</option>
						<option value="Formulary">Formulary</option>
						<option value="Genealogy">Genealogy</option>
						<option value="Glossary / Dictionary">Glossary / Dictionary</option>
						<option value="Guild Records">Guild Records</option>
						<option value="Hagiography">Hagiography</option>
						<option value="Inquisition - Heresy">Inquisition - Heresy</option>
						<option value="Inscription">Inscription</option>
						<option value="Inventory">Inventory</option>
						<option value="Law - Canon Law">Law - Canon Law</option>
						<option value="Law - Legislation">Law - Legislation</option>
						<option value="Law - Local Ordinances">Law - Local Ordinances</option>
						<option value="Law - Treatise/Commentary">Law - Treatise/Commentary</option>
						<option value="Letter">Letter</option>
						<option value="Literature - Drama">Literature - Drama</option>
						<option value="Literature - Prose">Literature - Prose</option>
						<option value="Literature - Verse">Literature - Verse</option>
						<option value="Liturgy">Liturgy</option>
						<option value="Memoir">Memoir</option>
						<option value="Memoir - Family">Memoir - Family</option>
						<option value="Miscellany">Miscellany</option>
						<option value="Monastic Rule">Monastic Rule</option>
						<option value="Muster">Muster</option>
						<option value="Oration">Oration</option>
						<option value="Other">Other</option>
						<option value="Papal Bull">Papal Bull</option>
						<option value="Petition">Petition</option>
						<option value="Philosophic Work">Philosophic Work</option>
						<option value="Prophecy">Prophecy</option>
						<option value="Proverbs">Proverbs</option>
						<option value="Register - Bishop">Register - Bishop</option>
						<option value="Register - Notarial">Register - Notarial</option>
						<option value="Scripture">Scripture</option>
						<option value="Sermons">Sermons</option>
						<option value="Taxes">Taxes</option>
						<option value="Taxes - Clerical Subsidy">Taxes - Clerical Subsidy</option>
						<option value="Taxes - Lay Subsidy">Taxes - Lay Subsidy</option>
						<option value="Taxes - Poll Tax">Taxes - Poll Tax</option>
						<option value="Theology">Theology</option>
						<option value="Theology - Devotional">Theology - Devotional</option>
						<option value="Theology - Doctrine">Theology - Doctrine</option>
						<option value="Theology - Mystical Work">Theology - Mystical Work</option>
						<option value="Theology - Practical/Instructional">Theology - Practical/Instructional</option>
						<option value="Theology/Philosophy - Summa">Theology/Philosophy - Summa</option>
						<option value="Translation">Translation</option>
						<option value="Treatise - Instruction/Advice">Treatise - Instruction/Advice</option>
						<option value="Treatise - Other">Treatise - Other</option>
						<option value="Treatise - Political">Treatise - Political</option>
						<option value="Treatise - Scientific/Medical">Treatise - Scientific/Medical</option>
						<option value="Visitations">Visitations</option>
						<option value="Will">Will</option>
					</select>
				</li>
				<li class="half"><label for="subject">Subject</label>
					<select name="subjects[]" multiple="multiple">
						<option value="Agriculture">Agriculture</option>
						<option value="Apocalypticism">Apocalypticism</option>
						<option value="Architecture and Buildings">Architecture and Buildings</option>
						<option value="Art">Art</option>
						<option value="Asiatic Nomads: Huns, Mongols, etc.">Asiatic Nomads: Huns, Mongols, etc.</option>
						<option value="Byzantium">Byzantium</option>
						<option value="Carolingians">Carolingians</option>
						<option value="Church Fathers">Church Fathers</option>
						<option value="Classics / Humanism">Classics / Humanism</option>
						<option value="Clergy - Anticlericalism">Clergy - Anticlericalism</option>
						<option value="Clergy - Monks, Nuns, Friars">Clergy - Monks, Nuns, Friars</option>
						<option value="Clergy - Priests, Bishops, Canons">Clergy - Priests, Bishops, Canons</option>
						<option value="Conversion">Conversion</option>
						<option value="Crusades">Crusades</option>
						<option value="Diplomacy">Diplomacy</option>
						<option value="Early Germanic Peoples: Goths, Franks, etc.">Early Germanic Peoples: Goths, Franks, etc.</option>
						<option value="Economy - Crafts and Industry">Economy - Crafts and Industry</option>
						<option value="Economy - Guilds and Labor">Economy - Guilds and Labor</option>
						<option value="Economy - Trade">Economy - Trade</option>
						<option value="Education / Universities">Education / Universities</option>
						<option value="Family / Children">Family / Children</option>
						<option value="Government">Government</option>
						<option value="Grammar / Rhetoric">Grammar / Rhetoric</option>
						<option value="Heresy">Heresy</option>
						<option value="Historiography">Historiography</option>
						<option value="Jews / Judaism">Jews / Judaism</option>
						<option value="Law - Canon">Law - Canon</option>
						<option value="Law - Crime">Law - Crime</option>
						<option value="Law - Secular">Law - Secular</option>
						<option value="Literature - Arthurian">Literature - Arthurian</option>
						<option value="Literature - Comedy / Satire">Literature - Comedy / Satire</option>
						<option value="Literature - Devotional">Literature - Devotional</option>
						<option value="Literature - Drama">Literature - Drama</option>
						<option value="Literature - Epics, Romance">Literature - Epics, Romance</option>
						<option value="Literature - Folklore, Legends">Literature - Folklore, Legends</option>
						<option value="Literature - Other">Literature - Other</option>
						<option value="Magic / Witchcraft">Magic / Witchcraft</option>
						<option value="Maritime">Maritime</option>
						<option value="Material Culture: Food, Clothing, Household">Material Culture: Food, Clothing, Household</option>
						<option value="Medicine">Medicine</option>
						<option value="Military Orders">Military Orders</option>
						<option value="Monasticism">Monasticism</option>
						<option value="Music">Music</option>
						<option value="Muslims / Islam">Muslims / Islam</option>
						<option value="Nobility / Gentry">Nobility / Gentry</option>
						<option value="Papacy">Papacy</option>
						<option value="Peasants">Peasants</option>
						<option value="Philosophy / Theology">Philosophy / Theology</option>
						<option value="Philisophy - Aristotelian">Philisophy - Aristotelian</option>
						<option value="Philosophy - Ethics / Moral Theology">Philosophy - Ethics / Moral Theology</option>
						<option value="Philosophy - Logic">Philosophy - Logic</option>
						<option value="Philosophy - Metaphysics">Philosophy - Metaphysics</option>
						<option value="Philosophy - Platonic / Neo-Platonic">Philosophy - Platonic / Neo-Platonic</option>
						<option value="Philosophy - Political">Philosophy - Political</option>
						<option value="Piety">Piety</option>
						<option value="Piety - Confession, Penance">Piety - Confession, Penance</option>
						<option value="Piety - Lay">Piety - Lay</option>
						<option value="Piety - Mysticism">Piety - Mysticism</option>
						<option value="Plague and Disease">Plague and Disease</option>
						<option value="Political Thought">Political Thought</option>
						<option value="Poverty / Charity">Poverty / Charity</option>
						<option value="Recreation">Recreation</option>
						<option value="Reform">Reform</option>
						<option value="Religion - Institutional Church">Religion - Institutional Church</option>
						<option value="Revolt">Revolt</option>
						<option value="Royalty / Monarchs">Royalty / Monarchs</option>
						<option value="Saints">Saints</option>
						<option value="Saints - Cults / Relics">Saints - Cults / Relics</option>
						<option value="Science / Technology">Science / Technology</option>
						<option value="Science - Astronomy">Science - Astronomy</option>
						<option value="Science - Mathematics">Science - Mathematics</option>
						<option value="Theology - Christology">Theology - Christology</option>
						<option value="Theology - Ecclesiology">Theology - Ecclesiology</option>
						<option value="Theology - Eschatology">Theology - Eschatology</option>
						<option value="Theology - Heretical">Theology - Heretical</option>
						<option value="Theology - History">Theology - History</option>
						<option value="Theology - Mariology">Theology - Mariology</option>
						<option value="Theology - Moral / Ethics">Theology - Moral / Ethics</option>
						<option value="Theology - Sacramental">Theology - Sacramental</option>
						<option value="Theology - Scriptural / Exegesis">Theology - Scriptural / Exegesis</option>
						<option value="Theology - Trinitarian">Theology - Trinitarian</option>
						<option value="Towns / Cities">Towns / Cities</option>
						<option value="Travel / Pilgrimage">Travel / Pilgrimage</option>
						<option value="Vikings">Vikings</option>
						<option value="War - Chivalry">War - Chivalry</option>
						<option value="War - Military History">War - Military History</option>
						<option value="Women / Gender">Women / Gender</option>
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
				<li class="whole"><label for="comments">Comments</label>
					<textarea id="comments" name="comments" value="<?php echo $data['comments'];?>" rows="10"></textarea></li>
				<li class="whole"><label for="intro_summary">Introduction Summary</label>
					<textarea id="intro_summary" name="intro_summary" value="<?php echo $data['intro_summary'];?>" rows="10"></textarea></li>
				<li class="whole"><label for="addenda">Notes</label>
					<textarea id="addenda" name="addenda" value="<?php echo $data['addenda'];?>" rows="5" placeholder="These are private notes and will not be seen by the public."></textarea></li>
				<li class="checkbox"><input name="live" value="1" type="checkbox" <?php if ( $data['live'] ) echo "checked";?>>Make record public</li>

		<input type="submit" class="button" value="<?php echo $button;?>" />
	</form>
<?php
}

function join_table($table, $data, $db_server, $action){
echo "<pre>1";
print_r($table);
echo "1</pre>";
echo "<pre>2";
print_r($data[$table]);
echo "2</pre>";
	if ( $table == 'authorships' )
		$name = "author_id";
	else
		$name = "name";
print ("dammit");
print( next($data[$table]));
print( next($data[$table]));
$data2 = $data[$table];
print( next($data[$table]));
print ("dammit2:");
	if ($data[$table]){
		if ( $action == 'update' ){
			$query = "delete from $table where source_id = $data[id];";
			$result = mysqli_query($db_server,$query)
				or die ("Couldn't execute delete:"
				.mysqli_error($db_server));
echo "<pre>3";
print_r($query);
echo "3</pre>";
		}
		$query = "insert into $table (source_id, $name) VALUES ";
		foreach ($data[$table] as $f){
		$query .= "(".$data[id].",\"$f\")";
		if (next($data[$table])==true) $query .= ",";
		}
		$query .= ";";
#echo "<br>";
echo "<pre>4";
print_r($query);
echo "4</pre>";
#echo "<br>";
		$result = mysqli_query($db_server,$query)
			or die ("Couldn't execute insert:"
			.mysqli_error($db_server));
	}
}

include ('footer.php'); ?>
