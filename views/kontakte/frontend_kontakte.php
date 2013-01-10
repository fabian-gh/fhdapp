<?php session_start(); ?>
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
		
		function init() {
		
			// Looking for deep link, else default is first category
			showCategory( 
				<?php 
					// Check if cat is set and is in proper range (1 to 4)
					if (isset($_GET['cat']) && $_GET['cat'] > 0 && $_GET['cat'] < 5)
						echo $_GET['cat'];
					else echo "1";
				?>
				);
		
		}
	
		function showCategory(id) {	
		
			// Hide current
			$('.visible').addClass("hidden");
			$('.visible').removeClass("visible");
			
			// Show new selected
			$('.category_' + id).addClass("visible");
			$('.category_' + id).removeClass("hidden");
		}
		
		function styleButton(id) {
			
			// Problem: Buttons turns into a div due to JQuery, unable to access via id
			$('#category_1').css('background-color', 'red');
		}
	
	</script>
	<style type="text/css">
	
		<!-- CSS styles for hiding and showing the specific elements of an category -->
		.visible { 
			visibility : visible;
		}
		
		.hidden { 
			visibility : hidden;
			height: 0px;
		}
		
		<!-- Styling buttons -->
		.ui-btn {
			background-color: white;
			border-radius: 1px;
			margin-right: 20px;
		}
		
		.body {
			font-size: 14px;
			color: black;
		}
		
	</style>
	<!-- Looking for deep links or setting default page content -->
	<body onLoad="init()">
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
							<td><input id="categtory_1" type="button" value="Bewerbung" onClick="showCategory(1);" style="background-color: white;"/></td>
							<td><input id="categtory_2" type="button" value="Leben" onClick="showCategory(2)"/></td>
						</tr>
						<tr>
							<td><input id="categtory_3" type="button" value="Ausland" onClick="showCategory(3)"/></td>
							<td><input id="categtory_4" type="button" value="Allgemein" onClick="showCategory(4)"/></td>
						</tr>
					</table>
				</div>
				
				<!-- Accordion -->
				<div data-role="collapsible-set">
				
					<!-- load data from database -->
					<?php
					
						// Create controller object to access data
						require_once '../../controllers/kontakteController.php';
						$Contacts = new kontakteController();
						
						// Get contacts from database
						$contacts = $Contacts->c_getContacts();	

						// Print data on website
						foreach ($contacts as $contact) {
							// Create collapsable
							echo "<div class='hidden category_" . $contact['category_id'] . "' data-role='collapsible' data-theme='a' data-collapsed='false'>";							
							// Header
							echo "<h3>" . $contact['title'] . "</br>" .
								$contact['title'] . "</h3>";
							
							// Content
							echo "<p>Raum " . $contact['room'] . " (Campus Nord/Sued)</br>";
								
							if(strlen($contact['office_hours']) > 0) 
								echo $contact['office_hours'] . "</br>";
								
							if(strlen($contact['phone_office_hours']) > 0)
								echo $contact['phone_office_hours'] . "</br></br>";	
								
							echo $contact['contact'] . "</br>" .
								 $contact['phone'] . "</br>";
								 
							if(strlen($contact['fax']) > 0)
								echo "Fax: " . $contact['fax'] . "</br>";
								
							echo "<a href=''>" . $contact['mail'] . "</a></br></br>";
								
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