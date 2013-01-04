<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */
	ob_start();
	
	require_once 'controllers/veranstaltungenController.php';
	$Controller = new VeranstaltungenController();
	
	$ergebnis =  $Controller->getInformation(1,5);
	
	
	
	//echo $details;
	
	
	echo'
		<div data-role="header">
			<h1>Veranstaltungen</h1>
		</div>
		<div data-role="content">
		<!-- akkordionmenü -->
		<div data-role="collapsible-set">
		';

		
			for($i=0; $i<count($ergebnis); $i++) 
			{
			$Name = $ergebnis[$i]['name'];
			$Beschreibung = $ergebnis[$i]['description'];
			$Datum =$ergebnis[$i]['date'];

			echo "<div data-role='collapsible' data-theme='a'>
			<h3>$Name</h3>
			<p>$Beschreibung</p>
			<p>$Datum</p></div>";
		
		
		
			/*foreach($ergebnis as $details)
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
				*/
			/*foreach($ergebnis as $temp)
			{
			$details = $temp
			echo 	'<div data-role="collapsible" data-theme="a"><h3>'.$details[0]{'name'].'</h3>
				<p>'.$details[1]['date'].'</p>
				<p>'.$details[2]['description'].'</p>
				</div>';*/
			}
	
			echo '	</div><!-- /collapsible set -->
				</div><!-- /content -->
		';

	ob_end_flush();
	/* End of file veranstaltungen.php */
	/* Location: ./views/veranstaltungen/veranstaltungen.php */
?>