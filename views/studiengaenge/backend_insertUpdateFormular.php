<!-- backend_insertUpdateFormular.php zum einfügen und bearbeiten eines Studiengangs mit Fehlerbehandlung -->

	<?php require_once '../../views/studiengaenge/backend_includeCLEditor.php'; //Includet die für den CLEditor notwendigen Sachen ?>	

	<?php	
		//Ausgabe der Überschrift
		if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			echo "<script type=\"text/javascript\">$('#liEditDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen" markieren
			echo "<h3>Studiengang bearbeiten</h3>";	//Überschrift augeben
		}
		else{
			echo "<script type=\"text/javascript\">$('#liInsertUpdateStudycourse').attr('class', 'active');</script>";	//Link "einfügen" markieren
			echo "<h3>Neuen Studiengang einf&uuml;gen</h3>";		//Überschrift ausgeben
		}
		
		if(!empty($error))
			echo "Bitte Fehler Korrigieren";
		
		$tabindex = 0;
	?>
	
	
<form method="post">	
	
	<div class="allFields">
		<!-- Dropdownmenü um die Abschlussbeschreibung anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="graduate_id">Abschlussbeschreibung: </label>
			</div>
			<div class="singleFieldValue">
				<select name="graduate_id" id="graduate_id" tabindex=<?php echo 1+$tabindex; ?>> 
				<?php
					$graduates = $studycoursesController->selectDropDownDataGraduates();	//alle graduates selektieren
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
		</div>		
		
		
		<div class="clear"></div>
		
		
		<!-- Namen des Studiengangs Bei Fehlerhafter Eingabe class="error" setzen-->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="name" <?php if(isset($error["name"])) echo"class=\"error\""; ?>>Name des Studiengangs: </label>
			</div>
			<div class="singleFieldValue">
				<input name="name" id="name" type="text" size="40" maxlength="100" tabindex=<?php echo 2+$tabindex; ?> value="<?php echo htmlspecialchars (@$_POST["name"]); ?>">
			</div>
		</div>
		
		
		<div class="clear"></div>
				
		
		<!-- Dropdownmenü um den Fachbereich auszuwählen -->
		<div class="singleField">
			<div class="singleFieldDescription"><label for="department_id">Fachbereich: </label></div>
			<div class="singleFieldValue">
				<select name="department_id" id="department_id" tabindex=<?php echo 3+$tabindex; ?>> 
				<?php
					$departments = $studycoursesController->selectDropDownDataDepartments();	//alle departments selektieren
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
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Eingabe Semesteranzahl  Bei Fehlerhafter Eingabe class="error" setzen-->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="semestercount" <?php if(isset($error["semestercount"])) echo"class=\"error\""; ?>>Semesteranzahl: </label>
			</div>
			<div class="singleFieldValue">
				<input type="text" name="semestercount" id="semestercount" size="1" maxlength="2" value="<?php echo @$_POST["semestercount"]; ?>" tabindex=<?php echo 4+$tabindex; ?>>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Checkbox für Dualer Studiengang -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label>Auch angeboten als: </label>
			</div>
			<div class="singleFieldValue">
				<input type="checkbox" <?php if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> name="dual" id="dual" tabindex=<?php echo 5+$tabindex; ?>>
				<label for="dual"> Dualer Studiengang</label>
				<br /><br />
				<input type="checkbox" name="teilzeit" id="teilzeit" <?php if(isset($_POST["teilzeit"])) echo "checked=\"checked\""; ?> tabindex=<?php echo 6+$tabindex; ?>>
				<label for="teilzeit"> Teilzeit Studiengang</label>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Checkbox für Kategorien -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label <?php if(isset($error["categories"])) echo"class=\"error\""; ?>>Kategorien: </label>
			</div>
			<div class="singleFieldValue">
				<?php
					$categories = $studycoursesController->selectCategories();	//alle kategorien selektieren
					foreach($categories AS $c){	//für jeden tupel 
						echo "<input type=\"checkbox\" id=\"".$c["name"]."\" name=\"".$c["name"]."\" value=".$c["id"]." tabindex=".(7+$tabindex)." style=\"margin: 2px 0px 2px 0px;\"";
						$tabindex += 1;
						if(isset($_POST[$c["name"]])) 
							echo " checked=\"checked\"";
						echo ">";
						echo "<label for=\"".$c["name"]."\"> ".$c["name"]."</label>";
						echo "<br />";
					}
					unset($categories);	//löscht $categories
				?>
			</div>
		</div>
		
		
		<div class="clear"></div>
			
		
		<!-- Textarea CLEditor - Eingabe Studiengangbeshreibung Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<span <?php if(isset($error["description"])) echo"class=\"error\""; ?>>Studiengangbeschreibung: </span>
			</div>
			<div class="singleFieldValue">
				<textarea name="description" id="description" tabindex=<?php echo 8+$tabindex; ?>><?php echo @$_POST["description"]; ?></textarea>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Sprachauswahl -->
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
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Eingabefeld Link für weitere Informationen Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="link" <?php if(isset($error["link"])) echo"class=\"error\""; ?>>Link f&uuml;r weitere Informationen: </label>
			</div>
			<div class="singleFieldValue">
				<input name="link" id="link" type="text" size="40" value="<?php echo @$_POST["link"]; ?>" tabindex=<?php echo 10+$tabindex;?>>		
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
	</div>	<!-- allFields -->
		
		
		
		
		
	<?php
		if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			//Bearbeiten-Button
			echo "<input name=\"editStudycourseConfirm_btn\" type=\"submit\" value=\"&Auml;nderung best&auml;tigen\"tabindex=".(11+$tabindex).">";
			//hidden fields
			echo "<input type=\"hidden\" name=\"id\" value=".$_POST["id"].">";
		}
		else	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			//Einfüge-Button
			echo "<input name=\"insertStudycourse_btn\" type=\"submit\" value=\"Studiengang einf&uuml;gen\" tabindex=".(11+$tabindex).">";	
	?>

</form>

