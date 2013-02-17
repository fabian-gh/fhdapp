<<<<<<< HEAD


<?php
    require_once '../../layout/backend/header.php';	//header einbinden
	require_once '../../controllers/studiengaengeController2.php';	//Einbinden des Controllers
	$studycoursesController = new StudycoursesController();	//neues ControllerObjekt wird erzeugt und in der Variabel gespeichert
	echo "<script type=\"text/javascript\">$('#liStudyCourses').attr('class', 'active');</script>";	//link aktivieren
	
	echo "<h2>Studieng&auml;nge</h2>";	
	if(isset($_POST["insertStudycourse_btn"])){	//Wenn etwas eingefügt werden soll
		$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Post-Formular auf eine fehlerhafte Eingabe überprüfen
		if(!empty($error)){	//Wenn $error nicht leer ist (also eine FEHLERHAFTE EINGABE vorliegt)
			require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen der Studiengänge anzeigen
		}
		else{	//Wenn $error ein leer ist, also KEIN Fehler bei der eingabe vorliegt
			$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen und die ID des zuletzt eingefügten Studiengangs in $lastStudiID abspeichern, denn diese wird benötigt, falls bei der Bestätigung des neu eingefügten Studiengangs sofort bearbeitet werden soll (wenn also "Diesen studiengang bearbeiten" im "backend_insertUpdateConfirmation.php" ausgewählt wird)
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
		$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Post-Formular auf eine fehlerhafte Eingabe überprüfen
		if(!isset($_POST["editStudycourseConfirm_btn"]) OR !empty($error))	//Wenn noch keine Werte verändert wurden, sondern nur ein Studiengang zum bearbeiten ausgewählt wurde oder Wenn $error nicht leer ist (also eine FEHLERHAFT EINGABE vorliegt)
			require_once 'backend_insertUpdateFormular.php';	//backend_insertUpdateFormular aufrufen. Das backend_insertUpdateFormular wird ausgefüllt sein, da in "showStudycourse.php" hidden fields übergeben werden, und somit das $_POST ausgefüllt ist
		else{	//Wenn der Studiengang geupdatet werden soll und keine fehlerhaften eingaben da sind
			$studycoursesController->updateStudycourse($_POST);	//Updaten "studycourses" Tabelle
			$studycoursesController->deleteFromStudicourseCategories($_POST["id"]);	//Tupel des Studiengangs aus der Zwischentabelle löschen
			$studycoursesController->insertStudCat($_POST["id"], $_POST);	//Neue Tupel in die Zwischentabelle einfügen
			require_once 'backend_insertUpdateConfirmation.php';	//und bestätigung anzeigen
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
	
    require_once '../../layout/backend/footer.php';	//footer einbinden
?>		
=======
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="sources/css/stylebackend.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="sources/js/jquery-1.8.2.min.js"></script>
	<title>FHD App - Redaktion</title>
</head>

<body>

	<div id="wrapper">
		<div id="header">	<!-- Header -->
			<h1> FHD-App Redaktion </h1>
		</div>
		<div id="nav">	<!-- Navigation -->
			<ul>
				<a href="cms.php?page=Studiengaenge"><li>Studieng&auml;nge</li></a>
				<ul>	<!-- Subnavigation -->
					<a href="cms.php?page=Studiengaenge&action=einfuegen"><li>Einf&uuml;gen</li></a> <!-- Einfügen von Studiengängen, setzt deeplink auf ?page=Studiengaenge&action=einfuegen-->
					<a href="cms.php?page=Studiengaenge&action=bearbeitenLoeschen"><li>Bearbeiten/L&ouml;schen</li></a>	<!-- Einfügen von Studiengängen, setzt deeplink auf ?page=Studiengaenge&action=bearbeitenLoeschen-->
				</ul>
				<a href=""><li>Mensa</li></a>
				<a href=""><li>Termine</li></a>
				<a href=""><li>Kontakte</li></a>
				<a href=""><li>FAQ</li></a>
				<a href=""><li>Veranstaltungen</li></a>
			</ul>
		</div>
		
		<div id="content">	<!-- Inhalt -->
			<h1>Studieng&auml;nge</h1>
			
			<?php
				require_once 'controllers/studiengaengeController.php';	//Einbinden des Controllers
    			$studycoursesController = new StudycoursesController();	//neues ControllerObjekt wird erzeugt und in der Variabel gespeichert
				
				//Wenn Formlular abgesendet wurde
				if(isset($_POST["insertNewStudi"])){
					$studycoursesController->insertStudycourse($_POST);
				}
				else{	//Wenn kein Formular abgesendet wurde
					
					if(isset($_GET["action"])){	//Wenn eine Action (Einfügen/BearbeitenLöschen) gewählt wurde
						switch($_GET["action"]){	//switch case für subnav
							case "einfuegen":	
								require_once 'backend_insertFormular.php';	//Formular zum einfügen der Studiengänge
								break;
							case "bearbeitenLoeschen":
								require_once 'ass.php';	//Formular zum bearbeiten und löschen der Studiengänge
							break;
						}
					}
					else{	//Wenn keine action gewählt wurde
						
					}
					
				}
			?>
			
		</div>
		
		<div class="clearBoth"></div>
	</div>	

</body>

</html>
>>>>>>> parent of f955329... unneeded files deleted
