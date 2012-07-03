<?php include('header.php');
	include ('connect.php'); 

$labels = array( 
		"name" => "Name",
		"alias" => "Alias",
		"title" => "Title",
		);

/* Check information from form */
foreach($_POST as $field => $value)
{
	/* check for blank fields */
	if(empty($value))
	{
		$blank_array[] = $field;
	}
}
if(@sizeof($blank_array) > 0) 
{
	echo "You didn't fill in one or more required fields.  You must enter:";
	foreach($blank_array as $value)
	{
		echo "{$labels[$value]}";
	}
}
else /* if data is okay */
{

	foreach($labels as $field => $value)
  	{
     	$good_data[ $field] = 
           	strip_tags( trim( $_POST[$field] ) ) ;    		
		$good_data[$field] = 
			mysqli_real_escape_string($db_server, $good_data[$field]);
		}
		$query = "INSERT INTO authors (name, alias, title) VALUES ('$_POST[name]','$_POST[alias]','$_POST[title]');";

		$result = mysqli_query($db_server,$query)
			or die ("Couldn't execute query:"
				.mysqli_error($db_server));
		if(mysqli_affected_rows($db_server) > 0)
		{
			echo "{$_POST['name']} has been added.";
		}
		else
			echo "No author added.";
	}

include ('footer.php');
?>

