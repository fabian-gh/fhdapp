<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Sascha Möller (FM), <sascha.moeller@fh-duesseldorf.de>
 */
	ob_start();
	
	//Header einbinden
	require_once '../../layout/backend/header.php';
	
	//Conroller einbinden
	require_once '../../controllers/veranstaltungenController.php';
	$Controller = new VeranstaltungenController;
	
	//Fachbereiche laden
	$FACHBEREICHE =  $Controller->getDepartments();
	
	//Klasse für Formularfelder einbinden
	require_once 'backend_formular.php';

	if(isset($_GET['FB']))
		$FB_GET = $_GET['FB'];
	else
		$FB_GET = 1;
	
	//Variable für alle JQuery Methoden, wird am Ende des Dokuments ausgegeben
	$JQUERY = '';
	$MESSAGE = '';
	
	//Überprüfung ob Formular abgesendet wurde
	if(isset($_POST['veranstaltung_speichern']))
	{
		if($_POST['veranstaltung_id'] == 'new')
		{
			//Neue Veranstaltung hinzufügen
			if($Controller->addEvent() == false)
				$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Veranstaltung wurde nicht eingetragen.';
			else
				$MESSAGE = 'Veranstaltung wurde eingetragen.';
		}
		else
		{
			//Veranstaltung ändern = Veranstaltung löschen + Veranstaltung neu hinzufügen
			if($Controller->deleteEvent($_POST['veranstaltung_id']) == false)
			{
				$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Veranstaltung wurde nicht ge&auml;ndert.';
			}
			else
			{
				//Veranstaltung wurde ohne Fehler gelöscht, Veranstaltung neu einfügen
				if($Controller->addEventID($_POST['veranstaltung_id']) == false)
					$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Veranstaltung wurde nicht ge&auml;ndert.';
				else
					$MESSAGE = 'Veranstaltung wurde ge&auml;ndert.';
			}
		}		
	}
	else if(isset($_POST['loeschen']))
	{
		if($Controller->deleteEvent($_POST['loeschen']) == true)
			$MESSAGE = 'Veranstaltung wurde gel&ouml;scht.';
		else
			$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Veranstaltung wurde nicht gel&ouml;scht.';
	}
	
	echo '
		<div class="veranstaltung_message" style="border-width:1px; border-style:solid;">
		'.$MESSAGE.'
		</div>
	';
	
	echo '<br/><br/><br/><br/>';
	
	//Neues Objekt von Formular erstellen
	$Formular = new Formular($Controller);
	//Leeres Formular erstellen
	echo $Formular->getEmptyForm($FB_GET);
	//JQuery für das leere Formular erstellen
	$JQUERY .= $Formular->getJqueryEmptyForm();
	
	echo '<br/><br/><br/><br/>';
	
	//Fachbereiche durchlaufen und DropDownListe füllen
	if($FACHBEREICHE != null)
	{
		$INPUT_FACHBEREICH = '';
		//Durch alle Fachbereiche durchlaufen
		for($i=0; $i<count($FACHBEREICHE); $i++) 
		{
			//Überprüfen ob Fachbereiche der ausgewählte ist
			if($FACHBEREICHE[$i]['id'] == $FB_GET)
				$INPUT_FACHBEREICH .= '<option value="'.$FACHBEREICHE[$i]['id'].'" SELECTED> '.$FACHBEREICHE[$i]['name'].' </option>
				';
			else
				$INPUT_FACHBEREICH .= '<option value="'.$FACHBEREICHE[$i]['id'].'" > '.$FACHBEREICHE[$i]['name'].' </option>
				';
		}
		//Komplette DropDownListe ausgeben
		echo'
			<div id="div_fachbereich_auswahl">
				<h3>W&auml;hlen Sie den Fachbereich aus f&uuml;r den Sie die Veranstaltungen bearbeiten m&ouml;chten</h3>
				<form id="fachbereich_auswahl" action="">
					<select id="fachbereich_select" name="FB" size="1">
						'.$INPUT_FACHBEREICH.'
					</select>
				</form>
			</div>
		';
	}
	else
	{
		//Falls keine Fachbereiche in der Datenbank, Fehlermeldung ausgeben
		echo 'Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden';
	}
		
		
	
	echo '<br/><br/><br/><br/>';
	
	//Datenbank-Abfrage alle Veranstaltungen für aktuellen Fachbereich laden
	$ERGEBNIS =  $Controller->getInformationEventsWithDepartmentsWihoutUsertype($FB_GET);
	
	if($ERGEBNIS != null)
	{
		//Veranstaltungen durchlaufen und darstellen
		for($i=0; $i<count($ERGEBNIS); $i++) 
		{
			$NAME				= $ERGEBNIS[$i]['name'];
			$EVENTID			= $ERGEBNIS[$i]['id'];
			$BESCHREIBUNG		= $ERGEBNIS[$i]['description'];	
			$DATUM				= new DateTime($ERGEBNIS[$i]['date']);		
			
			//DATUM SPLITTEN
			$TAG		= date_format($DATUM, 'd');
			$MONAT		= date_format($DATUM, 'm');
			$JAHR		= date_format($DATUM, 'Y');
			$STUNDEN	= date_format($DATUM, 'H');
			$MINUTEN	= date_format($DATUM, 'i');
			
						
			//Alle Fachbereiche laden, die zur Veranstaltung gehören
			$ERGEBNIS_FB = $Controller->getInformationDepartmentsFromEvents($EVENTID);
			//Alle Usertypes laden, die zur Veranstaltung gehören
			$ERGEBNIS_USER = $Controller->getInformationUsertypesFromEvents($EVENTID);

			//Neues Objekt von Formular erstellen
			$Formular = new Formular($Controller);
			//Alle Variablen setzen
			$Formular->setALL($NAME, $EVENTID, $TAG, $MONAT, $JAHR, $STUNDEN, $MINUTEN, $BESCHREIBUNG, $ERGEBNIS_FB, $ERGEBNIS_USER);
			//Veranstaltung darstellen mit Bearbeiten-Option
			echo $Formular->getEventContainer($FB_GET);
			echo '<br/><br/>';
			//JQuery erstellen
			$JQUERY .= $Formular->getJquery();
		}
	}
	else
	{
		echo "Kein Datensatz vorhanden!";
	}

	echo '<br/><br/><br/><br/>';
	
	//JQuery Ausgeben
	echo '
		<script type="text/javascript">
				$(function(){
				
				$("#fachbereich_select").change(function(){
					$("#fachbereich_auswahl").submit();
				});
				
				'.$JQUERY.'	
			});
			
			function checkStunden(Zahl){
				Zahl = parseInt(Zahl);
				if (!isNaN(Zahl))
				{
					if(Zahl >= 0 && Zahl <= 23)
						return true;
					else
						return false;
				} else {
					return false;
				}
			}
			
			function checkMinuten(Zahl){
				Zahl = parseInt(Zahl);
				if (!isNaN(Zahl))
				{
					if(Zahl >= 0 && Zahl <= 59)
						return true;
					else
						return false;
				} else {
					return false;
				}
			}

			
			function checkDatum(TAG,MONAT,JAHR)
			{
				MONAT = MONAT - 1;
				// Erzeugung eines neuen Dateobjektes
				var REALDATE = new Date(JAHR,MONAT,TAG);
				
				// Überprüfung ob das Datum stimmt
				if (REALDATE.getDate()== TAG && REALDATE.getMonth()== MONAT && REALDATE.getFullYear()== JAHR)
					return true; 
				else 
					return false;
			}

			function checkText(Text){
				if (Text == "")
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		</script>';
	
	
	require_once '../../layout/backend/footer.php';
	ob_end_flush();
	/* End of file veranstaltungen_edit.php */
	/*
					$("#new_formular_button").click(function(){
						hide_all();
						$("#new_formular").slideToggle("fast");
					});
	*/
	/* Location: ./views/veranstaltungen/veranstaltungen_edit.php */
?>