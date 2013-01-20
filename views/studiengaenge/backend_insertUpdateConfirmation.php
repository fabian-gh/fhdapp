<!-- Zeigt eine Bestätigung an, wenn ein neuer Studiengang eingefügt wurde oder ein bestehender Studiengang bearbeitet wurde -->
	
	
	<?php
		if(isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet wurde
			echo "<script type=\"text/javascript\">$('#editDeleteStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "Der Studiengang <i><b>".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".$_POST["name"]."</i></b> wurde erfolgreich bearbeitet</h3>";
		}
		else{	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			echo "<script type=\"text/javascript\">$('#insertUpdateStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "<h3>Folgender Studiengang wurde einf&uuml;gt</h3>";	
		}
	?>
	
	
	
	<!-- Abschlussbeschreiben des Studiengangs -->
	<label><p>Abschlussbeschreibung: <?php echo $studycoursesController->graduateIdToName($_POST["graduate_id"]); ?></p></label>
	<br />
	
	
	<!-- Name des Studiengangs -->
	<label><p>Name des Studiengangs: <?php echo $_POST["name"]; ?></p></label>
	<br />
	
	
	<!-- Fachbereich des Studiengangs -->
	<label><p>Fachbereich: <?php echo $studycoursesController->departmentIdToName($_POST["department_id"]); ?></p></label>
	<br />
	
	
	<!-- Semesteranzahl des Studiengangs -->
	<label><p>Semesteranzahl: <?php echo $_POST["semestercount"]; ?></p></label>
	<br />
	
	<!-- Zeigt ob der Studiengang dual ist oder nicht -->
	<label>
	<?php 
		if(isset($_POST["dual"]))
			echo "<p>Dualer Studiengang</p>";
		else
			echo "<p>Kein dualer Studiengang</p>";
		echo "<br />";
	?>
	</label>
	
	
	<!-- Zeigt ob der Studiengang Teilzeit ist oder Vollzeit -->
	<label>
	<?php
		if($_POST["vollTeil"]==4) //value je nach Datenbank 4=Vollzeit
			echo "<p>Vollzeit Studiengang </p>";
		else
			echo "<p>Teilzeit Studiengang </p>";
		echo "<br />";
	?>
	</label>
	
	<!-- Gibt die Kategorien aus, zudem der Studiengang zugeordnet wurde -->
	<label><p>Kategorien: </p>
	<?php
		if(isset($_POST["ingenieurwissenschaftlich"]))
			echo "<p>ingenieurwissenschaftlich</p>";
		if(isset($_POST["gestalterisch"]))
			echo "<p>gestalterisch</p>";
		if(isset($_POST["gesellschaftlich"]))
			echo "<p>gesellschaftlich</p>";
		if(isset($_POST["wirtschaftlich"]))
			echo "<p>wirtschaftlich</p>";
	?>
	</label>
	<br />
		
	
	<!-- Gibt die Beschreibung des Studiengangs aus -->
	<label><p>Beschreibung des Studiengangs: </p><?php echo $_POST["description"]; ?></label>
	<br />
	
	<!-- Zeigt in welcher Sprache der Studiengang geschrieben wurde -->
	<label><p>Geschrieben in: <?php echo $studycoursesController->languageIdToName($_POST["language_id"]); ?></p></label>
	<br />
	
	<!-- Zeigt den Link für weitere Informationen über den Studiengang an -->
	<label><p>Link f&uuml;r weitere Informationen: <a href="<?php echo $_POST["link"]; ?>"><?php echo $_POST["link"]; ?></a></p></label>
	<br />
	
	<!-- Buttons -->
	
	<?php
	// 1.Button
		//Für den Studiengang die Informationen holen,
		if(isset($_POST["insertStudycourse_btn"]))	//Wenn ein Studiengang eingefügt wurde
			$studycourse = $studycoursesController->selectStudicourse($lastStudiID);	//$lastStudiID vewenden
		else	//sonst
			$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//$_POST["id"] vewenden
		//Der "Diesen Studiengang bearbeiten" - Button
		echo "<form method=\"post\"><input type=\"submit\" value=\"Diesen Studiengang bearbeiten\" name=\"editStudycourse_btn\">";
		//die hidden-fields (für das post, zum bearbeiten) mit "ausgeben"
		echo "<input type=\"hidden\" name=\"id\" value=".$studycourse["id"]."><input type=\"hidden\" name=\"graduate_id\" value=\"".$studycourse["graduate_id"]."\"><input type=\"hidden\" name=\"graduate_name\" value=\"".$studycourse["graduate_name"]."\"><input type=\"hidden\" name=\"name\" value=\"".$studycourse["name"]."\"><input type=\"hidden\" name=\"department_id\" value=\"".$studycourse["department_id"]."\"><input type=\"hidden\" name=\"semestercount\" value=\"".$studycourse["semestercount"]."\"><input type=\"hidden\" name=\"description\" value=\"".htmlspecialchars($studycourse["description"])."\"><input type=\"hidden\" name=\"link\" value=\"".$studycourse["link"]."\"><input type=\"hidden\" name=\"language_id\" value=\"".$studycourse["language_id"]."\">";
		if(isset($studycourse["vollTeil"]))
			echo "<input type=\"hidden\" name=\"vollTeil\" value=\"".$studycourse["vollTeil"]."\">";
		if(isset($studycourse["dual"]))
			echo "<input type=\"hidden\" name=\"dual\" value=\"".$studycourse["dual"]."\">";
		if(isset($studycourse["ingenieurwissenschaftlich"]))
			echo "<input type=\"hidden\" name=\"ingenieurwissenschaftlich\" value=\"".$studycourse["ingenieurwissenschaftlich"]."\">";
		if(isset($studycourse["gestalterisch"]))
			echo "<input type=\"hidden\" name=\"gestalterisch\" value=\"".$studycourse["gestalterisch"]."\">";
		if(isset($studycourse["gesellschaftlich"]))
			echo "<input type=\"hidden\" name=\"gesellschaftlich\" value=\"".$studycourse["gesellschaftlich"]."\">";
		if(isset($studycourse["wirtschaftlich"]))
			echo "<input type=\"hidden\" name=\"wirtschaftlich\" value=\"".$studycourse["wirtschaftlich"]."\">";
		echo "</form>";
	
	// 2.Button 
		if(isset($_POST["editStudycourseConfirm_btn"]))	//Wenn ein Studiengang bearbeitet wurde
			//"Zurück zu den Studiengängen" - Button anzeigen
			echo "<a href=\"?page=Studiengaenge&action=bearbeitenLoeschen\"><input type=\"submit\" value=\"Alle Studieng&auml;nge anzeigen\"></a>";
		else	//sonst (Wenn ein neuer Studiengang eingefügt wurde)
			//"Weiteren Studiengang einfügen" - Button anzeigen
			echo "<a href=\"?page=Studiengaenge&action=einfuegen\"><input type=\"submit\" value=\"Weiteren Studiengang einf&uuml;gen\"></a>";
	?>
	
	<br />