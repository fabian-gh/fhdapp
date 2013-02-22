<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2013
 * @link http://www.fh-duesseldorf.de
 * @author Jan Brinkmann>
 */
	ob_start();
	require_once 'controllers/veranstaltungenController.php';
	
	$Controller = new VeranstaltungenController();
	//Fachbereich ID wird immer auf 5 (Medien) gesetzt, wenn kein Studiengang in der Adresszeile zu finden ist
	(!isset($_GET['course']))? $dept = 5:$dept = $Controller->getDepartmentFromStudycourse($_GET['course']);
	//Auslesen der Veranstaltungstabelle in der Datenbank mit Benutzertyp und Fachbereich ID
	$ergebnis =  $Controller->getInformation($_GET['eis'],$dept);
		
		//Ausgabe Überschrift
		echo "<div data-role='collapsible-set' data-theme='a'> <h1>Veranstaltungen</h1>" ;
			//Falls keine Datensätze vorhanden sind, dann sollte dies auch angezeigt werden
			if( $ergebnis != null )
			{	
				//Array durchlaufen/auslesen und Informationen ausgeben
				for($i=0; $i<count($ergebnis); $i++) 
				{
					$Name = $ergebnis[$i]['name'];
					$Beschreibung = $ergebnis[$i]['description'];
					
					//Daten ordetnlich formatiert
					$Datum = new DateTime($ergebnis[$i]['date']);
					$Monat = 	date_format($Datum, 'm');
					$Tag   = 	date_format($Datum, 'd');
					$Monat = 	date_format($Datum, 'm');
					$Jahr  = 	date_format($Datum, 'Y');			
					$Stunden = 	date_format($Datum, 'H');
					$Minuten =	date_format($Datum, 'i');
					
					//Ausgabe
				
					echo "<div data-role='collapsible' data-iconpos='right' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-theme='a'>
					
					<h3>$Name</h3>
					<p><h4>$Tag.$Monat.$Jahr &ensp; &ensp;$Stunden:$Minuten Uhr</h4></p><br>
					<p>$Beschreibung</p></div>";
				}
			}
			else
				echo '<div>Es sind keine Veranstaltungen vorhanden</div>';

	ob_end_flush();
	/* End of file veranstaltungen.php */
?>