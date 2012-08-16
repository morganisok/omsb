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
			<li><input name="trans_none" value="1" type="checkbox">Original language included</li>
			<li><input name="trans_english" value="1" type="checkbox">Translated into English</li>
			<li><input name="trans_french" value="1" type="checkbox">Translated into French</li>
			<li><input name="trans_other" value="1" type="checkbox">Translated into another language</li>
			<li><label for="trans_comment">Translation Comments</label>
				<textarea id="trans_comment" name="trans_comment" rows="5" placeholder="Other information about the translation, such as whether it appears on facing page of original text, whether translations are only offered for some of the text, or whether a translation of poetry is in verse or prose."></textarea></li>
			<li><label for="archive">Archival Reference</label>
				<textarea id="archive" name="archive" rows="3" placeholder="Archive, record office or library where original documents are located; include shelf no/class/call no. if known."></textarea></li>
			<li>Need dropdowns for medieval author</li>
			<li>Original Language:
				<select name="language[]" multiple="multiple">
					<option value="Anglo-Norman">Anglo-Norman</option>
					<option value="Arabic">Arabic</option>
					<option value="Azestan">Azestan</option>
					<option value="Chinese">Chinese</option>
					<option value="Cornish">Cornish</option>
					<option value="Czech">Czech</option>
					<option value="Dutch">Dutch</option>
					<option value="English - Anglo-Saxon / Old English">English - Anglo-Saxon / Old English</option>
					<option value="English - Middle English">English - Middle English</option>
					<option value="English - Scots">English - Scots</option>
					<option value="Ethiopian">Ethiopian</option>
					<option value="French - Breton">French - Breton</option>
					<option value="French - Gascon">French - Gascon</option>
					<option value="French - Old French">French - Old French</option>
					<option value="French - Other">French - Other</option>
					<option value="French - Provencal">French - Provencal</option>
					<option value="German">German</option>
					<option value="German - Middle High German">German - Middle High German</option>
					<option value="Greek">Greek</option>
					<option value="Hebrew">Hebrew</option>
					<option value="Italian">Italian</option>
					<option value="Latin">Latin</option>
					<option value="Manx">Manx</option>
					<option value="Old Norse">Old Norse</option>
					<option value="Old/Middle Irish">Old/Middle Irish</option>
					<option value="Other">Other</option>
					<option value="Pahlavi">Pahlavi</option>
					<option value="Pazand">Pazand</option>
					<option value="Persian">Persian</option>
					<option value="Portuguese">Portuguese</option>
					<option value="Russian">Russian</option>
					<option value="Scottish Gaelic">Scottish Gaelic</option>
					<option value="Spanish">Spanish</option>
					<option value="Spanish - Catalan">Spanish - Catalan</option>
					<option value="Spanish - Medieval">Spanish - Medieval</option>
					<option value="Turkish">Turkish</option>
					<option value="Welsh">Welsh</option>
				</select>
			</li>
	</fieldset>
	<fieldset>
		<legend>Region Information</legend>
			<li><label for="region">County/Town/Parish/Village</label>
				<input id="region" name="region" type="text"></li>
			<li>Geopolitical Region:
				<select name="region[]" multiple="multiple">
					 <option value="Africa">Africa</option>
					 <option value="Algeria">Algeria</option>
					 <option value="Armenia">Armenia</option>
					 <option value="Asia">Asia</option>
					 <option value="Austria">Austria</option>
					 <option value="Balkans">Balkans</option>
					 <option value="Belgium">Belgium</option>
					 <option value="Bohemia">Bohemia</option>
					 <option value="British Isles">British Isles</option>
					 <option value="Bulgaria">Bulgaria</option>
					 <option value="Byzantium">Byzantium</option>
					 <option value="China">China</option>
					 <option value="Crete">Crete</option>
					 <option value="Czech Republic">Czech Republic</option>
					 <option value="Denmark">Denmark</option>
					 <option value="Egypt">Egypt</option>
					 <option value="England">England</option>
					 <option value="Europe">Europe</option>
					 <option value="Finland">Finland</option>
					 <option value="Flanders">Flanders</option>
					 <option value="France">France</option>
					 <option value="Germany">Germany</option>
					 <option value="Greece">Greece</option>
					 <option value="Holy Roman Empire">Holy Roman Empire</option>
					 <option value="Hungary">Hungary</option>
					 <option value="Iberian Peninsula">Iberian Peninsula</option>
					 <option value="Iceland">Iceland</option>
					 <option value="India">India</option>
					 <option value="Ireland">Ireland</option>
					 <option value="Italy">Italy</option>
					 <option value="Middle East">Middle East</option>
					 <option value="Netherlands">Netherlands</option>
					 <option value="New World">New World</option>
					 <option value="Norway">Norway</option>
					 <option value="Persia">Persia</option>
					 <option value="Poland">Poland</option>
					 <option value="Portugal">Portugal</option>
					 <option value="Prussia">Prussia</option>
					 <option value="Russia">Russia</option>
					 <option value="Scandinavia">Scandinavia</option>
					 <option value="Scotland">Scotland</option>
					 <option value="Spain">Spain</option>
					 <option value="Sweden">Sweden</option>
					 <option value="Switzerland">Switzerland</option>
					 <option value="Tunisia">Tunisia</option>
					 <option value="Turkey">Turkey</option>
					 <option value="Ukraine">Ukraine</option>
					 <option value="Wales">Wales</option>
					 <option value="Yugoslavia">Yugoslavia</option>
				</select>
			</li>
	</fieldset>
	<fieldset>
		<legend>Finding Aids</legend>
			<li>Record Type
				<select name="type[]" multiple="multiple">
					<option value="Account Roll">Account Roll</option>
					<option value="Account Roll - Bailiff/Reeve">Account Roll - Bailiff/Reeve</option>
					<option value="Account Roll - Building">Account Roll - Building</option>
					<option value="Account Roll - Estate">Account Roll - Estate</option>
					<option value="Account Roll - Household">Account Roll - Household</option>
					<option value="Account Roll - Obedientiary">Account Roll - Obedientiary</option>
					<option value="Account Roll - Port Customs">Account Roll - Port Customs</option>
					<option value="Biography">Biography</option>
					<option value="Cartulary">Cartulary</option>
					<option value="Charters, Deeds">Charters, Deeds</option>
					<option value="Chronicle, Annals">Chronicle, Annals</option>
					<option value="Commentary / Gloss / Exegesis">Commentary / Gloss / Exegesis</option>
					<option value="Contract">Contract</option>
					<option value="Coroner's Roll">Coroner's Roll</option>
					<option value="Councils - Church">Councils - Church</option>
					<option value="Councils - Secular">Councils - Secular</option>
					<option value="Court Roll">Court Roll</option>
					<option value="Court Roll - Ecclesiastical">Court Roll - Ecclesiastical</option>
					<option value="Court Roll - Eyre">Court Roll - Eyre</option>
					<option value="Court Roll - Gaol Delivery">Court Roll - Gaol Delivery</option>
					<option value="Court Roll - Sessions of the Peace">Court Roll - Sessions of the Peace</option>
					<option value="Custumal">Custumal</option>
					<option value="Dialog">Dialog</option>
					<option value="Disputation - Philosophical/Theological">Disputation - Philosophical/Theological</option>
					<option value="Extents and Surveys">Extents and Surveys</option>
					<option value="Formulary">Formulary</option>
					<option value="Genealogy">Genealogy</option>
					<option value="Glossary / Dictionary">Glossary / Dictionary</option>
					<option value="Guild Records">Guild Records</option>
					<option value="Hagiography">Hagiography</option>
					<option value="Inquisition - Heresy">Inquisition - Heresy</option>
					<option value="Inscription">Inscription</option>
					<option value="Inventory">Inventory</option>
					<option value="Law - Canon Law">Law - Canon Law</option>
					<option value="Law - Legislation">Law - Legislation</option>
					<option value="Law - Local Ordinances">Law - Local Ordinances</option>
					<option value="Law - Treatise/Commentary">Law - Treatise/Commentary</option>
					<option value="Letter">Letter</option>
					<option value="Literature - Drama">Literature - Drama</option>
					<option value="Literature - Prose">Literature - Prose</option>
					<option value="Literature - Verse">Literature - Verse</option>
					<option value="Liturgy">Liturgy</option>
					<option value="Memoir">Memoir</option>
					<option value="Memoir - Family">Memoir - Family</option>
					<option value="Miscellany">Miscellany</option>
					<option value="Monastic Rule">Monastic Rule</option>
					<option value="Muster">Muster</option>
					<option value="Oration">Oration</option>
					<option value="Other">Other</option>
					<option value="Papal Bull">Papal Bull</option>
					<option value="Petition">Petition</option>
					<option value="Philosophic Work">Philosophic Work</option>
					<option value="Prophecy">Prophecy</option>
					<option value="Proverbs">Proverbs</option>
					<option value="Register - Bishop">Register - Bishop</option>
					<option value="Register - Notarial">Register - Notarial</option>
					<option value="Scripture">Scripture</option>
					<option value="Sermons">Sermons</option>
					<option value="Taxes">Taxes</option>
					<option value="Taxes - Clerical Subsidy">Taxes - Clerical Subsidy</option>
					<option value="Taxes - Lay Subsidy">Taxes - Lay Subsidy</option>
					<option value="Taxes - Poll Tax">Taxes - Poll Tax</option>
					<option value="Theology">Theology</option>
					<option value="Theology - Devotional">Theology - Devotional</option>
					<option value="Theology - Doctrine">Theology - Doctrine</option>
					<option value="Theology - Mystical Work">Theology - Mystical Work</option>
					<option value="Theology - Practical/Instructional">Theology - Practical/Instructional</option>
					<option value="Theology/Philosophy - Summa">Theology/Philosophy - Summa</option>
					<option value="Translation">Translation</option>
					<option value="Treatise - Instruction/Advice">Treatise - Instruction/Advice</option>
					<option value="Treatise - Other">Treatise - Other</option>
					<option value="Treatise - Political">Treatise - Political</option>
					<option value="Treatise - Scientific/Medical">Treatise - Scientific/Medical</option>
					<option value="Visitations">Visitations</option>
					<option value="Will">Will</option>
				</select>
			</li>
			<li>Subject
				<select name="subject[]" multiple="multiple">
					<option value="Agriculture">Agriculture</option>
					<option value="Apocalypticism">Apocalypticism</option>
					<option value="Architecture and Buildings">Architecture and Buildings</option>
					<option value="Art">Art</option>
					<option value="Asiatic Nomads: Huns, Mongols, etc.">Asiatic Nomads: Huns, Mongols, etc.</option>
					<option value="Byzantium">Byzantium</option>
					<option value="Carolingians">Carolingians</option>
					<option value="Church Fathers">Church Fathers</option>
					<option value="Classics / Humanism">Classics / Humanism</option>
					<option value="Clergy - Anticlericalism">Clergy - Anticlericalism</option>
					<option value="Clergy - Monks, Nuns, Friars">Clergy - Monks, Nuns, Friars</option>
					<option value="Clergy - Priests, Bishops, Canons">Clergy - Priests, Bishops, Canons</option>
					<option value="Conversion">Conversion</option>
					<option value="Crusades">Crusades</option>
					<option value="Diplomacy">Diplomacy</option>
					<option value="Early Germanic Peoples: Goths, Franks, etc.">Early Germanic Peoples: Goths, Franks, etc.</option>
					<option value="Economy - Crafts and Industry">Economy - Crafts and Industry</option>
					<option value="Economy - Guilds and Labor">Economy - Guilds and Labor</option>
					<option value="Economy - Trade">Economy - Trade</option>
					<option value="Education / Universities">Education / Universities</option>
					<option value="Family / Children">Family / Children</option>
					<option value="Government">Government</option>
					<option value="Grammar / Rhetoric">Grammar / Rhetoric</option>
					<option value="Heresy">Heresy</option>
					<option value="Historiography">Historiography</option>
					<option value="Jews / Judaism">Jews / Judaism</option>
					<option value="Law - Canon">Law - Canon</option>
					<option value="Law - Crime">Law - Crime</option>
					<option value="Law - Secular">Law - Secular</option>
					<option value="Literature - Arthurian">Literature - Arthurian</option>
					<option value="Literature - Comedy / Satire">Literature - Comedy / Satire</option>
					<option value="Literature - Devotional">Literature - Devotional</option>
					<option value="Literature - Drama">Literature - Drama</option>
					<option value="Literature - Epics, Romance">Literature - Epics, Romance</option>
					<option value="Literature - Folklore, Legends">Literature - Folklore, Legends</option>
					<option value="Literature - Other">Literature - Other</option>
					<option value="Magic / Witchcraft">Magic / Witchcraft</option>
					<option value="Maritime">Maritime</option>
					<option value="Material Culture: Food, Clothing, Household">Material Culture: Food, Clothing, Household</option>
					<option value="Medicine">Medicine</option>
					<option value="Military Orders">Military Orders</option>
					<option value="Monasticism">Monasticism</option>
					<option value="Music">Music</option>
					<option value="Muslims / Islam">Muslims / Islam</option>
					<option value="Nobility / Gentry">Nobility / Gentry</option>
					<option value="Papacy">Papacy</option>
					<option value="Peasants">Peasants</option>
					<option value="Philosophy / Theology">Philosophy / Theology</option>
					<option value="Philisophy - Aristotelian">Philisophy - Aristotelian</option>
					<option value="Philosophy - Ethics / Moral Theology">Philosophy - Ethics / Moral Theology</option>
					<option value="Philosophy - Logic">Philosophy - Logic</option>
					<option value="Philosophy - Metaphysics">Philosophy - Metaphysics</option>
					<option value="Philosophy - Platonic / Neo-Platonic">Philosophy - Platonic / Neo-Platonic</option>
					<option value="Philosophy - Political">Philosophy - Political</option>
					<option value="Piety">Piety</option>
					<option value="Piety - Confession, Penance">Piety - Confession, Penance</option>
					<option value="Piety - Lay">Piety - Lay</option>
					<option value="Piety - Mysticism">Piety - Mysticism</option>
					<option value="Plague and Disease">Plague and Disease</option>
					<option value="Political Thought">Political Thought</option>
					<option value="Poverty / Charity">Poverty / Charity</option>
					<option value="Recreation">Recreation</option>
					<option value="Reform">Reform</option>
					<option value="Religion - Institutional Church">Religion - Institutional Church</option>
					<option value="Revolt">Revolt</option>
					<option value="Royalty / Monarchs">Royalty / Monarchs</option>
					<option value="Saints">Saints</option>
					<option value="Saints - Cults / Relics">Saints - Cults / Relics</option>
					<option value="Science / Technology">Science / Technology</option>
					<option value="Science - Astronomy">Science - Astronomy</option>
					<option value="Science - Mathematics">Science - Mathematics</option>
					<option value="Theology - Christology">Theology - Christology</option>
					<option value="Theology - Ecclesiology">Theology - Ecclesiology</option>
					<option value="Theology - Eschatology">Theology - Eschatology</option>
					<option value="Theology - Heretical">Theology - Heretical</option>
					<option value="Theology - History">Theology - History</option>
					<option value="Theology - Mariology">Theology - Mariology</option>
					<option value="Theology - Moral / Ethics">Theology - Moral / Ethics</option>
					<option value="Theology - Sacramental">Theology - Sacramental</option>
					<option value="Theology - Scriptural / Exegesis">Theology - Scriptural / Exegesis</option>
					<option value="Theology - Trinitarian">Theology - Trinitarian</option>
					<option value="Towns / Cities">Towns / Cities</option>
					<option value="Travel / Pilgrimage">Travel / Pilgrimage</option>
					<option value="Vikings">Vikings</option>
					<option value="War - Chivalry">War - Chivalry</option>
					<option value="War - Military History">War - Military History</option>
					<option value="Women / Gender">Women / Gender</option>
				</select>
			</li>
	</fieldset>
	<fieldset>
		<legend>Apparatus</legend>
			<li><input name="app_index" value="1" type="checkbox">Index</li>
			<li><input name="app_glossary" value="1" type="checkbox">Glossary</li>
			<li><input name="app_appendix" value="1" type="checkbox">Appendix</li>
			<li><input name="app_bibliography" value="1" type="checkbox">Bibliography</li>
			<li><input name="app_facsimile" value="1" type="checkbox">Facsimile</li>
			<li><input name="app_intro" value="1" type="checkbox">Introduction</li>
			<li><label for="comments">Comments</label>
				<textarea id="comments" name="comments" rows="10"></textarea></li>
			<li><label for="intro_summary">Introduction Summary</label>
				<textarea id="intro_summary" name="intro_summary" rows="10"></textarea></li>
			<li><label for="addenda">Notes</label>
				<textarea id="addenda" name="addenda" rows="5" placeholder="These are private notes and will not be seen by the public."></textarea></li>
			<li><li><input name="live" value="1" type="checkbox">Make record public</li></li>

	<input type='submit' value='Create New Source' />
</form>


<?php include ('footer.php'); ?>