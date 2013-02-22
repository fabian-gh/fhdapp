<?php
/**
*	Dateiname: "backend_showStudycourses.php"
*	Zweck:	Diese Datei gibt alle Studiengänge in einer Tabelle aus, mit den Buttons zum "Bearbeiten" und "Löschen" des jeweiligen Studiengangs.
*			Desweiteren dient diese Datei als Bestätigung, wenn ein Studiengang gelöscht wurde.
*	Benutzt von: "backend_studiengaenge.php"
*	Autor Name: Okan Köse
*	Autor E-Mail: okan.koese@gmx.de	
**/
?>

	<script type="text/javascript">$('#liEditDeleteStudycourse').attr('class', 'active');</script>	<!-- Link "Bearbeiten/Löschen"(in der Navigation) aktivieren (rot markieren) -->
	
	<h3>Studieng&auml;nge bearbeiten oder l&ouml;schen</h3>	<!-- Überschrift ausgeben -->
	
	<?php
		if(isset($_POST["deleteStudycourseConfirm_btn"]))	//Wenn ein Studiengang erfolgreich gelöscht wurde
			echo "<i><b><br />".$_POST["graduate_name"]." ".$_POST["name"]."</b></i> wurde erfolgreich gel&ouml;scht";	//Bestätigungstext ausgeben. "$_POST["name"]" und "$_POST["graduate_name"]" kommen aus der "backend_studiengaenge.php"
	?>
	
	<!---- Ausgabe der Tabelle mit allen Studiengängen ---->
	<table class="studycourseTable" border=1>
		<!-- Tabelle mit den Spalten "Nr."	"Name"	"Abschlussart"	"Bearbeiten"	"Löschen" -->
		<tr><th>Nr.</th><th>Name</th><th>Abschlussart</th><th>Sprache</th><th>Bearbeiten</th><th>L&ouml;schen</th></tr>
		<?php
			$studycourses = $studycoursesController->selectStudicourses();	//Alle Studiengänge alphabetisch geordnet mit study_name, graduate_name, category_name, id holen
			if(empty($studycourses))	//Wenn keine Studiengänge vorhanden sind, dann
				echo "<tr><td colspan=6 style=\"text-align: center;\">Kein Studiengang vorhanden</td></tr>";	//"Kein Studiengang vorhanden"-Text ausgeben
			else{	//Wenn es Studiengänge gibt
				$count = 1;	//"$count" ist für die Spalte "Nr." in der Tabelle, in der alle Studiengänge angezeigt werden
				foreach($studycourses AS $s){	//für jeden tupel, also für jeden Studiengang
					//---- Ausgabe einer Zeile in der Tabelle mit den jeweiligen Werten des Studiengangs ----
					echo "<form method=\"post\">
						<tr>
							<td style=\"text-align: right;\">".$count."</td><td>".$s["study_name"]."</td><td style=\"min-width: 150px;\">".$s["graduate_name"]."</td><td>".$s["language_name"]."</td><td>
							<input type=\"submit\" class=\"studycourseButtons\" style=\"padding: 1px 3px 1px 3px;\" value=\"Bearbeiten\" name=\"editStudycourse_btn\"></td><td>
							<input type=\"submit\" class=\"studycourseDeleteButtons\" style=\"padding: 1px 3px 1px 3px;\" value=\"L&ouml;schen\" name=\"deleteStudycourse_btn\"></td>
						</tr>
						<input type=\"hidden\" name=\"id\" value=".$s["id"].">
					</form>"; //Formular (für diese eine Tabellenzeile) schließen 
					$count++;	//Für die Spalte "Nr." count um 1 erhöhen
				}
				unset($count);	//Löscht die Variable
			}
		?>
	</table>