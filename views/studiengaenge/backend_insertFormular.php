<form method="post">
	<h3>Neuen Studiengang einf&uuml;gen</h3>
	
	<!-- Dropdownmen� um die Abschlussbeschreibung auszuw�hlen -->
	<p>Abschlussbeschreibung: </p></br>
	

	<select name="graduate_id" tabindex=1 > 
	<?php
		$graduates = $studycoursesController->selectData("graduates");	//alle graduates selektieren
		foreach($graduates AS $g){	//f�r jeden tupel 
			echo "<option value=".$g["id"].">".$g["name"]."</option>";	//eine option einf�gen
		}
		unset($graduates);	//l�scht $graduates
	?>
	</select>
	</br>
	
	<!-- Eingabe vom Namen des Studiengangs -->
	<p>Name des Studiengangs: </p> 
	<input name="name" type="text" size="40" maxlength="100" tabindex=2>
	</br>
	
	<!-- Dropdownmen� um den Fachbereich auszuw�hlen -->
	<p>Fachbereich: </p>
	<select name="department_id" tabindex=3> 
	<?php
		$departments = $studycoursesController->selectData("departments");	//alle departments selektieren
		foreach($departments AS $g){	//f�r jeden tupel 
			echo "<option value=".$g["id"].">".$g["name"]."</option>";	//eine option einf�gen
		}
	?>
	</select>
	</br>
	
	<!-- Eingabe Semesteranzahl -->
	<p>Semesteranzahl: </p>
	<input type="text" name="semestercount" size="1" maxlength="2" tabindex=4>
	</br></br>
	
	<!-- Checkbox f�r Dualer Studiengang -->
	<input type="checkbox" name="dual" value=5 id=5 tabindex=5> <label for=5 > Duales Studium</label><br>			<!-- value je nach Datenbank -->
	<br/>
	
	<!-- Radiobuttons -->
	<p>Vollzeit / Teilzeit: </p>
	<input type="radio" name="vollTeil" value=4 id=4 tabindex=6> <label for=4 >Vollzeit</label><br>	<!-- value je nach Datenbank -->
	<input type="radio" name="vollTeil" value=3 id=3 tabindex=6> <label for=3 >Teilzeit</label><br>	<!-- value je nach Datenbank -->
	<br/>
	
	<!-- Checkbox f�r Kategorien -->
	<p>Kategorien: </p>
	<input type="checkbox" name="ingenieurwissenschaftlich" value=6 id=6 tabindex=7> <label for=6 >ingenieurwissenschaftlich</label><br>			<!-- value je nach Datenbank -->
	<input type="checkbox" name="gestalterisch" value=7 id=7 tabindex=8> <label for=7 >gestalterisch</label><br>			<!-- value je nach Datenbank -->
	<input type="checkbox" name="gesellschaftlich" value=8 id=8 tabindex=9> <label for=8 >gesellschaftlich</label> <br>			<!-- value je nach Datenbank -->
	<input type="checkbox" name="wirtschaftlich" value=9 id=9 tabindex=10> <label for=9 >wirtschaftlich</label> <br>			<!-- value je nach Datenbank -->
	<br/>
		
	
	<!-- Eingabe Studiengangbeshreibung -->
	<p>Beschreibung des Studiengangs: </p></br>
	<textarea name="description" cols="45" rows="10" tabindex=11></textarea>
	</br>
	
	<!-- Sprachauswahl -->
	<p>Geschrieben in: </p>
	<select name="language_id" tabindex=12 > 
	<?php
		$languages = $studycoursesController->selectData("languages");	//alle languages selektieren
		foreach($languages AS $g){	//f�r jeden tupel 
			echo "<option value=".$g["id"].">".$g["name"]."</option>";	//eine option einf�gen
		}
	?>
	</select>
	</br>
	
	<!-- Eingabefeld Link f�r weitere Informationen -->
	<p>Link f&uuml;r weitere Informationen: </p>
	<input name="link" type="text" size="60" tabindex=13>
	</br>
	
	<!-- Best�tigungs Button -->
	<input name="insertNewStudi" type="submit" value="Einf&uuml;gen" style="width: 70px;" tabindex=14>
	</br>
	
	
</form>