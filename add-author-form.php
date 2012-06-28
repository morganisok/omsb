<?php include('header.php'); ?>

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


<?php include ('footer.php'); ?>