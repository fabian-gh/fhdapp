<?php ob_start();

// TODO: Campus berücksichtigen beim Einfügen / Ändern


    //header einbinden
    require_once '../../layout/backend/header.php';
    
	//create new Controller Object
	require_once '../../controllers/kontakteController.php';
	$controller = new kontakteController();
?>
			<style type="text/css">

				.confirmation{
					background-color: #76FF76;
					border: 2px solid #00B100;
					text-align: center;
					width: 100%;
					height: 100%;
					margin-bottom: 20px;
				}
				
				.confirmation p {
					padding-top: 7px;
					padding-bottom: 10px;
				}

				.confirmationTable {
					margin: auto;
				}

				.confirmation span {
					font-weight: bold;
				}

				.contactLabel {
					width: 150px;
					display: inline-block;
					margin-top: 15px;
					text-align: left;
				}

				input[type=text], textarea { 
					margin-left: 15px;
					margin-top: 15px;
					width: 300px;
				}

				input[type=radio], input[type=checkbox] {
					margin-left: 10px;
					margin-bottom: 5px;
				}

				fieldset {
					margin-top: 15px;
					margin-bottom: 15px;
				}

				.submit {
					margin-top: 15px;
					float: right;
				}
				button {
					margin-top: 30px;
				}

				.radio {
					margin-left: 3px;
				}

				.borderfield {
					padding: 10px;
				}
			</style>
			<script>
				$.fn.scrollTo = function( target, options, callback ){
				  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
				  var settings = $.extend({
				    scrollTarget  : target,
				    offsetTop     : 50,
				    duration      : 500,
				    easing        : 'swing'
				  }, options);
				  return this.each(function(){
				    var scrollPane = $(this);
				    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
				    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
				    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
				      if (typeof callback == 'function') { callback.call(this); }
				    });
				  });
				}
			</script>

<?php
	//check if the addContact-submit button has been pressed
	if(isset($_POST['contactSubmit'])){
		//call function to submit the typed values
		$controller->c_insertContact($_POST);
	}
	if(isset($_POST['alterContactSubmit'])){
		$controller->c_alterContact($_POST);
	}
	if(isset($_POST['alterAllContactsSubmit'])){
		$controller->c_alterAllContacts($_POST);
	}
	if(isset($_POST['alterOneContactSubmit'])){
		$controller->c_alterOneContact($_POST);
	}
	if(isset($_POST['deleteContact'])){
		$controller->c_deleteContact($_POST);
	}				
?>
		


			<button id="addContactButton" onclick="showAddContact()" style="margin-bottom: 20px;" >Neuen Kontakt hinzufügen</button>


			<!-- List the existing data in a table and give the possibility to alter or delete it -->
			<div id="alterContact">
				<?php 
				$contacts = $controller->c_getContacts();
				if($contacts != null){
					echo	'<table width="100%" border="0" cellpadding="0" cellspacing="0">
					            <tr>
					                <th>Kontaktstelle</th>
					                <th>Kategorie</th>
					                <th>Fachbereich</th>
					                <th>Bearbeiten</th>
					                <th>Löschen</th>
					            </tr>';

						foreach ($contacts as $value) {
						echo '<form action="" method="post">';			
							echo '<tr>
									<td>' . $value['title'] . '</td>
									<td>' . $value['catName'] . '</td>
									<td>' . $value['deptName'] . '</td>
									<td> <input type="hidden" name ="contactID" value="' . $value['contactID'] . '" /> <input type="hidden" name="deptID" value="' . $value['deptID'] . '" /><input type="submit" name="alterContact" value="Daten bearbeiten" /> </td>
									<td> <input type="submit" name="deleteContact" value="Kontakt löschen" onclick=\'return confirm("Möchten Sie diesen Kontakt wirklich löschen?")\' /></td>
								</tr>';
						echo '</form>';
						}
				} else {
					echo '<p>Es sind noch keine Kontakte in der Datenbank vorhanden.</p>';
				}
				?>
				</table>
			</div>
			
			<?php
					if(isset($_POST['alterContact'])){
						$contactDepts = $controller->c_getContactDepts($_POST);
						//check if the contact exists for one or multiple departments
						if($contactDepts[1] != null){
							echo '<p class="multipleContacts">
									<span> Bitte beachten:</span> <br />
									Der Kontakt ist für mehrere Fachbereiche eingetragen. 
									Möchten Sie ihn für alle Fachbereiche ändern oder nur den Fachbereich des ausgewählten?</p>';
							//should the contact be altered for all departments or just a single one? 
							echo '	<form action="" method="post">
										<input type="hidden" name="contactID" value=" '. $_POST['contactID'] .' " />
										<input type="hidden" name="deptID" value=" '.$_POST['deptID'].' " />
										<input type="submit" style="margin-top: 15px; margin-right: 15px;" name="alterAllContacts" value="Für alle ändern" />
										<input type="submit" style="margin-top: 15px; margin-right: 15px;" name="alterOneContact" value="Nur ausgewählten ändern"/>
									</form>
								';
						}
						else{
							$alterContact = $controller->c_getContact($_POST);
							//getting the categories from the db
							$categories = $controller->c_getCategories();	
							//getting the departments from the db
							$departments = $controller->c_getDepartments();	

							echo '
								<div class="alterContact">
									<form name="alterContactForm" action="#" method="post">
									<fieldset class="borderfield">
										<legend>Kontakt bearbeiten</legend>
										<label class="contactLabel" for="alterContactTitle">Kontakstelle</label> <input type="text" id="alterContactTitle" name="alterContactTitle" value="' .$alterContact[0]['title']. '" /><br />
										<label class="contactLabel" for="alterContactContact"> Ansprechpartner</label> <input type="text" id="alterContactContact" name="alterContactContact" value="'. $alterContact[0]['contact'].'" /><br />										
										<label class="contactLabel" for="alterContactDescription"> Beschreibung</label> <textarea id="alterContactDescription" name="alterContactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)">'. $alterContact[0]['description'] .'</textarea>	<br />							
										<fieldset>';
							//creating a radiobutton for every category. Value is set to match the ID
							for ($i = 0; $i < count($categories); $i++) {
								if($categories[$i]['id'] != $alterContact[0]['catID'])
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								else 
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" checked="checked" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
							}
							echo '		</fieldset>
										<fieldset>';
							for ($i = 0; $i < count($departments); $i++) {
								if($departments[$i]['id'] != $alterContact[0]['deptID'])
									echo '<input type="checkbox" name="alterContactDepartment[]" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
								else
									echo '<input type="checkbox" name="alterContactDepartment[]" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" checked="checked" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
								if($i == 3)
									echo '<br />';
							}	
							echo '		</fieldset>
									<label class="contactLabel" for="alterContactPhone"> Telefon</label> <input type="text" id="alterContactPhone" name="alterContactPhone" value="'. $alterContact[0]['phone'].'" /><br />
									<label class="contactLabel" for="alterContactFax"> Fax</label> <input type="text" id="alterContactFax" name="alterContactFax" value="'. $alterContact[0]['fax'].'" /><br />
									<label class="contactLabel" for="alterContactMail"> E-Mail</label> <input type="text" id="alterContactMail" name="alterContactMail" value="'. $alterContact[0]['mail'].'" /><br />
									<label class="contactLabel" for="alterContactRoom"> Raum</label> <input type="text" id="alterContactRoom" name="alterContactRoom" value="'. $alterContact[0]['room'].'" /><br />
									<label class="contactLabel" for="alterContactAddress"> Adresse</label> <input type="text" id="alterContactAddress" name="alterContactAddress" value="'. $alterContact[0]['address'].'" /><br />
									<label class="contactLabel" for="alterContactOfficeHours"> Büro-Offnungszeiten</label> <input type="text" id="alterContactOfficeHours" name="alterContactOfficeHours" value="'. $alterContact[0]['office_hours'].'" /><br />
									<label class="contactLabel" for="alterContactPhoneOfficeHours"> Telefonische Sprechzeiten</label> <input type="text" id="alterContactPhoneOfficeHours" name="alterContactPhoneOfficeHours" value="'. $alterContact[0]['phone_office_hours'].'" /><br />
									<input type="hidden" name="contactID" value="' . $alterContact[0]['contactID'] . ' " />
									<input type="hidden" name="deptID" value="' . $alterContact[0]['deptID'] . '" />
									<input type="submit" name="alterContactSubmit" value="Daten ändern" id="alterContactBtn" class="submit"/>
									</fieldset>
							';

							echo'	</form>
								</div>';
						}
					}
			?>

			<?php 
				//TODO: wenn mehrere FB, mehrere Checkboxen markieren
				if(isset($_POST['alterAllContacts'])){
							$alterContact = $controller->c_getContact($_POST);
							//getting the categories from the db
							$categories = $controller->c_getCategories();	
							//getting the departments from the db
							$departments = $controller->c_getDepartments();	

							$contactDepts = $controller->c_getContactDepts($alterContact[0]['contactID']);

							echo '
								<div class="alterContact">
									<form name="alterContactForm" action="#" method="post">
									<fieldset class="borderfield">
										<legend>Kontakt bearbeiten </legend>
										<label class="contactLabel" for="alterContactTitle">Kontaktstelle</label> <input type="text" id="alterContactTitle" name="alterContactTitle" value="' .$alterContact[0]['title']. '" /> </br>
										<label class="contactLabel" for="alterContactContact"> Ansprechpartner</label> <input type="text" id="alterContactContact" name="alterContactContact" value="'. $alterContact[0]['contact'].'" /><br />
										<label class="contactLabel" for="alterContactDescription"> Beschreibung</label> <textarea id="alterContactDescription" name="alterContactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)">'. $alterContact[0]['description'] .'</textarea>	<br />							
										<fieldset>';
							//creating a radiobutton for every category. Value is set to match the ID
							for ($i = 0; $i < count($categories); $i++) {
								if($categories[$i]['id'] != $alterContact[0]['catID'])
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								else 
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" checked="checked" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
							}
							echo '		</fieldset>
										<fieldset>';

							for ($i = 0; $i < count($departments); $i++) {
								$check = "";
								for($j = 0; $j < count($contactDepts); $j++){
									if($departments[$i]['id'] == $contactDepts[$j]['department_id'])
										$check = 'checked="checked"';

								}					
								echo '<input type="checkbox" name="alterContactDepartment[]" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" ' . $check . '/><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
								if($i == 3)
									echo '<br />';

							}	
							echo '		</fieldset>
									
									<label class="contactLabel" for="alterContactPhone"> Telefon</label> <input type="text" id="alterContactPhone" name="alterContactPhone" value="'. $alterContact[0]['phone'].'" /><br />
									<label class="contactLabel" for="alterContactFax"> Fax</label> <input type="text" id="alterContactFax" name="alterContactFax" value="'. $alterContact[0]['fax'].'" /><br />
									<label class="contactLabel" for="alterContactMail"> E-Mail</label> <input type="text" id="alterContactMail" name="alterContactMail" value="'. $alterContact[0]['mail'].'" /><br />
									<label class="contactLabel" for="alterContactRoom"> Raum</label> <input type="text" id="alterContactRoom" name="alterContactRoom" value="'. $alterContact[0]['room'].'" /><br />
									<label class="contactLabel" for="alterContactAddress"> Adresse</label> <input type="text" id="alterContactAddress" name="alterContactAddress" value="'. $alterContact[0]['address'].'" />
									<label class="contactLabel" for="alterContactOfficeHours"> Büro-Offnungszeiten</label> <input type="text" id="alterContactOfficeHours" name="alterContactOfficeHours" value="'. $alterContact[0]['office_hours'].'" /><br />
									<label class="contactLabel" for="alterContactPhoneOfficeHours"> Telefonische Sprechzeiten</label> <input type="text" id="alterContactPhoneOfficeHours" name="alterContactPhoneOfficeHours" value="'. $alterContact[0]['phone_office_hours'].'" /><br />
									<input type="hidden" name="contactID" value="' . $alterContact[0]['contactID'] . ' " />
									<input type="hidden" name="deptID" value="' . $alterContact[0]['deptID'] . '" />
									<input type="submit" name="alterAllContactsSubmit" value="Daten ändern" id="alterContactBtn" class="submit" />
									</fieldset>
							';

							echo'	</form>
								</div>';	
				}

				if(isset($_POST['alterOneContact'])){
					$alterContact = $controller->c_getContact($_POST);
					//getting the categories from the db
					$categories = $controller->c_getCategories();	
					//getting the departments from the db
					$departments = $controller->c_getDepartments();		

					echo '
								<div class="alterContact">
									<form name="alterContactForm" action="#" method="post">
										<fieldset class="borderfield">
										<legend>Kontakt bearbeiten</legend>
										<label class="contactLabel" for="alterContactTitle">Kontaktstelle</label> <input type="text" id="alterContactTitle" name="alterContactTitle" value="' .$alterContact[0]['title']. '" /> <br />
										<label class="contactLabel" for="alterContactContact"> Ansprechpartner</label> <input type="text" id="alterContactContact" name="alterContactContact" value="'. $alterContact[0]['contact'].'" /> <br />
										<label class="contactLabel" for="alterContactDescription"> Beschreibung</label> <textarea id="alterContactDescription" name="alterContactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)">'. $alterContact[0]['description'] .'</textarea> <br />							
										<fieldset>';
							//creating a radiobutton for every category. Value is set to match the ID
							for ($i = 0; $i < count($categories); $i++) {
								if($categories[$i]['id'] != $alterContact[0]['catID'])
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								else 
									echo '<input type="radio" name="alterContactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" checked="checked" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
							}
							echo '		</fieldset>
										<fieldset>';
							for ($i = 0; $i < count($departments); $i++) {	
								if($departments[$i]['id'] != substr($_POST['deptID'], 1, 1))
									echo '<input type="checkbox" name="alterContactDepartment[]" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
								else
									echo '<input type="checkbox" name="alterContactDepartment[]" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" checked="checked" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
								if($i == 3)
									echo '<br />';
							}	
							echo '		</fieldset>
									
									<label class="contactLabel" for="alterContactPhone"> Telefon</label> <input type="text" id="alterContactPhone" name="alterContactPhone" value="'. $alterContact[0]['phone'].'" /><br />
									<label class="contactLabel" for="alterContactFax"> Fax</label> <input type="text" id="alterContactFax" name="alterContactFax" value="'. $alterContact[0]['fax'].'" /><br />
									<label class="contactLabel" for="alterContactMail"> E-Mail</label> <input type="text" id="alterContactMail" name="alterContactMail" value="'. $alterContact[0]['mail'].'" /><br />
									<label class="contactLabel" for="alterContactRoom"> Raum</label> <input type="text" id="alterContactRoom" name="alterContactRoom" value="'. $alterContact[0]['room'].'" /><br />
									<label class="contactLabel" for="alterContactAddress"> Adresse</label> <input type="text" id="alterContactAddress" name="alterContactAddress" value="'. $alterContact[0]['address'].'" /><br />
									<label class="contactLabel" for="alterContactOfficeHours"> Büro-Offnungszeiten</label> <input type="text" id="alterContactOfficeHours" name="alterContactOfficeHours" value="'. $alterContact[0]['office_hours'].'" /><br />
									<label class="contactLabel" for="alterContactPhoneOfficeHours"> Telefonische Sprechzeiten</label> <input type="text" id="alterContactPhoneOfficeHours" name="alterContactPhoneOfficeHours" value="'. $alterContact[0]['phone_office_hours'].'" /><br />
									<input type="hidden" name="contactID" value="' . $alterContact[0]['contactID'] . ' " />
									<input type="hidden" name="deptID" value="' . $alterContact[0]['deptID'] . '" />
									<input type="submit" name="alterOneContactSubmit" value="Daten ändern" id="alterContactBtn" class="submit"/>
									</fieldset>
							';

							echo'	</form>
								</div>';
				}
			?>
			<!-- End alter contacts -->
			<!-- Begin add contact -->
			<div id="addContact" style="visibility : hidden; height: 0px;">
				<fieldset class="borderfield">
				<legend>Neuen Kontakt hinzufügen</legend>
				<form name="contactForm" method="post" action="#" id="contactForm">
					<label class="contactLabel">Kontaktstelle </label><input type="text" name="contactTitle" placeholder="z.B.: Zulassungsstelle, Dekanat, ... " /> 
					<label class="contactLabel"> Ansprechpartner </label> <input type="text" name="contactContact" id="test" placeholder="Max Mustermann" /> <br />	
					<label class="contactLabel"> Beschreibung</label> <textarea name="contactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)"></textarea> <br />				
					<fieldset>
						<legend>Kategorie</legend> <br />
							<?php 
								//getting the categories from the db
								$categories = $controller->c_getCategories();
								//creating a radiobutton for every category. Value is set to match the ID
								for ($i = 0; $i < count($categories); $i++) {
									echo '<input type="radio" name="contactCategory" id="'. $categories[$i]['name'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								}
							?>
					</fieldset>
					<fieldset>	
						<legend>Fachbereich</legend> <br />
							<?php 
								//getting the departments from the db
								$departments = $controller->c_getDepartments();
								//creating a radiobutton for every department. Value is matching the ID
								for ($i = 0; $i < count($departments); $i++) {
									echo '<input type="checkbox" name="contactDepartment[]" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
									if($i == 3)
										echo '<br />';
								}
							?>
					</fieldset>	
					<label class="contactLabel"> Telefon </label> <input type="text" name="contactPhonenumber" placeholder="0211-123456" /> <br />
					<label class="contactLabel"> Fax </label> <input type="text" name="contactFaxnumber" placeholder="0211-123456" /><br />
					<label class="contactLabel"> E-Mail </label> <input type="text" name="contactMail" placeholder="max.mustermann@fh-duesseldorf.de" /><br />
					<label class="contactLabel"> Raum </label> <input type="text" name="contactRoom" placeholder="z.B.: H 1.5" /><br />
					<label class="contactLabel"> Campus und Adresse </label>  <textarea name="contactAdress" cols="50" rows="3" placeholder="Campus Nord / Süd , Straße"></textarea> <br />
					<label class="contactLabel"> Büro - Öffnungszeiten </label> <textarea name="contactOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> <br />
					<label class="contactLabel"> Telefonische Sprechzeiten </label> <textarea name="contactPhoneOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> <br />
					<input type="submit" class="submit" name="contactSubmit" value="Daten abschicken" id="addContactBtn" onclick="return check()" />
				</form>
				</fieldset>
			</div>
			<!-- End add contact -->	
			<script type="text/javascript">
				/**
				*	Gets called when the "add new contact" button is pressed
				*/
				function showAddContact(){

					//show the div if the button has not been pressed
					if(($('#addContact').css('visibility') === "hidden")){
						$('#addContact').css('visibility', 'visible');
						$('#addContact').css('height', '100%');
						$('#addContactButton').html('Neuen Kontakt hinzufügen - verbergen');
						$('body').scrollTo('#addContact');
					}
					// hide it otherwise 
					else {
						$('#addContact').css('visibility', 'hidden');
						$('#addContact').css('height', '0px');
						$('#addContactButton').html('Neuen Kontakt hinzufügen');			
					}
				}

				function check(){
					var dept = false;
					$("input[type=checkbox]").each( 
						function(){
							if($(this).prop("checked") === true){
								dept = true;
							}
						}
					);
					
					var category = false;
					$("input[type=radio]").each( 
						function(){
							if($(this).prop("checked") === true){
								category = true;
							}
							console.log($(this).prop("checked"));
						}
					);
					
					

			

					
				
					if(dept && category){
						return true;
					} else {
						categoryAlert = "";
						deptAlert = "";
						if(!category)
							categoryAlert ="Bitte wählen Sie eine Kategorie aus. \n";
						if(!dept)
							deptAlert ="Bitte wählen Sie einen Fachbereich aus. \n";
						alert(categoryAlert + deptAlert);
						return false;
					}

				}
			</script>

<?php
	require_once '../../layout/backend/footer.php';
	ob_flush();
?>