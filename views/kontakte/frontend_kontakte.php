<?php
	session_start();
?>	
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../../sources/css/style.css" media="screen" />
		<link rel="stylesheet" href="../../sources/css/jquery.mobile-1.2.0.css"/>
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
        <title>Kontakte</title>
    </head>
	<script type="text/javascript">	
	
		function showCategory(id) {	
			// Hide current
			$('.visible').addClass("hidden");
			$('.visible').removeClass("visible");
			
			// Show new selected
			$('.category_' + id).addClass("visible");
			$('.category_' + id).removeClass("hidden");
		}
	
	</script>
	<style type="text/css">
		.visible { 
			visibility : visible;
		}
		
		.hidden { 
			visibility : hidden;
			height: 0px;
		}
		
		.button  {
			background-color:white !important;
			border: 2px solid red !important;
			border-radius: 0px !important;
		}
	</style>
	<body onLoad="showCategory(0)">

		<div id ="header">
			<div id ="logo">
				<a href="#">FHD</a>
			</div>
			<div id ="breadcrumb">
				<a href="#">Start</a> »  
				<a href="#" class="nav-icon">Interessent</a> »  
				<a href="#">Studgang »</a>
				<a href="#">BMI »</a>
				<a href="#">Kontakte</a>
			</div>
		</div>
		
		<div id ="content" data-role="content">
			<div >
				<!-- Categories -->
				<div id="categories" style="margin: auto;">
					<table style="margin: auto;">
						<tr>
							<td><input class="button" type="button" value="Bewerbung" onClick="showCategory(0)" style="background-color: white;"/></td>
							<td><input type="button" value="Leben" onClick="showCategory(1)"/></td>
						</tr>
						<tr>
							<td><input type="button" value="Ausland" onClick="showCategory(2)"/></td>
							<td><input type="button" value="Allgemein" onClick="showCategory(3)"/></td>
						</tr>
					</table>
				</div>
				
				<!-- akkordionmenü -->
				<div data-role="collapsible-set">
				
					<!-- load data from database -->
					<?php
						require_once '../../controllers/kontakteController.php';
						$Contacts = new kontakteController();
						// Get data
						$contacts = $Contacts->c_getContacts();	

						// Print data on website
						foreach ($contacts as $contact) {
							// Create collapsable
							echo "<div class='category_" . $contact['category_id'] . "' data-role='collapsible' data-theme='a' data-collapsed='false'>";							
							// Header
							echo "<h3>" . $contact['title'] . "</br>" .
								$contact['description'] . "</h3>";
							
							// Content
							echo "<p>Raum " . $contact['room'] . " (Campus Nord/Sued)</br>";
								
							if(strlen($contact['office_hours']) > 0) 
								echo $contact['office_hours'] . "</br>";
								
							if(strlen($contact['phone_office_hours']) > 0)
								echo $contact['phone_office_hours'];	
								
							echo $contact['contact'] . "</br>" .
								 $contact['phone'] . "</br>";
								 
							if(strlen($contact['fax']) > 0)
								echo $contact['fax'] . "</br>";
								
							echo "<a href=''>" . $contact['mail'] . "</a>";
								
							if(strlen($contact['address']) > 0) 
								echo $contact['address'];								
							
							// End of collapsable
							echo "</p></div>";
						}
					?>          
				</div>
				
			</div>
		</div>
	</body>
</html>