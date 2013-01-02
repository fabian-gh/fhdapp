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
?>