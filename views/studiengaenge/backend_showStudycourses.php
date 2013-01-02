<!-- Zeigt eine Tabelle mit allen Studiengängen an -->

	<h3>Studieng&auml;nge l&ouml;schen oder bearbeiten</h3>


	<table border=1>
		<tr><th>Name</th><th>Abschlussart</th><th>Art</th><th>Bearbeiten</th><th>L&ouml;schen</th></tr>
		<?php
			$studycourses = $studycoursesController->selectStudicourses();	//Alle Studiengänge alphabetisch geordnet mit study_name, graduate_name, category_name, id 
			if(empty($studycourses))
				echo "<tr><td colspan=5>Kein Studiengang vorhanden</td></tr>";
			else{
				foreach($studycourses AS $s){	//für jeden tupel 
					//eine Zeile ausgeben mit den Spalten "Name"	"Abschlussart"	"Art"	"Bearbeiten"	"Löschen"
					echo "<form method=\"post\"><input type=\"hidden\" name=\"id\" value=".$s["id"]."><tr><td>".$s["study_name"]."</td><td>".$s["graduate_name"]."</td><td>".$s["category_name"]."</td><td><input type=\"submit\" value=\"Bearbeiten\" name=\"edit_btn\"></td><td><input type=\"submit\" value=\"L&ouml;schen\" name=\"delete_btn\"></td></tr>";
					//Für den Studiengang die Informationen holen,
					$studycourse = $studycoursesController->selectStudicourse($s["id"]);
					//die hidden-field (für das post, um das backend_insertFormular aufzurufen, damit alles schon vor ausgefüllt ist) mit "ausgeben"
					echo "<input type=\"hidden\" name=\"graduate_id\" value=\"".$studycourse["graduate_id"]."\"><input type=\"hidden\" name=\"graduate_name\" value=\"".$studycourse["graduate_name"]."\"><input type=\"hidden\" name=\"name\" value=\"".$studycourse["name"]."\"><input type=\"hidden\" name=\"department_id\" value=\"".$studycourse["department_id"]."\"><input type=\"hidden\" name=\"semestercount\" value=\"".$studycourse["semestercount"]."\"><input type=\"hidden\" name=\"description\" value=\"".$studycourse["description"]."\"><input type=\"hidden\" name=\"link\" value=\"".$studycourse["link"]."\"><input type=\"hidden\" name=\"language_id\" value=\"".$studycourse["language_id"]."\">";
					if(isset($studycourse["vollTeil"]))
						echo "<input type=\"hidden\" name=\"vollTeil\" value=\"".$studycourse["vollTeil"]."\">";
					if(isset($studycourse["dual"]))
						echo "<input type=\"hidden\" name=\"dual\" value=\"".$studycourse["dual"]."\">";
					if(isset($studycourse["ingenieurwissenschaftlich"]))
						echo "<input type=\"hidden\" name=\"ingenieurwissenschaftlich\" value=\"".$studycourse["ingenieurwissenschaftlich"]."\">";
					if(isset($studycourse["gestalterisch"]))
						echo "<input type=\"hidden\" name=\"gestalterisch\" value=\"".$studycourse["gestalterisch"]."\">";
					if(isset($studycourse["gesellschaftlich"]))
						echo "<input type=\"hidden\" name=\"gesellschaftlich\" value=\"".$studycourse["gesellschaftlich"]."\">";
					if(isset($studycourse["wirtschaftlich"]))
						echo "<input type=\"hidden\" name=\"wirtschaftlich\" value=\"".$studycourse["wirtschaftlich"]."\">";
					//und das formular (für diese eine Zeile) noch schließen 
					echo "</form>";
				}
			}
		?>
	</table>