<?php	
		
	echo "<h1>FAQ</h1>";
	
	require_once 'controllers/faqController.php'; //Controller einbingen
	$controller = new FaqController();
	$dept = $controller->getDepartmentFromCourse($_GET['course']) ;//Bestimmung des Fachbereichs aus dem gewählten Studiengang
	
	$resultSet = $controller->getFAQsFrontend($dept, $_GET['eis']);//Entsprechende FAQs auslesen
	
	//Collapsible-Set erstellen und FAQs auflisten
	echo "<div data-role='collapsible-set' data-iconpos='right' data-collapsed-icon='arrow-r' data-expanded-icon='arrow-d' data-theme='a'>";
	if ($_GET['eis'] == 'i'){
		echo "<h2>Fragen zur Bewerbung</h2>";
		for($i=0; $i<11; $i++) {
			$frage = $resultSet[$i]['question'];
			$antwort = $resultSet[$i]['answer'];
			echo "<div data-role='collapsible'><h1>$frage</h1><tr><td>$antwort</td></tr></div>";; //Rest zugeklappt lassen
		}
		echo "</br><h2>Fragen zum Studiengang</h2>";
	}

		for($i=11; $i<count($resultSet); $i++) {
			$frage = $resultSet[$i]['question'];
			$antwort = $resultSet[$i]['answer'];
			if($i == 0)
				echo "<div data-role='collapsible' data-collapsed='false'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Erste FAQ aufklappen
			else
				echo "<div data-role='collapsible'><h1>$frage</h1><tr><td>$antwort</td></tr></div>";; //Rest zugeklappt lassen
		}
	echo "</div>";
	
?>

