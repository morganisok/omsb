		</div><!-- #main -->
	</div><!-- #content -->
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
