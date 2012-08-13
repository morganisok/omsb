<?php include('header.php');
	include ('connect.php'); 

$labels = array( 
		"name" => "Name",
		"alias" => "Alias",
		"title" => "Title",
		"date_type" => "datemod",
		"date_begin" => "from",
		"date_end" => "to",
		"bio" => "bio",
		);


	foreach($labels as $field => $value)
  	{
     	$good_data[ $field] = 
           	strip_tags( trim( $_POST[$field] ) ) ;    		
		$good_data[$field] = 
			mysqli_real_escape_string($db_server, $good_data[$field]);
		}
		$query = "INSERT INTO authors (
				name, 
				alias, 
				title, 
				date_type,
				date_begin,
				date_end
			)
			VALUES (
				'$_POST[name]',
				'$_POST[alias]',
				'$_POST[title]', 
				'$_POST[datemod]',
				'$_POST[from]',
				'$_POST[to]'
			);";

		$result = mysqli_query($db_server,$query)
			or die ("Couldn't execute query:"
				.mysqli_error($db_server));
		if(mysqli_affected_rows($db_server) > 0)
		{
			echo "{$_POST['name']} has been added.";
		}
		else
			echo "No author added.";


include ('footer.php');
?>

