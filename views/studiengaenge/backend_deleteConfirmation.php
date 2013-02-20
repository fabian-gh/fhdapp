

	<?php 
		$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//Daten des zu löschenden Studiengangs holen um z.B. den Namen des Studiengangs zu erfahren
		echo "<script type=\"text/javascript\">$('#liEditDeleteStudycourse').attr('class', 'active');</script>";	//Link "Bearbeiten/Löschen"(in der Navigation) aktivieren (rot markieren)
	?>
	
	<!---- Ausgabe des Formulars ---->
	<h3>L&ouml;schen des Studiengangs best&auml;tigen</h3>
	<div class="allFields">
		<p class="singleField">Wollen Sie den Studiengang <i><b><?php echo "".$studycourse["graduate_name"]." ".$studycourse["name"].""; ?></i></b> endg&uuml;ltig l&ouml;schen?</p> <!-- Abschlussgrad("graduate_name") und Name("name") des Studiengangs mit den zuvor abgespeicherten Daten (in "$studycourse") ausgeben -->
		<div class="singleField" style="margin-top: 12px;">
			<div class="singleFieldDescription" style="margin-right: 12px;">
				<form method="post">
					<input type="hidden" name="id" value=<?php echo $_POST["id"] ?>>	<!-- hidden-Field mit der id des zu löschenden Studiengangs, damit beim Senden des Formulares (durch klick auf den button) die Information des zu löschenden Studiengangs (ID) nicht verloren geht -->
					<input type="submit" name="deleteStudycourseConfirm_btn" value="Studiengang endg&uuml;ltig l&ouml;schen" class="studycourseDeleteButtons">
				</form>
			</div>
			<div class="singleFieldValue" style="margin-top: 2px;">
				<a href="../../views/studiengaenge/backend_studiengaenge.php?page=Studiengaenge&action=bearbeitenLoeschen"><input type="submit" value="Nein, zur&uuml;ck" class="studycourseButtons"></a>	<!-- Button um das Löschen abzubrechen und zurück zu allen Studiengängen zu gelangen. setzt deeplink auf "?page=Studiengaenge&action=bearbeitenLoeschen"-->
			</div>
		</div>
		<div class="clear"></div>
	</div>
