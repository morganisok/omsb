<?php include('header.php');
	include ('connect.php'); 

$labels = array( 
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


//sanitize form data and insert it into database
	foreach($labels as $field => $value)
  	{
     	$good_data[ $field] = 
           	strip_tags( trim( $_POST[$field] ) ) ;    		
		$good_data[$field] = 
			mysqli_real_escape_string($db_server, $good_data[$field]);
		}
		$query = "INSERT INTO sources (
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
			echo "{$_POST['title']} has been added."; 
			$source_id=mysqli_insert_id($db_server);
		}
		else
			echo "No source added.";

// Insert Geopolitical Regions into database
		$region=$_POST['region'];
		if ($region){
			$query2 = "insert into countries (source_id, name) VALUES";
		 foreach ($region as $r){
		 	$query2 .= "($source_id,\"$r\")";
		 	if (next($region)==true) $query2 .= ",";
		 }
		 	 	$query2 .= ";";
		 }
			$result = mysqli_query($db_server,$query2)
				or die ("Couldn't execute query:"
					.mysqli_error($db_server));

// Insert Languagess into database
		$language=$_POST['language'];
		if ($language){
			$query3 = "insert into languages (source_id, name) VALUES";
		 foreach ($language as $l){
		 	$query3 .= "($source_id,\"$l\")";
		 	if (next($language)==true) $query3 .= ",";
		 }
		 	 	$query3 .= ";";
		 }
			$result = mysqli_query($db_server,$query3)
				or die ("Couldn't execute query:"
					.mysqli_error($db_server));

// Insert Record Types into database
		$type=$_POST['type'];
		if ($type){
			$query4 = "insert into types (source_id, name) VALUES";
		 foreach ($type as $t){
		 	$query4 .= "($source_id,\"$t\")";
		 	if (next($type)==true) $query4 .= ",";
		 }
		 	 	$query4 .= ";";
		 }
			$result = mysqli_query($db_server,$query4)
				or die ("Couldn't execute query:"
					.mysqli_error($db_server));


// Insert Subjects into database
		$subject=$_POST['subject'];
		if ($subject){
			$query5 = "insert into subjects (source_id, name) VALUES";
		 foreach ($subject as $s){
		 	$query5 .= "($source_id,\"$s\")";
		 	if (next($subject)==true) $query5 .= ",";
		 }
		 	 	$query5 .= ";";
		 }
			$result = mysqli_query($db_server,$query5)
				or die ("Couldn't execute query:"
					.mysqli_error($db_server));									

include ('footer.php');
?>

