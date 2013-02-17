<<<<<<< HEAD
<?php session_start(); 
?>
<!DOCTYPE html>

<html>
<head>
	<title>Backend Kontakte</title>
	<link rel="stylesheet" type="text/css" href="../../sources/css/style_backend.css" />
	<script type="text/javascript" src="../../sources/js/jquery-1.8.2.min.js"></script>
	<meta charset="UTF-8">
	<!-- jQuery function for "add contacts" button-->
	<script type="text/javascript">
		/**
		*	Gets called when the "add new contact" button is pressed
		*/
		function showAddContact(){

			//show the div if the button has not been pressed
			if(($('#addContact').css('visibility') === "hidden")){
				$('#addContact').css('visibility', 'visible');
				$('#addContact').css('height', '100%');
				$('#addContactButton').html('Verbergen');
			}
			// hide it otherwise 
			else {
				$('#addContact').css('visibility', 'hidden');
				$('#addContact').css('height', '0px');
				$('#addContactButton').html('Neuen Kontakt hinzufügen');			
			}
		}
	</script>
</head>
<body>

	<!-- PHP functions for getting and sending the data-->
	<?php

		//create new Controller Object
		require_once '../../controllers/kontakteController.php';
		$controller = new kontakteController();

		//check if the addContact-submit button has been pressed
		if(isset($_POST['contactSubmit'])){
			//call function to submit the typed values
			$controller->c_insertContact();
		}


		if(is_null($_SESSION['loggedIn'])){
			echo 'Noch nicht eingeloggt. Bitte <a href="../../index.php"> auf dieser Seite </a> einloggen.';
			exit();
		}
	?>
	<div id ="header">
   		<div id ="headline">
       		<h1>CMS Web-App</h1>
    	</div>
    </div>
    <div id="wrapper">
    	<div id ="nav">
        <h3>Seiteninhalt bearbeiten:</h3>
       	<ul>
         	<li><a href='#'>Studiengänge</a></li>
            <li><a href='#'>Veranstaltungen</a></li>
            <li><a href='#'>Termine</a></li>
            <li><a href='#'>Mensa</a></li>
            <li><a href='#'>FAQ</a></li>
            <li><a href='#'>Kontakt</a></li>
		</ul>
		</div>
		<div id="content">
			<!-- List the existing data in a table and give the possibility to alter or delete it -->
			<div id="alterContact">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
		            <tr>
		                <th>Kontakttitel</th>
		                <th>Kategorie</th>
		                <th>Fachbereich</th>
		                <th>Bearbeiten</th>
		                <th>Löschen</th>
		            </tr>
				<?php 
					$contacts = $controller->c_getContacts();
					echo '<form action="" method="post">';
					foreach ($contacts as $value) {
						// function for the buttons!? 
						echo '<tr>
								<td>' . $value['title'] . '</td>
								<td>' . $value['catName'] . '</td>
								<td>' . $value['deptName'] . '</td>
								<td> <input type="submit" name="alterContact'. $value['contactID'] .'" value="Daten bearbeiten" /> </td>
								<td> <input type="submit" name="deleteContact'. $value['contactID'] .'" value="Daten löschen" /></td>
							</tr>';
					}
					echo '</form>';
					foreach ($contacts as $value) {
						if(isset($_POST['deleteContact' . $value['contactID']]))
							$controller->c_deleteContact($value['contactID']);
					}
				?>
				</table>
			</div>
			<!-- End alter contacts -->
			<?php
				if(isset($_POST['alterContact' . $value['contactID']])){
					$alterContact = $controller->c_getContact($value['contactID']);
					//getting the categories from the db
					$categories = $controller->c_getCategories();	
					//getting the departments from the db
					$departments = $controller->c_getDepartments();			
					echo '
						<div>
							<form name="alterContactForm" action="" method="post">
								<label for="alterContactTitle">Titel des Kontakts</label> <input type="text" id="alterContactTitle" name="alterContactTitle" value="' .$alterContact[0]['title']. '" />
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
						if($categories[$i]['id'] != $alterContact[0]['catID'])
							echo '<input type="radio" name="alterContactDepartment" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
						else
							echo '<input type="radio" name="alterContactDepartment" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" checked="checked" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
						if($i == 3)
							echo '<br />';
					}	
					echo '		</fieldset>
							<label class="contactLabel" for="alterContactDescription"> Beschreibung</label> <textarea id="alterContactDescription" name="alterContactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)">'. $alterContact[0]['description'] .'</textarea>								
							<label class="contactLabel" for="alterContactContact"> Kontaktperson</label> <input type="text" id="alterContactContact" name="alterContactContact" value="'. $alterContact[0]['contact'].'" />
							<label class="contactLabel" for="alterContactPhone"> Telefon</label> <input type="text" id="alterContactPhone" name="alterContactPhone" value="'. $alterContact[0]['phone'].'" />
							<label class="contactLabel" for="alterContactFax"> Fax</label> <input type="text" id="alterContactFax" name="alterContactFax" value="'. $alterContact[0]['fax'].'" />
							<label class="contactLabel" for="alterContactMail"> E-Mail</label> <input type="text" id="alterContactMail" name="alterContactMail" value="'. $alterContact[0]['mail'].'" />
							<label class="contactLabel" for="alterContactRoom"> Raum</label> <input type="text" id="alterContactRoom" name="alterContactRoom" value="'. $alterContact[0]['room'].'" />
							<label class="contactLabel" for="alterContactAddress"> Adresse</label> <input type="text" id="alterContactAddress" name="alterContactAddress" value="'. $alterContact[0]['address'].'" />
							<label class="contactLabel" for="alterContactOfficeHours"> Büro-Offnungszeiten</label> <input type="text" id="alterContactOfficeHours" name="alterContactOfficeHours" value="'. $alterContact[0]['office_hours'].'" />
							<label class="contactLabel" for="alterContactPhoneOfficeHours"> Telefonische Sprechzeiten</label> <input type="text" id="alterContactPhoneOfficeHours" name="alterContactPhoneOfficeHours" value="'. $alterContact[0]['phone_office_hours'].'" />
							<input type="submit" name="alterContactSubmit" value="Daten ändern" id="alterContactBtn" />
					';

					echo'	</form>
						</div>';

					}
					if(isset($_POST['alterContactSubmit'])){
						$controller->c_alterContact($value['contactID']);
					}
			?>
			<!-- Section for adding new contacts -->
			<button id="addContactButton" onclick="showAddContact()" style="margin-bottom: 20px;" >Neuen Kontakt hinzufügen</button>
			<div id="addContact" style="visibility : hidden; height: 0px;">
				<form name="contactForm" method="post" action="#" id="contactForm">
					<label class="contactLabel">Titel des Kontakts </label><input type="text" name="contactTitle" placeholder="z.B.: Zulassungsstelle" /> 
					<fieldset>
						<label class="contactLabel">Kategorie</label> <br />
							<?php 
								//getting the categories from the db
								$categories = $controller->c_getCategories();
								//creating a radiobutton for every category. Value is set to match the ID
								for ($i = 0; $i < count($categories); $i++) {
									echo '<input type="radio" name="contactCategory" class="radioInput" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								}
							?>
					</fieldset>
					<fieldset>	
						<label class="contactLabel">Fachbereich</label> <br />
							<?php 
								//getting the departments from the db
								$departments = $controller->c_getDepartments();
								//creating a radiobutton for every department. Value is matching the ID
								for ($i = 0; $i < count($departments); $i++) {
									echo '<input type="radio" name="contactDepartment" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
									if($i == 3)
										echo '<br />';
								}
							?>
					</fieldset>	
					<label class="contactLabel"> Beschreibung</label> <textarea name="contactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen"></textarea> 
					<label class="contactLabel"> Kontaktperson </label> <input type="text" name="contactContact" id="test" placeholder="Max Mustermann" /> 
					<label class="contactLabel"> Telefon </label> <input type="text" name="contactPhonenumber" placeholder="0211-123456" /> 
					<label class="contactLabel"> Fax </label> <input type="text" name="contactFaxnumber" placeholder="0211-123456" />
					<label class="contactLabel"> E-Mail </label> <input type="text" name="contactMail" placeholder="max.mustermann@fh-duesseldorf.de" />
					<label class="contactLabel"> Raum </label> <input type="text" name="contactRoom" placeholder="z.B.: H 1.5" />
					<label class="contactLabel"> Adresse </label>  <textarea name="contactAdress" cols="50" rows="3" placeholder="Falls vom Hauptgebäude abweichend"></textarea> 
					<label class="contactLabel"> Büro - Öffnungszeiten </label> <textarea name="contactOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> 
					<label class="contactLabel"> Telefonische Sprechzeiten </label> <textarea name="contactPhoneOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> 
					<input type="submit" name="contactSubmit" value="Daten abschicken" id="addContactBtn" />
				</form>
			</div>
			<!-- End add contact -->
		</div>
		<!-- End of content-->
		<div class="clear"></div>
		</div>
	</div>
	<!-- End of wrapper -->
	<div id="footer"></div>
</body>
</html>
=======
<?php

// TODO: Campus berücksichtigen beim Einfügen / Ändern
// TODO: Allgemeinen Fachbereich berücksichtigen und in neuer Zwischentabelle eintragen


    //header einbinden
    require_once '../../layout/backend/header.php';
    
	//create new Controller Object
	require_once '../../controllers/kontakteController.php';
	$controller = new kontakteController();

	//check if the addContact-submit button has been pressed
	if(isset($_POST['contactSubmit'])){
		//call function to submit the typed values
		$controller->c_insertContact();
	}
	if(isset($_POST['alterContactSubmit'])){
		$controller->c_alterContact($_POST);
	}
	if(isset($_POST['deleteContact'])){
		$controller->c_deleteContact($_POST);
	}				
?>
		<script type="text/javascript">
				/**
				*	Gets called when the "add new contact" button is pressed
				*/
				function showAddContact(){

					//show the div if the button has not been pressed
					if(($('#addContact').css('visibility') === "hidden")){
						$('#addContact').css('visibility', 'visible');
						$('#addContact').css('height', '100%');
						$('#addContactButton').html('Verbergen');
					}
					// hide it otherwise 
					else {
						$('#addContact').css('visibility', 'hidden');
						$('#addContact').css('height', '0px');
						$('#addContactButton').html('Neuen Kontakt hinzufügen');			
					}
				}
			</script>
			<style type="text/css">

				.confirmation{
					background-color: #76FF76;
					border: 2px solid #00B100;
					text-align: center;
					width: 100%;
					height: 30px;
					margin-bottom: 20px;
				}
				
				.confirmation p {
					padding-top: 7px;
				}
			</style>	

			<!-- List the existing data in a table and give the possibility to alter or delete it -->
			<div id="alterContact">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
		            <tr>
		                <th>Kontakttitel</th>
		                <th>Kategorie</th>
		                <th>Fachbereich</th>
		                <th>Bearbeiten</th>
		                <th>Löschen</th>
		            </tr>
				<?php 
					$contacts = $controller->c_getContacts();
					if($contacts != null)
						foreach ($contacts as $value) {
						echo '<form action="" method="post">';
						
							// function for the buttons!? 
							echo '<tr>
									<td>' . $value['title'] . '</td>
									<td>' . $value['catName'] . '</td>
									<td>' . $value['deptName'] . '</td>
									<td> <input type="hidden" name ="contactID" value="' . $value['contactID'] . '" /> <input type="hidden" name="deptID" value="' . $value['deptID'] . '" /><input type="submit" name="alterContact" value="Daten bearbeiten" /> </td>
									<td> <input type="submit" name="deleteContact" value="Kontakt löschen" onclick=\'return confirm("Möchten Sie diesen Kontakt wirklich löschen?")\' /></td>
								</tr>';
						echo '</form>';
						}
				?>
				</table>
			</div>
			<!-- End alter contacts -->
			<?php
					if(isset($_POST['alterContact'])){
						$alterContact = $controller->c_getContact($_POST);
						//getting the categories from the db
						$categories = $controller->c_getCategories();	
						//getting the departments from the db
						$departments = $controller->c_getDepartments();	

						echo '
							<div>
								<form name="alterContactForm" action="#" method="post">
									<label for="alterContactTitle">Titel des Kontakts</label> <input type="text" id="alterContactTitle" name="alterContactTitle" value="' .$alterContact[0]['title']. '" />
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
							// TODO: keine Radio, sondern Checkboxen, damit ein Kontakt direkt für mehrere FB eingetragen werden kann
							if($departments[$i]['id'] != $alterContact[0]['deptID'])
								echo '<input type="checkbox" name="alterContactDepartment" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
							else
								echo '<input type="checkbox" name="alterContactDepartment" class="radioInput" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" checked="checked" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
							if($i == 3)
								echo '<br />';
						}	
						echo '		</fieldset>
								<label class="contactLabel" for="alterContactDescription"> Beschreibung</label> <textarea id="alterContactDescription" name="alterContactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen)">'. $alterContact[0]['description'] .'</textarea>								
								<label class="contactLabel" for="alterContactContact"> Kontaktperson</label> <input type="text" id="alterContactContact" name="alterContactContact" value="'. $alterContact[0]['contact'].'" />
								<label class="contactLabel" for="alterContactPhone"> Telefon</label> <input type="text" id="alterContactPhone" name="alterContactPhone" value="'. $alterContact[0]['phone'].'" />
								<label class="contactLabel" for="alterContactFax"> Fax</label> <input type="text" id="alterContactFax" name="alterContactFax" value="'. $alterContact[0]['fax'].'" />
								<label class="contactLabel" for="alterContactMail"> E-Mail</label> <input type="text" id="alterContactMail" name="alterContactMail" value="'. $alterContact[0]['mail'].'" />
								<label class="contactLabel" for="alterContactRoom"> Raum</label> <input type="text" id="alterContactRoom" name="alterContactRoom" value="'. $alterContact[0]['room'].'" />
								<label class="contactLabel" for="alterContactAddress"> Adresse</label> <input type="text" id="alterContactAddress" name="alterContactAddress" value="'. $alterContact[0]['address'].'" />
								<label class="contactLabel" for="alterContactOfficeHours"> Büro-Offnungszeiten</label> <input type="text" id="alterContactOfficeHours" name="alterContactOfficeHours" value="'. $alterContact[0]['office_hours'].'" />
								<label class="contactLabel" for="alterContactPhoneOfficeHours"> Telefonische Sprechzeiten</label> <input type="text" id="alterContactPhoneOfficeHours" name="alterContactPhoneOfficeHours" value="'. $alterContact[0]['phone_office_hours'].'" />
								<input type="hidden" name="id" value="' . $alterContact[0]['contactID'] . ' " />
								<input type="hidden" name="deptID" value="' . $alterContact[0]['deptID'] . '" />
								<input type="submit" name="alterContactSubmit" value="Daten ändern" id="alterContactBtn" />
						';

						echo'	</form>
							</div>';

						}
			?>
			<!-- Section for adding new contacts -->

			<!-- TODO: Funktion ohne JavaScript realisieren -->
			<button id="addContactButton" onclick="showAddContact()" style="margin-bottom: 20px;" >Neuen Kontakt hinzufügen</button>
			<div id="addContact" style="visibility : hidden; height: 0px;">
				<form name="contactForm" method="post" action="#" id="contactForm">
					<label class="contactLabel">Titel des Kontakts </label><input type="text" name="contactTitle" placeholder="z.B.: Zulassungsstelle" /> 
					<fieldset>
						<label class="contactLabel">Kategorie</label> <br />
							<?php 
								//getting the categories from the db
								$categories = $controller->c_getCategories();
								//creating a radiobutton for every category. Value is set to match the ID
								for ($i = 0; $i < count($categories); $i++) {
									echo '<input type="radio" name="contactCategory" id="'. $categories[$i]['category'] .'" value="' . ($i + 1) . '" /><label class="radio" for="' . $categories[$i]['name'] . '">'.$categories[$i]['name'] . '</label>';
								}
							?>
					</fieldset>
					<fieldset>	
						<label class="contactLabel">Fachbereich</label> <br />
							<?php 
								//getting the departments from the db
								$departments = $controller->c_getDepartments();
								//creating a radiobutton for every department. Value is matching the ID
								for ($i = 0; $i < count($departments); $i++) {
									echo '<input type="checkbox" name="contactDepartment" value="' . ($i + 1) . '" id="' . $departments[$i]['name'] . '" /><label class="radio" for="' . $departments[$i]['name'] . '">'. $departments[$i]['name'] . '</label>';
									if($i == 3)
										echo '<br />';
								}
							?>
					</fieldset>	
					<label class="contactLabel"> Beschreibung</label> <textarea name="contactDescription" cols="50" rows="4" placeholder="Eine kurze Beschreibung zum Kontakt (max. 200 Zeichen"></textarea> 
					<label class="contactLabel"> Kontaktperson </label> <input type="text" name="contactContact" id="test" placeholder="Max Mustermann" /> 
					<label class="contactLabel"> Telefon </label> <input type="text" name="contactPhonenumber" placeholder="0211-123456" /> 
					<label class="contactLabel"> Fax </label> <input type="text" name="contactFaxnumber" placeholder="0211-123456" />
					<label class="contactLabel"> E-Mail </label> <input type="text" name="contactMail" placeholder="max.mustermann@fh-duesseldorf.de" />
					<label class="contactLabel"> Raum </label> <input type="text" name="contactRoom" placeholder="z.B.: H 1.5" />
					<label class="contactLabel"> Adresse </label>  <textarea name="contactAdress" cols="50" rows="3" placeholder="Falls vom Hauptgebäude abweichend"></textarea> 
					<label class="contactLabel"> Büro - Öffnungszeiten </label> <textarea name="contactOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> 
					<label class="contactLabel"> Telefonische Sprechzeiten </label> <textarea name="contactPhoneOfficehours" cols="50" rows="3" placeholder="z.B.: Mo - Fr: 09 - 18 Uhr"></textarea> 
					<input type="submit" name="contactSubmit" value="Daten abschicken" id="addContactBtn" />
				</form>
			</div>
			<!-- End add contact -->
<?php
	require_once '../../layout/backend/footer.php';
?>
>>>>>>> origin/daniel16.02
