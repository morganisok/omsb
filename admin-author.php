<?php include('header.php');
        include ('connect.php'); 


####  new author form  ####
if (!$_POST && !$_GET) {

?>
<form id="add-author"  action='add-author.php' method='POST'>
        <fieldset>
                <legend>Add a New Author</legend>
                <ul>
                        <li><label for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Author's name as found in DMA or WorldCat" autofocus></li>
                        <li><label for="alias">Alias</label>
                                <input id="alias" name="alias" type="text" placeholder="Alternate names or spellings"></li>
                        <li><label for="title">Title</label>
                                <input id="title" name="title" type="text" placeholder="Title, such as Saint, King, Bishop, etc."></li>
                        <li><label for="datemod">Date modifier</label>
                                <input id="datemod" name="datemod" type="text" placeholder="circa, died, flourished, reigned"></li>
                        <li><label for="from">From</label>
                                <input id="from" name="from" type="text" placeholder="begin date"></li>
                        <li><label for="to">To</label>
                                <input id="to" name="to" type="text" placeholder="end date"></li>
                        <li><label for="bio">Biographical information</label>
                                <textarea id="bio" name="bio" rows="5" placeholder="Biographical information"></textarea></li>
                </ul>
        </fieldset>
        <input type='submit' value='Create New Author' />
</form>


<?php

}
####  we have $_POST data -- add new author ####
if ( $_POST && !$_GET ) {



$id=$_POST['id'];

echo "<pre>2-post: ";
print_r($_POST);
echo "-2-get: ";
print_r($_GET);
echo "</pre>-";



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


} 


####  we have $_GET & $_POST data -- edit author ####
#if ( $_POST && $_GET ) {
if ( $_GET ) {

$id=$_GET['id'];

if ($_POST){
$id=$_POST['id'];


echo "<pre>";
echo "</pre>";
        $labels = array( 
                "id" => "id",
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
                $query = "UPDATE authors set
                                name       = '$_POST[name]',
                                alias      = '$_POST[alias]',
                                title      = '$_POST[title]', 
                                date_type  = '$_POST[datemod]',
                                date_begin = '$_POST[from]',
                                date_end   = '$_POST[to]'
                         where id=$id;";
                $result = mysqli_query($db_server,$query)
                        or die ("Couldn't execute query:"
                                .mysqli_error($db_server));
                if(mysqli_affected_rows($db_server) > 0)
                {
                        echo "{$_POST['name']} has been updated.";
                }
                else
                        echo "No changes made.";
}

$sql = mysqli_query($db_server, "select * from authors where id=$id;");

if ( !$sql->num_rows ) {
  die ("Could not find that author."); 
}

$author = mysqli_fetch_array($sql);
$name = $author['name'];
$alias = $author['alias'];
$title = $author['title'];
$datemod = $author['date_type'];
$from = $author['date_begin'];
$to = $author['date_end'];
$bio = $author['bio'];

}


####  we have $_GET data -- edit author form ####
if ( !$_POST && $_GET ) {

?>


<form id="admin-author"  action='admin-author.php' method='POST'>
        <fieldset>
                <legend>Edit Author Details</legend>
                <ul>
                                <input id="id" name="id" type="hidden" value=<?php echo $id;?>></li>
                        <li><label for="name">Name</label>
                                <input id="name" name="name" type="text" placeholder="Author's name as found in DMA or WorldCat" value="<?php echo $name;?>" autofocus></li>
                        <li><label for="alias">Alias</label>
                                <input id="alias" name="alias" type="text" placeholder="Alternate names or spellings" value="<?php echo $alias;?>"></li>
                        <li><label for="title">Title</label>
                                <input id="title" name="title" type="text" placeholder="Title, such as Saint, King, Bishop, etc." value="<?php echo $title;?>" ></li>
                        <li><label for="datemod">Date modifier</label>
                                <input id="datemod" name="datemod" type="text" placeholder="circa, died, flourished, reigned" value="<?php echo $datemod;?>"></li>
                        <li><label for="from">From</label>
                                <input id="from" name="from" type="text" placeholder="begin date" value="<?php echo $from;?>"></li>
                        <li><label for="to">To</label>
                                <input id="to" name="to" type="text" placeholder="end date"value="<?php echo $to;?>"></li>
                        <li><label for="bio">Biographical information</label>
                                <textarea id="bio" name="bio" rows="5" placeholder="Biographical information"><?php echo $bio;?></textarea></li>
                </ul>
        </fieldset>
        <input type='submit' value='Submit Changes' />
</form>


<?php
}
include ('footer.php'); ?>

