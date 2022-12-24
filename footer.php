		</div><!-- #main -->
	</div><!-- #content -->
</div><!-- #wrapper -->
</div><!-- #shadow -->
<footer>
	<p>&copy; 2004-<?php echo date( 'Y' ); ?> <a href="http://fordham.edu">Fordham University</a>.  <a href="mailto:medvlsources@fordham.edu">MedvlSources@Fordham.edu</a></p>
</footer>
</body>
<script>
document.querySelectorAll('.multiselect').forEach((el)=>{
	let settings = {
		maxOptions: null,
		plugins: {
		remove_button:{
			title:'Remove this item',
		}
	},
	};
 	new TomSelect(el,settings);
});
</script>
<script src="js/omsb-textile.js"></script>
</html>
