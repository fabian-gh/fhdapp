<!-- backend_insertUpdateFormular.php zum einfügen und bearbeiten eines Studiengangs mit Fehlerbehandlung -->


	<script src="../../sources/customjs/studiengaenge.js" type="text/javascript"></script>	<!-- studiengange.js einbinden -->
	<?php require_once '../../views/studiengaenge/backend_includeCLEditor.php'; //Includet die für den CLEditor notwendigen Sachen ?>	

	<?php	
		//Ausgabe der Überschrift
		if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			echo "<script type=\"text/javascript\">$('#editDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen" markieren
			echo "<h3>Studiengang bearbeiten</h3>";	//Überschrift augeben
		}
		else{
			echo "<script type=\"text/javascript\">$('#insertUpdateStudycourse').attr('class', 'active');</script>";	//Link "einfügen" markieren
			echo "<h3>Neuen Studiengang einf&uuml;gen</h3>";		//Überschrift ausgeben
		}
		
		if(!empty($error))
			echo "Bitte Fehler Korrigieren";
		
		$tabindex = 1;
	?>
	
	
<form id="insertUpdateStudycourse" method="post">	
	
	<div class="allFields">
		<!-- Dropdownmenü um die Abschlussbeschreibung anzuzeigen -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="graduate_id">Abschlussbeschreibung: </label>
			</div>
			<div class="singleFieldValue">
				<select name="graduate_id" id="graduate_id" tabindex=<?php echo $tabindex; ?>> 
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
				<input name="name" id="name" type="text" size="40" maxlength="100" tabindex=<?php echo $tabindex+1; ?> value="<?php echo htmlspecialchars (@$_POST["name"]); ?>">
			</div>
		</div>
		
		
		<div class="clear"></div>
				
		
		<!-- Dropdownmenü um den Fachbereich auszuwählen -->
		<div class="singleField">
			<div class="singleFieldDescription"><label for="department_id">Fachbereich: </label></div>
			<div class="singleFieldValue">
				<select name="department_id" id="department_id" tabindex=<?php echo $tabindex+2; ?>> 
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
				<input type="text" name="semestercount" id="semestercount" size="1" maxlength="2" value="<?php echo @$_POST["semestercount"]; ?>" tabindex=<?php echo $tabindex+3; ?>>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Checkbox für Dualer Studiengang -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="dual">Dualer Studiengang </label>
			</div>
			<div class="singleFieldValue">
				<input type="checkbox" <?php if(isset($_POST["dual"])) echo "checked=\"checked\""; ?> name="dual" id="dual" value=5 tabindex=<?php echo $tabindex+4; ?>>	<!-- value je nach Datenbank -->
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Ausgabe der Radiobuttons "Vollzeit" und "Teilzeit" Bei Fehlerhafter Eingabe class="error" setzen -->
		<div class="singleField">		
			<div class="singleFieldDescription">
				<label <?php if(isset($error["vollTeil"])) echo"class=\"error\""; ?>>Vollzeit / Teilzeit: </label>
			</div>
			<div class="singleFieldValue">
				<input type="radio" name="vollTeil" id="vollzeit" <?php if(@$_POST["vollTeil"]==4) echo "checked=\"checked\""; ?> value=4 tabindex=<?php echo $tabindex+5; ?>>
				<label for="vollzeit">Vollzeit </label><br />
				<input type="radio" name="vollTeil" id="teilzeit" <?php if(@$_POST["vollTeil"]==3) echo "checked=\"checked\""; ?> value=3 tabindex=<?php echo $tabindex+6; ?>>
				<label for="teilzeit">Teilzeit </label>
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
						echo "<input type=\"checkbox\" id=\"".$c["name"]."\" name=\"".$c["name"]."\" value=".$c["id"]." tabindex=".($tabindex+7)." style=\"margin: 2px 0px 2px 0px;\"";
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
				<textarea name="description" id="description" tabindex=<?php echo $tabindex+8; ?>><?php echo @$_POST["description"]; ?></textarea>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Sprachauswahl -->
		<div class="singleField">
			<div class="singleFieldDescription">
				<label for="language_id">Geschrieben in: </label>
			</div>
			<div class="singleFieldValue">
				<select name="language_id" id="language_id" tabindex=<?php echo $tabindex+9; ?> > 
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
				<input name="link" id="link" type="text" size="40" value="<?php echo @$_POST["link"]; ?>" tabindex=<?php echo $tabindex+10;?>>		
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
	</div>	<!-- allFields -->
		
		
		
		
		
	<?php
		if(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet werden soll
			//Bearbeiten-Button
			echo "<input name=\"editStudycourseConfirm_btn\" type=\"submit\" value=\"&Auml;nderung best&auml;tigen\" class=\"button\" tabindex=".($tabindex+11).">";
			//hidden fields
			echo "<input type=\"hidden\" name=\"id\" value=".$_POST["id"].">";
			//echo "<input type=\"hidden\" name=\"editStudycourse_btn\">";
		}
		else	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			//Einfüge-Button
			echo "<input name=\"insertStudycourse_btn\" type=\"submit\" value=\"Studiengang einf&uuml;gen\" class=\"button\" tabindex=".($tabindex+11).">";	
	?>

</form>

