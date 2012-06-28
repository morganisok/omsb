<?php include('header.php');
	include ('connect.php'); 

$labels = array( 
		"name" => "Name",
		"alias" => "Alias",
		"title" => "Ttile",
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
     		if( $field == "phone" )
		{
        		$good_data[ $field] =
            		preg_replace( " /[) ( . -] /" , "" , $good_data[ $field] ) ;
     		}
		$good_data[$field] = 
			mysqli_real_escape_string($cxn, $good_data[$field]);
		}
		$query = "INSERT INTO authors SET author='$good_data[author]'
			WHERE name='$_POST[name]'
			AND alias='$_POST[alias]'
			AND title='$_POST[title]'";
		$result = mysqli_query($cxn,$query)
			or die ("Couldn't execute query:"
				.mysqli_error($cxn));
		if(mysqli_affected_rows($cxn) > 0)
		{
			echo "{$_POST['name']} has been added.";
		}
		else
			echo "No author added.";
	}

include footer.php;
?>

