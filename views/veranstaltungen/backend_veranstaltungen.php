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
	
	if(isset($_GET['FB']))
		$FB_AKTUELLER = $_GET['FB'];
	else
		$FB_AKTUELLER = 1;
	
	//Fachbereiche laden
	$FACHBEREICHE =  $Controller->getDepartments();
	//Datenbank-Abfrage alle Veranstaltungen für aktuellen Fachbereich laden
	$ERGEBNIS =  $Controller->getInformationEventsWithDepartmentsWihoutUsertype($FB_AKTUELLER);
	
	//Klasse für Formularfelder einbinden
	require_once 'backend_formular.php';	
	
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
	}//Veranstaltung löschen, anhand der ID
	else if(isset($_POST['loeschen_id']))
	{
		if($Controller->deleteEvent($_POST['loeschen_id']) == true)
			$MESSAGE = 'Veranstaltung wurde gel&ouml;scht.';
		else
			$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Veranstaltung wurde nicht gel&ouml;scht.';
	}//Alle Veranstaltungen die älter als heute sind löschen
	else if(isset($_POST['veranstaltung_alt_loeschen']))
	{
		if($Controller->deleteOldEvent() == true)
			$MESSAGE = 'Alte Veranstaltungen wurde gel&ouml;scht.';
		else
			$MESSAGE = 'Es ist ein Fehler aufgetreten.<br/>Alte Veranstaltungen wurde nicht gel&ouml;scht.';
	}
	
	//Ausgeben der Meldung
	echo '
		<div class="veranstaltung_message" style="border-width:1px; border-style:solid;">
		'.$MESSAGE.'
		</div>
	';
	
	echo '<br/><br/><br/><br/>';
	
	//Lösch Button für alle alten Veranstaltungen
	echo '	
		<a class="button" id="loesch_button_all">Alle vergangenen Veranstaltungen l&ouml;schen</a>
			<form action="?FB='.$FB_AKTUELLER.'" id="veranstaltungen_loeschen" method="post">
				<input type="hidden" name="veranstaltung_alt_loeschen" id="loeschen_hidden_all" value="true"/>
			</form>
		<br/><br/>	
		';
	
	//Neues Objekt von Formular erstellen
	$Formular = new Formular($Controller);
	//Leeres Formular erstellen
	echo $Formular->getEmptyForm($FB_AKTUELLER);
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
			if($FACHBEREICHE[$i]['id'] == $FB_AKTUELLER)
			{
				$INPUT_FACHBEREICH .= '<option value="'.$FACHBEREICHE[$i]['id'].'" SELECTED> '.$FACHBEREICHE[$i]['name'].' </option>
				';
				$FB_AKTUELLER_NAME = $FACHBEREICHE[$i]['name'];
			}
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
			<br /><br />
			<h3>Veranstaltungen vom Fachbereich '.$FB_AKTUELLER_NAME.':</h3>
			<br /><br />
		';
	}
	else
	{
		//Falls keine Fachbereiche in der Datenbank, Fehlermeldung ausgeben
		echo 'Fehler mit der Datenbank. Fachbereiche konnten nicht geladen werden';
	}
	
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
			echo $Formular->getEventContainer($FB_AKTUELLER);
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
				
				$("#loesch_button_all").click(function(){
					MESSAGE = "Achtung!!!\nAlle vergangenen Veranstaltungen werden gelöscht!";
					if(confirm(MESSAGE))
						$("#veranstaltungen_loeschen").submit();
				});
				
				'.$JQUERY.'	
			});
			
			function checkFormular(ID){
				TAG 			= $("#veranstaltung_datum_tag_"+ID).val();
				MONAT 			= $("#veranstaltung_datum_monat_"+ID).val();
				JAHR			= $("#veranstaltung_datum_jahr_"+ID).val();
				STUNDEN			= $("#veranstaltung_uhrzeit_stunden_"+ID).val();
				MINUTEN 		= $("#veranstaltung_uhrzeit_minuten_"+ID).val();
				BESCHREIBUNG 	= $("#veranstaltung_beschreibung_"+ID).val();
				NAME 			= $("#veranstaltung_name_"+ID).val();
									
				FALSCHE_EINGABEN = "";
				CORRECT = true;
				
				//Überprüfen der Uhrzeit
				if(!(checkStunden(STUNDEN) == true && checkMinuten(MINUTEN) == true))
				{
					FALSCHE_EINGABEN += "Uhrzeit falsch.Bitte Überprüfen!\n";
					$("#div_veranstaltung_form_uhrzeit_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_uhrzeit_"+ID).css("border", "0px solid black");
				
				//Überprüfen des Datums				
				if(!(checkDatum(TAG,MONAT,JAHR) == true))
				{
					FALSCHE_EINGABEN += "Datum falsch.Bitte Überprüfen!\n";
					$("#div_veranstaltung_form_datum_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_datum_"+ID).css("border", "0px solid black");
				
				//Überprüfen ob Veranstaltungs-Beschreibung gesetzt ist	
				if(!(checkText(BESCHREIBUNG) == true))
				{
					FALSCHE_EINGABEN += "Bitte geben Sie eine Beschreibung ein!\n";
					$("#div_veranstaltung_form_beschreibung_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_beschreibung_"+ID).css("border", "0px solid black");
				
				//Überprüfen ob Veranstaltungsname gesetzt ist	
				if(!(checkText(NAME) == true))
				{
					FALSCHE_EINGABEN += "Bitte geben Sie einen Namen für die Veranstaltung ein!\n";
					$("#div_veranstaltung_form_name_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_name_"+ID).css("border", "0px solid black");
				
				//Überprüfen ob mind. 1 Fachbereicha ausgewählt ist	
				if(!(checkSelected("fieldset_veranstaltung_form_fachbereich_"+ID) == true))
				{
					FALSCHE_EINGABEN += "Es muss mindestens ein Fachbereich ausgewählt werden!\n";
					$("#div_veranstaltung_form_fachbereiche_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_fachbereiche_"+ID).css("border", "0px solid black");
				
				//Überprüfen ob mind. 1 Usertype ausgewählt ist	
				if(!(checkSelected("fieldset_veranstaltung_form_usertype_"+ID) == true))
				{
					FALSCHE_EINGABEN += "Es muss mindestens ein Modus ausgewählt werden!\n";
					$("#div_veranstaltung_form_usertype_"+ID).css("border", "2px solid red");
					CORRECT = false;
				}
				else
					$("#div_veranstaltung_form_usertype_"+ID).css("border", "0px solid black");
				
				
				if(CORRECT == false)
				{
					alert("Bitte beachten Sie:\n"+FALSCHE_EINGABEN);
					return false;
				}

				return true;
			};
			
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
			
			function checkSelected(ID)
			{
				var CHECKED = false;
				var ele = document.getElementById(ID).getElementsByTagName("input");
					for(var i=0;i<ele.length;i++)
						if(ele[i].getAttribute("type") == "checkbox")
							if(ele[i].checked == true)
								CHECKED = true;
				return CHECKED;
			}
			
			function setSelected(INPUTCLASS)
			{
				 $("."+INPUTCLASS).prop("checked", true);
			}
			
			function setUnselected(INPUTCLASS)
			{
				$("."+INPUTCLASS).removeAttr("checked");
			}
		</script>';
	
	
	require_once '../../layout/backend/footer.php';
	ob_end_flush();
	/* End of file veranstaltungen_edit.php */
	/* Location: ./views/veranstaltungen/veranstaltungen_edit.php */
?>