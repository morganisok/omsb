<?php include('header.php');
	include ('connect.php'); 

$labels = array( 
		"my_id" => "my_id",
		"editor" => "editor",
		"title" => "title",
		"publication" => "publication",
		"pub_date" => "pub_date",
		"isbn" => "ISBN",
		"text_pages" => "text_pages",
	//	"trans_english" => "trans_english",
	//	"trans_french" => "trans_french",
	//	"trans_other" => "trans_other",
	//	"trans_none" => "trans_none",
		"date_begin" => "date_begin",
		"date_end" => "date_end",
		"region" => "region",
		"archive" => "archive",
		"link" => "link",
	//	"app_index" => "app_index",
	//	"app_glossary" => "app_glossary",
	//	"app_appendix" => "app_appendix",
	//	"app_bibliography" => "app_bibliography",
	//	"app_facsimile" => "app_facsimile",
	//	"app_intro" => "app_intro",
		"comments" => "comments",
		"intro_summary" => "intro_summary",
		"addenda" => "addenda",
	//	"live" => "live",
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
			my_id,
			editor,
			title,
			publication,
			pub_date,
			ISBN,
			text_pages,
			date_begin,
			date_end,
			region,
			archive,
			link,
			comments,
			intro_summary,
			addenda,
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
				'$_POST[ISBN]',
				'$_POST[text_pages]',
				'$_POST[date_begin]',
				'$_POST[date_end]', 
				'$_POST[region]',
				'$_POST[archive]',
				'$_POST[link]',
				'$_POST[comments]',
				'$_POST[intro_summary]',
				'$_POST[addenda]', 
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
		}
		else
			echo "No source added.";


include ('footer.php');
?>

