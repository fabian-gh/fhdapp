<!-- backend_insertUpdateFormular.php zum einfügen und bearbeiten eines Studiengangs mit Fehlerbehandlung -->

	
<?php 

	require_once '../../views/studiengaenge/backend_CLEditor.php'; //Bindet die für den CLEditor notwendigen Sachen ein (siehe "backend_CLEditor.php") 

	
	//---- Ausgabe der Überschrift ----//
	if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
		echo "<script type=\"text/javascript\">$('#liEditDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen"(in der Navigation) aktivieren (rot markieren)
		echo "<h3>Studiengang bearbeiten</h3>";	//Überschrift augeben
	}
	else{	//Wenn ein Studiengang eingefügt werden soll
		echo "<script type=\"text/javascript\">$('#liInsertUpdateStudycourse').attr('class', 'active');</script>";	//Link "Einfügen"(in der Navigation) aktivieren (rot markieren)
		echo "<h3>Studiengang einf&uuml;gen</h3>";		//Überschrift ausgeben
	}
	
	
	//---- Ausgabe der Fehlerbenachrichtigung, falls eine fehlerhafte Eingabe vorliegt ----//
	if(!empty($error)){	//Wenn es eine fehlerhafte Eingabe gibt, als wenn die Variable "$error" nicht leer ist, sondern ein Assoziatives-Array mit den Namen der fehlerhaften Formular-Felder als Index ist
		?>
		<!-- Ausgabe des/der Fehler-Formualrs/Box -->
		<div class="errorBox">
			<p>Fehlerhafte Eingabe an der Stelle:</p>
			<ul>
				<?php
				if(isset($error["name"])) echo "<li> &quot;Name&quot; - <span>Es muss ein Name f&uuml;r den Studiengang angegeben sein</span></li>";	//Name fehlerhaft
				if(isset($error["semestercount"])) echo "<li> &quot;Semesteranzahl&quot; - <span>Die Semesteranzahl muss angegeben und eine Zahl sein</span></li>";	//Semesteranzahl fehlerhaft
				if(isset($error["angebotenAls"])) echo "<li> &quot;Wird angeboten als&quot; - <span>Es muss mindestens eine Auswahl getroffen sein</span></li>";	//mind. 1 Checkbox nicht angewählt
				if(isset($error["categories"])) echo "<li> &quot;Kategorien&quot; - <span>Es muss mindestens eine Kategorie ausgewählt sein</span></li>";	//mind. 1 Checkbox nicht angewählt
				if(isset($error["description"])) echo "<li> &quot;Studiengangsbeschreibung&quot; - <span>Studiengangsbeschreibung muss angegeben sein</span></li>";	//Beschreibung fehlerhaft
				if(isset($error["link"])) echo "<li> &quot;Link f&uuml;r weitere Informationen&quot; - <span>Link muss angeben sein</span></li>";	//link fehlerhaft
				?>
			</ul>
		</div>
		<?php
	}		
	
	$tabindex = 0;	//Dia Variable "$tabindex" ist für den tabindex der Formular-Felder, weil die Checkboxen für die Kategorien dynamisch geladen werden und somit der tabindex auch variabel sein muss
?>
	
	
<!---- Ausgabe des Formulars ---->
<form method="post">	
	<div class="allFields">
	
	
		<!--- Abschlussbeschreibung --- 
		Beschreibung "Abschlussbeschreibung: " und das Dropdownmenü um die Abschlussbeschreibung anzuzeigen. Werte werden dynamisch aus der Datenbank geladen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="graduate_id">Abschlussbeschreibung: </label>
			</div>
			<div class="singleFieldValue">
				<select name="graduate_id" id="graduate_id" tabindex=<?php echo 1+$tabindex; ?>> 
				<?php
					$graduates = $studycoursesController->selectDropDownDataGraduates();	//alle graduates selektieren
					foreach($graduates AS $g){	//für jeden abschlussbeschreibung 
						echo "<option ";	//eine Option in das Dropdown-Menü einfügen - START
						if($g["id"] == @$_POST["graduate_id"]){	//Vorauswahl
							echo "selected=\"selected\" ";
						}
						echo "value=".$g["id"].">".$g["name"]."</option>";	//eine option einfügen - END
					}
					unset($graduates);	//Löscht die Variable
				?>
				</select>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!--- Namen ---
		Beschreibung "Name: " und das Eingabefeld um den Namen es Studiengangs eingeben zu könne, bzw anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="name" <?php /*Fehlerbehandlung*/if(isset($error["name"])) echo"class=\"error\""; ?>>Name des Studiengangs: </label> 
			</div>
			<div class="singleFieldValue">
				<input name="name" id="name" type="text" size="36" maxlength="100" tabindex=<?php echo 2+$tabindex; ?> value="<?php /*Vorauswahl*/echo htmlspecialchars (@$_POST["name"]); ?>">
			</div>
		</div><div class="clear"></div>
				
		
		
		
		<!--- Fachbereich --- 
		Beschreibung "Fachbereich: " und das Dropdownmenü um die Fachbereiche anzuzeigen. Werte werden dynamisch aus der Datenbank geladen -->
		<div class="singleField">
			<div class="singleFieldDescription"><label for="department_id">Fachbereich: </label></div>
			<div class="singleFieldValue">
				<select name="department_id" id="department_id" tabindex=<?php echo 3+$tabindex; ?>> 
				<?php
					$departments = $studycoursesController->selectDropDownDataDepartments();	//alle departments selektieren
					foreach($departments AS $d){	//für jeden Fachbereich 
						echo "<option ";	//eine Option in das Dropdown-Menü einfügen - START
						if($d["id"] == @$_POST["department_id"]){	//Für die Vorauswahl
							echo "selected=\"selected\" ";
						}
						echo "value=".$d["id"].">".$d["name"]."</option>";	//eine option einfügen - END
					}
					unset($departments);	//Löscht die Variable
				?>
				</select>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!--- Semesteranzahl ---
		Beschreibung "Semesteranzahl: " und das Eingabefeld um die Semesteranzahl des Studiengangs eingeben zu können, bzw anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="semestercount" <?php /*Fehlerbehandlung*/if(isset($error["semestercount"])) echo"class=\"error\""; ?>>Semesteranzahl: </label>
			</div>
			<div class="singleFieldValue">
				<input type="text" name="semestercount" id="semestercount" size="1" maxlength="2" value="<?php /*Vorauswahl*/echo @$_POST["semestercount"]; ?>" tabindex=<?php echo 4+$tabindex; ?>>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!--- Wird angeboten als --- 
		Beschreibung "Wird angeboten als: " und die dazugehöroigen Checkboxen "Vollzeit Studiengang", "Teilzeit Studiengang" und "Dualer Studiengang" ausgeben -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label <?php /*Fehlerbehandlung*/if(isset($error["angebotenAls"])) echo"class=\"error\""; ?>>Wird angeboten als: </label>
			</div>
			<div class="singleFieldValue">
				<input type="checkbox" name="vollzeit" id="vollzeit" <?php /*Vorauswahl*/if(isset($_POST["vollzeit"])) echo "checked=\"checked\""; ?> style="margin: 3px 0px 2px 0px;" tabindex=<?php echo 6+$tabindex; ?>>
				<label for="vollzeit"> Vollzeit Studiengang</label>
				<br />
				<input type="checkbox" name="teilzeit" id="teilzeit" <?php /*Vorauswahl*/if(isset($_POST["teilzeit"])) echo "checked=\"checked\""; ?> style="margin: 7px 0px 2px 0px;" tabindex=<?php echo 6+$tabindex; ?>>
				<label for="teilzeit"> Teilzeit Studiengang</label>
				<br />
				<input type="checkbox" name="dual" id="dual" <?php /*Vorauswahl*/if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> style="margin: 7px 0px 2px 0px;" tabindex=<?php echo 5+$tabindex; ?>>
				<label for="dual"> Dualer Studiengang</label>
				
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!--- Kategorien --- 
		Beschreibung "Kategorien: " und die dazugehöroigen Checkboxen, die dynmaisch aus der Datenbank geladen werden, ausgeben -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label <?php /*Fehlerbehandlung*/if(isset($error["categories"])) echo"class=\"error\""; ?>>Kategorien: </label>
			</div>
			<div class="singleFieldValue">
				<?php
					$categories = $studycoursesController->selectCategories();	//alle Kategorien selektieren
					foreach($categories AS $c){	//für jede Kategorie
						echo "<input type=\"checkbox\" id=\"".$c["name"]."\" name=\"".$c["name"]."\" value=".$c["id"]." tabindex=".(7+$tabindex)." style=\"margin: 4px 0px 2px 0px;\"";	//eine Checkbox ausgeben - START
						$tabindex += 1;	//"$tabindex" inkrementieren
						if(isset($_POST[$c["name"]])) 
							echo " checked=\"checked\"";	//Für die Vorauswahl
						echo ">";	//eine Checkbox ausgeben - ENDE
						echo "<label for=\"".$c["name"]."\"> ".$c["name"]."</label>";	//Label(mit Beschreibung) für die Checkbox ausgeben
						echo "<br />";
					}
					unset($categories);	//Löscht die Variable
				?>
			</div>
		</div><div class="clear"></div>
			
			
			
		
		<!--- Studiengangsbeschreibung --- 
		Beschreibung "Studiengangsbeschreibung: " und die dazugehöroige (modifizierte (durch den CLEditor)) Textarea ausgeben um eine Studiengangsbeschreibung einzugeben bzw. die Studiengangsbeschreibung anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<span <?php /*Fehlerbehandlung*/if(isset($error["description"])) echo"class=\"error\""; ?>>Studiengangsbeschreibung: </span>
			</div>
			<div class="singleFieldValue">
				<textarea name="description" id="description" tabindex=<?php echo 8+$tabindex; ?>><?php /*Vorauswahl*/echo @$_POST["description"]; ?></textarea>
			</div>
		</div><div class="clear"></div>
		
		
		
		
		<!--- Sprachauswahl --- 
		Beschreibung "Geschrieben in: " und das Dropdownmenü um die Sprachen anzuzeigen. Werte werden dynamisch aus der Datenbank geladen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="language_id">Geschrieben in: </label>
			</div>
			<div class="singleFieldValue">
				<select name="language_id" id="language_id" tabindex=<?php echo 9+$tabindex; ?> > 
				<?php
					$languages = $studycoursesController->selectDropDownDataLanguages();	//alle languages selektieren
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
		</div><div class="clear"></div>
		
		
		
		<!--- Link ---
		Beschreibung "Link für weitere Informationen: " und das Eingabefeld um den Link für weitere Informationen über den Studiengangs eingeben zu können, bzw anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="link" <?php /*Fehlerbehandlung*/if(isset($error["link"])) echo"class=\"error\""; ?>>Link f&uuml;r weitere Informationen: </label>
			</div>
			<div class="singleFieldValue">
				<input name="link" id="link" type="text" size="54" value="<?php echo /*Vorauswahl*/@$_POST["link"]; ?>" tabindex=<?php echo 10+$tabindex;?>>		
			</div>
		</div><div class="clear"></div>
		
		
		
			
	<!---- Ausgabe der Buttons ---->	
	<?php
		if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			echo "<input class=\"button\" name=\"editStudycourseConfirm_btn\" type=\"submit\" value=\"&Auml;nderung best&auml;tigen\"tabindex=".(11+$tabindex).">"; //"Änderung Bestätigen"-Button ausgeben
			echo "<input type=\"hidden\" name=\"id\" value=".$_POST["id"].">";	//hidden-Field um die ID mit zu übergeben, damit die Information(welcher Studiengang bearbeitet werden soll) nicht verloren geht
		}
		else	//Wenn ein neuer Studiengange eingefügt werden soll
			echo "<input class=\"button\" style=\"\" name=\"insertStudycourse_btn\" type=\"submit\" value=\"Studiengang einf&uuml;gen\" tabindex=".(11+$tabindex).">";	//"Studiengang einfügen"-Button ausgeben
		unset($tabindex);	//Variable löschen
	?>
	
	</div>	<!-- div mit class="allFields" schließen -->
</form>	<!-- formular schließen -->

