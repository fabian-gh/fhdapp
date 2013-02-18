<!-- Zeigt eine Bestätigung an, wenn ein neuer Studiengang eingefügt wurde oder ein bestehender Studiengang bearbeitet wurde -->
	
	
	<?php
		if(isset($_POST["editStudycourseConfirm_btn"])){	//Wenn ein Studiengang bearbeitet wurde
			echo "<script type=\"text/javascript\">$('#liEditDeleteStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "Der Studiengang <i><b>".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".$_POST["name"]."</i></b> wurde erfolgreich bearbeitet</h3>";
		}
		else{	//sonst (Wenn ein neuer Studiengange eingefügt werden soll)
			echo "<script type=\"text/javascript\">$('#liInsertUpdateStudycourse').attr('class', 'active');</script>";	//Link markieren
			echo "<h3>Folgender Studiengang wurde eingef&uuml;gt</h3>";	
		}
	?>
	
	<div class="allFields">
	
	
		<!-- Abschlussbeschreiben des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Abschlussbeschreibung: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->graduateIdToName($_POST["graduate_id"]); ?>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Name des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Name des Studiengangs: </div>
			<div class="singleFieldValue">
				<?php echo $_POST["name"]; ?>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Fachbereich des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Fachbereich: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->departmentIdToName($_POST["department_id"]); ?>
			</div>
		</div>
		
		
		 <div class="clear"></div>
		 
		 
		<!-- Semesteranzahl des Studiengangs -->
		<div class="singleField">
			<div class="singleFieldDescription">Semesteranzahl: </div>
				<div class="singleFieldValue"><?php echo $_POST["semestercount"]; ?>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<!-- Zeigt ob der Studiengang als dualer Studiengang angeboten wird -->
		<div class="singleField">
			<div class="singleFieldDescription">Studiengang angeboten als:</div>
			<?php 
				if(isset($_POST["dual"]))
					echo "<div class=\"singleFieldValue\"> Dualer Studiengang";
				else
					echo "<div class=\"singleFieldValue\"> nicht dualer Studiengang";
				echo "<br />";
				if(isset($_POST["teilzeit"])) //value je nach Datenbank 4=Vollzeit
					echo " Teilzeit Studiengang <br /> Vollzeit Studiengang </div>";
				else
					echo "Vollzeit Studiengang </div>";
			?>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Gibt die Kategorien aus, zudem der Studiengang zugeordnet wurde -->
		<div class="singleField">
			<div class="singleFieldDescription">Kategorien: </div>
			<div class="singleFieldValue">
				<?php
					$categories = $studycoursesController->selectCategories();
					foreach($categories AS $c){	//für jeden tupel 
						if(isset($_POST[$c["name"]]))
							echo $c["name"];
					}
					unset($categories);
				?>
			</div>
		</div>	
		 
		 
		<div class="clear"></div>
		 
		 
		<!-- Gibt die Beschreibung des Studiengangs aus -->
		<div class="singleField">
			<div class="singleFieldDescription">Studiengangbeschreibung: </div>
				<div class="singleFieldValue"><?php echo $_POST["description"]; ?>
			</div>
		</div>
		
		<div class="clear"></div>
		
		<!-- Zeigt in welcher Sprache der Studiengang geschrieben wurde -->
		<div class="singleField">
			<div class="singleFieldDescription">Geschrieben in: </div>
			<div class="singleFieldValue">
				<?php echo $studycoursesController->languageIdToName($_POST["language_id"]); ?>
			</div>
		</div>
		
		
		<div class="clear"></div>
		
		
		<!-- Zeigt den Link für weitere Informationen über den Studiengang an -->
		<div class="singleField">
			<div class="singleFieldDescription">Link f&uuml;r weitere Informationen: </div>
			<div class="singleFieldValue">
				<a href="<?php echo $_POST["link"]; ?>" target="_blank"><?php echo $_POST["link"]; ?></a>
			</div>
		</div>
		
		
		<div class="clear"></div>
		  
		  
	</div>	<!-- allFields -->
	
	
	<!-- Buttons -->	
	<?php
	// 1.Button
		//Für den Studiengang die Informationen holen,
		if(isset($_POST["insertStudycourse_btn"]))	//Wenn ein Studiengang eingefügt wurde
			$studycourse = $studycoursesController->selectStudicourse($lastStudiID);	//$lastStudiID vewenden
		else	//sonst
			$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//$_POST["id"] vewenden
		echo "<form method=\"post\"><input type=\"submit\" value=\"".$studycoursesController->graduateIdToName($_POST["graduate_id"])." ".$_POST["name"]." bearbeiten\" name=\"editStudycourse_btn\">";	//Der "Diesen Studiengang bearbeiten" - Button
		echo "<input type=\"hidden\" name=\"id\" value=".$studycourse["id"].">";	// id mit hidden field übergeben
		echo "</form>";	//Formualr vom "Diesen Studiengang bearbeiten" - Button schließen
	
	// 2.Button 
		if(isset($_POST["editStudycourseConfirm_btn"]))	//Wenn ein Studiengang bearbeitet wurde
			//"Zurück zu den Studiengängen" - Button anzeigen
			echo "<a href=\"?page=Studiengaenge&action=bearbeitenLoeschen\"><input type=\"submit\" value=\"Alle Studieng&auml;nge anzeigen\"></a>";
		else	//sonst (Wenn ein neuer Studiengang eingefügt wurde)
			//"Weiteren Studiengang einfügen" - Button anzeigen
			echo "<a href=\"?page=Studiengaenge&action=einfuegen\"><input type=\"submit\" value=\"Weiteren Studiengang einf&uuml;gen\"></a>";
	?>