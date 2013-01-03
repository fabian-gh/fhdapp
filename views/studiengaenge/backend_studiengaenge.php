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
					<a href="cms.php?page=Studiengaenge&action=einfuegen"><li>Einf&uuml;gen</li></a> <!-- Einf�gen von Studieng�ngen, setzt deeplink auf ?page=Studiengaenge&action=einfuegen-->
					<a href="cms.php?page=Studiengaenge&action=bearbeitenLoeschen"><li>Bearbeiten/L&ouml;schen</li></a>	<!-- Einf�gen von Studieng�ngen, setzt deeplink auf ?page=Studiengaenge&action=bearbeitenLoeschen-->
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
					if(isset($_POST["insertStudycourse_btn"])){	//Wenn etwas eingef�gt werden soll
						$error = $studycoursesController->checkInsertEditFormular($_POST);
						if(!is_bool($error)){	//Wenn $error kein bool ist (also eine FEHLERHAFTE EINGABE vorliegt, weil dann ein array zur�ckgegeben wird)
							require_once 'backend_insertFormular.php';	//Formular zum einf�gen der Studieng�nge
						}
						else{	//Wenn $error ein bool ist, also KEIN Fehler bei der eingabe vorliegt
							$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen und die ID des Studiengangs in $lastStudiID abspeichern, denn diese wird ben�tigt, falls der neu eingef�gte Studiengang sofort bearbeitet werden soll (wenn also "diesen studiengang bearbeiten" bei "backend_insertConfirmation.php" ausgew�hlt wird)
							require_once 'backend_insertConfirmation.php';	//und best�tigung anzeigen
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
						if(isset($_POST["editStudycourseConfirm_btn"])){	//Wenn die Bearbeitung des Studiengangs abgespeichert werden soll
							$studycoursesController->updateStudycourse($_POST);	//Updaten
							require_once 'backend_insertConfirmation.php';	//und best�tigung anzeigen
						}
						else	//Wenn noch keine Werte ver�ndert wurden, sondern nur ein Studiengang zum bearbeiten ausgew�hlt wurde
							require_once 'backend_insertFormular.php';	//insertFormular aufrufen. Das insertFormular wird ausgef�llt sein, da in "showStudycourse.php" hidden fields �bergeben werden, und somit das $_POST ausgef�llt ist
					}
				}
				else{	//Wenn kein Formular abgesendet wurde
					
					if(isset($_GET["action"])){	//Wenn eine Action (Einf�gen/BearbeitenL�schen) gew�hlt wurde
						switch($_GET["action"]){	//switch case f�r subnav
							case "einfuegen":	
								require_once 'backend_insertFormular.php';	//Formular zum einf�gen der Studieng�nge
								break;
							case "bearbeitenLoeschen":
								require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und l�schen der Studieng�nge
							break;
						}
					}
					else{	//Wenn keine action gew�hlt wurde
						
					}
					
				}
			?>
			
		</div>
		
		<div class="clearBoth"></div>
	</div>	

</body>

</html>