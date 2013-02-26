<?php

/**
 * FHD-App
 * @copyright Fachhochschule Duesseldorf, 2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Schoendorff & Sascha Bardua
 **/

class kontakteModel{
	

	/**
	* 	Fügt einen neuen Kontakt ein. Erzeugt ein Tupel in Kontakte und die dazugehörigen in "contacts_mm_departments"
	*
	*/
	public function m_insertContact(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". utf8_decode($_POST['contactTitle']) ."', "
														.utf8_decode($_POST['contactCategory']).", 
														1, '"
														.utf8_decode($_POST['contactDescription']). "', '"
														.utf8_decode($_POST['contactContact']). "', '"
														.utf8_decode($_POST['contactPhonenumber']). "', '"
														.utf8_decode($_POST['contactFaxnumber']) . "', '"
														.utf8_decode($_POST['contactMail']) . "', '"
														.utf8_decode($_POST['contactRoom']) . "', '"
														.utf8_decode($_POST['contactAdress']) . "', '"
														.utf8_decode($_POST['contactOfficehours']) . "', '"
														.utf8_decode($_POST['contactPhoneOfficehours']) . "');");
		
			// get the ID of the inserted contact
			$contactID = $db->insert_id;
			//create tuples in "contacts_mm_departments"
			foreach ($_POST['contactDepartment'] as $dept) {
				$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
								VALUES ($contactID, $dept)");
			}
			
			//print out a confirmation
			$this->displayChanges($contactID);

		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	*	Gibt ein div aus, welches die eingefügten bzw. geänderten Datensätze ausgit
	*
	*	@param $contactID Die ID des anzuzeigenden Datensatzes
	*/
	public function displayChanges($contactID){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);

			$result = $db->query("SELECT * FROM contacts WHERE id = $contactID");

			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}

			$contactDepts = $this->m_getContactDepts($contactID);
			$depts = $this->m_getDepartments();
			$categories = $this->m_getCategories();

			echo '<div class="confirmation">
				<p>Folgender Kontakt wurde geändert:

					<table class="confirmationTable">
						<tr>
							<td><span>Titel des Kontakts</span></td>
							<td> '. utf8_encode($resultSet[0]['title']) .'</td>
						</tr>
						<tr>
							<td><span>Ansprechpartner</span></td>
							<td> '. utf8_encode($resultSet[0]['contact']) .'</td>
						</tr>
						<tr>
							<td><span>Beschreibung</span></td>
							<td> '. utf8_encode($resultSet[0]['description']) .'</td>
						</tr>
						<tr>
							<td><span>Fachbereich(e)</span></td>
							<td> '; for($i = 0; $i < count($contactDepts); $i ++){
										echo $depts[($contactDepts[$i]['department_id'] -1)]['name'];
										if($i < count($contactDepts) - 1){
											echo ', ';
										}
									}
									echo '</td>
						</tr>
						<tr>	
							<td><span>Kategorie</span></td>
							<td>';
								$catID = $resultSet[0]['category_id'] - 1;
							 	echo $categories[$catID]['name']; 
						echo '</td>
						</tr>
						<tr>
							<td><span>Telefon</span></td>
							<td> '. utf8_encode($resultSet[0]['phone']) .'</td>
						</tr>
						<tr>
							<td><span>Fax</span></td>
							<td> '. utf8_encode($resultSet[0]['fax']) .'</td>
						</tr>
						<tr>
							<td><span>Mail</span></td>
							<td> '. utf8_encode($resultSet[0]['mail']) .'</td>
						</tr>
						<tr>
							<td><span>Raum</span></td>
							<td> '. utf8_encode($resultSet[0]['room']) .'</td>
						</tr>
						<tr>
							<td><span>Adresse</span></td>
							<td> '. utf8_encode($resultSet[0]['address']) .'</td>
						</tr>
						<tr>
							<td><span>Öffnungszeiten</span></td>
							<td> '. utf8_encode($resultSet[0]['office_hours']) .'</td>
						</tr>
						<tr>
							<td><span>Telefonische Sprechzeiten</span></td>
							<td> '. utf8_encode($resultSet[0]['phone_office_hours']) .'</td>
						</tr>
					</table>

				</p>
			</div>';

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	* Ändert die Daten eines Kontakts, der für mehrere Fachbereiche verantwortlich ist
	*
	* @param $contactID Die ID des zu ändernden Datensatzes
	*/
	public function m_alterAllContacts($contactID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts

			$result = $db->query("UPDATE contacts SET 
									title = '" . utf8_decode($_POST['alterContactTitle']) . "',
									category_id = " . utf8_decode($_POST['alterContactCategory']) . ",
									description = '" . utf8_decode($_POST['alterContactDescription']) ."',
									contact = '" . utf8_decode($_POST['alterContactContact']) ."',
									phone = '" . utf8_decode($_POST['alterContactPhone']) ."',
									fax = '" . utf8_decode($_POST['alterContactFax']) ."',
									mail = '" . utf8_decode($_POST['alterContactMail']) ."',
									room = '" . utf8_decode($_POST['alterContactRoom']) ."',
									address = '" . utf8_decode($_POST['alterContactAddress']) ."',
									office_hours = '" . utf8_decode($_POST['alterContactOfficeHours']) ."',
									phone_office_hours = '" . utf8_decode($_POST['alterContactPhoneOfficeHours']) ."'
									WHERE id = $contactID");
			foreach ($_POST['alterContactDepartment'] as $dept) {
				if($dept != $_POST['deptID']){
					$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $dept");
										
					$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id) VALUES ($contactID, $dept)");
				}
			}

			$this->displayChanges($contactID);
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

	/**
	* Ändert die Daten eines Kontakts, der für geanu einen Fachbereich verantwortlich ist
	*
	*@param $contactID Die ID des zu ändernden Datensatzes
	*@param $deptID Die ID des Fachbereichs des zu ändernden Datensatzes
	*/
	public function m_alterContact($contactID, $deptID){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);


			$result = $db->query("UPDATE contacts SET
										title = '" . utf8_decode($_POST['alterContactTitle']) . "',
										category_id = " . utf8_decode($_POST['alterContactCategory']) . ",
										description = '" . utf8_decode($_POST['alterContactDescription']) ."',
										contact = '" . utf8_decode($_POST['alterContactContact']) ."',
										phone = '" . utf8_decode($_POST['alterContactPhone']) ."',
										fax = '" . utf8_decode($_POST['alterContactFax']) ."',
										mail = '" . utf8_decode($_POST['alterContactMail']) ."',
										room = '" . utf8_decode($_POST['alterContactRoom']) ."',
										address = '" . utf8_decode($_POST['alterContactAddress']) ."',
										office_hours = '" . utf8_decode($_POST['alterContactOfficeHours']) ."',
										phone_office_hours = '" . utf8_decode($_POST['alterContactPhoneOfficeHours']) ."'
										WHERE id = $contactID");

			
			$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $deptID");
			// in case that the department changed and / or new departments were added: 
			foreach ($deptID as $dept) {
				if($dept != $_POST['deptID']){
					$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $dept");
										
					$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id) VALUES ($contactID, $dept)");
				} 
			}
			
			$this->displayChanges($contactID);
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

	/**
	*	Liest alle Daten aus contacts_mm_categories und übergibt diese
	*
	*	@return $resultSet Array of Array mit allen Informationen über jede Kategorie
	*/
	public function m_getCategories(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT * FROM contact_categories");

			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	*	Liest alle Daten aus contacts_mm_departments und übergibt diese
	*
	*	@return $resultSet Array of Array mit allen Informationen über jeden Fachbereich
	*/
	public function m_getDepartments(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT * FROM departments");

			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}		
	}

	/**
	*	Liest alle Kontakte inklusive derer Fachereichsnamen und Kategorie(n) aus und übergitb diese
	*
	*	@return $resultSet Array of Array mit allen Informationen über jeden Kontakt
	*/
	public function m_getContacts(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, cat.Name AS catName, con.category_id, dept.name AS deptName, dept.id AS deptID
									FROM contacts con, contact_categories cat, contacts_mm_departments condept, departments dept
									WHERE con.category_id = cat.id AND con.id = condept.contact_id AND condept.department_id = dept.id
									ORDER BY con.title");
			
			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

	/**
	*	Übergibt den Fachbereich zu einem dazugehörigen Studiengangsnamen
	*	@return Multi-dimensionales Array genau einer Fachbereichs ID
	*/
	public function m_getDeptByCourse($courseName){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT department_id FROM studycourses WHERE name = '" . $courseName . "' LIMIT 1");
			
			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
			
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

	/**
	*	Löscht einen Kontakt aus der Datenbank
	*	@param $contactID Die ID des zu löschenden Datensatzes
	*	@param $deptID Die Fachbereichs ID des zu löschenden Kontakts
	*/
	public function m_deleteContact($contactID, $deptID){
			
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to insert the values
			$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $deptID");

			$resultSet = null;
			$result = $db->query("SELECT * FROM contacts_mm_departments WHERE contact_id = $contactID");
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			if($resultSet == null){
				$db->query("DELETE FROM contacts WHERE id = " . $contactID);
			}

			echo '
			<div class="confirmation">
				<p> Der Kontakt wurde gelöscht. </p>
			</div>
			';				
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	*	Übergibt einen bestimmten Kontakt
	*	@param $deptID Die Fachbereichs ID des Kontakts
	*	@return Multi-dimensionales Array mit Kontaktdaten
	*/
	public function m_getContact($contactID, $deptID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName, cat.id AS catID, dept.id AS deptID
									FROM contacts con, contact_categories cat, departments dept, contacts_mm_departments condept
									WHERE con.id = $contactID AND con.category_id = cat.id AND condept.contact_id = $contactID AND dept.id = $deptID");

			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;								
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	*	Übergibt die Fachbereiche für einen bestimmten Kontakt 
	*
	*	@param $contactID Die ID des Kontakts
	*
	*/
	public function m_getContactDepts($contactID){
		try{
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			$result = $db->query("SELECT * FROM contacts_mm_departments WHERE contact_id = $contactID");

			$resultSet = null;
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}

			return $resultSet;
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	* 	Diese Funktion wird aufgerufen, wenn ein Kontakt für mehrere Fachbereiche verantwortlich ist, der Benuter aber nur einen Kontakt für einen bestimmten Fachbereich ändern möchte
	*
	*	@param $post Das $_POST Objekt einer Form
	*
	*/
	public function m_alterOneContact($post){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			
			$db->query("INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". utf8_decode($post['alterContactTitle']) ."', "
														.utf8_decode($post['alterContactCategory']).", 
														1, '"
														.utf8_decode($post['alterContactDescription']). "', '"
														.utf8_decode($post['alterContactContact']). "', '"
														.utf8_decode($post['alterContactPhone']). "', '"
														.utf8_decode($post['alterContactFax']) . "', '"
														.utf8_decode($post['alterContactMail']) . "', '"
														.utf8_decode($post['alterContactRoom']) . "', '"
														.utf8_decode($post['alterContactAddress']) . "', '"
														.utf8_decode($post['alterContactOfficeHours']) . "', '"
														.utf8_decode($post['alterContactPhoneOfficeHours']) . "');");
			$contactID = $db->insert_id;

			$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = ". $post['contactID']." AND department_id = ".$post['deptID']);
			

			for ($i=0; $i < count($post['alterContactDepartment']); $i++) { 
				$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
									VALUES ($contactID," . $post['alterContactDepartment'][$i] .")");
			}
			

			$this->displayChanges($contactID);

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
}