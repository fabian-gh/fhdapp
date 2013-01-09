

<?php
	//header einbinden
    require_once '../../layout/backend/header.php';
	//link aktivieren
	echo "<script type=\"text/javascript\">$('#liStudyCourses').attr('class', 'active');</script>";
	echo "<h2>Studieng&auml;nge</h2>";
	require_once '../../controllers/studiengaengeController.php';	//Einbinden des Controllers
	$studycoursesController = new StudycoursesController();	//neues ControllerObjekt wird erzeugt und in der Variabel gespeichert
	
	//Wenn ein Formular abgesendet wurde
	if(isset($_POST["insertStudycourse_btn"]) OR isset($_POST["deleteStudycourse_btn"]) OR isset($_POST["editStudycourse_btn"])){
		if(isset($_POST["insertStudycourse_btn"])){	//Wenn etwas eingefügt werden soll
			$error = $studycoursesController->checkInsertEditFormular($_POST);
			if(!is_bool($error)){	//Wenn $error kein bool ist (also eine FEHLERHAFTE EINGABE vorliegt, weil dann ein array zurückgegeben wird)
				require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen der Studiengänge
			}
			else{	//Wenn $error ein bool ist, also KEIN Fehler bei der eingabe vorliegt
				$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen und die ID des Studiengangs in $lastStudiID abspeichern, denn diese wird benötigt, falls der neu eingefügte Studiengang sofort bearbeitet werden soll (wenn also "diesen studiengang bearbeiten" bei "backend_insertUpdateConfirmation.php" ausgewählt wird)
				require_once 'backend_insertUpdateConfirmation.php';	//und bestätigung anzeigen
				unset($lastStudiID);
			}
			unset($error);
		}
		elseif(isset($_POST["deleteStudycourse_btn"])){	//Wenn etwas gelöcht werden soll
			if(!isset($_POST["deleteStudycourseConfirm_btn"]))	//Wurde schon bestätigt, ob der Studiengang wirklich gelöscht werden soll? Wenn nein, dann
				require_once 'backend_deleteConfirmation.php';	//Frage nach ob der Studiengang wirklich gelöscht werden soll
			else{	//sonst löche ihn und gebe eine bestätigung aus
				$studycoursesController->deleteStudicourse($_POST["id"]);	//Dann löschen		
				echo "<p>Studiengang gel&ouml;scht</p>";
				require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und löschen der Studiengänge wieder anzeigen
			}							
				
		}
		elseif(isset($_POST["editStudycourse_btn"])){	//Wenn etwas bearbeitet werden soll
			if(isset($_POST["editStudycourseConfirm_btn"])){	//Wenn die Bearbeitung des Studiengangs abgespeichert werden soll
				$studycoursesController->updateStudycourse($_POST);	//Updaten "studycourses" Tabelle
				$studycoursesController->deleteFromStudicourseCategories($_POST["id"]);
				$studycoursesController->insertStudCat($_POST["id"], $_POST);
				require_once 'backend_insertUpdateConfirmation.php';	//und bestätigung anzeigen
			}
			else	//Wenn noch keine Werte verändert wurden, sondern nur ein Studiengang zum bearbeiten ausgewählt wurde
				require_once 'backend_insertUpdateFormular.php';	//insertFormular aufrufen. Das insertFormular wird ausgefüllt sein, da in "showStudycourse.php" hidden fields übergeben werden, und somit das $_POST ausgefüllt ist
		}
	}
	else{	//Wenn kein Formular abgesendet wurde
		if(isset($_GET["action"])){	//Wenn eine Action (Einfügen/BearbeitenLöschen) gewählt wurde
			switch($_GET["action"]){	//switch case für subnav
				case "einfuegen":	
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen der Studiengänge
					break;
				case "bearbeitenLoeschen":
					require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und löschen der Studiengänge
					break;
			}
		}
		else{
			echo "<a href=\"?page=Studiengaenge&action=einfuegen\"><input type=\"submit\" value=\"Einen neuen Studiengang einf&uuml;gen\"></a>";	//Einfügen von Studiengängen, setzt deeplink auf ?page=Studiengaenge&action=einfuegen-->
			echo "<a href=\"?page=Studiengaenge&action=bearbeitenLoeschen\"><input type=\"submit\" value=\"Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen\"></a>";	// Einfügen von Studiengängen, setzt deeplink auf ?page=Studiengaenge&action=bearbeitenLoeschen-->
		}
	}
	
	 //footer einbinden
    require_once '../../layout/backend/footer.php';
?>		