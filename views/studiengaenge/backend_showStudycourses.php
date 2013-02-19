<!-- Zeigt eine Tabelle mit allen Studieng�ngen an -->

	<!-- Link markieren -->
	<script type="text/javascript">$('#liEditDeleteStudycourse').attr('class', 'active');</script>	
	
	<h3>Studieng&auml;nge l&ouml;schen oder bearbeiten</h3>
	<table id="showStudycourses_table" border=1>
		<tr><th>Nr.</th><th>Name</th><th>Abschlussart</th><th>Sprache</th><th>Bearbeiten</th><th>L&ouml;schen</th></tr>
		<?php
			$studycourses = $studycoursesController->selectStudicourses();	//Alle Studieng�nge alphabetisch geordnet mit study_name, graduate_name, category_name, id 
			if(empty($studycourses))
				echo "<tr><td colspan=5>Kein Studiengang vorhanden</td></tr>";
			else{
				$count = 1;	//F�r die Spalte "Nr." in der Tabelle, in der alle Studieng�nge angezeigt werden
				$categories = $studycoursesController->selectCategories();	//alle kategorien selektieren
				foreach($studycourses AS $s){	//f�r jeden tupel, also f�r jeden Studiengang
					//eine Zeile in der Tabelle ausgeben mit den Spalten "Nr."	"Name"	"Abschlussart"	"Bearbeiten"	"L�schen", mit den Werten des Studiengangs
					echo "<form method=\"post\">
						<tr>
							<td>".$count."</td><td>".$s["study_name"]."</td><td>".$s["graduate_name"]."</td><td>".$s["language_name"]."</td><td>
							<input type=\"submit\" value=\"Bearbeiten\" name=\"editStudycourse_btn\"></td><td>
							<input type=\"submit\" value=\"L&ouml;schen\" name=\"deleteStudycourse_btn\"></td>
						</tr>
						<input type=\"hidden\" name=\"id\" value=".$s["id"].">
					</form>"; //Formular (f�r diese eine Tabellenzeile) schlie�en 
					$count++;	//F�r die Spalte "Nr." count um 1 erh�hen
				}
				unset($categories);	//l�scht $categories
				unset($count);	//l�scht $count
			}
		?>
	</table>