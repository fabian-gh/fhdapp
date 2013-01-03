<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="sources/css/stylebackend.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="sources/css/styleBackendStudiengaenge.css" rel="stylesheet" type="text/css" media="screen" />
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
				
				//Wenn ein Formular abgesendet wurde
				if(isset($_POST["insertStudycourse_btn"]) OR isset($_POST["deleteStudycourse_btn"]) OR isset($_POST["editStudycourse_btn"])){
					if(isset($_POST["insertStudycourse_btn"])){	//Wenn etwas eingefügt werden soll
						$error = $studycoursesController->checkInsertEditFormular($_POST);
						if(!is_bool($error)){	//Wenn $error kein bool ist (also eine FEHLERHAFTE EINGABE vorliegt, weil dann ein array zurückgegeben wird)
							require_once 'backend_insertFormular.php';	//Formular zum einfügen der Studiengänge
						}
						else{	//Wenn $error ein bool ist, also KEIN Fehler bei der eingabe vorliegt
							$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen und die ID des Studiengangs in $lastStudiID abspeichern, denn diese wird benötigt, falls der neu eingefügte Studiengang sofort bearbeitet werden soll (wenn also "diesen studiengang bearbeiten" bei "backend_insertConfirmation.php" ausgewählt wird)
							require_once 'backend_insertConfirmation.php';	//und bestätigung anzeigen
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
							$studycoursesController->updateStudycourse($_POST);	//Updaten
							require_once 'backend_insertConfirmation.php';	//und bestätigung anzeigen
						}
						else	//Wenn noch keine Werte verändert wurden, sondern nur ein Studiengang zum bearbeiten ausgewählt wurde
							require_once 'backend_insertFormular.php';	//insertFormular aufrufen. Das insertFormular wird ausgefüllt sein, da in "showStudycourse.php" hidden fields übergeben werden, und somit das $_POST ausgefüllt ist
					}
				}
				else{	//Wenn kein Formular abgesendet wurde
					
					if(isset($_GET["action"])){	//Wenn eine Action (Einfügen/BearbeitenLöschen) gewählt wurde
						switch($_GET["action"]){	//switch case für subnav
							case "einfuegen":	
								require_once 'backend_insertFormular.php';	//Formular zum einfügen der Studiengänge
								break;
							case "bearbeitenLoeschen":
								require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und löschen der Studiengänge
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