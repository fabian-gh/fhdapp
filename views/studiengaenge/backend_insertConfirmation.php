<!-- Bestätigung Einfügen Studiengang -->

	<h3>Folgender Studiengang wurde einf&uuml;gt</h3>
	
	<!--  -->
	<p>Abschlussbeschreibung: <?php echo $studycoursesController->graduateIdToName($_POST["graduate_id"]); ?></p>
	</br>
	
	
	<!--  -->
	<p>Name des Studiengangs: <?php echo $_POST["name"]; ?></p>
	</br>
	
	
	<!--  -->
	<p>Fachbereich: <?php echo $studycoursesController->departmentIdToName($_POST["department_id"]); ?></p>
	</br>
	
	
	<!--  -->
	<p>Semesteranzahl: <?php echo $_POST["semestercount"]; ?></p>
	</br>
	
	<!--  -->
	<p>Dualer Studiengang</p>
	<br/>
	
	<!--  -->
	<p>Vollzeit: </p>
	<p>Teilzeit: </p>
	<br/>
	
	<!--  -->
	<p>Kategorien: </p>
	<br/>
		
	
	<!--  -->
	<p>Beschreibung des Studiengangs: <?php echo $_POST["description"]; ?></p> 
	</br>
	
	<!--  -->
	<p>Geschrieben in: <?php echo $studycoursesController->languageIdToName($_POST["language_id"]); ?></p>
	</br>
	
	<!--  -->
	<p>Link f&uuml;r weitere Informationen: <?php echo $_POST["link"]; ?></p>
	</br>
	
	<!--  -->
	<input type="submit" value="Diesen Studiengang bearbeiten">
	<a href="cms.php?page=Studiengaenge&action=einfuegen"><input type="submit" value="Weiteren Studiengang einf&uuml;gen"></a>
	</br>