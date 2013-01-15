<!-- JavaScript necessary for loading page contents -->
<script type="text/javascript">	
	
	function init() {
	
		// Looking for deep link, else default is first category
		showCategory( 
			<?php 
				// Check if cat is set and is in proper range (1 to 4)
				if (isset($_GET['cat']) && $_GET['cat'] > 0 && $_GET['cat'] < 6)
					echo $_GET['cat'];
				else echo "1";
			?>
			);		
	}

	function showCategory(id) {	
	
		// Hide current category
		$('.visible').addClass("hidden");
		$('.visible').removeClass("visible");
		
		// Show new selected
		$('.category_' + id).addClass("visible");
		$('.category_' + id).removeClass("hidden");
	}
</script>

<!-- CSS styles for hiding and showing the specific elements of an category -->
<style type="text/css">		
	.visible { 
		visibility : visible;
	}
	
	.hidden { 
		visibility : hidden;
		height: 0px;
	}		
</style>

<!-- Code representing the content of the page -->
<div >
	<!-- Categories -->
	<div id="categories" style="margin: auto;">
		<table style="margin: auto;">
			<tr>
				<?php
					// Decide role of student or interested person
					if (isset($_GET['eis'])) {
						// Student
						if ($_GET['eis'] == 'i')
							echo '<td><input id="categtory_0" type="button" value="Bewerbung" onClick="showCategory(0);" style="background-color: white;"/></td>';
						else 
							echo '<td><input id="categtory_1" type="button" value="Studiengang" onClick="showCategory(1);" style="background-color: white;"/></td>';
					}
					else 
						echo '<td><input id="categtory_0" type="button" value="Bewerbung" onClick="showCategory(0);" style="background-color: white;"/></td>';
				?>
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
			require_once 'controllers/kontakteController.php';
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
				echo "<p>Raum " . $contact['room'] . " (" . $contact['campus'] . ")</br>";
					
				if(strlen($contact['office_hours']) > 0) 
					echo $contact['office_hours'] . "</br>";
					
				if(strlen($contact['phone_office_hours']) > 0)
					echo $contact['phone_office_hours'] . "</br></br>";	
					
				echo $contact['contact'] . "</br>" .
					 $contact['phone'] . "</br>";
					 
				if(strlen($contact['fax']) > 0)
					echo "Fax: " . $contact['fax'] . "</br>";
					
				echo "<a href='mailto:'>" . $contact['mail'] . "</a></br></br>";
					
				if(strlen($contact['address']) > 0) 
					echo $contact['address'];								
				
				// End of collapsable
				echo "</p></div>";
			}
		?>          
	</div>
</div>