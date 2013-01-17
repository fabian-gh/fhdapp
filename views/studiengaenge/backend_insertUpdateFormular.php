<!-- backend_insertUpdateFormular.php zum einfügen und bearbeiten eines Studiengangs mit Fehlerbehandlung -->


<script src="../../sources/customjs/studiengaenge.js" type="text/javascript"></script>	<!-- studiengange.js einbinden -->
<?php require_once '../../views/studiengaenge/backend_includeCLEditor.php'; //Includet die für den CLEditor notwendigen Sachen ?>	

<?php	
	//Ausgabe der Überschrift
	if(isset($_POST["editStudycourse_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
		echo "<script type=\"text/javascript\">$('#editDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen" markieren
		echo "<h3>Studiengang bearbeiten</h3>";	//Überschrift augeben
		}
	else{	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
		echo "<script type=\"text/javascript\">$('#insertUpdateStudycourse').attr('class', 'active');</script>";	//Link "einfügen" markieren
		echo "<h3>Neuen Studiengang einf&uuml;gen</h3>";		//Überschrift ausgeben
	}
	if(isset($error))
		echo "Bitte Fehler Korrigieren";
	echo "<br /><br />";
?>
	
	
<form id="insertUpdateStudycourse" method="post">	
	<div class="allFields">
	
	
		<!-- Dropdownmenü um die Abschlussbeschreibung anzuzeigen -->
		<div class="singleField">
			<label for="graduate_id">Abschlussbeschreibung: </label>
			<select name="graduate_id" id="graduate_id" tabindex=1 > 
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
			</select>
		</div>
		<br /><br />
		
		
		<!-- Namen des Studiengangs Bei Fehlerhafter Eingabe class="error" setzen-->
		<div class="singleField">
			<label for="name" <?php if(isset($error["name"])) echo"class=\"error\""; ?>>Name des Studiengangs: </label>
			<input name="name" id="name" type="text" size="40" maxlength="100" tabindex=2 value="<?php echo htmlspecialchars (@$_POST["name"]); ?>">
		</div>

		
		<br /><br />
		
		
		<!-- Dropdownmenü um den Fachbereich auszuwählen -->
		<div class="singleField">
			<label for="department_id">Fachbereich: </label>
			<select name="department_id" id="department_id" tabindex=3> 
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
		</div>
		
		
		<br /><br />
		
		
		<!-- Eingabe Semesteranzahl  Bei Fehlerhafter Eingabe class="error" setzen-->
		<div class="singleField">
			<label for="semestercount" <?php if(isset($error["semestercount"])) echo"class=\"error\""; ?>>Semesteranzahl: </label>
			<input type="text" name="semestercount" id="semestercount" size="1" maxlength="2" value="<?php echo @$_POST["semestercount"]; ?>" tabindex=4>
		</div>
		
		
		<br /><br />
		
		
		<!-- Checkbox für Dualer Studiengang -->
		<div class="singleField">
			<label for="dual">Dualer Studiengang </label>
			<input type="checkbox" <?php if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> name="dual" id="dual" value=5 tabindex=5>	<!-- value je nach Datenbank -->
		</div>
		
		
		<br /><br />
		
		
		<!-- Ausgabe der Radiobuttons "Vollzeit" und "Teilzeit" Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">
			<label <?php if(isset($error["vollTeil"])) echo"class=\"error\""; ?>>Vollzeit / Teilzeit: </label><br />
			<input type="radio" name="vollTeil" id="vollzeit" <?php if(@$_POST["vollTeil"]==4) echo "checked=\"checked\""; ?> value=4 tabindex=6>
			<label for="vollzeit">Vollzeit </label><br />
			<input type="radio" name="vollTeil" id="teilzeit" <?php if(@$_POST["vollTeil"]==3) echo "checked=\"checked\""; ?> value=3 tabindex=6>
			<label for="teilzeit">Teilzeit </label><br />
		</div>
		
		
		<br /><br />
		
		
		<!-- Checkbox für Kategorien -->
		<div class="singleField">
			<label>Kategorien: </label><br />
			<input type="checkbox" id="ingenieurwissenschaftlich" name="ingenieurwissenschaftlich" <?php if(isset($_POST["ingenieurwissenschaftlich"])) echo "checked=\"checked\""; ?> value=6 tabindex=7>	<!-- value je nach Datenbank -->
			<label for="ingenieurwissenschaftlich">ingenieurwissenschaftlich</label><br />
			<input type="checkbox" id="gestalterisch" name="gestalterisch" <?php if(isset($_POST["gestalterisch"])) echo "checked=\"checked\""; ?> value=7 tabindex=8>	<!-- value je nach Datenbank -->
			<label for="gestalterisch">gestalterisch</label><br />
			<input type="checkbox" id="gesellschaftlich" name="gesellschaftlich" <?php if(isset($_POST["gesellschaftlich"])) echo "checked=\"checked\""; ?> value=8 tabindex=9>	<!-- value je nach Datenbank -->
			<label for="gesellschaftlich">gesellschaftlich</label><br />
			<input type="checkbox" id="wirtschaftlich" name="wirtschaftlich" <?php if(isset($_POST["wirtschaftlich"])) echo "checked=\"checked\""; ?> value=9 tabindex=10>	<!-- value je nach Datenbank -->
			<label for="wirtschaftlich">wirtschaftlich</label><br />
		</div>
		
		
		<br /><br />
			
		
		<!-- Textarea CLEditor - Eingabe Studiengangbeshreibung Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">
			<span <?php if(isset($error["description"])) echo"class=\"error\""; ?>>Beschreibung des Studiengangs: </span>
			<textarea name="description" id="description" tabindex=11><?php echo @$_POST["description"]; ?></textarea>
		</div>
		
		
		<br /><br />
		
		
		<!-- Sprachauswahl -->
		<div class="singleField">
			<label for="language_id">Geschrieben in: </label>
			<select name="language_id" id="language_id" tabindex=12 > 
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
		</div>
		
		
		<br /><br />
		
		<!-- Eingabefeld Link für weitere Informationen Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">
			<label for="link" <?php if(isset($error["link"])) echo"class=\"error\""; ?>>Link f&uuml;r weitere Informationen: </label>
			<input name="link" id="link" type="text" size="60" value="<?php echo @$_POST["link"]; ?>" tabindex=13>		
		</div>
		
		
		<br /><br />
		
		
		<?php
			if(isset($_POST["editStudycourse_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
				//Bearbeiten-Button
				echo "<input name=\"editStudycourseConfirm_btn\" type=\"submit\" value=\"&Auml;nderung best&auml;tigen\" class=\"button\" tabindex=14>";
				//hidden fields
				echo "<input type=\"hidden\" name=\"id\" value=".$_POST["id"].">";
				echo "<input type=\"hidden\" name=\"editStudycourse_btn\">";
			}
			else	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
				//Einfüge-Button
				echo "<input name=\"insertStudycourse_btn\" type=\"submit\" value=\"Studiengang einf&uuml;gen\" class=\"button\" tabindex=14>";	
		?>
	</div>
</form>

