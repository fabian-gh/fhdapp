<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Jan Brinkmann>
 */
	ob_start();

	require_once 'controllers/veranstaltungenController.php';
	$Controller = new VeranstaltungenController();
	(!isset($_GET['course']))? $dept = 5:$dept = $Controller->getDepartmentFromStudycourse($_GET['course']);

	$ergebnis =  $Controller->getInformation($_GET['eis'],$dept);

		echo "<div data-role='collapsible-set' data-theme='a'> <h1>Veranstaltungen</h1>" ;
				//Falls keine Datensätze vorhanden sind
				if( $ergebnis != null )
				{	//array durchlaufen und informationen ausgeben
					for($i=0; $i<count($ergebnis); $i++) 
					{
						$Name = $ergebnis[$i]['name'];
						$Beschreibung = $ergebnis[$i]['description'];
						//$Datum =$ergebnis[$i]['date'];
						//Daten ordetnlich formatiert
						$Datum = new DateTime($ergebnis[$i]['date']);
						$Monat = 	date_format($Datum, 'm');
						$Tag   = 	date_format($Datum, 'd');
						$Monat = 	date_format($Datum, 'm');
						$Jahr  = 	date_format($Datum, 'Y');			
						$Stunden = 	date_format($Datum, 'H');
						$Minuten =	date_format($Datum, 'i');

						//Ausgabe
						echo "<div data-role='collapsible' data-theme='a'>
						
						<h3>$Name</h3>
						<p><h4>$Tag.$Monat.$Jahr &ensp; &ensp;$Stunden:$Minuten Uhr</h4></p><br>
						<p>$Beschreibung</p></div>";
					}
				}
				else
					echo '<div>Es sind keine Veranstaltungen vorhanden</div>';

		;

	ob_end_flush();
	/* End of file veranstaltungen.php */
	/* Location: ./views/veranstaltungen/veranstaltungen.php */
?>