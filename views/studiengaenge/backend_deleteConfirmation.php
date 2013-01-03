<!-- Frage ob ein Studiengang endgültig gelöcht werden soll -->

	<h3>L&ouml;sch Best&auml;tigung</h3>

	<?php $studycourse = $studycoursesController->selectStudicourse($_POST["id"]); ?>
	<p>Wollen sie den Studiengang <i><b><?php echo "".$studycourse["graduate_name"]." ".$studycourse["name"].""; ?></i></b> endg&uuml;ltig l&ouml;schen?</p>
	<form method="post">
		<input type="hidden" name="deleteStudycourse_btn">
		<input type="hidden" name="id" value=<?php echo $_POST["id"] ?>>
		<input type="submit" name="deleteStudycourseConfirm_btn" value="Studiengang endg&uuml;ltig l&ouml;schen">
	</form>
	<a href="cms.php?page=Studiengaenge&action=bearbeitenLoeschen"><input type="submit" value="Nein, zur&uuml;ck"></a>
	</br>
