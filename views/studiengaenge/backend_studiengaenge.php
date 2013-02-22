<?php ob_start();

/**
*	Dateiname: "backend_studiengaenge.php"
*	Zweck:	Diese Datei ist die Pr�sentationsebene im MVC-Muster.
*			Diese Datei steuert die Pr�sentationen, also dei Ausgaben des Bereiches "Studieng�nge" in der Redaktion.
*			Diese Datei bestimmt, welche Dateien wann eingebunden werden sollen.
*	Benutzt von: "../../layout/backend/header.php"
*	Autor Name: Okan K�se
*	Autor E-Mail: okan.koese@gmx.de	
**/

    require_once '../../layout/backend/header.php';	//Backend-Header einbinden
	
	require_once '../../controllers/studiengaengeControllerBackend.php';	//Studieng�nge-Controller einbinden
	$studycoursesController = new StudycoursesController();	//neues ControllerObjekt erzeugen und in der Variabel speichern
	
	echo "<script type=\"text/javascript\">$('#liStudyCourses').attr('class', 'active');</script>";	//Link "Studieng�nge"(in der Navigation) aktivieren (rot markieren)
	
	echo "<h2>Studieng&auml;nge</h2>";	//Ausgabe der �berschrift "Studieng�nge"

	
	
/******************** Beginn der Steuerung ********************/


		/*----- Wenn etwas eingef�gt werden soll (mit method="post" - $_POST) -----*/
		if(isset($_POST["insertStudycourse_btn"])){	//Wenn das Formular (in der backend_insertUpdate.php) abgeschickt wurde
			$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Formular(aus backend_insertUpdate.php) mit der Methode 'checkInsertEditFormular' auf eine fehlerhafte Eingabe �berpr�fen
			if(!empty($error))	//Wenn die Variable '$error' nicht leer ist (Es liegt eine FEHLERHAFTE EINGABE vor. '$error' ist nun ein assoziatives Array, das die Namen der fehlerhaften Eingabefelder als assoziativen Index enth�lt) 
				require_once 'backend_insertUpdateFormular.php';	//Formular zum einf�gen und bearbeiten der Studieng�nge (backend_insertUpdateFormular.php) anzeigen
			else{	//Wenn "$error" leer ist, also KEIN Fehler bei der Eingabe vorliegt
				$_POST["link"] = $studycoursesController->addHttp($_POST["link"]);	//F�gt dem Link (Link f�r weitere Informationen �ber den Studiengan, siehe backend_insertUpdateFormular.php) ein "http://" hinzu, falls nicht vorhanden
				$lastStudiID = $studycoursesController->insertStudycourse($_POST);	//Studiengan eintragen (mit der Methode "insertStudycourse($_POST)") und die ID dieses Studiengangs in "$lastStudiID" abspeichern. "$lastStudiId" wird ben�tigt, falls bei der Best�tigung (backend_insertUpdateConfirmation.php) des neu eingef�gten Studiengangs dieser sofort bearbeitet werden soll.
				require_once 'backend_insertUpdateConfirmation.php';	//Best�tigung des eingef�gten Studiengangs anzeigen
				unset($lastStudiID);	//L�scht die Variable
			}
			unset($error);	//L�scht die Variable
		}
		
		
		
		/*----- Wenn etwas gel�scht werden soll (mit method="post" - $_POST) -----*/
		elseif(isset($_POST["deleteStudycourse_btn"]) OR isset($_POST["deleteStudycourseConfirm_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "L�schen" eines Studiengangs geklickt wurde oder wenn (in der "backend_deleteConfirmation.php") der Button zum "Studiengang entg�ltig l�schen" geklickt wurde
			if(isset($_POST["deleteStudycourse_btn"]))	//Wenn (m "backend_showStudycourses.php") der Button zum "L�schen" geklickt wurde
				require_once 'backend_deleteConfirmation.php';	//Frage nach ob der Studiengang wirklich gel�scht werden soll
			else{	//Wenn (im "backend_deleteConfirmation.php") der Button zum "Studiengang entg�ltig l�schen" geklickt wurde
				$studycourse = $studycoursesController->selectStudicourse($_POST["id"]);	//Selektiert den zu l�schenden Studiengan um:
				$_POST["graduate_name"] = $studycourse["graduate_name"];					//"graduate_name" (z.B. "Bachelor of Science") im Post abzuspechern und
				$_POST["name"] = $studycourse["name"];										//"name" (z.B. "Medieninformatik") im Post abzuspechern --> "$_POST["graduate_name"]" und "$_POST["name"]" werden in der "backend_showStudycourses.php" ben�tigt, um bei erfolgreichem l�schen eines Studiengangs den Best�tigungstext anzuzeigen
				unset($studycourse);	//L�scht die Variable
				$studycoursesController->deleteStudicourse($_POST["id"]);	//Dann l�schen		
				require_once 'backend_showStudycourses.php';	//Formular zum bearbeiten und l�schen der Studieng�nge wieder anzeigen
			}
		}	
		
		
		
		/*----- Wenn etwas bearbeitet werden soll (mit method="post" - $_POST) -----*/
		elseif(isset($_POST["editStudycourse_btn"]) OR isset($_POST["editStudycourseConfirm_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "Bearbeiten" eines Studiengangs geklickt wurde oder wenn (in der "backend_insertUpdateConfirmation.php") der Button zum "�ndern best�tigen" geklickt wurde
			if(isset($_POST["editStudycourse_btn"])){	//Wenn (im "backend_showStudycourses.php") der Button zum "Bearbeiten" eines Studiengangs geklickt wurde
			
				//"$_POST" soll ausgef�llt werden, um (m "backend_insertUpdateConfirmation.php") die Formular-Felder mit den Daten des zu bearbeitenden Studiengangs auszuf�llen.
				/* ---- "$_POST" ausf�llen - START ---- */
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
				foreach($categories AS $c){	//F�r jede Kategorie
					if(isset($studycourse[$c["name"]]))	//Wenn Studiengang der jeweiligen Kategorie angeh�rt, dann
						$_POST[$c["name"]] = $studycourse[$c["name"]];	//Im "$_POST" einen assoziativen Index mit dem Kategorie-Namen erstellen
				}
				/* ---- "$_POST" ausf�llen - ENDE ---- */
				
				require_once 'backend_insertUpdateFormular.php';	//backend_insertUpdateFormular aufrufen. Das backend_insertUpdateFormular wird ausgef�llt sein, da in "showStudycourse.php" hidden fields �bergeben werden, und somit das $_POST ausgef�llt ist
			}
			else{	//Wenn (im "backend_insertUpdateConfirmation.php") der Button zum "�ndern best�tigen" geklickt wurde
				$error = $studycoursesController->checkInsertEditFormular($_POST);	//Das Formular(aus backend_insertUpdate.php) mit der Methode "checkInsertEditFormular" auf eine fehlerhafte Eingabe �berpr�fen
				if(!empty($error))	//Wenn die Variable '$error' nicht leer ist (Es liegt eine FEHLERHAFTE EINGABE vor. '$error' ist nun ein assoziatives Array, das die Namen der fehlerhaften Eingabefelder als assoziativen Index enth�lt) 
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einf�gen und bearbeiten der Studieng�nge (m backend_insertUpdateFormular.php) anzeigen
				else{	//Wenn KEIN Fehler bei der Eingabe vorliegt, "$error" also leer ist
					$_POST["link"] = $studycoursesController->addHttp($_POST["link"]);	//F�gt dem Link (Link f�r weitere Informationen �ber den Studiengan, siehe backend_insertUpdateFormular.php) ein "http://" hinzu, falls nicht vorhanden
					$studycoursesController->updateStudycourse($_POST);	//Den Studiengang in der Datenbank mit Hilfe der Methode "updateStudycourse($post)" aktualisieren
					require_once 'backend_insertUpdateConfirmation.php';	//Best�tigung des aktualisierten Studiengangs anzeigen
				}
			}
		}
		
		
		
		/*----- Wenn ein Link geklickt wurde (mit method="get" - $_GET) -----*/
		else{	//Weder einf�gen, noch l�schen, noch bearbeiten, also kein Formular abgesendet
			switch(@$_GET["action"]){	//Switch-case mit Hilfe der "action" Variable aus der URL
				case "einfuegen":	
					$_POST["vollzeit"] = 4;	//"4" ist der Wert f�r "Vollzeit" aus der Relation "categories". Dies wird im Post gespeichert, damit im backend_insertUpdate.php die Checkbox "Vollzeit" gecheckt ist, wenn man einen neuen Studiengang einf�gen will
					require_once 'backend_insertUpdateFormular.php';	//Formular zum einf�gen und bearbeiten der Studieng�nge (backend_insertUpdateFormular.php) anzeigen
					break;
				case "bearbeitenLoeschen":
					require_once 'backend_showStudycourses.php';	//Formular zum einf�gen und bearbeiten der Studieng�nge (backend_showStudycourses.php) anzeigen
					break;
				default:	//Wenn keine "action"-Variable in der URL vorhanden ist
					?>	<!-- Erkl�ren was in dem Arbeitspaket "Studieng�nge" alles gemacht werden kann -->
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
						<!-- und zwei Buttons ausgeben, um entweder einen Studiengang einzuf�gen oder schon vorhandene Studieng�nge zu bearbeiten/l�schen 
							Es gibt einen Link um die Buttons, also wird di "action"-Variable in der URL erstellt und wird das switch-case (s.o.) abgearbeitet -->
					<div class="singleField">	
						<a href="?page=Studiengaenge&action=einfuegen"><input class="studycourseButtons" type="submit" value="Einen neuen Studiengang einf&uuml;gen"></a>	<!-- Button um zum "Einf�gen von Studieng�ngen" zu gelangen, setzt deeplink auf "?page=Studiengaenge&action=einfuegen" -->
						<a href="?page=Studiengaenge&action=bearbeitenLoeschen"><input class="studycourseButtons" type="submit" value="Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen"></a>	<!-- Button um "Bereits vorhandene Studieng&auml;nge bearbeiten oder L&ouml;schen" zu k�nnen, setzt deeplink auf "?page=Studiengaenge&action=bearbeitenLoeschen" -->
					</div>
					<?php
					break;
			}
		}
		
/******************** Ende der Steuerung ********************/
	
	

    require_once '../../layout/backend/footer.php';	//footer einbinden
	
	ob_flush();
?>		