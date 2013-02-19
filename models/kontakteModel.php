<?php

class kontakteModel{
	

	/**
	*	Inserts a new contact. Creates a tuple in "contacts" and as many as needed in "contacts_mm_departments"
	*
	*/
	public function m_insertContact(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);

			//execute SQL Query to insert the values
			
			$db->query("INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". $_POST['contactTitle'] ."', "
														.$_POST['contactCategory'].", 
														1, '"
														.$_POST['contactDescription']. "', '"
														.$_POST['contactContact']. "', '"
														.$_POST['contactPhonenumber']. "', '"
														.$_POST['contactFaxnumber'] . "', '"
														.$_POST['contactMail'] . "', '"
														.$_POST['contactRoom'] . "', '"
														.$_POST['contactAdress'] . "', '"
														.$_POST['contactOfficehours'] . "', '"
														.$_POST['contactPhoneOfficehours'] . "');");
		
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
	*	Prints out a div which displays the inserted / altered contact and all its data
	*
	*	@param $contactID The ID of the contact which should be displayed
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
							<td> '. $resultSet[0]['title'] .'</td>
						</tr>
						<tr>
							<td><span>Ansprechpartner</span></td>
							<td> '. $resultSet[0]['contact'] .'</td>
						</tr>
						<tr>
							<td><span>Beschreibung</span></td>
							<td> '. $resultSet[0]['description'] .'</td>
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
							<td> '. $resultSet[0]['phone'] .'</td>
						</tr>
						<tr>
							<td><span>Fax</span></td>
							<td> '. $resultSet[0]['fax'] .'</td>
						</tr>
						<tr>
							<td><span>Mail</span></td>
							<td> '. $resultSet[0]['mail'] .'</td>
						</tr>
						<tr>
							<td><span>Raum</span></td>
							<td> '. $resultSet[0]['room'] .'</td>
						</tr>
						<tr>
							<td><span>Adresse</span></td>
							<td> '. $resultSet[0]['address'] .'</td>
						</tr>
						<tr>
							<td><span>Öffnungszeiten</span></td>
							<td> '. $resultSet[0]['office_hours'] .'</td>
						</tr>
						<tr>
							<td><span>Telefonische Sprechzeiten</span></td>
							<td> '. $resultSet[0]['phone_office_hours'] .'</td>
						</tr>
					</table>

				</p>
			</div>';

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}

	/**
	* Alters the data of a contact which is resposible for multiple Departments.
	* Changes the data for all departments.
	*
	* @param $contactID The ID of the contact which should be altered
	*/
	public function m_alterAllContacts($contactID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			
			$result = $db->query("UPDATE contacts SET 
									title = '" . $_POST['alterContactTitle'] . "',
									category_id = " . $_POST['alterContactCategory'] . ",
									description = '" . $_POST['alterContactDescription'] ."',
									contact = '" . $_POST['alterContactContact'] ."',
									phone = '" . $_POST['alterContactPhone'] ."',
									fax = '" . $_POST['alterContactFax'] ."',
									mail = '" . $_POST['alterContactMail'] ."',
									room = '" . $_POST['alterContactRoom'] ."',
									address = '" . $_POST['alterContactAddress'] ."',
									office_hours = '" . $_POST['alterContactOfficeHours'] ."',
									phone_office_hours = '" . $_POST['alterContactPhoneOfficeHours'] ."'
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
	* Alters the data of a contact which is resposible for only one department.
	*
	*@param $contactID The ID of the contact which should be altered
	*@param $deptID The ID of the department the selected contact is connected to
	*/
	public function m_alterContact($contactID, $deptID){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);


			$result = $db->query("UPDATE contacts SET
										title = '" . $_POST['alterContactTitle'] . "',
										category_id = " . $_POST['alterContactCategory'] . ",
										description = '" . $_POST['alterContactDescription'] ."',
										contact = '" . $_POST['alterContactContact'] ."',
										phone = '" . $_POST['alterContactPhone'] ."',
										fax = '" . $_POST['alterContactFax'] ."',
										mail = '" . $_POST['alterContactMail'] ."',
										room = '" . $_POST['alterContactRoom'] ."',
										address = '" . $_POST['alterContactAddress'] ."',
										office_hours = '" . $_POST['alterContactOfficeHours'] ."',
										phone_office_hours = '" . $_POST['alterContactPhoneOfficeHours'] ."'
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
	*	Gets all the categories from contacts_mm_categories
	*
	*	@return $resultSet Contains an array of arrays which contain all the information about every category
	*/
	public function m_getCategories(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("SET NAMES 'utf8'");
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
	*	Gets all the departments from contacts_mm_departments
	*
	*	@return $resultSet Contains an array of arrays which contain all the information about every category
	*/
	public function m_getDepartments(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("SET NAMES 'utf8'");
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
	*	Gets all the contacts plus the associated names of the department(s) and category
	*
	*	@return $resultSet Contains an array of arrays which contain all the information about every contact
	*/
	public function m_getContacts(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("SET NAMES 'utf8'");
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, cat.Name AS catName, con.category_id, dept.name AS deptName, dept.id AS deptID
									FROM contacts con, contact_categories cat, contacts_mm_departments condept, departments dept
									WHERE con.category_id = cat.id AND con.id = condept.contact_id AND condept.department_id = dept.id");
			
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
	*	Gets the departmentID of a specific course name
	*	@return Returns an multi-dimensional array
	*/
	public function m_getDeptByCourse($courseName){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("SET NAMES 'utf8'");
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT department_id FROM studycourses WHERE name = " . $courseName . " LIMIT 1");
			
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
	*	Deletes a contact from database
	*	@param $contactID ID of contact to delete
	*	@param $deptID DepartmentID of contact to delete
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
	*	Gets specific contact
	*	@param $deptID DepartmentID of contact to get
	*	@return Returns an multi-dimensional array
	*/
	public function m_getContact($contactID, $deptID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			// Handles problems with ä,ö,ü
			$db->query("SET NAMES 'utf8'");
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
	*	Gets the department(s) for one specific contact 
	*
	*	@param $contactID the ID of the specific contact
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
	*	This function is called when a contact is responsible for multiple departments and the user wants to change the information of the contact for just a single department
	*
	*	@param $post the complete $_POST object sent via the form
	*
	*/
	public function m_alterOneContact($post){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);

			
			$db->query("INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". $post['alterContactTitle'] ."', "
														.$post['alterContactCategory'].", 
														1, '"
														.$post['alterContactDescription']. "', '"
														.$post['alterContactContact']. "', '"
														.$post['alterContactPhone']. "', '"
														.$post['alterContactFax'] . "', '"
														.$post['alterContactMail'] . "', '"
														.$post['alterContactRoom'] . "', '"
														.$post['alterContactAddress'] . "', '"
														.$post['alterContactOfficeHours'] . "', '"
														.$post['alterContactPhoneOfficeHours'] . "');");
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