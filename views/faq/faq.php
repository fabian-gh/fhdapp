<?php
	//Controller einbinden
	require_once 'controllers/faqController.php';
	//Objekt erstellen
	$controller = new FaqController();
	//Überschrift
	echo "<h1>FAQ</h1>";
	
	//Auflistung der FAQs mit einem Collasible Set
	echo "<div data-role='collapsible-set'>";								
	
	//Falls kein Fachbereich gesetzt ist, soll "Allgemein" gesetzt werden, sonst aus dem Studiengang den Fachbereich bestimmen
	(!isset($_GET['dept']))? $dept = 0 : $dept = $controller->getDepartmentFromCourse($_GET['course']) ;
	//Entsprechende FAQs auslesen	
	$resultSet = $controller->getFAQsFrontend($dept, $_GET['eis']);				
	//FAQs auflisten					
	for($i=0; $i<count($resultSet); $i++) {
		$frage = $resultSet[$i]['question'];
		$antwort = $resultSet[$i]['answer'];
		
		if($i == 0)
			echo "<div data-role='collapsible' data-theme='a' data-collapsed='false'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Erste FAQ aufklappen
		else
			echo "<div data-role='collapsible' data-theme='a'><h1>$frage</h1><tr><td>$antwort</td></tr></div>"; //Rest zugeklappt lassen
	}
	echo "</div>";
?>

