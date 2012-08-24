<?php include('header.php');
        include ('connect.php'); 


if (!$_POST && !$_GET) {      ####  new author form  ####
	display_form(0, "Add a New Author", "Create New Author");
}

if ( $_POST && !$_GET ) {      ####  we have only $_POST data -- update DB  ####
	if ( $_POST['id'] ) {          ####  we have an ID & are editing  ####
		$id=$_POST['id'];
        $labels = array( 
                "id" => "id",
                "name" => "Name",
                "alias" => "Alias",
                "title" => "Title",
                "date_type" => "date_type",
                "date_begin" => "date_begin",
                "date_end" => "date_end",
                "bio" => "bio"
                );

        foreach($labels as $field => $value)
        {
        $good_data[ $field] = 
                strip_tags( trim( $_POST[$field] ) ) ;    
                $good_data[$field] = 
                        mysqli_real_escape_string($db_server, $good_data[$field]);
                }
                $query = "UPDATE authors set
                                name       = '$_POST[name]',
                                alias      = '$_POST[alias]',
                                title      = '$_POST[title]', 
                                date_type  = '$_POST[date_type]',
                                date_circa  = '$_POST[date_circa]',
                                date_begin = '$_POST[date_begin]',
                                date_end   = '$_POST[date_end]',
                                bio        = '$_POST[bio]'
                         where id=$id;";
                $result = mysqli_query($db_server,$query)
                        or die ("Couldn't execute query:"
                                .mysqli_error($db_server));
                if(mysqli_affected_rows($db_server) > 0)
                {
							display_form($_POST, "{$_POST['name']} has been updated.", "Submit Changes");
                }
                else
							display_form($_POST, "No changes made.", "Submit Changes");

	} else {  ####  we don't have an ID because we are adding new author  ####

		$labels = array( 
                "name" => "Name",
                "alias" => "Alias",
                "title" => "Title",
                "date_type" => "date_type",
                "date_circa" => "date_circa",
                "date_begin" => "date_begin",
                "date_end" => "date_end",
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
                                date_circa,
                                date_begin,
                                date_end,
                                bio
                        )
                        VALUES (
                                '$_POST[name]',
                                '$_POST[alias]',
                                '$_POST[title]', 
                                '$_POST[date_type]',
                                '$_POST[date_circa]',
                                '$_POST[date_begin]',
                                '$_POST[date_end]',
                                '$_POST[bio]'
                        );";

                $result = mysqli_query($db_server,$query)
                        or die ("Couldn't execute query:"
                                .mysqli_error($db_server));
                if(mysqli_affected_rows($db_server) > 0) {
                     $_POST['id'] = mysqli_insert_id($db_server);
							display_form($_POST, "{$_POST['name']} has been added.", "Submit Changes");

							echo "<a href=\"display-author.php?id={$_POST['id']}\">View Author Record</a>.";
                }
                else
#                        echo "No author added.";
							display_form($_POST, "No author added", "Submit Changes");
	}
} 


if ( $_GET ) {         ####  we have $_GET data -- edit author ####
	if ( $_GET['delete'] ) {    ## we are going to delete this author really quickly! ##
		echo "<h2>Delete Author</h2>";

		$id=$_GET['delete'];
		$sql = mysqli_query($db_server, "select * from authors where id=$id;");

		$author = mysqli_fetch_array($sql);
		$name = $author['name'];
		?>

		<p><?php echo $name; ?> has been removed from the database.</p>
		<?php
		$sql = mysqli_query($db_server, "delete from authors where id=$id;");
	} else {
		$id=$_GET['id'];
		$sql = mysqli_query($db_server, "select * from authors where id=$id;");

		if ( !$sql->num_rows ) {
  			die ("Could not find that author."); 
		}

		$author = mysqli_fetch_array($sql);
		$name = $author['name'];
		$alias = $author['alias'];
		$title = $author['title'];
		$date_type = $author['date_type'];
		$date_circa = $author['date_circa'];
		$date_begin = $author['date_begin'];
		$date_end = $author['date_end'];
		$bio = $author['bio'];

		display_form($author, "Edit Author Details", "Submit Changes");
	}
}

####  function to display the form  ####
function display_form($data, $legend, $button){
?>
	<form id="admin-author"  action='admin-author.php' method='POST'>
        <fieldset>
                <legend><?php echo $legend?></legend>
                <ul>
                                <input id="id" name="id" type="hidden" value=<?php echo $data['id'];?>></li>
                        <li><label for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Author's name as found in DMA or WorldCat" value="<?php echo $data['name'];?>" autofocus></li>
                        <li><label for="alias">Alias</label>
                                <input id="alias" name="alias" type="text" placeholder="Alternate names or spellings" value="<?php echo $data['alias'];?>"></li>
                        <li><label for="title">Title</label>
                                <input id="title" name="title" type="text" placeholder="Title, such as Saint, King, Bishop, etc." value="<?php echo $data['title'];?>" ></li>
                        <li><label for="date_type">Date modifier</label>
                                <input id="date_type" name="date_type" type="text" placeholder="circa, died, flourished, reigned" value="<?php echo $data['date_type'];?>"></li>
                        <li><label for="date_circa">Date circa</label>
                                <input id="date_circa" name="date_circa" type="checkbox" value="1" <?php if ( $data['date_circa'] ) echo "checked";?>></li>
                        <li><label for="date_begin">From</label>
                                <input id="date_begin" name="date_begin" type="text" placeholder="begin date" value="<?php echo $data['date_begin'];?>"></li>
                        <li><label for="date_end">To</label>
                                <input id="date_end" name="date_end" type="text" placeholder="end date"value="<?php echo $data['date_end'];?>"></li>
                        <li><label for="bio">Biographical information</label>
                                <textarea id="bio" name="bio" rows="5" placeholder="Biographical information"><?php echo $data['bio'];?></textarea></li>
                </ul>
        </fieldset>
        <input type='submit' value='<?php echo $button;?>' />
	</form>

<?php
}

include ('footer.php'); ?>

