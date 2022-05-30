<?php
include('header.php');
include('connect.php'); 
require_once('auth.php');

if(isAppLoggedIn()) { 

    if (!$_POST && !$_GET) {      ####  new author form  ####
        if($_SESSION['username'] == 'morgan' || $_SESSION['username'] == 'elc') {
    	   display_form(0, "Add a New Author", "Create New Author");
        } else {
            echo "Sorry, you do not have sufficient privileges to create new authors.";
        }
    }

    if ( !empty($_POST) ) {             ####  we already have an ID so we are editing  ####
echo "<pre>";
print_r($_POST);
echo "</pre>";        
        // must protect against 31336 hax0rz, zomg! (the 6 is on purpose--this won't stop sophisticated hacks)
        foreach ($_POST as $key => $post_field) {
            if(strlen($post_field) > 200 && ( $key != 'bio') )

                die("You submitted a post search term that was too long--please alert the web master and include the URL from your browser's location bar.");
        }
        if ( $_POST['id'] ) {             ####  we already have an ID so we are editing  ####
    		$id=$_POST['id'];
            $labels = array( 
                "id" => "id",
                "name" => "Name",
                "alias" => "Alias",
                "title" => "Title",
                "date_type" => "date_type",
                "date_circa" => "date_circa",
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
                name       = '$good_data[name]',
                alias      = '$good_data[alias]',
                title      = '$good_data[title]', 
                updated_at = '".date("Y-m-d H:i:s")."',
                date_type  = '$good_data[date_type]',
                date_circa = '$good_data[date_circa]',
                date_begin = '$good_data[date_begin]',
                date_end   = '$good_data[date_end]',
                bio        = '$good_data[bio]'
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

    	} else {             ####  we don't have an ID yet because we are inserting a new author & display that info  ####
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
                $good_data[$field] = mysqli_real_escape_string($db_server, $good_data[$field]);
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
                '$good_data[name]',
                '$good_data[alias]',
                '$good_data[title]', 
                '$good_data[date_type]',
                '$good_data[date_circa]',
                '$good_data[date_begin]',
                '$good_data[date_end]',
                '$good_data[bio]'
            );";

            $result = mysqli_query($db_server,$query)
                or die ("Couldn't execute query:"
                    .mysqli_error($db_server));
            if(mysqli_affected_rows($db_server) > 0) {
                $_POST['id'] = mysqli_insert_id($db_server);
    			display_form($_POST, "{$_POST['name']} has been added.", "Submit Changes");
    			echo "<a href=\"authors.php?id={$_POST['id']}\">View Author Record</a>.";
            }
            else
    			display_form($_POST, "No author added", "Submit Changes");
	}
    } elseif ( !empty($_GET) ) {
        // must protect against 31336 hax0rz, zomg! (the 6 is on purpose--this won't stop sophisticated hacks)
        foreach ($_GET as $get_field) {
            if(strlen($get_field) > 120 )
                die("You submitted a search term that was too long--please alert the web master and include the URL from your browser's location bar.");
        }
#        if ( $_GET ) {         ####  we have $_GET data from URL -- edit or delete author ####
        	if ( $_GET['delete'] ) {    ## we are going to delete this author ##
        		echo "<h2>Delete Author</h2>";

        		$id=mysqli_real_escape_string($db_server, $_GET['delete']);
        		$result = mysqli_query($db_server, "select * from authors where id=$id;");

        		if ( !$result->num_rows ) {
          			print ("Could not find that author. <br>");
          			print ("<a href=\"authors.php\">Go to Search Page</a>.");
        		} else {

        			$author = mysqli_fetch_array($result);
        			$name = $author['name'];
        			?>

        			<?php
        			$result = mysqli_query($db_server, "delete from authors where id=$id;");
        			if(mysqli_affected_rows($db_server) > 0) {
        			?>
        				<p><?php echo $name; ?> has been removed from the database.</p>
        				<?php
        			} else {
        				print ("Sorry, we couldn't delete that author.");
        			}  # end successful delete
        		}  # end valid search result

        	} elseif( $_GET['id'] && !$_POST) {        ####  we have _GET['id'] & no _POST data -- just display edit author form with ID's info #####
        		$id=mysqli_real_escape_string($db_server, $_GET['id']);
        		$result = mysqli_query($db_server, "select * from authors where id=$id;");

        		if ( !$result->num_rows ) {
          			print ("Could not find that author. <br>"); 
          			print ("<a href=\"authors.php\">Go to Search Page</a>.");
        		} else {
        			$author = mysqli_fetch_array($result);
        			$name = $author['name'];
        			$alias = $author['alias'];
        			$title = $author['title'];
        			$date_type = $author['date_type'];
        			$date_circa = $author['date_circa'];
        			$date_begin = $author['date_begin'];
        			$date_end = $author['date_end'];
        			$bio = $author['bio'];

        			display_form($author, "Edit Author Details", "Submit Changes");
        		}  # end valid search result
            } else {    #### we don't have a valid GET request!  ####
                echo "You sent a request the server could not understand; please try again.";
                echo "<!--No, I don't understand that banter at all!-->";
        	} # end if -- edit or delete
        }  # end _GET data
#    }
} else { ?>
    <p>Sorry, you must <a href="/login.php">log in</a> to view this page.</p>
<?php }

####  function to display the form  ####
function display_form($data, $legend, $button){
?>
		<form id="admin-author"  action='admin-authors.php<?php if ( $data['id'] ) echo "?id=$data[id]";?>' method='POST'>
        <fieldset>
                <legend><?php echo $legend?></legend>
                <ul>
                                <input id="id" name="id" type="hidden" value=<?php echo $data['id'];?>></li>
                        <li class="whole"><label for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Author's name as found in DMA or WorldCat" value="<?php echo $data['name'];?>" autofocus></li>
                        <li class="whole"><label for="alias">Alias</label>
                                <input id="alias" name="alias" type="text" placeholder="Alternate names or spellings" value="<?php echo $data['alias'];?>"></li>
                        <li class="whole"><label for="title">Title</label>
                                <input id="title" name="title" type="text" placeholder="Title, such as Saint, King, Bishop, etc." value="<?php echo $data['title'];?>" ></li>
                        <li class="checkbox fourth"><label for="date_circa">Date circa</label>
                                <input id="date_circa" name="date_circa" type="checkbox" value="1" <?php if ( $data['date_circa'] ) echo "checked";?>></li>
                        <li class="fourth"><label for="date_type">Date modifier</label>
                                <input id="date_type" name="date_type" type="text" placeholder="circa, died, flourished, reigned" value="<?php echo $data['date_type'];?>"></li>
                        <li class="fourth"><label for="date_begin">From</label>
                                <input id="date_begin" name="date_begin" type="text" placeholder="begin date" value="<?php echo $data['date_begin'];?>"></li>
                        <li class="fourth"><label for="date_end">To</label>
                                <input id="date_end" name="date_end" type="text" placeholder="end date"value="<?php echo $data['date_end'];?>"></li>
                        <li class="whole"><label for="bio">Biographical information</label>
                                <p><a href="#" onclick="toggle_visibility('format');">Text formatting instructions >></a></p>
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
                                <textarea id="bio" name="bio" rows="5" placeholder="Biographical information"><?php echo $data['bio'];?></textarea></li>
                </ul>
        </fieldset>
        <input type='submit' class="button" value='<?php echo $button;?>' />
	</form>

<?php
}

include ('footer.php'); ?>

