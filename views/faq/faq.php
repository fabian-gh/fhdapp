<?php
	//Controller einbinden
	require_once 'controllers/faqController.php';
	//Objekt erstellen
	$controller = new FaqController();


	echo "<div data-role='collapsible-set'>";								

	(!isset($_GET['dept']))? $dept = 0 : $dept = $_GET['dept'];
		
	$resultSet = $controller->getFAQsFrontend($dept, $_GET['eis']);				
						
	for($i=0; $i<count($resultSet); $i++) {
		$frage = $resultSet[$i]['question'];
		$antwort = $resultSet[$i]['answer'];
		
		if($i == 0)
			echo "<div data-role='collapsible' data-theme='a' data-collapsed='false'><h1>$frage</h1><tr><td>$antwort</td></tr></div>";
		else
			echo "<div data-role='collapsible' data-theme='a'><h1>$frage</h1><tr><td>$antwort</td></tr></div>";
	}
	echo "</div>";
?>