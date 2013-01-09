<?php
//Controller einbinden
require_once '../../controllers/faqController.php';
//Objekt erstellen
$controller = new FaqController();
	
	//TestVariable zum übersenden
	$test="Wie toll ist die FHD?";	
	
	$resultSet = $controller->getTestData($test);				
						
	//Test Ausgabe
	for($i=0; $i<count($resultSet); $i++) {
		$back1 = $resultSet[$i]['question'];
		//$back2 = $resultSet[$i]['answer'];
		
		//echo "back1=$back1 </br>back2=$back2";
		echo "back1=$back1";
	}
		
				
	
?>