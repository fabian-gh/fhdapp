<h1>FAQ</h1>
<?php
	//Controller einbingen
	require_once 'controllers/faqController.php';
	$controller = new FaqController();
	//Bestimmung des Fachbereichs aus dem gewählten Studiengang
	$dept = $controller->getDepartmentFromCourse($_GET['course']) ;
	//Entsprechende FAQs auslesen
	$resultSet = $controller->getFAQsFrontend($dept, $_GET['eis']);
	//Collapsible-Set erstellen
	echo "<div data-role='collapsible-set'>";								
	//FAQs auflisten					
	for($i=0; $i<count($resultSet); $i++) {
		$frage = $resultSet[$i]['question'];
		$antwort = $resultSet[$i]['answer'];
		if($i == 0)
			echo "<div data-role='collapsible' data-iconpos='right' data-theme='a' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-collapsed='false'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Erste FAQ aufklappen
		else
			echo "<div data-role='collapsible' data-iconpos='right' data-theme='a' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d'><h1>$frage</h1><tr><td>$antwort</td></tr></div>";; //Rest zugeklappt lassen
	}
	echo "</div>";
?>

