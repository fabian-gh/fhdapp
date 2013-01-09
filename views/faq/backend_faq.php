<html>
    <head>
        <title>FAQ-Input</title>
		
		<link rel="stylesheet" type="text/css" href="incs/layout.css">
    </head>
    
    <body>
		<?php
		$anzahl = 1;
		if(isset($_POST['anzahl'])){
			$anzahl = $_POST['anzahl'];
		}
		?>
		<div id="mainContainer">
			<div id="formular">
				<div class="formRight">
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					Einzugebende Fragen &nbsp; <input name="anzahl" type="text" value="<?php echo $anzahl ?>" size="2" maxlength="2" > &nbsp; <input  class="button" type="submit" value="OK">
				</form>
				</div>
				<form name="Formular" method="post" action="" accept-charset="utf-8">
					
					<table>
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
								<textarea name="frage" cols="70" rows="3"></textarea>
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
								<textarea name="antwort" cols="70" rows="3"></textarea>
								
							</td>
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td >
											<br />
											Sortierung:
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
											<input name="sort" type="text" value="" size="7" maxlength="5" >
											
										</td>
									
										<td >
											 &nbsp; 
											 <select name="fb" size="1">
											  <option>FB 1 Architektur </option>
											  <option>FB 2 Design </option>
											  <option>FB 3 Elektrotechnik </option>
											  <option>FB 4 Maschinenbau </option>
											  <option>FB 5 Medien </option>
											  <option>FB 6 Sozial- & Kulturwiss. </option>
											  <option>FB 7 Wirtschaft </option>
											</select>
											
										</td>
						
										<td >
											 &nbsp;  
											<select name="modus" size="1">
											  <option>Interessent </option>
											  <option>Student </option>
											  <option>Erstie </option>
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
				require_once '../../controllers/faqController.php';
				
				$faq = new FaqController();
				$faq->forwarding($_POST);
			}
			?>
    
	</body>
</html>