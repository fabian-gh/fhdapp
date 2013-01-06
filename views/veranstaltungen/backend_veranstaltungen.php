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
	
	//Klasse für Formularfelder einbinden
	require_once 'backend_formular.php';
		
	//Überprüfung ob Formular abgesendet wurde
	if(isset($_POST['veranstaltung_speichern']))
	{
		echo 'Vielen Dank';
		$Controller->addDatensatz();
	}
	else
	{
		if(isset($_GET['FB']))
			$FB_GET = $_GET['FB'];
		else
			$FB_GET = 1;
		
		//Variable für alle JQuery Methoden, wird am Ende des Dokuments ausgegeben
		$JQUERY = '';
		
		//Neues Objekt von Formular erstellen
		$Formular = new Formular;
		//Leeres Formular erstellen
		echo $Formular->getEmptyForm();
		//JQuery für das leere Formular erstellen
		$JQUERY .= $Formular->getJqueryEmptyForm();
		
		echo '<br/><br/><br/><br/>';
		
		//Auswahl des Fachbereiches 
		//Leeres Array mit 8 Feldern
		$SELECTED = array('', '', '' ,'', '', '', '');
		$SELECTED[$FB_GET-1] = 'Selected';
		echo'
			<div id="div_fachbereich_auswahl">
				<h3>W&auml;hlen Sie den Fachbereich aus f&uuml;r den Sie die Veranstaltungen bearbeiten m&ouml;chten</h3>
				<form id="fachbereich_auswahl" action="">
					<select id="fachbereich_select" name="FB" size="1">
						<option value="1" '.$SELECTED[1-1].'> Fachbereich 1 - Architektur  </option>
						<option value="2" '.$SELECTED[2-1].'> Fachbereich 2 - Design </option>
						<option value="3" '.$SELECTED[3-1].'> Fachbereich 3 - Elektrotechnik </option>
						<option value="4" '.$SELECTED[4-1].'> Fachbereich 4 - Maschinenbau und Verfahrenstechnik </option>
						<option value="5" '.$SELECTED[5-1].'> Fachbereich 5 - Medien </option>
						<option value="6" '.$SELECTED[6-1].'> Fachbereich 6 - Sozial- und Kulturwissenschaften </option>
						<option value="7" '.$SELECTED[7-1].'> Fachbereich 7 - Wirtschaft </option>
					</select>
				</form>
			</div>
		';
		
		echo '<br/><br/><br/><br/>';
		
		//Datenbank-Abfrage alle Veranstaltungen für aktuellen Fachbereich laden
		$ERGEBNIS =  $Controller->getInformationEventsWithDepartmentsWihoutUsertype($FB_GET);
		
		if($ERGEBNIS != null)
		{
			//Veranstaltungen durchlaufen und darstellen
			for($i=0; $i<count($ERGEBNIS); $i++) 
			{
				$NAME = $ERGEBNIS[$i]['name'];
				$ID = $ERGEBNIS[$i]['id'];
				$BESCHREIBUNG = $ERGEBNIS[$i]['description'];	
				$DATUM = new DateTime($ERGEBNIS[$i]['date']);		
				
				//DATUM SPLITTEN
				$TAG = 		date_format($DATUM, 'd');
				$MONAT = 	date_format($DATUM, 'm');
				$JAHR = 	date_format($DATUM, 'Y');
				$STUNDEN = 	date_format($DATUM, 'H');
				$MINUTEN =	date_format($DATUM, 'i');
				
				$FB1			= '  ';  	
				$FB2			= '  ';  	
				$FB3			= '  ';  	
				$FB4			= '  ';  	
				$FB5			= '  ';  	
				$FB6			= '  ';  	
				$FB7			= 'X ';  	
				$INTERESSENT	= '  ';	
				$STUDENT		= '  ';	
				$ERSTI			= '  ';	
				
				//Neues Objekt von Formular erstellen
				$Formular = new Formular;
				//Alle Variablen setzen
				$Formular->setALL(
								$NAME, 
								$ID, 
								$TAG, 
								$MONAT, 
								$JAHR, 
								$STUNDEN, 
								$MINUTEN, 
								$BESCHREIBUNG, 
								$FB1, 
								$FB2, 
								$FB3, 
								$FB4, 
								$FB5, 
								$FB6, 
								$FB7, 
								$INTERESSENT,
								$STUDENT, 
								$ERSTI
								);
				//Veranstaltung darstellen mit Bearbeiten-Option
				echo $Formular->getEventContainer($FB_GET);
				//JQuery erstellen
				$JQUERY .= $Formular->getJquery();
			}
		}
		else
		{
			echo "Kein Datensatz vorhanden!";
		}
				
		//require_once 'backend_datenbank_eintraege_control.php';
		echo '<br/><br/><br/><br/>';
		
		echo '
			<script type="text/javascript">
					$(function(){
					
					$("#fachbereich_select").change(function(){
						$("#fachbereich_auswahl").submit();
					});
					
					'.$JQUERY.'	
				});
			</script>
		';
	}
	
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