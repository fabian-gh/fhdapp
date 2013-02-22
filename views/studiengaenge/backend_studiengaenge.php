<?php ob_start();

/**
*	Dateiname: "backend_studiengaenge.php"
*	Zweck:	Diese Datei ist die Präsentationsebene im MVC-Muster.
*			Diese Datei steuert die Präsentationen, also dei Ausgaben des Bereiches "Studiengänge" in der Redaktion.
*			Diese Datei bestimmt, welche Dateien wann eingebunden werden sollen.
*	Benutzt von: "../../layout/backend/header.php"
*	Autor Name: Okan Köse
*	Autor E-Mail: okan.koese@gmx.de	
**/

    require_once '../../layout/backend/header.php';	//Backend-Header einbinden
	
	require_once '../../controllers/studiengaengeControllerBackend.php';	//Studiengänge-Controller einbinden
	$studycoursesController = new StudycoursesController();	//neues ControllerObjekt erzeugen und in der Variabel speichern
	
	echo "<script type=\"text/javascript\">$('#liStudyCourses').attr('class', 'active');</script>";	//Link "Studiengänge"(in der Navigation) aktivieren (rot markieren)
	
	echo "<h2>Studieng&auml;nge</h2>";	//Ausgabe der Überschrift "Studiengänge"

	
	
/******************** Beginn der Steuerung ********************/


		/*----- Wenn etwas eingefügt werden soll (mit method="post" - $_POST) -----*/
		if(isset($_POST["insertStudycourse_btn"])){	//Wenn das Formular (in der backend_insertUpdate.php) abgeschickt wurde
			$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Formular(aus backend_insertUpdate.php) mit der Methode 'checkInsertEditFormular' auf eine fehlerhafte Eingabe überprüfen
			if(!empty($error))	//Wenn die Variable '$error' nicht leer ist (Es liegt eine FEHLERHAFTE EINGABE vor. '$error' ist nun ein assoziatives Array, das die Namen der fehlerhaften Eingabefelder als assoziativen Index enthält) 
				require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen und bearbeiten der Studiengänge (backend_insertUpdateFormular.php) anzeigen
			else{	//Wenn "$error" leer ist, also KEIN Fehler bei der Eingabe vorliegt
				$_POST["link"] = $studycoursesController->addHttp($_POST["link"]);	//Fügt dem Link (Link für weitere Informationen über den Studiengan, siehe backend_insertUpdateFormular.php) ein "http://" hinzu, falls nicht vorhanden
				$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//Studiengan eintragen (mit der Methode "insertStudycourse($_POST)") und die ID dieses Studiengangs in "$lastStudiID" abspeichern. "$lastStudiId" wird benötigt, falls bei der Bestätigung (backend_insertUpdateConfirmation.php) des neu eingefügten Studiengangs dieser sofort bearbeitet werden soll.
				require_once 'backend_insertUpdateConfirmation.php';	//Bestätigung des eingefügten Studiengangs anzeigen
				unset($lastStudiID);	//Löscht die Variable
			}
			unset($error);	//Löscht die Variable
		}
		
		
		
		/*----- Wenn etwas gelöscht werden soll (mit method="post" - $_POST) -----*/
		elseif(isset($_POST["deleteStudycourse_btn"]) OR isset($_POST["deleteStudycourseConfirm_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "Löschen" eines Studiengangs geklickt wurde oder wenn (in der "backend_deleteConfirmation.php") der Button zum "Studiengang entgültig löschen" geklickt wurde
			if(isset($_POST["deleteStudycourse_btn"]))	//Wenn (m "backend_showStudycourses.php") der Button zum "Löschen" geklickt wurde
				require_once 'backend_deleteConfirmation.php';	//Frage nach ob der Studiengang wirklich gelöscht werden soll
			else{	//Wenn (im "backend_deleteConfirmation.php") der Button zum "Studiengang entgültig löschen" geklickt wurde
				$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//Selektiert den zu löschenden Studiengan um:
				$_POST["graduate_name"] = $studycourse["graduate_name"];					//"graduate_name" (z.B. "Bachelor of Science") im Post abzuspechern und
				$_POST["name"] = $studycourse["name"];										//"name" (z.B. "Medieninformatik") im Post abzuspechern --> "$_POST["graduate_name"]" und "$_POST["name"]" werden in der "backend_showStudycourses.php" benötigt, um bei erfolgreichem löschen eines Studiengangs den Bestätigungstext anzuzeigen
				unset($studycourse);	//Löscht die Variable
				$studycoursesController->deleteStudicourse($_POST["id"]);	//Dann löschen		
				require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und löschen der Studiengänge wieder anzeigen
			}
		}	
		
		
		
		/*----- Wenn etwas bearbeitet werden soll (mit method="post" - $_POST) -----*/
		elseif(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "Bearbeiten" eines Studiengangs geklickt wurde oder wenn (in der "backend_insertUpdateConfirmation.php") der Button zum "Ändern bestätigen" geklickt wurde
			if(isset($_POST["editStudycourse_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "Bearbeiten" eines Studiengangs geklickt wurde
			
				//"$_POST" soll ausgefüllt werden, um (m "backend_insertUpdateConfirmation.php") die Formular-Felder mit den Daten des zu bearbeitenden Studiengangs auszufüllen.
				/* ---- "$_POST" ausfüllen - START ---- */
				$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//Daten des zu bearbeitenden Studiengangs aus der Datenbank lesen
				$_POST["graduate_id"] = $studycourse["graduate_id"];
				$_POST["graduate_name"] = $studycourse["graduate_name"];	
				$_POST["name"] = $studycourse["name"];
				$_POST["department_id"] = $studycourse["department_id"];
				$_POST["semestercount"] = $studycourse["semestercount"];
				$_POST["description"] = $studycourse["description"];
				$_POST["link"] = $studycourse["link"];
				$_POST["language_id"] = $studycourse["language_id"];
				if(isset($studycourse["vollzeit"]))	//Wenn Studiengang ein Vollzeitstudiengang ist
					$_POST["vollzeit"] = $studycourse["vollzeit"];
				if(isset($studycourse["teilzeit"]))	//Wenn Studiengang ein Teilzeitstudiengang ist
					$_POST["teilzeit"] = $studycourse["teilzeit"];
				if(isset($studycourse["dual"]))	//Wenn Studiengang ein dualer Studiengang ist
					$_POST["dual"] = $studycourse["dual"];					
				$categories = $studycoursesController->selectCategories();	//Alle Kategorien (Design, Ingenieru, ...) selektieren und in "$categories" abspeichern
				foreach($categories AS $c){	//Für jede Kategorie
					if(isset($studycourse[$c["name"]]))	//Wenn Studiengang der jeweiligen Kategorie angehört, dann
						$_POST[$c["name"]] = $studycourse[$c["name"]];	//Im "$_POST" einen assoziativen Index mit dem Kategorie-Namen erstellen
				}
				/* ---- "$_POST" ausfüllen - ENDE ---- */
				
				require_once 'backend_insertUpdateFormular.php';	//backend_insertUpdateFormular aufrufen. Das backend_insertUpdateFormular wird ausgefüllt sein, da in "showStudycourse.php" hidden fields übergeben werden, und somit das $_POST ausgefüllt ist
			}
			else{	//Wenn (im "backend_insertUpdateConfirmation.php") der Button zum "Ändern bestätigen" geklickt wurde
				$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Formular(aus backend_insertUpdate.php) mit der Methode "checkInsertEditFormular" auf eine fehlerhafte Eingabe überprüfen
				if(!empty($error))	//Wenn die Variable '$error' nicht leer ist (Es liegt eine FEHLERHAFTE EINGABE vor. '$error' ist nun ein assoziatives Array, das die Namen der fehlerhaften Eingabefelder als assoziativen Index enthält) 
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen und bearbeiten der Studiengänge (m backend_insertUpdateFormular.php) anzeigen
				else{	//Wenn KEIN Fehler bei der Eingabe vorliegt, "$error" also leer ist
					$_POST["link"] = $studycoursesController->addHttp($_POST["link"]);	//Fügt dem Link (Link für weitere Informationen über den Studiengan, siehe backend_insertUpdateFormular.php) ein "http://" hinzu, falls nicht vorhanden
					$studycoursesController->updateStudycourse($_POST);	//Den Studiengang in der Datenbank mit Hilfe der Methode "updateStudycourse($post)" aktualisieren
					require_once 'backend_insertUpdateConfirmation.php';	//Bestätigung des aktualisierten Studiengangs anzeigen
				}
			}
		}
		
		
		
		/*----- Wenn ein Link geklickt wurde (mit method="get" - $_GET) -----*/
		else{	//Weder einfügen, noch löschen, noch bearbeiten, also kein Formular abgesendet
			switch(@$_GET["action"]){	//Switch-case mit Hilfe der "action" Variable aus der URL
				case "einfuegen":	
					$_POST["vollzeit"] = 4;	//"4" ist der Wert für "Vollzeit" aus der Relation "categories". Dies wird im Post gespeichert, damit im backend_insertUpdate.php die Checkbox "Vollzeit" gecheckt ist, wenn man einen neuen Studiengang einfügen will
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einfügen und bearbeiten der Studiengänge (backend_insertUpdateFormular.php) anzeigen
					break;
				case "bearbeitenLoeschen":
					require_once 'backend_showStudycourses.php';	//Formular zum einfügen und bearbeiten der Studiengänge (backend_showStudycourses.php) anzeigen
					break;
				default:	//Wenn keine "action"-Variable in der URL vorhanden ist
					?>	<!-- Erklären was in dem Arbeitspaket "Studiengänge" alles gemacht werden kann -->
					<h3>Studieng&auml;ge einf&uuml;gen oder bearbeiten/l&ouml;schen</h3>
					<div class="singleField" style="line-height: 140%;">
						<p>In diesem Bereich k&ouml;nnen Sie Studieng&auml;nge in die Datenbank der fhdapp einf&uuml;gen.</p>
						<p>Desweiteren k&ouml;nnen Sie schon vorhandene Studieng&auml;nge bearbeiten und auch</p>
						<p> wieder aus der Datenbank l&ouml;schen.</p>
						<br />
						<p>Um mit dem gew&uuml;nschten Arbeitsschritt fortzufahren, w&auml;hlen Sie bitte links in der</p>
						<p>Navigation den gew&uuml;nschten Arbeitsschritt aus, oder benutzen Sie einen der</p>
						<p>Folgenden Schaltfl&auml;schen: </p>
						<br />
					</div>
						<!-- und zwei Buttons ausgeben, um entweder einen Studiengang einzufügen oder schon vorhandene Studiengänge zu bearbeiten/löschen 
							Es gibt einen Link um die Buttons, also wird di "action"-Variable in der URL erstellt und wird das switch-case (s.o.) abgearbeitet -->
					<div class="singleField">	
						<a href="?page=Studiengaenge&action=einfuegen"><input class="studycourseButtons" type="submit" value="Einen neuen Studiengang einf&uuml;gen"></a>	<!-- Button um zum "Einfügen von Studiengängen" zu gelangen, setzt deeplink auf "?page=Studiengaenge&action=einfuegen" -->
						<a href="?page=Studiengaenge&action=bearbeitenLoeschen"><input class="studycourseButtons" type="submit" value="Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen"></a>	<!-- Button um "Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen" zu können, setzt deeplink auf "?page=Studiengaenge&action=bearbeitenLoeschen" -->
					</div>
					<?php
					break;
			}
		}
		
/******************** Ende der Steuerung ********************/
	
	

    require_once '../../layout/backend/footer.php';	//footer einbinden
	
	ob_flush();
?>		