<<<<<<< HEAD
<<<<<<< HEAD
<?php
//Controller einbinden
require_once '../../controllers/faqController.php';
//Objekt erstellen
$controller = new FaqController();

require_once '../../layout/frontend/header.php';
$user = 1;
$deptcookie = 1;
?>
				<div data-role="collapsible-set">				

					<form name="Formular" method="post" action="faq.php">
							<input type="checkbox" name="dept" value="0"<?php echo isset($_POST['dept']) ? ' checked="checked" ' : ''; ?> > Alle FB 
							<input type="submit" name="formSubmit" value="Anzeigen">
						  </form><br>
					

					<?php
					($_POST['dept'] != null) ? $dept = $_POST['dept'] : $dept = $deptcookie;
														
					$resultSet = $controller->getFAQsFrontend($user,$dept);				
										
					for($i=0; $i<count($resultSet); $i++) {
						$frage = $resultSet[$i]['question'];
						$antwort = $resultSet[$i]['answer'];
						
						echo "<div data-role='collapsible' data-theme='a'><h3>$frage</h3><p>$antwort</p></div>";
					}
					?>
				</div>
<?php
require_once '../../layout/frontend/footer.php';
=======
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
>>>>>>> origin/daniel16.02
=======
<?php
//Controller einbinden
require_once '../../controllers/faqController.php';
//Objekt erstellen
$controller = new FaqController();

require_once '../../layout/frontend/header.php';
$user = 1;
$deptcookie = 1;
?>
				<div data-role="collapsible-set">				

					<form name="Formular" method="post" action="faq.php">
							<input type="checkbox" name="dept" value="0"<?php echo isset($_POST['dept']) ? ' checked="checked" ' : ''; ?> > Alle FB 
							<input type="submit" name="formSubmit" value="Anzeigen">
						  </form><br>
					

					<?php
					($_POST['dept'] != null) ? $dept = $_POST['dept'] : $dept = $deptcookie;
														
					$resultSet = $controller->getFAQsFrontend($user,$dept);				
										
					for($i=0; $i<count($resultSet); $i++) {
						$frage = $resultSet[$i]['question'];
						$antwort = $resultSet[$i]['answer'];
						
						echo "<div data-role='collapsible' data-theme='a'><h3>$frage</h3><p>$antwort</p></div>";
					}
					?>
				</div>
<?php
require_once '../../layout/frontend/footer.php';
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
?>