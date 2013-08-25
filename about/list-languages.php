<?php include '../header.php';
include '../languages.php' ?>

<h2>Languages</h2>

<?php $languages = $language_array; 
foreach ($languages as $language) { ?>
	<li>
		<?php echo $language;?>
	</li>
<?php } ?>


<?php include '../footer.php'; ?>