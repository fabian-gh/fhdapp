<?php

class kontakteModel{
	
	// TODO: Möglichkeit, einen Kontakt direkt für mehrere FB einzutragen
	// TODO: language_id berücksichtigen, auch im Backend
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
			
			// in die zwischenrelation einfügen anhand der id der vorangegangenen Aktion als KontaktID und der im Formular angegebenen DeptID
			$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
								VALUES ($db->insert_id," . 
										$_POST['contactDepartment'] . ");");

			echo '
			<div class="confirmation">
				<p> Der Kontakt wurde eingefügt. </p>
			</div>
			';

		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	// TODO: Zwischenrelation berücksichtigen -> momentan wird der Kontakt verändert -> alle FB betroffen 
	public function m_alterContact($contactID, $deptID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			
			$result = $db->query("UPDATE contacts RIGHT OUTER JOIN contacts_mm_departments 
									ON
										contacts_mm_departments.contact_id = $contactID AND contacts_mm_departments.department_id = $deptID
									SET
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
										phone_office_hours = '" . $_POST['alterContactPhoneOfficeHours'] ."'");
			
			$query = "UPDATE contacts SET
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
									FROM contacts RIGHT OUTER JOIN contacts_mm_departments ON
										contacts_mm_departments.contact_id = $contactID AND contacts_mm_departments.department_id = $deptID";
			if($deptID != $_POST['alterContactDepartment']){
				$deptResult = $db->query("UPDATE contacts_mm_departments SET
												department_id = " . $_POST['alterContactDepartment'] . "
											WHERE contact_id = " . $contactID . " AND department_id = " . $deptID);
			}

			echo '
					<div class="confirmation">
						<p> Die Kontaktdaten wurden geändert. </p>
					</div>
				';
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

	public function m_getCategories(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT * FROM contact_categories");

			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function m_getDepartments(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT * FROM departments");

			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}		
	}

	public function m_getContacts(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
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

	public function m_deleteContact($contactID, $deptID){
			
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to insert the values
			$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $deptID");

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

	public function m_getContact($contactID, $deptID){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName, cat.id AS catID, dept.id AS deptID
									FROM contacts con, contact_categories cat, departments dept, contacts_mm_departments condept
									WHERE con.id = $contactID AND con.category_id = cat.id AND condept.contact_id = $contactID AND dept.id = $deptID");

			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
}