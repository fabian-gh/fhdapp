<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="../../sources/css/style_backend.css" rel="stylesheet" type="text/css" media="screen" />
	<title>FHD App - CMS</title>
</head>

<body>

	<div id ="header">
    	<div id ="headline">
        	<h1>CMS Web-App</h1>
        </div>
    </div>
    
    <div id ="wrapper">
    
    	<div id ="nav">
            <h3>Seiteninhalt bearbeiten:</h3>
        	<ul>
            	<li><a href='#'>Studiengänge</a></li>
                <li><a href='#'>Veranstaltungen</a></li>
                <li><a href='#'>Termine</a></li>
                <li><a href='#'>Mensa</a></li>
                <li><a class ="active" href='#'>FAQ</a></li>
                <li><a href='#'>Kontakt</a></li>
			</ul>
        </div>
        
        <div id ="content">
		<h1> FAQ Update/Delete </h1>
		<br />
		<?php
		//Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		//Überprüfung ob ändern geklickt(Button wird automagically erkannt) und auführen der änderung
		if(isset($_POST['change'])){
			$controller->setFaq($_POST);
		}
		
		//Überprüfung ob löschen geklickt(Button wird automagically erkannt) und löschen	
		if(isset($_POST['delete'])){
			$controller->deleteFaq($_POST['id']);
		}
		
		//Überprüfung ob Selektiert werden soll	
		if(isset($_POST['select'])){
			$resultSet = $controller->getFAQsBackend($_POST['departmentSelectID']);
			$selected = $_POST['departmentSelectID'];
		}else{
			$resultSet = $controller->getFAQsBackend(0);
			$selected = 0;
		}
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		
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
							echo "<option value=\"0\" selected>Alle</option>";
						}else{
							echo "<option value=\"0\">Alle</option>";
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
						$dept = $resultSet[$i]['deptid'];
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
											<input name=\"lang\" type=\"text\" value=\"$lang\" size=\"7\" maxlength=\"5\" >
											
										</td>
										<td >
											&nbsp; <input name=\"sort\" type=\"text\" value=\"$sort\" size=\"7\" maxlength=\"5\" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name=\"departmentID\" size=\"1\">";
											 
											//Schleife die alle Usertypes als <option> ausgibt.
											//der passende Usertype wird dabei vorausgewählt
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
											
											
											echo "</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name=\"usertypeID\" size=\"1\">";
											//Schleife die alle Usertypes als <option> ausgibt.
											//der passende Usertype wird dabei vorausgewählt
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
									<input  class=\"button\" name=\"change\" type=\"submit\" value=\"Ändern\"> &nbsp &nbsp &nbsp
									<input  class=\"button\" name=\"delete\" type=\"submit\" value=\"Löschen\">
									
								</div>
							</td>
						</tr>
					</table>
					</form>
					";
					}						
						?>

				
			</div>
		</div>
		
		</div>
		        
		<div class="clear"></div>
	</div>
    
    <div id ="footer">
</div>

</body>

</html>