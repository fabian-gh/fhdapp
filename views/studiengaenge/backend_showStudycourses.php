<!-- Best�tigung Einf�gen Studiengang -->

	<h3>Folgender Studiengang wurde einf&uuml;gt</h3>


	<?php
		echo "<p>";
		$studycourses = $studycoursesController->selectStudicourses();
		foreach($studycourses AS $s){	//f�r jeden tupel 
			echo $s["studyName"];
			echo " ";
			echo $s["graduateName"];
			echo " ";
			echo $s["categoryName"];
			echo "</br></br>";
		}
	?>
	<!--  -->
	<p>Abschlussbeschreibung: </p>
	</br>
	
	
	<!--  -->
	<p>Name des Studiengangs: </p>
	</br>
	
	
	<!--  -->
	<p>Fachbereich: </p>
	</br>
	
	
	<!--  -->
	<p>Semesteranzahl: </p>
	</br>
	
	<!--  -->
	<p>Dualer Studiengang</p>
	<br/>
	
	<!--  -->
	<p>Vollzeit: </p>
	<p>Teilzeit: </p>
	<br/>
	
	<!--  -->
	<p>Kategorien: </p>
	<br/>
		
	
	<!--  -->
	<p>Beschreibung des Studiengangs: </p> 
	</br>
	
	<!--  -->
	<p>Geschrieben in: </p>
	</br>
	
	<!--  -->
	<p>Link f&uuml;r weitere Informationen: </p>
	</br>
	
	<!--  -->
	<a href="cms.php?page=Studiengaenge&action=einfuegen"><input type="submit" value="Weiteren Studiengang einf&uuml;gen" style="width: 70px;"></a>
	</br>
