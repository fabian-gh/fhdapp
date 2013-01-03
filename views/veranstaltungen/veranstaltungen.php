<?php

/**
 * FHD-App
 * Penis
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */
	ob_start();
	require_once 'layout/frontend/header.php';
	
	require_once 'controllers/veranstaltungenController.php';
	$Controller = new VeranstaltungenController();
	
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
	ob_end_flush();
	/* End of file veranstaltungen.php */
	/* Location: ./views/veranstaltungen/veranstaltungen.php */
?>