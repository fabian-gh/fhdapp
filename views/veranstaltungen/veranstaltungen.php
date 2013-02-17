<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Jan Brinkmann>
 */
	ob_start();
<<<<<<< HEAD
<<<<<<< HEAD
	require_once 'layout/frontend/header.php';
=======
>>>>>>> origin/daniel16.02
=======
	require_once 'layout/frontend/header.php';
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	
	require_once 'controllers/veranstaltungenController.php';
	$Controller = new VeranstaltungenController();
	
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	$ergebnis =  $Controller->getInformation(1,1);
	
	
	
	//echo $details;
	
	
	echo'
		<div data-role="header">
			<h1>Veranstaltungen</h1>
		</div>
		<div data-role="content">
		<!-- akkordionmenü -->
		<div data-role="collapsible-set">
		';

	foreach($ergebnis as $details)
	{
		$zeile = explode(';',$details);
		echo 	'<div data-role="collapsible" data-theme="a"><h3>'.$zeile[0].'</h3>
				<p>'.$zeile[2].'</p>
				<p>'.$zeile[1].'</p>
				</div>';
	}
	
	echo '	</div><!-- /collapsible set -->
			</div><!-- /content -->
		';

	require_once 'layout/frontend/footer.php';
<<<<<<< HEAD
=======
	(!isset($_GET['dept']))? $dept = 5 : $dept = $_GET['dept'];
	$ergebnis =  $Controller->getInformation($_GET['eis'],$dept);
	//Alternative
	/*echo'
		<div data-role="header">
		<h1>Veranstaltungen</h1></div>
		<div data-role="content">
		<div data-role="collapsible-set">';*/
		
		echo "<div data-role='collapsible-set' data-iconpos='right' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-theme='a'> <h1>Veranstaltungen</h1>" ;
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
						echo "<div style='word-break:break-all;word-wrap:break-word' data-role='collapsible' data-theme='a' >
						<h3>$Name</h3>
						<p><h4>$Tag.$Monat.$Jahr &ensp; &ensp;$Stunden:$Minuten Uhr</h4></p><br>
						<p>$Beschreibung</p></div>";
					}
				}
				else
					echo '<div data-role="header"> &ensp; Es sind keine Veranstaltungen vorhanden</div>';
			
			/*foreach($ergebnis as $temp)
			{
			$details = $temp
			echo 	'<div data-role="collapsible" data-theme="a"><h3>'.$details[0]{'name'].'</h3>
				<p>'.$details[1]['date'].'</p>
				<p>'.$details[2]['description'].'</p>
				</div>';*/
	
			echo '	</div><!-- /collapsible set -->
				</div><!-- /content -->'
		;

>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	ob_end_flush();
	/* End of file veranstaltungen.php */
	/* Location: ./views/veranstaltungen/veranstaltungen.php */
?>