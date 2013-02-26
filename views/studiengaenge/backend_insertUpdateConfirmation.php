<?php
/**
*	Dateiname: "backend_insertUpdateConfirmation.php"
*	Zweck:	Diese Datei dient zur Anzeige des Bestätigungsformulares, wenn ein Studiengang neu eingefügt oder bearbeitet wurde.
*	Benutzt von: "backend_studiengaenge.php"
*	Autor Name: Okan Köse
*	Autor E-Mail: okan.koese@gmx.de	
**/
?>	
	
<?php

	//---- Ausgabe der Überschrift ----//
	if(isset($_POST["editStudycourseConfirm_btn"])){	///Wenn ein Studiengang erfolgreich bearbeitet wurde
		echo "<script type=\"text/javascript\">$('#liEditDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen"(in der Navigation) aktivieren (rot markieren)
		echo "<h3>Studiengang bearbeiten - Best&auml;tigung</h3>";	//Überschrift augeben
		echo "<p style=\"margin: 22px 0px 10px 0px;\">Der Studiengang <i><b>".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".$_POST["name"]."</i></b> wurde erfolgreich bearbeitet:</p>";	//bestätigung ausgeben
	}
	else{	//Wenn ein neuer Studiengange eingefügt wurde
		echo "<script type=\"text/javascript\">$('#liInsertUpdateStudycourse').attr('class', 'active');</script>";	//Link "Einfügen"(in der Navigation) aktivieren (rot markieren)
		echo "<h3>Studiengang einf&uuml;gen - Best&auml;tigung</h3>";	//Überschrift augeben
		echo "<p style=\"margin: 22px 0px 10px 0px;\">Studiengang <i><b>".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".$_POST["name"]."</b></i> wurde erfolgreich eingef&uuml;gt:<p>";	//Bestätigung ausgeben
	}
?>
	
	<!---- Ausgabe des Bestätigungsformulars ---->
	<div class="allFields">
	
		<!-- Abschlussbeschreiben des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Abschlussbeschreibung: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->graduateIdToName($_POST["graduate_id"]); ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Name des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Name des Studiengangs: </div>
			<div class="singleFieldValue">
				<?php echo $_POST["name"]; ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Fachbereich des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Fachbereich: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->departmentIdToName($_POST["department_id"]); ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Semesteranzahl des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Semesteranzahl: </div>
				<div class="singleFieldValue"><?php echo $_POST["semestercount"]; ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Zeigt als was der Studiengang angeboten wird -->
		<div class="singleField">
			<div class="singleFieldDescription">Wird angeboten als:</div>
			<div class="singleFieldValue"> 
				<?php
					if(isset($_POST["vollzeit"])){ //value je nach Datenbank 4=Vollzeit
						echo "<p style=\"margin: 2px 0px 2px 0px;\">Vollzeit Studiengang</p>";
					}
					if(isset($_POST["teilzeit"])){ //value je nach Datenbank 4=Vollzeit
						echo "<p>Teilzeit Studiengang</p>";
					}
					if(isset($_POST["dual"]))
						echo "<p style=\"margin-top: 2px;\">Dualer Studiengang</p>";
				?>
			</div> 
		</div><div class="clear"></div>
		
		
		
		
		<!-- Kategorien, zudem der Studiengang zugeordnet wurde -->
		<div class="singleField">
			<div class="singleFieldDescription">Kategorien: </div>
			<div class="singleFieldValue">
				<?php
					$categories = $studycoursesController->selectCategories();
					foreach($categories AS $c){	//für jeden tupel 
						if(isset($_POST[$c["name"]]))
							echo "<p style=\"margin-top: 2px;\">".$c["name"]."</p>";
					}
					unset($categories);
				?>
			</div>
		</div><div class="clear"></div>
		 
		 
		 
		 
		<!-- Beschreibung des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Studiengangsbeschreibung: </div>
				<div class="singleFieldValue"><?php echo strip_tags($_POST["description"], '<b><i>'); ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Zeigt in welcher Sprache der Studiengang geschrieben wurde -->
		<div class="singleField">
			<div class="singleFieldDescription">Geschrieben in: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->languageIdToName($_POST["language_id"]); ?>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!-- Link für weitere Informationen über den Studiengang -->
		<div class="singleField">
			<div class="singleFieldDescription">Link f&uuml;r weitere Informationen: </div>
			<div class="singleFieldValue">
				<a href="<?php echo htmlspecialchars($_POST["link"]); ?>"><?php echo $_POST["link"]; ?></a>
			</div>
		</div><div class="clear"></div>
		  
		  
		  
	
	<!---- Ausgabe Buttons ---->	
	<?php
	//-- Erster Button --    ->Der Bearbeiten Button (z.B. "Bachelor of Science Medieninformatik bearbeiten")
		if(isset($_POST["insertStudycourse_btn"]))	//Wenn ein Studiengang erfolgreich eingefügt wurde
			$studycourse = $studycoursesController->selectStudicourse($lastStudiID);	//Für den Studiengang die Informationen holen. "$lastStudiID" wurde abgespeichert, nachdem ein Studiengang mit der Methode "insertStudycourse" eingefügt wurde 
		else	//Wenn ein Studiengang bearbeitet wurde
			$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//Für den Studiengang die Informationen holen. "$_POST["id"]" existiert, weil ein bestimmter Studiengang(mit "$_POST["id"]") bearbeitet wird 
		echo "<form method=\"post\">";		//Formular für "xy bearbeiten" - ÖFFNEN
				echo "<input class=\"button\" style=\"min-width: 0px; float:right; max-height: 35px; padding: 7px 10px 15px 10px;\" type=\"submit\" value=\"".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".htmlspecialchars($_POST["name"])." bearbeiten\" name=\"editStudycourse_btn\">";	//Ausgabe des "xy bearbeiten" - Button
				echo "<input type=\"hidden\" name=\"id\" value=".$studycourse["id"].">";	//hidden-Field um die id zu übergeben
		echo "</form>";	//Formular für "xy bearbeiten" - SCHLIEßEN
		echo "<div class=\"clear\"></div>	

		
	</div>"; //div mit class="allFields" schließen 
	
	
	//-- Zweiter Button --	-->Der "Alle Studiengänge Anzeigen"-, oder "Einen weiteren Studiengang einfügen"-Button
		if(isset($_POST["editStudycourseConfirm_btn"]))	//Wenn ein Studiengang erfolgreich bearbeitet wurde
			//"Zurück zu den Studiengängen" - Button anzeigen:
			echo "<a href=\"?page=Studiengaenge&action=bearbeitenLoeschen\">
				<input class=\"studycourseButtons\" type=\"submit\" value=\"Alle Studieng&auml;nge anzeigen\">
			</a>";
		else	//Wenn ein neuer Studiengang eingefügt wurde
			//"Weiteren Studiengang einfügen" - Button anzeigen:
			echo "<a href=\"?page=Studiengaenge&action=einfuegen\">
				<input class=\"studycourseButtons\" type=\"submit\" value=\"Einen weiteren Studiengang einf&uuml;gen\">
			</a>";
	?>