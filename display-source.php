<?php 
include 'header.php';
include 'connect.php'; ?>

<?php require_once('classTextile.php'); 
$textile = new Textile(); ?>

<h2>Source Details</h2>

<?php 
$id=$_GET['id'];
$sql = mysqli_query($db_server, "select * from sources where id=$id;");

$source = mysqli_fetch_array($sql);
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
?>
		
<ul>
	<li><b>MyID:</b>				<?php echo $my_id; ?></li>
	<li><b>editor:</b>				<?php echo $editor; ?></li>
	<li><b>title:</b>				<?php echo $title; ?></li>
	<li><b>publication:</b>			<?php echo $publication; ?></li>
	<li><b>pub_date:</b>			<?php echo $pub_date; ?></li>
	<li><b>isbn:</b>				<?php echo $isbn; ?></li>
	<li><b>text_pages:</b>			<?php echo $text_pages; ?></li>
	<li><b>trans_english:</b>		<?php echo $trans_english; ?></li>
	<li><b>trans_french:</b>		<?php echo $trans_french; ?></li>
	<li><b>trans_other:</b>			<?php echo $trans_other; ?></li>
	<li><b>trans_none:</b>			<?php echo $trans_none; ?></li>
	<li><b>date_begin:</b>			<?php echo $date_begin; ?></li>
	<li><b>date_end:</b>			<?php echo $date_end; ?></li>
	<li><b>region:</b>				<?php echo $region; ?></li>
	<li><b>archive:</b>				<?php echo $archive; ?></li>
	<li><b>link:</b>				<?php echo $link; ?></li>
	<li><b>app_index:</b>			<?php echo $app_index; ?></li>
	<li><b>app_glossary:</b>		<?php echo $app_glossary; ?></li>
	<li><b>app_appendix:</b>		<?php echo $app_appendix; ?></li>
	<li><b>app_bibliography:</b>	<?php echo $app_bibliography; ?></li>
	<li><b>app_facsimile:</b>		<?php echo $app_facsimile; ?></li>
	<li><b>app_intro:</b>			<?php echo $app_intro; ?></li>
	<li><b>comments:</b>			<?php echo $textile->TextileThis($comments); ?></li>
	<li><b>intro_summary:</b>		<?php echo $textile->TextileThis($intro_summary); ?></li>
	<li><b>addenda:</b>				<?php echo $addenda; ?></li>
	<li><b>live:</b>				<?php echo $live; ?></li>
	<li><b>created_at:</b>			<?php echo $created_at; ?></li>
	<li><b>updated_at:</b>			<?php echo $updated_at; ?></li>
	<li><b>user_id:</b>				<?php echo $user_id; ?></li>
	<li><b>trans_comment:</b>		<?php echo $trans_comment; ?></li>
	<li><b>text_name:</b>			<?php echo $text_name; ?></li>
	<li><b>cataloger:</b>			<?php echo $cataloger; ?></li>
</ul>

<?php include 'footer.php'; ?>

