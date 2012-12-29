<!-- backend_insertFormular.php zum einf?gen eines Studiengangs mit Fehlerbehandlung -->

<form method="post">
	<h3>Neuen Studiengang einf&uuml;gen</h3>
	
	<!-- Dropdownmenü um die Abschlussbeschreibung auszuwählen -->
	<p>Abschlussbeschreibung: </p>
	<select name="graduate_id" tabindex=1 > 
	<?php
		$graduates = $studycoursesController->selectDropDownData("graduates");	//alle graduates selektieren
		foreach($graduates AS $g){	//für jeden tupel 
			echo "<option ";	//eine option einf?gen - anfang
			if($g["id"] == @$_POST["graduate_id"]){	//F?r eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$g["id"].">".$g["name"]."</option>";	//eine option einf?gen - ende
		}
		unset($graduates);	//löscht $graduates
	?>
	</select>
	</br>
	
	
	<!-- Eingabe vom Namen des Studiengangs -->
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Name: ") f?r das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge get?tig wurde. 
		//style class=error => Die Ausgabe ("Name: ") wird fett und rot
		echo "<p "; 
		if(isset($error["name"])){
			echo "class=\"error\""; 
		}
		echo ">Name des Studiengangs: </p>" 
	?>
	<input name="name" type="text" size="40" maxlength="100" tabindex=2 value=<?php echo @$_POST["name"]; ?>>
	</br>
	
	
	<!-- Dropdownmenü um den Fachbereich auszuwählen -->
	<p>Fachbereich: </p>
	<select name="department_id" tabindex=3> 
	<?php
		$departments = $studycoursesController->selectDropDownData("departments");	//alle departments selektieren
		foreach($departments AS $d){	//f?r jeden tupel 
			echo "<option ";	//eine option einf?gen - anfang
			if($d["id"] == @$_POST["department_id"]){	//F?r eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$d["id"].">".$d["name"]."</option>";	//eine option einf?gen - ende
		}
		unset($departments);	//l?scht $departments
	?>
	</select>
	</br>
	
	
	<!-- Eingabe Semesteranzahl -->
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Semesteranzahl: ") f?r das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge get?tig wurde. 
		//style class=error => Die Ausgabe ("Semesteranzahl: ") wird fett und rot
		echo "<p "; 
		if(isset($error["semestercount"])){
			echo "class=\"error\""; 
		}
		echo ">Semesteranzahl: </p>" 
	?>
	<input type="text" name="semestercount" size="1" maxlength="2" tabindex=4 value=<?php echo @$_POST["semestercount"]; ?>>
	</br></br>
	
	<!-- Checkbox für Dualer Studiengang -->
	<input type="checkbox" <?php if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> name="dual" value=5 id=5 tabindex=5> <label for=5 > Dualer Studiengang</label><br>	<!-- value je nach Datenbank -->
	<br/>
	
	<!-- Ausgabe der Radiobuttons "Vollzeit" und "Teilzeit" -->
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Vollzeit / Teilzeit: ") f?r das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge get?tig wurde. 
		//style class=error => Die Ausgabe ("Vollzeit / Teilzeit: ") wird fett und rot
		echo "<p "; 
		if(isset($error["vollTeil"])){
			echo "class=\"error\"";
		}
		echo ">Vollzeit / Teilzeit: </p>"; 
		
		//Wenn kein Radiobutton gew?hlt ist, dann die Radiobuttons ohne Vorselektion auusgeben
		if(!isset($_POST["vollTeil"])){
			echo "<input type=\"radio\" name=\"vollTeil\" value=4 id=4 tabindex=6> <label for=4 >Vollzeit</label><br>";	//value je nach Datenbank
			echo "<input type=\"radio\" name=\"vollTeil\" value=3 id=3 tabindex=6> <label for=3 >Teilzeit</label><br>";	//value je nach Datenbank
		}
		else{	//sonst Radiobuttons ausgeben und eins vorselektieren
			echo "<input type=\"radio\" ";
				if(@$_POST["vollTeil"]==4) //Wenn "Vollzeit" gew?hlt ist
					echo "checked=\"checked\" ";	//Dann checked="checked"
				echo "name=\"vollTeil\" value=4 id=4 tabindex=6> <label for=4 >Vollzeit</label><br>";	//value je nach Datenbank
			echo "<input type=\"radio\" ";
				if(@$_POST["vollTeil"]==3) //Wenn "Teilzeit" gew?hlt ist
					echo "checked=\"checked\" "; 	//Dann checked="checked"
				echo "name=\"vollTeil\" value=3 id=3 tabindex=6> <label for=3 >Teilzeit</label><br>";	//value je nach Datenbank
		}
	?>
	<br/>
	
	<!-- Checkbox für Kategorien -->
	<p>Kategorien: </p>
	<input type="checkbox" <?php if(isset($_POST["ingenieurwissenschaftlich"])) echo "checked=\"checked\""; ?> name="ingenieurwissenschaftlich" value=6 id=6 tabindex=7> <label for=6 >ingenieurwissenschaftlich</label><br>			<!-- value je nach Datenbank -->
	<input type="checkbox" <?php if(isset($_POST["gestalterisch"])) echo "checked=\"checked\""; ?> name="gestalterisch" value=7 id=7 tabindex=8> <label for=7 >gestalterisch</label><br>			<!-- value je nach Datenbank -->
	<input type="checkbox" <?php if(isset($_POST["gesellschaftlich"])) echo "checked=\"checked\""; ?> name="gesellschaftlich" value=8 id=8 tabindex=9> <label for=8 >gesellschaftlich</label> <br>			<!-- value je nach Datenbank -->
	<input type="checkbox" <?php if(isset($_POST["wirtschaftlich"])) echo "checked=\"checked\""; ?> name="wirtschaftlich" value=9 id=9 tabindex=10> <label for=9 >wirtschaftlich</label> <br>			<!-- value je nach Datenbank -->
	<br/>
		
	
	<!-- Eingabe Studiengangbeshreibung -->
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Beschreibung des Studiengangs: ") f?r das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge get?tig wurde. 
		//style class=error => Die Ausgabe ("Beschreibung des Studiengangs: ") wird fett und rot
		echo "<p "; 
		if(isset($error["description"])){
			echo "class=\"error\"";
		}
		echo ">Beschreibung des Studiengangs: </p>"; 
	?>
	<textarea name="description" cols="45" rows="10" tabindex=11><?php echo @$_POST["description"]; ?></textarea>
	</br>
	
	<!-- Sprachauswahl -->
	<p>Geschrieben in: </p>
	<select name="language_id" tabindex=12 > 
	<?php
		$languages = $studycoursesController->selectDropDownData("languages");	//alle languages selektieren
		foreach($languages AS $l){	//f?r jeden tupel 
			echo "<option ";	//eine option einf?gen - anfang
			if($l["id"] == @$_POST["language_id"]){	//F?r eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$l["id"].">".$l["name"]."</option>";	//eine option einf?gen - ende
		}
		unset($languages);	//l?scht $languages
	?>
	</select>
	</br>
	
	<!-- Eingabefeld Link für weitere Informationen -->
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Link f?r weitere Informationen: ") f?r das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge get?tig wurde. 
		//style class=error => Die Ausgabe ("Link f?r weitere Informationen: ") wird fett und rot
		echo "<p "; 
		if(isset($error["link"])){
			echo "class=\"error\"";
		}
		echo ">Link f&uuml;r weitere Informationen: </p>"; 
	?>
	<input name="link" type="text" size="60" tabindex=13 value=<?php echo @$_POST["link"]; ?>>
	</br>
	
	<!-- Bestätigungs Button -->
	<input name="insertNewStudi_btn" type="submit" value="Einf&uuml;gen" style="width: 70px;" tabindex=14>
	</br>
	
</form>