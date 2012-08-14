<?php include('header.php'); ?>

<h2>Create a New Source</h2>

<form id="add-source"  action='add-source.php' method='POST'>
	<fieldset>
		<legend>Cataloger Information</legend>
			<li><label for="my_id">MyID</label>
				<input id="my_id" name="my_id" type="text" placeholder="00.00" autofocus></li>
			<li><label for="cataloger">Cataloger Initials</label>
				<input id="cataloger" name="cataloger" type="text"></li>
	</fieldset>
	<fieldset>
		<legend>Publication Information</legend>
			<li><label for="editor">Modern Editor/Translator</label>
				<input id="editor" name="editor" type="text" placeholder="Surname [comma, space] forename of authors or editors"></li>
			<li><label for="title">Title</label>
				<input id="title" name="title" type="text" placeholder="Article or chapter title (in quotation marks), or book title"></li>
			<li><label for="publication">Publication Information</label>
				<input id="publication" name="publication" type="text" placeholder="series or journal name, publication city and publisher, etc."></li>	
			<li><label for="pub_date">Publication Date</label>
				<input id="pub_date" name="pub_date" type="text"></li>	
			<li><label for="isbn">ISBN</label>
				<input id="isbn" name="isbn" type="text"></li>	
			<li><label for="text_pages">Text Pages</label>
				<input id="text_pages" name="text_pages" type="text"></li>
			<li><label for="link">Link</label>
				<input id="link" name="link" type="text" placeholder="URL of complete text"></li>
	</fieldset>
	<fieldset>
		<legend>Original Text Information</legend>
			<li><label for="text_name">Text Name</label>
				<textarea id="text_name" name="text_name" rows="5" placeholder="Name of the text and any variants in name or spelling"></textarea></li>
			<li><label for="date_begin">Earliest Date</label>
				<input id="date_begin" name="date_begin" type="text"></li>
			<li><label for="date_end">Latest Date</label>
				<input id="date_end" name="date_end" type="text"></li>
			<li>Need checkbox fields here for translation options</li>
			<li><label for="trans_comment">Translation Comments</label>
				<textarea id="trans_comment" name="trans_comment" rows="5" placeholder="Other information about the translation, such as whether it appears on facing page of original text, whether translations are only offered for some of the text, or whether a translation of poetry is in verse or prose."></textarea></li>
			<li><label for="trans_comment">Archival Reference</label>
				<textarea id="trans_comment" name="trans_comment" rows="3" placeholder="Archive, record office or library where original documents are located; include shelf no/class/call no. if known."></textarea></li>
			<li>Need dropdowns for medieval author and language</li>
	</fieldset>
	<fieldset>
		<legend>Region Information</legend>
			<li><label for="region">County/Town/Parish/Village</label>
				<input id="region" name="region" type="text"></li>
			<li>Need dropdown for country</li>
	</fieldset>
	<fieldset>
		<legend>Finding Aids</legend>
			<li>Need dropdowns for record type and subject</li>
	</fieldset>
	<fieldset>
		<legend>Apparatus</legend>
			<li>Need checkboxes for apparatus</li>
			<li><label for="comments">Comments</label>
				<textarea id="comments" name="comments" rows="10"></textarea></li>
			<li><label for="intro_summary">Introduction Summary</label>
				<textarea id="intro_summary" name="intro_summary" rows="10"></textarea></li>
			<li><label for="addenda">Notes</label>
				<textarea id="addenda" name="addenda" rows="5" placeholder="These are private notes and will not be seen by the public."></textarea></li>
			<li>Need checkbox for public/private</li>

	<input type='submit' value='Create New Source' />
</form>


<?php include ('footer.php'); ?>