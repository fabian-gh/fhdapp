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
				
				//Wenn ein Formular abgesendet wurde
				if(isset($_POST["insertNewStudi_btn"]) OR isset($_POST["delete_btn"]) OR isset($_POST["edit_btn"])){
					if(isset($_POST["insertNewStudi_btn"])){	//Wenn etwas eingef?gt werden soll
						$error = $studycoursesController->checkInsertEditFormular($_POST);
						if(!is_bool($error)){	//Wenn $error kein bool ist (also eine fehlerhafte eingabe vorliegt, weil dann ein array zur?ckgegeben wird)
							require_once 'backend_insertFormular.php';	//Formular zum einf?gen der Studieng?nge
						}
						else{	
							$studycoursesController->insertStudycourse($_POST);	//sonst alles eintragen
							require_once 'backend_insertConfirmation.php';	//und best?tigung anzeigen
						}
						unset($error);
					}
					if(isset($_POST["delete_btn"])){	//Wenn etwas gel?scht werden soll
						if(!isset($_POST["deleteConfirm_btn"]))	//Wurde schon best?tigt, ob der Studiengang wirklich gel?scht werden soll? Wenn nein, dann
							require_once 'backend_deleteConfirmation.php';	//Frage nach ob der Studiengang wirklich gel?scht werden soll
						else{	//sonst l?che ihn und gebe eine best?tigung aus
							$studycoursesController->deleteStudicourse($_POST["id"]);	//Dann l?schen		
							echo "<p>Studiengang gel&ouml;scht</p>";
							require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und l?schen der Studieng?nge wieder anzeigen
						}							
							
					}
					if(isset($_POST["edit_btn"])){	//Wenn etwas gel?scht werden soll
						echo "edit";
					}
					unset($error);
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