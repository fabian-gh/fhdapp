<?php
/**
*	Dateiname: "backend_showStudycourses.php"
*	Zweck:	Diese Datei gibt alle Studieng�nge in einer Tabelle aus, mit den Buttons zum "Bearbeiten" und "L�schen" des jeweiligen Studiengangs.
*			Desweiteren dient diese Datei als Best�tigung, wenn ein Studiengang gel�scht wurde.
*	Benutzt von: "backend_studiengaenge.php"
*	Autor Name: Okan K�se
*	Autor E-Mail: okan.koese@gmx.de	
**/
?>

	<script type="text/javascript">$('#liEditDeleteStudycourse').attr('class', 'active');</script>	<!-- Link "Bearbeiten/L�schen"(in der Navigation) aktivieren (rot markieren) -->
	
	<h3>Studieng&auml;nge bearbeiten oder l&ouml;schen</h3>	<!-- �berschrift ausgeben -->
	
	<?php
		if(isset($_POST["deleteStudycourseConfirm_btn"]))	//Wenn ein Studiengang erfolgreich gel�scht wurde
			echo "<i><b><br />".$_POST["graduate_name"]." ".$_POST["name"]."</b></i> wurde erfolgreich gel&ouml;scht";	//Best�tigungstext ausgeben. "$_POST["name"]" und "$_POST["graduate_name"]" kommen aus der "backend_studiengaenge.php"
	?>
	
	<!---- Ausgabe der Tabelle mit allen Studieng�ngen ---->
	<table class="studycourseTable" border=1>
		<!-- Tabelle mit den Spalten "Nr."	"Name"	"Abschlussart"	"Bearbeiten"	"L�schen" -->
		<tr><th>Nr.</th><th>Name</th><th>Abschlussart</th><th>Sprache</th><th>Bearbeiten</th><th>L&ouml;schen</th></tr>
		<?php
			$studycourses = $studycoursesController->selectStudicourses();	//Alle Studieng�nge alphabetisch geordnet mit study_name, graduate_name, category_name, id holen
			if(empty($studycourses))	//Wenn keine Studieng�nge vorhanden sind, dann
				echo "<tr><td colspan=6 style=\"text-align: center;\">Kein Studiengang vorhanden</td></tr>";	//"Kein Studiengang vorhanden"-Text ausgeben
			else{	//Wenn es Studieng�nge gibt
				$count = 1;	//"$count" ist f�r die Spalte "Nr." in der Tabelle, in der alle Studieng�nge angezeigt werden
				foreach($studycourses AS $s){	//f�r jeden tupel, also f�r jeden Studiengang
					//---- Ausgabe einer Zeile in der Tabelle mit den jeweiligen Werten des Studiengangs ----
					echo "<form method=\"post\">
						<tr>
							<td style=\"text-align: right;\">".$count."</td><td>".$s["study_name"]."</td><td style=\"min-width: 150px;\">".$s["graduate_name"]."</td><td>".$s["language_name"]."</td><td>
							<input type=\"submit\" class=\"studycourseButtons\" style=\"padding: 1px 3px 1px 3px;\" value=\"Bearbeiten\" name=\"editStudycourse_btn\"></td><td>
							<input type=\"submit\" class=\"studycourseDeleteButtons\" style=\"padding: 1px 3px 1px 3px;\" value=\"L&ouml;schen\" name=\"deleteStudycourse_btn\"></td>
						</tr>
						<input type=\"hidden\" name=\"id\" value=".$s["id"].">
					</form>"; //Formular (f�r diese eine Tabellenzeile) schlie�en 
					$count++;	//F�r die Spalte "Nr." count um 1 erh�hen
				}
				unset($count);	//L�scht die Variable
			}
		?>
	</table>