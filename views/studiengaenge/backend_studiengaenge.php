

<?php
    require_once '../../layout/backend/header.php';	//header einbinden
	require_once '../../controllers/studiengaengeController.php';	//Einbinden des Controllers
	$studycoursesController = new StudycoursesController();	//neues ControllerObjekt wird erzeugt und in der Variabel gespeichert
	echo "<script type=\"text/javascript\">$('#liStudyCourses').attr('class', 'active');</script>";	//link aktivieren
	
	echo "<h2>Studieng&auml;nge</h2>";	
	if(isset($_POST["insertStudycourse_btn"])){	//Wenn etwas eingef�gt werden soll
		$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Post-Formular auf eine fehlerhafte Eingabe �berpr�fen
		if(!empty($error)){	//Wenn $error nicht leer ist (also eine FEHLERHAFTE EINGABE vorliegt)
			require_once 'backend_insertUpdateFormular.php';	//Formular zum einf�gen der Studieng�nge anzeigen
		}
		else{	//Wenn $error ein leer ist, also KEIN Fehler bei der eingabe vorliegt
			$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen und die ID des zuletzt eingef�gten Studiengangs in $lastStudiID abspeichern, denn diese wird ben�tigt, falls bei der Best�tigung des neu eingef�gten Studiengangs sofort bearbeitet werden soll (wenn also "Diesen studiengang bearbeiten" im "backend_insertUpdateConfirmation.php" ausgew�hlt wird)
			require_once 'backend_insertUpdateConfirmation.php';	//und best�tigung anzeigen
			unset($lastStudiID);
		}
		unset($error);
	}
	elseif(isset($_POST["deleteStudycourse_btn"])){	//Wenn etwas gel�cht werden soll
		if(!isset($_POST["deleteStudycourseConfirm_btn"]))	//Wurde schon best�tigt, ob der Studiengang wirklich gel�scht werden soll? Wenn nein, dann
			require_once 'backend_deleteConfirmation.php';	//Frage nach ob der Studiengang wirklich gel�scht werden soll
		else{	//sonst l�che ihn und gebe eine best�tigung aus
			$studycoursesController->deleteStudicourse($_POST["id"]);	//Dann l�schen		
			echo "<p>Studiengang gel&ouml;scht</p>";
			require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und l�schen der Studieng�nge wieder anzeigen
		}							
			
	}
	elseif(isset($_POST["editStudycourse_btn"])){	//Wenn etwas bearbeitet werden soll
		$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Post-Formular auf eine fehlerhafte Eingabe �berpr�fen
		if(!isset($_POST["editStudycourseConfirm_btn"]) OR !empty($error))	//Wenn noch keine Werte ver�ndert wurden, sondern nur ein Studiengang zum bearbeiten ausgew�hlt wurde oder Wenn $error nicht leer ist (also eine FEHLERHAFT EINGABE vorliegt)
			require_once 'backend_insertUpdateFormular.php';	//backend_insertUpdateFormular aufrufen. Das backend_insertUpdateFormular wird ausgef�llt sein, da in "showStudycourse.php" hidden fields �bergeben werden, und somit das $_POST ausgef�llt ist
		else{	//Wenn der Studiengang geupdatet werden soll und keine fehlerhaften eingaben da sind
			$studycoursesController->updateStudycourse($_POST);	//Updaten "studycourses" Tabelle
			$studycoursesController->deleteFromStudicourseCategories($_POST["id"]);	//Tupel des Studiengangs aus der Zwischentabelle l�schen
			$studycoursesController->insertStudCat($_POST["id"], $_POST);	//Neue Tupel in die Zwischentabelle einf�gen
			require_once 'backend_insertUpdateConfirmation.php';	//und best�tigung anzeigen
		}
	}
	else{	//Wenn kein Formular abgesendet wurde
		if(isset($_GET["action"])){	//Wenn eine Action (Einf�gen/BearbeitenL�schen) gew�hlt wurde
			switch($_GET["action"]){	//switch case f�r subnav
				case "einfuegen":	
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einf�gen der Studieng�nge
					break;
				case "bearbeitenLoeschen":
					require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und l�schen der Studieng�nge
					break;
			}
		}
		else{
			echo "<a href=\"?page=Studiengaenge&action=einfuegen\"><input type=\"submit\" value=\"Einen neuen Studiengang einf&uuml;gen\"></a>";	//Einf�gen von Studieng�ngen, setzt deeplink auf ?page=Studiengaenge&action=einfuegen-->
			echo "<a href=\"?page=Studiengaenge&action=bearbeitenLoeschen\"><input type=\"submit\" value=\"Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen\"></a>";	// Einf�gen von Studieng�ngen, setzt deeplink auf ?page=Studiengaenge&action=bearbeitenLoeschen-->
		}
	}
	
    require_once '../../layout/backend/footer.php';	//footer einbinden
?>		