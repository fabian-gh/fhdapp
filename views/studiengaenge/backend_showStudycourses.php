<!-- Zeigt eine Tabelle mit allen Studiengängen an -->

	<h3>Studieng&auml;nge l&ouml;schen oder bearbeiten</h3>


	<table border=1>
		<tr><th>Name</th><th>Abschlussart</th><th>Art</th><th>Bearbeiten</th><th>L&ouml;schen</th></tr>
		<?php
		$studycourses = $studycoursesController->selectStudicourses();	//Alle Studiengänge alphabetisch geordnet mit studyName, graduateName, categoryName, id 
		if(empty($studycourses))
			echo "<tr><td colspan=5>Kein Studiengang vorhanden</td></tr>";
		else{
			foreach($studycourses AS $s){	//für jeden tupel 
				echo "<form method=\"post\"><input type=\"hidden\" name=\"id\" value=".$s["id"]."><tr><td>".$s["studyName"]."</td><td>".$s["graduateName"]."</td><td>".$s["categoryName"]."</td><td><input type=\"submit\" value=\"Bearbeiten\" name=\"edit_btn\"></td><td><input type=\"submit\" value=\"L&ouml;schen\" name=\"delete_btn\"></td></tr></form>";
			}
		}
		?>
	</table>