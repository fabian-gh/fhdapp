<?php
//header einbinden
require_once '../../layout/backend/header.php';
?>
		<h2> FAQ Eingabe </h2>
		<?php
		// Controller einbinden
		require_once '../../controllers/faqController.php';
		//Objekt erstellen
		$controller = new FaqController();
		
		$resultSetDepartments = $controller->getDepartments();
		$resultSetUsertypes = $controller->getUsertypes();
		$resultSetLang = $controller->getLang();
		
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
								<textarea name="question<?php echo $i ?>" cols="70" rows="2"><?php if(isset($_POST['question'.$i])){echo $_POST['question'.$i];}else{echo '';}?></textarea>
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
								<textarea name="answer<?php echo $i ?>" cols="70" rows="2"><?php if(isset($_POST['answer'.$i])){echo $_POST['answer'.$i];}else{echo '';}?></textarea>
								
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
											 <select name="lang<?php echo $i ?>" size="1">
											<?php
											for($n=0; $n<count($resultSetLang); $n++) {
												$id = $resultSetLang[$n]['id'];
												$name = $resultSetLang[$n]['name'];
												if($id == $_POST['lang'.$i]){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
												
											}
											?>
											</select>
											
										</td>
										<td >
											&nbsp; <input name="sort<?php echo $i ?>" type="text" value="<?php if(isset($_POST['sort'.$i])){echo $_POST['sort'.$i];}else{echo '';}?>" size="7" maxlength="5" >
											
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name="departmentID<?php echo $i ?>" size="1">
											<?php
											for($n=0; $n<count($resultSetDepartments); $n++) {
												$id = $resultSetDepartments[$n]['id'];
												$name = $resultSetDepartments[$n]['name'];
												
												if($id == $_POST['departmentID'.$i]){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
												
											}
											?>
											<option value="100">Allgemein</option>";
											</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name="usertypeID<?php echo $i ?>" size="1">
											<?php
											for($m=0; $m<count($resultSetUsertypes); $m++) {
												$id = $resultSetUsertypes[$m]['id'];
												$name = $resultSetUsertypes[$m]['name'];
												
												if($id == $_POST['usertypeID'.$i]){
													echo "<option value=\"$id\" selected>$name</option>";
												}else{
													echo "<option value=\"$id\">$name</option>";
												}
												
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
			require_once '../../layout/backend/footer.php';
			?>