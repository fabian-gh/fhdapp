<?php
	echo "<h1>FAQ</h1>";
	//Controller einbinden
	require_once 'controllers/faqController.php';
	//Controller-Objekt erstellen
	$controller = new FaqController();
	//Bestimmung des Fachbereichs aus dem gewählten Studiengang
	$dept = $controller->getDepartmentFromCourse($_GET['course']) ;
	//Entsprechende FAQs auslesen
	$resultSet = $controller->getFAQsFrontend($dept, $_GET['eis']);	
	//Auflistung der FAQs mit einem Collasible Set
	echo "<div data-role='collapsible-set' data-iconpos='right' data-theme='a' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d'>";										
	//FAQs auflisten					
	for($i=0; $i<count($resultSet); $i++) {
		$frage = $resultSet[$i]['question'];
		$antwort = $resultSet[$i]['answer'];
		
		if($i == 0)
			echo "<div data-role='collapsible' data-collapsed='false'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Erste FAQ aufklappen
		else
			echo "<div data-role='collapsible'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Rest zugeklappt lassen
	}
	echo "</div>";
?>

