		<?php
		//header einbinden
		require_once '../../layout/backend/header.php';
		//Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		//�berpr�fung ob �ndern geklickt(Button wird automagically erkannt) und auf�hren der �nderung
		if(isset($_POST['change'])){
			$controller->setFaq($_POST);
		}
		
		//�berpr�fung ob l�schen geklickt(Button wird automagically erkannt) und l�schen	
		if(isset($_POST['delete'])){
			$controller->deleteFaq($_POST['id']);
		}
		
		//�berpr�fung ob Selektiert werden soll	
		if(isset($_POST['select'])){
			$resultSet = $controller->getFAQsBackend($_POST['departmentSelectID']);
			$selected = $_POST['departmentSelectID'];
		}else{
			$resultSet = $controller->getFAQsBackend(0);
			$selected = 0;
		}
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		$resultSetLang = $controller->getLang();
		
		?>
		<div id="mainContainer">
			<div id="formular">
				<a href='backend_faq.php'>FAQ Eingeben</a> 
				<br /> <br />
					<form name="Formular" method="post" action="" accept-charset="utf-8">
						Selektieren nach: 
						<select name="departmentSelectID" size="1">
						<?php
						for($n=0; $n<count($resultSetDepartments); $n++) {
							$id = $resultSetDepartments[$n]['id'];
							$name = $resultSetDepartments[$n]['name'];
							
							if($id == $selected){
								echo "<option value=\"$id\" selected>$name</option>";
							}else{
								echo "<option value=\"$id\">$name</option>";
							}
						}
						if($selected == 0){
							echo "<option value=\"0\" selected>Allgemein</option>";
						}else{
							echo "<option value=\"0\">Allgemein</option>";
						}
						
						?>
						</select>		
						&nbsp; <input  class="button" name="select" type="submit" value="OK">
					</form>
						 <br />
					<?php					
					for($i=0; $i<count($resultSet); $i++) {
						
						$z = $i+1;
						$id = $resultSet[$i]['id'];
						$frage = $resultSet[$i]['question'];
						$antwort = $resultSet[$i]['answer'];
						$sort = $resultSet[$i]['sorting'];
						$lang = $resultSet[$i]['language_id'];
						if(isset($resultSet[$i]['deptid']))
							$dept = $resultSet[$i]['deptid'];
						else
							$dept = 100;
						$user = $resultSet[$i]['userid'];
						
						echo "
						<form name=\"Formular\" method=\"post\" action=\"\" accept-charset=\"utf-8\">
					
						<table>
						<tr>
							<td>";
								 
								if($z>1){
								
								echo "<br />";

								}
								echo "$z Frage:
							</td>
						</tr>
			
							<td>
								<input type=\"hidden\" name=\"id\" value=\"$id\">
								<input type=\"hidden\" name=\"inputArt\" value=\"2\">
							
								<textarea name=\"question\" cols=\"70\" rows=\"2\">$frage</textarea>
							</td>
						</tr>
						<tr>
							<td>
								<br />
								Antwort:
							</td>
						</tr>
						<tr>
							<td>
								<textarea name=\"answer\" cols=\"70\" rows=\"2\">$antwort</textarea>
								
							</td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td >
											<br />
											Sprach ID:
										</td>
										<td >
											<br />
											&nbsp; Sortierung:
										</td>
										<td >
											<br />
											 &nbsp; Fachbereich:
										</td>
										<td >
											<br />
											 &nbsp; Modus:
										</td>
									</tr>
									<tr>
									
										<td >
											 <select name=\"lang\" size=\"1\">";
											 
											//Schleife die alle Usertypes als <option> ausgibt.
											//der passende Usertype wird dabei vorausgew�hlt
											 for($n=0; $n<count($resultSetLang); $n++) {
												$id = $resultSetLang[$n]['id'];
												$name = $resultSetLang[$n]['name'];
												
												//Vorauswahl des Usertypes aus Datenbank
												if($id == $lang){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
												
											}
											
											
											echo "</select>
											
										</td>
										<td >
											&nbsp; <input name=\"sort\" type=\"text\" value=\"$sort\" size=\"7\" maxlength=\"5\" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name=\"departmentID\" size=\"1\">";
											 
											//Schleife die alle Usertypes als <option> ausgibt.
											//der passende Usertype wird dabei vorausgew�hlt
											 for($n=0; $n<count($resultSetDepartments); $n++) {
												$id = $resultSetDepartments[$n]['id'];
												$name = $resultSetDepartments[$n]['name'];
												
												//Vorauswahl des Usertypes aus Datenbank
												if($id == $dept){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
											}
											if($dept == 100)
												echo "<option value=\"$\" selected>Allgemein</option>";
											else
												echo "<option value=\"$\">Allgemein</option>";
											
											
											echo "</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name=\"usertypeID\" size=\"1\">";
											//Schleife die alle Usertypes als <option> ausgibt.
											//der passende Usertype wird dabei vorausgew�hlt
											  for($m=0; $m<count($resultSetUsertypes); $m++) {
												$id = $resultSetUsertypes[$m]['id'];
												$name = $resultSetUsertypes[$m]['name'];
												
												//Vorauswahl des Usertypes aus Datenbank
												if($id == $user){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
											}
											
											echo" </select>
											
										</td>
									</tr>
								</table>
								<div class=\"formRight\">
									<input  class=\"button\" name=\"change\" type=\"submit\" value=\"�ndern\"> &nbsp &nbsp &nbsp
									<input  class=\"button\" name=\"delete\" type=\"submit\" onclick=\"return conf()\" value=\"L�schen\">
									
								</div>
							</td>
						</tr>
					</table>
					</form>
					";
					}	
					echo "</div> </div>";
					//footer einbinden
					require_once '../../layout/backend/footer.php';
						?>