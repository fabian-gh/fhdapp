<!-- Frage ob ein Studiengang endg�ltig gel�cht werden soll -->

	<?php 
		$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);
		echo "<script type=\"text/javascript\">$('#editDeleteStudycourse').attr('class', 'active');</script>";	//Link rot markieren
	?>

	<h3>L&ouml;sch Best&auml;tigung</h3>
	<p>Wollen sie den Studiengang <i><b><?php echo "".$studycourse["graduate_name"]." ".$studycourse["name"].""; ?></i></b> endg&uuml;ltig l&ouml;schen?</p>
	<form method="post">
		<input type="hidden" name="deleteStudycourse_btn">
		<input type="hidden" name="id" value=<?php echo $_POST["id"] ?>>
		<input type="submit" name="deleteStudycourseConfirm_btn" value="Studiengang endg&uuml;ltig l&ouml;schen">
	</form>
	<a href="?page=Studiengaenge&action=bearbeitenLoeschen"><input type="submit" value="Nein, zur&uuml;ck"></a>
	<br />
