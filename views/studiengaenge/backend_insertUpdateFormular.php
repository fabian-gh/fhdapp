<!-- backend_insertUpdateFormular.php zum einfügen und bearbeiten eines Studiengangs mit Fehlerbehandlung -->

<?php require_once '../../views/studiengaenge/backend_includeCLEditor.php'; //Includet die CLEditor notwendigen Sachen ?>	

<form method="post">
	<?php	
		if(isset($_POST["editStudycourse_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			echo "<script type=\"text/javascript\">$('#editDeleteStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "<h3>Studiengang bearbeiten</h3>";
			}
		else{	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			echo "<script type=\"text/javascript\">$('#insertUpdateStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "<h3>Neuen Studiengang einf&uuml;gen</h3>";	
		}
	?>
	
	<!-- Dropdownmenü um die Abschlussbeschreibung auszuwählen -->
	<label><span>Abschlussbeschreibung: </span>
	<select name="graduate_id" tabindex=1 > 
	<?php
		$graduates = $studycoursesController->selectDropDownData("graduates");	//alle graduates selektieren
		foreach($graduates AS $g){	//für jeden tupel 
			echo "<option ";	//eine option einfügen - anfang
			if($g["id"] == @$_POST["graduate_id"]){	//Für eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$g["id"].">".$g["name"]."</option>";	//eine option einfügen - ende
		}
		unset($graduates);	//löscht $graduates
	?>
	</select></label>
	<br /><br />
	
	
	<!-- Eingabe vom Namen des Studiengangs -->
	<label>
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Name: ") für das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge getütig wurde. 
		//style class=error => Die Ausgabe ("Name: ") wird fett und rot
		echo "<span "; 
		if(isset($error["name"])){
			echo "class=\"error\""; 
		}
		echo ">Name des Studiengangs: </span>";
	?>
	<input name="name" type="text" size="40" maxlength="100" tabindex=2 value="<?php echo htmlspecialchars (@$_POST["name"]); ?>">
	</label>
	<br /><br />
	
	
	<!-- Dropdownmenü um den Fachbereich auszuwählen -->
	<label>
	<span>Fachbereich: </span>
	<select name="department_id" tabindex=3> 
	<?php
		$departments = $studycoursesController->selectDropDownData("departments");	//alle departments selektieren
		foreach($departments AS $d){	//für jeden tupel 
			echo "<option ";	//eine option einfügen - anfang
			if($d["id"] == @$_POST["department_id"]){	//Für eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$d["id"].">".$d["name"]."</option>";	//eine option einfügen - ende
		}
		unset($departments);	//löscht $departments
	?>
	</select>
	</label>
	<br /><br />
	
	
	<!-- Eingabe Semesteranzahl -->
	<label>
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Semesteranzahl: ") für das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge getätig wurde. 
		//style class=error => Die Ausgabe ("Semesteranzahl: ") wird fett und rot
		echo "<span "; 
		if(isset($error["semestercount"])){
			echo "class=\"error\""; 
		}
		echo ">Semesteranzahl: </span>";
	?>
	<input type="text" name="semestercount" size="1" maxlength="2" tabindex=4 value="<?php echo @$_POST["semestercount"]; ?>">
	</label>
	<br /><br />
	
	<!-- Checkbox für Dualer Studiengang -->
	<label><input type="checkbox" <?php if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> name="dual" value=5 tabindex=5> Dualer Studiengang</label><br /><br />	<!-- value je nach Datenbank -->
	<br /><br />
	
	<!-- Ausgabe der Radiobuttons "Vollzeit" und "Teilzeit" -->
	<span id="vollTeil">Vollzeit / Teilzeit: </span><br />
	<label><input type="radio" name="vollTeil" <?php if(@$_POST["vollTeil"]==4) echo "checked=\"checked\""; ?> value=4 tabindex=6> Vollzeit</label><br />
	<label><input type="radio" name="vollTeil" <?php if(@$_POST["vollTeil"]==3) echo "checked=\"checked\""; ?> value=3 tabindex=6> Teilzeit</label><br />
	<br /><br />
	
	<!-- Checkbox für Kategorien -->
	<span>Kategorien: </span><br />
	<label><input type="checkbox" <?php if(isset($_POST["ingenieurwissenschaftlich"])) echo "checked=\"checked\""; ?> name="ingenieurwissenschaftlich" value=6 tabindex=7> ingenieurwissenschaftlich</label><br />			<!-- value je nach Datenbank -->
	<label><input type="checkbox" <?php if(isset($_POST["gestalterisch"])) echo "checked=\"checked\""; ?> name="gestalterisch" value=7 tabindex=8> gestalterisch</label><br />			<!-- value je nach Datenbank -->
	<label><input type="checkbox" <?php if(isset($_POST["gesellschaftlich"])) echo "checked=\"checked\""; ?> name="gesellschaftlich" value=8 tabindex=9> gesellschaftlich</label><br />			<!-- value je nach Datenbank -->
	<label><input type="checkbox" <?php if(isset($_POST["wirtschaftlich"])) echo "checked=\"checked\""; ?> name="wirtschaftlich" value=9 tabindex=10> wirtschaftlich</label><br />			<!-- value je nach Datenbank -->
	<br /><br />
		
	
	<!-- Textarea CLEditor - Eingabe Studiengangbeshreibung -->
	<label>
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Beschreibung des Studiengangs: ") für das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge getätig wurde. 
		//style class=error => Die Ausgabe ("Beschreibung des Studiengangs: ") wird fett und rot
		echo "<span "; 
		if(isset($error["description"])){
			echo "class=\"error\"";
		}
		echo ">Beschreibung des Studiengangs: </span>"; 
	?>
	<textarea name="description" id="description" name="studyDescription" tabindex=11><?php echo @$_POST["description"]; ?></textarea>
	</label>
	<br /><br />
	
	<!-- Sprachauswahl -->
	<label>
	<span>Geschrieben in: </span>
	<select name="language_id" tabindex=12 > 
	<?php
		$languages = $studycoursesController->selectDropDownData("languages");	//alle languages selektieren
		foreach($languages AS $l){	//für jeden tupel 
			echo "<option ";	//eine option einfügen - anfang
			if($l["id"] == @$_POST["language_id"]){	//Für eine Vorauswahl
				echo "selected=\"selected\" ";
			}
			echo "value=".$l["id"].">".$l["name"]."</option>";	//eine option einfügen - ende
		}
		unset($languages);	//löscht $languages
	?>
	</select>
	</label>
	<br /><br />
	
	<!-- Eingabefeld Link für weitere Informationen -->
	<label>
	<?php 
		//Dieser PHP-Block gibt die Beschreibung ("Link für weitere Informationen: ") für das darauf folgende <input> aus, 
		//wobei die Beschreibung die styleclass "error" bekommt,
		//wenn vorher eine fehlerhaft Eingabge getätig wurde. 
		//style class=error => Die Ausgabe ("Link für weitere Informationen: ") wird fett und rot
		echo "<span "; 
		if(isset($error["link"])){
			echo "class=\"error\"";
		}
		echo ">Link f&uuml;r weitere Informationen: </span>"; 
	?>
	<input name="link" type="text" size="60" tabindex=13 value="<?php echo @$_POST["link"]; ?>">
	</label>
	<br /><br />
	
	<?php
		if(isset($_POST["editStudycourse_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			//Bearbeiten-Button
			echo "<input name=\"editStudycourseConfirm_btn\" type=\"submit\" value=\"&Auml;nderung best&auml;tigen\" tabindex=14>";
			//hidden fields
			echo "<input type=\"hidden\" name=\"id\" value=".$_POST["id"].">";
			echo "<input type=\"hidden\" name=\"editStudycourse_btn\">";
		}
		else	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			//Einfüge-Button
			echo "<input name=\"insertStudycourse_btn\" type=\"submit\" value=\"Studiengang einf&uuml;gen\" tabindex=14>";	
	?>
</form>

<?php
	//Fehlerüberprüfung - Wenn fehlerhafte Eingaben existieren, der jenigen id die klasse error zuweisen, damit die schrift rot und fett wird
	if(isset($error["vollTeil"]))
		echo "<script type=\"text/javascript\">$('#vollTeil').attr('class', 'error');</script>";
?>



