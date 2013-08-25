<?php include '../header.php';
include '../countries.php' ?>

<h2>Geo-Political Regions</h2>

<?php $countries = $country_array; 
foreach ($countries as $country) { ?>
	<li>
		<?php echo $country;?>
	</li>
<?php } ?>


<?php include '../footer.php'; ?>