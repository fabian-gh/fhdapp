<form method="post">
	<h3>Neuen Studiengang einf&uuml;gen</h3>
	
	<!-- Dropdownmenü um die Abschlussbeschreibung auszuwählen -->
	<p>Abschlussbeschreibung: </p></br>
	<select name="graduate_id" tabindex=1 > 
		<option value=1>B.Sc. - Bachelor of Science</option>
		<option value=2>B.Eng. - Bachelor of Engineering</option>
		<option value=3>B.A. - Bachelor of Arts</option>
		<option value=4>M.Sc. - Master of Science</option>
		<option value=5>M.Eng. - Master of Engineering</option>
		<option value=6>M.A. - Master of Arts</option>
	</select>
	</br>
	
	<!-- Eingabe vom Namen des Studiengangs -->
	<p>Name des Studiengangs: </p>
	<input name="name" type="text" size="40" maxlength="100" tabindex=2>
	</br>
	
	<!-- Dropdownmenü um den Fachbereich auszuwählen -->
	<p>Fachbereich: </p>
	<select name="department_id" tabindex=3> 
		<option value=1>1 - Architektur</option>
		<option value=2>2 - Design</option>
		<option value=3>3 - Elektrotechnik</option>
		<option value=4>4 - Maschinenbau & Verfahrenstechnik</option>
		<option value=5>5 - Medien</option>
		<option value=6>6 - Sozial- und Kulturwissenschaften</option>
		<option value=7>7 - Wirtschaft</option>
	</select>
	</br>
	
	<!-- Eingabe Semesteranzahl -->
	<p>Semesteranzahl: </p>
	<input type="text" name="semestercount" size="1" maxlength="2" tabindex=4>
	</br>
	
	<!-- Eingabe Studiengangbeshreibung -->
	<p>Beschreibung des Studiengangs: </p></br>
	<textarea name="description" cols="45" rows="10" tabindex=5></textarea>
	</br>
	
	<!-- Sprachauswahl -->
	<p>Geschrieben in: </p>
	<select name="language_id" tabindex=6 > 
		<option value=1>Deutsch</option>
		<option value=2>Englisch</option>
		<option value=3>Franz&ouml;sisch</option>
		<option value=4>Spanisch</option>
		<option value=19>Russisch</option>
		<option value=24>T&uuml;rkisch</option>
	</select>
	</br>
	
	<!-- Eingabefeld Link für weitere Informationen -->
	<p>Link f&uuml;r weitere Informationen: </p>
	<input name="link" type="text" size="60" tabindex=7>
	</br>
	
	<!-- Bestätigungs Button -->
	<input name="insert" type="submit" value="Einf&uuml;gen" style="width: 70px;" tabindex=8>
	</br>
	
	
</form>