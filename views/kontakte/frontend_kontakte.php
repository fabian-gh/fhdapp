<!-- JavaScript necessary for loading page contents -->
<script type="text/javascript">	

	function showCategory(id) {	
	
		// Hide current category
		$('.visible').addClass("hidden");
		$('.visible').removeClass("visible");
		
		// Show new selected
		$('.category_' + id).addClass("visible");
		$('.category_' + id).removeClass("hidden");
	}

	/* Category IDs
	1 = Bewerbung
	2 = Studiengang
	3 = Allgemein
	4 = Leben
	5 = Ausland
	*/

</script>

<!-- CSS styles for hiding and showing the specific elements of an category -->
<style type="text/css">		
	.visible { 
		visibility : visible;
		height:auto;
	}
	
	.hidden { 
		visibility : hidden;
		height: 0px;
	}	

	/*Used to handle scroll bar problems due to hiding item*/
	.ui-content {
		overflow: hidden;
	}	
</style>

<!-- Code representing the content of the page -->
<h1><?php echo $_GET['page']; ?></h1>
<!-- Categories -->
<div id="categories">
	<table style="margin: auto;">
		<tr>
			<?php
				// Get role or set default
				$_GET['eis'] = isset($_GET['eis']) ? $_GET['eis'] : 'i'; 

				// Decide labeling, event handler and category refering to role
				if ($_GET['eis'] == 'i') {
					echo '<td><input id="categtory_1" type="button" value="Bewerbung" onClick="showCategory(1);" style="background-color: white;"/></td>';
					$_GET['cat'] = isset($_GET['cat']) ? $_GET['cat'] : '1';
				}
				else {
					echo '<td><input id="categtory_2" type="button" value="Studiengang" onClick="showCategory(2);" style="background-color: white;"/></td>';
					$_GET['cat'] = isset($_GET['cat']) ? $_GET['cat'] : '2';
				}
				
			?>
			<td><input id="categtory_4" type="button" value="Leben" onClick="showCategory(4)"/></td>
		</tr>
		<tr>
			<td><input id="categtory_5" type="button" value="Ausland" onClick="showCategory(5)"/></td>
			<td><input id="categtory_3" type="button" value="Allgemein" onClick="showCategory(3)"/></td>
		</tr>
	</table>
</div>

<!-- Accordion -->
<div data-role="collapsible-set">

	<!-- load data from database -->
	<?php
	
		// Create controller object to access data
		require_once 'controllers/kontakteController.php';
		$Contacts = new kontakteController();
		
		// Get contacts from database
		$contacts = $Contacts->c_getContacts();	
		
		//Check if there is data available
		if ($contacts != null) {
		
			 // Get current department id to filter contacts by current department
			$deptID = $Contacts->c_getDeptByCourse($_GET['course']);

			// Print data on website
			foreach ($contacts as $contact) { 

				// Filter data by department
				if ($contact['deptID'] == $deptID) {
					// Create collapsable
					echo "<div class='";

					// Decide if should be visible or hidden
					if ($contact['category_id'] == $_GET['cat'])
						echo 'visible ';
					else echo 'hidden ';

					echo "category_" . $contact['category_id'] . "' data-role='collapsible' data-theme='a' data-collapsed='true'>";							
					// Header
					echo "<h3>" . $contact['title'] . "</br>" .
						$contact['description'] . "</h3>";
					
					// Hours container
					echo '<div style="margin-bottom:8px">';

					if(strlen($contact['office_hours']) > 0) 
						echo $contact['office_hours'] . "</br>";
						
					if(strlen($contact['phone_office_hours']) > 0)
						echo $contact['phone_office_hours'] . "</br></br>";

					echo '</div>';
					
					// Contact container
					echo '<div style="margin-bottom:8px">';

					echo $contact['contact'] . "</br>" .
						 "Tel: " . $contact['phone'] . "</br>";
						 
					if(strlen($contact['fax']) > 0)
						echo "Fax: " . $contact['fax'] . "</br>";
						
					echo "<a href='mailto:" . $contact['mail'] . "''>" . $contact['mail'] . "</a>";

					echo '</div>';
					
					// Hours container
					echo '<div style="margin-bottom:8px">';

					echo "<p>Raum " . $contact['room'] . "</br>";

					if(strlen($contact['address']) > 0) 
						echo $contact['address'];								
					echo '</div>';

					// End of collapsable
					echo "</p></div>";
				}
			}
		}
		else {
			echo '<p>Es wurden keine Kontakte gefunden. Bitte überprüfen Sie die Datenbankeinstellungen.</p>';
		}
	?>      
</div>