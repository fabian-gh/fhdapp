<<<<<<< HEAD
<<<<<<< HEAD
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="../../sources/css/stylebackend.css" rel="stylesheet" type="text/css" media="screen" />
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
		<h1> FAQ's eingeben </h1>
		<br />
		<?php
		// Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		
		$anzahl = 1;
		if(isset($_POST['anzahl'])){
			$anzahl = $_POST['anzahl'];
		}
		?>
		<div id="mainContainer">
			<div id="formular">
				<div class="formRight">
				<a href='backend_change_faq.php'>FAQ ändern/löschen</a>
				<br /><br />
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					Einzugebende Fragen &nbsp; <input name="anzahl" type="text" value="<?php echo $anzahl ?>" size="2" maxlength="2" > &nbsp; <input  class="button" type="submit" value="OK">
				</form>
				</div>
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					
					<table>
					
						<input type="hidden" name="inputArt" value="1">
						
						<?php for ($i = 1; $i <= $anzahl; $i++) { ?>
						<tr>
							<td>
								<?php 
								if($i>1){
								
								echo "<br />";

								}
								?>
								<?php echo $i; ?>. Frage:
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="question<?php echo $i ?>" cols="70" rows="2"></textarea>
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
								<textarea name="answer<?php echo $i ?>" cols="70" rows="2"></textarea>
								
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
											<input name="lang<?php echo $i ?>" type="text" value="1" size="7" maxlength="5" >
											
										</td>
										<td >
											&nbsp; <input name="sort<?php echo $i ?>" type="text" value="" size="7" maxlength="5" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name="departmentID<?php echo $i ?>" size="1">
											<?php
											for($n=0; $n<count($resultSetDepartments); $n++) {
												$id = $resultSetDepartments[$n]['id'];
												$name = $resultSetDepartments[$n]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name="usertypeID<?php echo $i ?>" size="1">
											<?php
											for($m=0; $m<count($resultSetUsertypes); $m++) {
												$id = $resultSetUsertypes[$m]['id'];
												$name = $resultSetUsertypes[$m]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
								
						<?php 
								if( $i<$anzahl){	
						echo "<tr>
								<td>
									<br />
									<hr>
								</td>
							</tr>";
						}
						?>
						<?php } ?>
					</table>
					<input type="hidden" name="anzahl" value="<?php echo $anzahl ?>">
					
					<div class="formRight">
						<br class="smallUmbruch"/>
						<input  class="button" name="save" type="submit" value="Speichern"> &nbsp &nbsp &nbsp
						<input  class="button" type="reset" value="Löschen">
					</div>
				</form>
			</div>
		</div>
		
		<?php
			if(isset($_POST['save'])){
				$controller->setFaq($_POST);
			}
			?>
		</div>
		        
		<div class="clear"></div>
	</div>
    
    <div id ="footer">
</div>

</body>

</html>
=======
<?php  require_once '../../layout/backend/header.php'; ?>

        <div id ="content">
		<h1> FAQ's eingeben </h1>
		<br />
		<?php
		// Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		
		$anzahl = 1;
		if(isset($_POST['anzahl'])){
			$anzahl = $_POST['anzahl'];
		}
		?>
		<div id="mainContainer">
			<div id="formular">
				<div class="formRight">
				<a href='backend_change_faq.php'>FAQ &auml;ndern/l&ouml;schen</a>
				<br /><br />
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					Einzugebende Fragen &nbsp; <input name="anzahl" type="text" value="<?php echo $anzahl ?>" size="2" maxlength="2" > &nbsp; <input  class="button" type="submit" value="OK">
				</form>
				</div>
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					
					<table>
					
						<input type="hidden" name="inputArt" value="1">
						
						<?php for ($i = 1; $i <= $anzahl; $i++) { ?>
						<tr>
							<td>
								<?php 
								if($i>1){
								
								echo "<br />";

								}
								?>
								<?php echo $i; ?>. Frage:
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="question<?php echo $i ?>" cols="70" rows="2"></textarea>
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
								<textarea name="answer<?php echo $i ?>" cols="70" rows="2"></textarea>
								
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
											<input name="lang<?php echo $i ?>" type="text" value="1" size="7" maxlength="5" >
											
										</td>
										<td >
											&nbsp; <input name="sort<?php echo $i ?>" type="text" value="" size="7" maxlength="5" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name="departmentID<?php echo $i ?>" size="1">
											<?php
											for($n=0; $n<count($resultSetDepartments); $n++) {
												$id = $resultSetDepartments[$n]['id'];
												$name = $resultSetDepartments[$n]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name="usertypeID<?php echo $i ?>" size="1">
											<?php
											for($m=0; $m<count($resultSetUsertypes); $m++) {
												$id = $resultSetUsertypes[$m]['id'];
												$name = $resultSetUsertypes[$m]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
								
						<?php 
								if( $i<$anzahl){	
						echo "<tr>
								<td>
									<br />
									<hr>
								</td>
							</tr>";
						}
						?>
						<?php } ?>
					</table>
					<input type="hidden" name="anzahl" value="<?php echo $anzahl ?>">
					
					<div class="formRight">
						<br class="smallUmbruch"/>
						<input  class="button" name="save" type="submit" value="Speichern"> &nbsp &nbsp &nbsp
						<input  class="button" type="reset" value="L&ouml;schen">
					</div>
				</form>
			</div>
		</div>
		
		<?php
			if(isset($_POST['save'])){
				$controller->setFaq($_POST);
			}
			?>
		</div>
		
<?php  require_once '../../layout/backend/footer.php'; ?>
>>>>>>> origin/daniel16.02
=======
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link href="../../sources/css/stylebackend.css" rel="stylesheet" type="text/css" media="screen" />
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
		<h1> FAQ's eingeben </h1>
		<br />
		<?php
		// Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		
		$anzahl = 1;
		if(isset($_POST['anzahl'])){
			$anzahl = $_POST['anzahl'];
		}
		?>
		<div id="mainContainer">
			<div id="formular">
				<div class="formRight">
				<a href='backend_change_faq.php'>FAQ ändern/löschen</a>
				<br /><br />
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					Einzugebende Fragen &nbsp; <input name="anzahl" type="text" value="<?php echo $anzahl ?>" size="2" maxlength="2" > &nbsp; <input  class="button" type="submit" value="OK">
				</form>
				</div>
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					
					<table>
					
						<input type="hidden" name="inputArt" value="1">
						
						<?php for ($i = 1; $i <= $anzahl; $i++) { ?>
						<tr>
							<td>
								<?php 
								if($i>1){
								
								echo "<br />";

								}
								?>
								<?php echo $i; ?>. Frage:
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="question<?php echo $i ?>" cols="70" rows="2"></textarea>
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
								<textarea name="answer<?php echo $i ?>" cols="70" rows="2"></textarea>
								
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
											<input name="lang<?php echo $i ?>" type="text" value="1" size="7" maxlength="5" >
											
										</td>
										<td >
											&nbsp; <input name="sort<?php echo $i ?>" type="text" value="" size="7" maxlength="5" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name="departmentID<?php echo $i ?>" size="1">
											<?php
											for($n=0; $n<count($resultSetDepartments); $n++) {
												$id = $resultSetDepartments[$n]['id'];
												$name = $resultSetDepartments[$n]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name="usertypeID<?php echo $i ?>" size="1">
											<?php
											for($m=0; $m<count($resultSetUsertypes); $m++) {
												$id = $resultSetUsertypes[$m]['id'];
												$name = $resultSetUsertypes[$m]['name'];
												
												echo "<option value=\"$id\">$name</option>";
											}
											?>
											</select>
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
								
						<?php 
								if( $i<$anzahl){	
						echo "<tr>
								<td>
									<br />
									<hr>
								</td>
							</tr>";
						}
						?>
						<?php } ?>
					</table>
					<input type="hidden" name="anzahl" value="<?php echo $anzahl ?>">
					
					<div class="formRight">
						<br class="smallUmbruch"/>
						<input  class="button" name="save" type="submit" value="Speichern"> &nbsp &nbsp &nbsp
						<input  class="button" type="reset" value="Löschen">
					</div>
				</form>
			</div>
		</div>
		
		<?php
			if(isset($_POST['save'])){
				$controller->setFaq($_POST);
			}
			?>
		</div>
		        
		<div class="clear"></div>
	</div>
    
    <div id ="footer">
</div>

</body>

</html>
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
