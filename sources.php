<?php include 'header.php';
include 'connect.php';
require_once 'paginator.class.php';
require_once 'auth.php';

function search_form() { ?>
	<form action="sources.php" method="get">
		<?php if(isAppLoggedIn()) { ?>
			<!-- Form for logged in users -->
					<fieldset>
						<legend>Cataloger Information</legend>
							<li class="half"><label for="my_id">MyID</label>
								<input id="my_id" name="my_id" type="text" autofocus></li>
							<li class="half"><label for="cataloger">Cataloger Initials</label>
								<input id="cataloger" name="cataloger" type="text"></li>
					</fieldset>
					<fieldset>
						<legend>Publication Information</legend>
							<li class="whole"><label for="editor">Modern Editor/Translator</label>
								<input id="editor" name="editor" type="text"></li>
							<li class="whole"><label for="title">Title</label>
								<input id="title" name="title" type="text"></li>
							<li class="whole"><label for="publication">Publication Information</label>
								<input id="publication" name="publication" type="text"></li>	
							<li class="third"><label for="pub_date">Publication Date</label>
								<input id="pub_date" name="pub_date" type="text"></li>	
							<li class="third"><label for="isbn">ISBN</label>
								<input id="isbn" name="isbn" type="text"></li>	
							<li class="third"><label for="text_pages">Text Pages</label>
								<input id="text_pages" name="text_pages" type="text"></li>
							<li class="whole"><label for="link">Link</label>
								<input id="link" name="link" type="text"></li>
					</fieldset>
					<fieldset>
						<legend>Original Text Information</legend>
							<li class="whole"><label for="text_name">Text Name</label>
								<textarea id="text_name" name="text_name" rows="3"></textarea></li>
							<li class="half"><label for="date_begin">Earliest Date</label>
								<input id="date_begin" name="date_begin" type="text"></li>
							<li class="half"><label for="date_end">Latest Date</label>
								<input id="date_end" name="date_end" type="text"></li>
							<li class="checkbox"><input name="trans_none" value="1" type="checkbox">Original language included</li>
							<li class="checkbox"><input name="trans_english" value="1" type="checkbox">Translated into English</li>
							<li class="checkbox"><input name="trans_french" value="1" type="checkbox">Translated into French</li>
							<li class="checkbox"><input name="trans_other" value="1" type="checkbox">Translated into another language</li>
							<li class="half"><label for="trans_comment">Translation Comments</label>
								<textarea id="trans_comment" name="trans_comment" rows="3"></textarea></li>
							<li class="half"><label for="archive">Archival Reference</label>
								<textarea id="archive" name="archive" rows="3"></textarea></li>
							<li class="half"><label for="author">Medieval Author</label>
								<?php $authors = mysqli_query($db_server, "select name,id from authors order by name;"); ?>
								<select name="author[]" multiple="multiple">
										<?php while ($row = mysqli_fetch_array($authors)){ ?>
											<option value="<?php echo $row[1]; ?>"><?php echo $row[0]; ?></option>
										<?php } ?>
								</select>
							</li>
							<li class="half"><label for "language">Original Language:</label>
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
							<li class="half"><label for="region">County/Town/Parish/Village</label>
								<input id="region" name="region" value="<?php echo $data['region'];?>" type="text"></li>
							<li class="half"><label for "countries">Geopolitical Region:</label>
								<select name="countries[]" multiple="multiple">
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
							<li class="half"><label for="type">Record Type</label>
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
							<li class="half"><label for="subject">Subject</label>
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
							<li class="checkbox"><input name="app_index" value="1" type="checkbox">Index</li>
							<li class="checkbox"><input name="app_glossary" value="1" type="checkbox">Glossary</li>
							<li class="checkbox"><input name="app_appendix" value="1" type="checkbox">Appendix</li>
							<li class="checkbox"><input name="app_bibliography" value="1" type="checkbox">Bibliography</li>
							<li class="checkbox"><input name="app_facsimile" value="1" type="checkbox">Facsimile</li>
							<li class="checkbox"><input name="app_intro" value="1" type="checkbox">Introduction</li>
							<li class="whole"><label for="comments">Comments</label>
								<textarea id="comments" name="comments" rows="3"></textarea></li>
							<li class="whole"><label for="intro_summary">Introduction Summary</label>
								<textarea id="intro_summary" name="intro_summary" rows="3"></textarea></li>
							<li class="whole"><label for="addenda">Notes</label>
								<textarea id="addenda" name="addenda" rows="3"></textarea></li>
							<li class="checkbox"><input name="live" value="1" type="checkbox">Public Records</li>
					</fieldset>
		<?php } else { ?>
			<!-- Form for not logged in users -->
					<fieldset>
						<legend>Search for modern editions of medieval primary sources</legend>
							<li class="whole"><label for="text_name">Text Name</label> <!-- this field needs to search in both text_name and title fields -->
								<input id="text_name" name="text_name" placeholder="Medieval or modern title of the work"></li>
							<li class="half"><label for="author">Medieval Author</label>
								<input id="author" name="author" type="text">
								<p>You can find all records by an author using the <a href="http://omsb.alchemycs.com/authors.php">Medieval author search</a>.</p></li>
							<li class="half"><label for="editor">Modern Editor/Translator</label>
								<input id="editor" name="editor" type="text"></li>
							<li class="checkbox"><input name="link" value="1" type="checkbox">Limit search to sources available online</li><!-- if this is checked, only return records where there is something in the link field -->
							<li class="half"><label for="date_begin">Earliest Date</label>
								<input id="date_begin" name="date_begin" type="text"></li>
							<li class="half"><label for="date_end">Latest Date</label>
								<input id="date_end" name="date_end" type="text"></li>
							<li class="checkbox"><input name="trans_none" value="1" type="checkbox">Original language included</li>
							<li class="checkbox"><input name="trans_english" value="1" type="checkbox">Translated into English</li>
							<li class="checkbox"><input name="trans_french" value="1" type="checkbox">Translated into French</li>
							<li class="checkbox"><input name="trans_other" value="1" type="checkbox">Translated into another language</li>
							<li class="half"><label for "language">Original Language:</label>
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
							<li class="half"><label for="region">County/Town/Parish/Village</label>
								<input id="region" name="region" value="<?php echo $data['region'];?>" type="text"></li>
							<li class="half"><label for "countries">Geopolitical Region:</label>
								<select name="countries[]" multiple="multiple">
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
							<li class="half"><label for="type">Record Type</label>
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
							<li class="half"><label for="subject">Subject</label>
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
		<?php } ?>
	<input type="submit" class="button" value="Search Sources" />
    </form>
<?php } ?>
<h2>Search</h2>
<h4>This search form is not currently functional.  It will be functional by the end of August.  Sorry for the inconvenience.</h4>
<?php if (!$_GET){           ####  we display the form to get a search term  ####
	search_form();
} else {  # we have a search term
	?>

	<?php
	if ( $_GET['search'] ) {   ####  we have a search term, not a display source  ####

	echo "<h2>Search Results</h2>";

	$searchterm = mysqli_real_escape_string($db_server, $_GET['search']); ?>

	<p>You searched for: 
	<?php echo $_GET['search']; ?>
	</p>

	<?php $result = mysqli_query($db_server, "select * from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%';");
	if ( !$result->num_rows ) {
		print ("Could not find any sources that match your search terms."); 
		search_form();
	} else {
	?>

	<h4>Search Results:</h4>
	<!-- Pagination Stuff -->
	<div class="pages">
	<?php $result = mysqli_query($db_server, "select count(*) from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%';");
		$db_count = mysqli_fetch_array($result);
		$pages = new Paginator;
		$pages->items_total = $db_count[0];
		$pages->mid_range = 7;
		$pages->paginate();
		echo $pages->display_pages(); 
		echo $pages->display_items_per_page();
		$result = mysqli_query($db_server, "select * from sources where sources.title like '%$searchterm%' or sources.text_name like '%$searchterm%' order by sources.editor $pages->limit;"); ?>
	</div>
	<!-- End Pagination Stuff -->

	<?php while ($row = mysqli_fetch_array($result)){

		$id = $row['id'];
		$editor = $row['editor'];
		$title = $row['title']; ?>

		<ul>
			<li><?php echo $editor; ?>, <a href="http://omsb.alchemycs.com/sources.php?id=<?php echo $id; ?>">
				<?php echo $title; ?></a> 
				<?php if(isAppLoggedIn()) { ?>
					<p class="maintenance">
							<script type="text/javascript" language="JavaScript">
							function confirmAction(){
						      var confirmed = confirm("Are you sure? This will remove this source forever!");
						      return confirmed;
							}
							</script>
						<a href="http://omsb.alchemycs.com/admin-source.php?id=<?php echo $id; ?>">Edit</a> | 
						<a href="http://omsb.alchemycs.com/admin-source.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
					</p>
				<?php } ?>
			</li>
		</ul>
		
	 	<?php
		 } # end while
	 }  # end if for good search results
} else {           ####  not searching, we will display a source  ####

	require_once('classTextile.php'); 
	$textile = new Textile(); ?>

	<h2>Source Details</h2>

	<?php 
	$id = mysqli_real_escape_string($db_server, $_GET['id']);
	$result = mysqli_query($db_server, "select * from sources where id=$id;");

	$source = mysqli_fetch_array($result);
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


	<?php if(isAppLoggedIn()) { ?>		
	<!-- private view for logged in users -->
			<article class="source private">

				<h5>Publication Information</h5>
				<p><label>Modern Editor/Translator:</label><?php echo $editor; ?></p>
				<p><label>Book/Article Title:</label> <?php echo $title; ?></p>
				<p><label>Publication Information:</label> <?php echo $publication; ?>, <?php echo $pub_date; ?></p>
				<p><label>ISBN:</label> <?php echo $isbn; ?></p>
				<p><label>Number of pages of primary source text:</label> <?php echo $text_pages; ?></p>
				<p><label>Hyperlink:</label> <?php echo $link; ?></p>

				<h5>Original Text Information</h5>
				<p><label>Text name(s):</label> <?php echo $text_name; ?></p>
				<p><label>Medieval Author(s):</label>
							<ul>
					<?php $authors = mysqli_query($db_server, "select author_id from authorships where source_id=$id;");
					$authorsquery = "select name from authors where id in (";
					while ($row = mysqli_fetch_array($authors)){
						$authorsquery .= "$row[0],";
					}
					$authorsquery = substr($authorsquery,0,-1);
					$authorsquery .= ");";
					$authorsname = mysqli_query($db_server, $authorsquery);
					while ($row = mysqli_fetch_array($authorsname)){
						echo "<li> $row[0] </li>";
					}
					?>
					</ul></p>
				<p><label>Dates:</label> <?php echo $date_begin; ?> - <?php echo $date_end; ?></p>
				<p><label>Archival Reference: </label> <?php echo $archive; ?></p>
				<p><label>Original Language(s):</label>
					<ul>
					<?php $languages = mysqli_query($db_server, "select name from languages where source_id=$id;");
					while ($row = mysqli_fetch_array($languages)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>Translation: </label>
					<ul class="translation">
					<?php if($trans_none) { echo "<li>Original language included</li>"; }
						if($trans_english) { echo "<li>Translated into English</li>"; }
						if($trans_french) { echo "<li>Translated into French</li>"; }
						if($trans_other) { echo "<li>Translated into another language</li>"; } 
						?>
					</ul></p>
				<p><label>Translation Comments:</label> <?php echo $trans_comment; ?></p>

				<h5>Region Information</h5>
				<p><label>Geopolitical Region(s): </label>
					<ul>
					<?php $countries = mysqli_query($db_server, "select name from countries where source_id=$id;");
					while ($row = mysqli_fetch_array($countries)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>County/Region:</label> <?php echo $county; ?></p>

				<h5>Finding Aids</h5>
				<p><label>Record Types:</label>
					<ul>
					<?php $types = mysqli_query($db_server, "select name from types where source_id=$id;");
					while ($row = mysqli_fetch_array($types)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul></p>
				<p><label>Subject Headings:</label>
							<ul>
					<?php $subjects = mysqli_query($db_server, "select name from subjects where source_id=$id;");
					while ($row = mysqli_fetch_array($subjects)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>	</p>

			<h5>Apparatus</h5>
				<p><label>Apparatus:</label>
					<ul class="apparatus">
					<?php if($app_index) { echo "<li>Index</li>"; } 
						if($app_glossary) { echo "<li>Glossary</li>"; }
						if($app_appendix) { echo "<li>Appendix</li>"; }
						if($app_bibliography) { echo "<li>Bibliography</li>"; }
						if($app_facsimile) { echo "<li>Facsimile</li>"; }
						if($app_intro) { echo "<li>Introduction</li>"; }
						?>
					</ul></p>
				<div class="comments"><label>Comments:</label> <?php echo $textile->TextileThis($comments); ?> </div>
				<div class="intro-summary"><label>Introduction Summary:</label> <?php echo $textile->TextileThis($intro_summary); ?></div>
				<p><label>Cataloger:</label>
				<p><label>My ID:</label> <?php echo $my_id; ?></p>
				<p><label>Notes: </label> <?php echo $addenda; ?></p>
				<p><?php if($live) {
					echo "This record is viewable by the public";
				} else {
					echo "This record is hidden from the public";
				} ?></p>
				<p><label>Cataloger: </label><?php echo $cataloger; ?></p>
				<p class="maintenance">
						<script type="text/javascript" language="JavaScript">
						function confirmAction(){
					      var confirmed = confirm("Are you sure? This will remove this source forever!");
					      return confirmed;
						}
						</script>
					<a href="http://omsb.alchemycs.com/admin-source.php?id=<?php echo $id; ?>">Edit</a> | 
					<a href="http://omsb.alchemycs.com/admin-source.php?delete=<?php echo $id; ?>" onclick="return confirmAction()">Delete</a>
				</p>
	<?php } else { ?>

	<!-- public view for not logged in users -->

			<article class="source">
				<p class="citation">
					<?php echo $editor; ?>,
					<i><?php echo $title; ?></i>
					(<?php echo $publication; ?>,<?php echo $pub_date; ?>). 
					<?php if($isbn) { ?>
						ISBN: 
						<?php echo $isbn; ?>
						<a href="http://worldcat.org/isbn/<?php echo $isbn; ?>" target="_blank">Find this book in a library</a>
					<?php } ?>
					<?php if($link) { ?>
						<a href="<?php echo $link; ?>" target="_blank">Read this source online</a>
					<?php } ?>
				</p>

				<?php if($text_name) { ?>
					<p><label>Text name(s):</label> <?php echo $text_name; ?></p>
				<?php } ?>

				<?php if($text_pages) { ?>
					<p><label>Number of pages of primary source text:</label> <?php echo $text_pages; ?></p>
				<?php } ?>

				<p><label>Author(s):</label>
					<ul>
					<?php $authors = mysqli_query($db_server, "select author_id from authorships where source_id=$id;");
					$authorsquery = "select name from authors where id in (";
					while ($row = mysqli_fetch_array($authors)){
						$authorsquery .= "$row[0],";
					}
					$authorsquery = substr($authorsquery,0,-1);
					$authorsquery .= ");";
					$authorsname = mysqli_query($db_server, $authorsquery);
					while ($row = mysqli_fetch_array($authorsname)){
						echo "<li> $row[0] </li>";
						// TODO: NEED TO GET AUTHOR ID AND MAKE A LINK
					}
					?>
					</ul>
				</p>

				<?php if($date_begin || $date_end) { ?>
					<p><label>Dates:</label> <?php echo $date_begin; ?> - <?php echo $date_end; ?></p>
				<?php } ?>

				<?php if($archive) { ?>
					<p><label>Archival Reference:</label> <?php echo $archive; ?></p>
				<?php } ?>	

				<p><label>Original Language(s):</label>
					<ul>
					<?php $languages = mysqli_query($db_server, "select name from languages where source_id=$id;");
					while ($row = mysqli_fetch_array($languages)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>

				<p><label>Translation:</label>
					<ul class="translation">
					<?php if($trans_none) { echo "<li>Original language included</li>"; }
						if($trans_english) { echo "<li>Translated into English</li>"; }
						if($trans_french) { echo "<li>Translated into French</li>"; }
						if($trans_other) { echo "<li>Translated into another language</li>"; } 
						?>
					</ul>
				</p>

				<?php if($trans_comment) { ?>
					<p><label>Translation Comments:</label> <?php echo $trans_comment; ?></p>
				<?php } ?>

				<p><label>Geopolitical Region(s):</label>
					<ul>
					<?php $countries = mysqli_query($db_server, "select name from countries where source_id=$id;");
					while ($row = mysqli_fetch_array($countries)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>

				<?php if($county) { ?>
					<p><label>County/Region:</label> <?php echo $county; ?></p>
				<?php } ?>

				<p><label>Record Type(s):</label>
					<ul>
					<?php $types = mysqli_query($db_server, "select name from types where source_id=$id;");
					while ($row = mysqli_fetch_array($types)){
						echo "<li> $row[0] </li>";
					} ?>
					</ul>
				</p>
				<p><label>Subject Heading(s):</label>
					<ul>
					<?php $subjects = mysqli_query($db_server, "select name from subjects where source_id=$id;");
					while ($row = mysqli_fetch_array($subjects)){
						echo "<li> $row[0] </li>";
						// some day it might be nice to make all of the subjects link to a search for the subject (might as well do other stuff too)
					} ?>
					</ul>
				</p>
				<p><label>Apparatus:</label>
					<ul class="apparatus">
					<?php if($app_index) { echo "<li>Index</li>"; } 
						if($app_glossary) { echo "<li>Glossary</li>"; }
						if($app_appendix) { echo "<li>Appendix</li>"; }
						if($app_bibliography) { echo "<li>Bibliography</li>"; }
						if($app_facsimile) { echo "<li>Facsimile</li>"; }
						if($app_intro) { echo "<li>Introduction</li>"; }
						?>
					</ul>
				</p>
				<div class="comments"><label>Comments:</label><?php echo $textile->TextileThis($comments); ?></div>
				<div class="intro-summary"><label>Introduction Summary:</label><?php echo $textile->TextileThis($intro_summary); ?></div>
				<p><label>Cataloger:</label><?php echo $cataloger; ?></p>

			</article>
	<?php } 

} # end if
?>

<?php include 'footer.php';
}
?>
