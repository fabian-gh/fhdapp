<?php

class kontakteModel{
	
<<<<<<< HEAD
<<<<<<< HEAD
=======

	// TODO: language_id berücksichtigen, auch im Backend
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	public function m_insertContact(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			//execute SQL Query to insert the values
			// *** Foreign Keys
			$db->query("INSERT INTO contacts (title, category_id, department_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". $_POST['contactTitle'] ."', "
														.$_POST['contactCategory'].", "
														.$_POST['contactDepartment'].", 
<<<<<<< HEAD
=======

			//execute SQL Query to insert the values
			$db->query("INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". $_POST['contactTitle'] ."', "
														.$_POST['contactCategory'].", 
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
														1, '"
														.$_POST['contactDescription']. "', '"
														.$_POST['contactContact']. "', '"
														.$_POST['contactPhonenumber']. "', '"
														.$_POST['contactFaxnumber'] . "', '"
														.$_POST['contactMail'] . "', '"
														.$_POST['contactRoom'] . "', '"
														.$_POST['contactAdress'] . "', '"
														.$_POST['contactOfficehours'] . "', '"
<<<<<<< HEAD
<<<<<<< HEAD
														.$_POST['contactPhoneOfficehours'] . "');");	
=======
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

>>>>>>> origin/daniel16.02
=======
														.$_POST['contactPhoneOfficehours'] . "');");	
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

<<<<<<< HEAD
<<<<<<< HEAD
	public function m_alterContact($id){
=======
	// TODO: wenn FB geändert wird: neue werden eingetragen, nicht ausgewählte nicht entfernt
	public function m_alterAllContacts($contactID){

>>>>>>> origin/daniel16.02
=======
	public function m_alterContact($id){
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			$result = $db->query("UPDATE contacts SET
									title = '" . $_POST['alterContactTitle'] . "',
									category_id = " . $_POST['alterContactCategory'] . ",
									department_id =" . $_POST['alterContactDepartment'] . ",
<<<<<<< HEAD
=======
			
			$result = $db->query("UPDATE contacts SET 
									title = '" . $_POST['alterContactTitle'] . "',
									category_id = " . $_POST['alterContactCategory'] . ",
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
									description = '" . $_POST['alterContactDescription'] ."',
									contact = '" . $_POST['alterContactContact'] ."',
									phone = '" . $_POST['alterContactPhone'] ."',
									fax = '" . $_POST['alterContactFax'] ."',
									mail = '" . $_POST['alterContactMail'] ."',
									room = '" . $_POST['alterContactRoom'] ."',
									address = '" . $_POST['alterContactAddress'] ."',
									office_hours = '" . $_POST['alterContactOfficeHours'] ."',
									phone_office_hours = '" . $_POST['alterContactPhoneOfficeHours'] ."'
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
									");
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}		
<<<<<<< HEAD
=======
									WHERE id = $contactID");

			foreach ($_POST['alterContactDepartment'] as $dept) {
				if($dept != $_POST['deptID']){
					$deptResult = $db->query("UPDATE contacts_mm_departments SET
													department_id = " . $dept . "
												WHERE contact_id = " . $contactID . " AND department_id = " . $_POST['deptID']);
				} else{
					$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
									VALUES ($contactID, $dept)");
				}
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


			// falls die deptID geändert wurde & evtl noch mehr FB hinzugekommen sind 
			foreach ($deptID as $dept) {
				if($dept != $_POST['deptID']){
					$deptResult = $db->query("UPDATE contacts_mm_departments SET
													department_id = " . $dept . "
												WHERE contact_id = " . $contactID . " AND department_id = " . $_POST['deptID']);
				} else{
					$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
									VALUES ($contactID, $dept)");
				}
			}
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	}

	public function m_getCategories(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT * FROM contact_categories");

<<<<<<< HEAD
<<<<<<< HEAD
=======
			$resultSet = null;
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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

<<<<<<< HEAD
<<<<<<< HEAD
=======
			$resultSet = null;
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName
									FROM contacts con, contact_categories cat, departments dept
									WHERE con.category_id = cat.id AND con.department_id = dept.id");
			$resultSet = null;

<<<<<<< HEAD
=======
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
	
	public function m_getDeptByCourse($courseName){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT department_id FROM studycourses WHERE name = '$courseName' LIMIT 1");
			
			$resultSet = null;
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
										
		}
		catch(Exception $e){
			echo $e->getMessage();
		}	
	}

<<<<<<< HEAD
<<<<<<< HEAD
	public function m_deleteContact($id){
=======
	public function m_deleteContact($contactID, $deptID){
			
>>>>>>> origin/daniel16.02
=======
	public function m_deleteContact($id){
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to insert the values
<<<<<<< HEAD
<<<<<<< HEAD
			// *** Foreign Keys
			$db->query("DELETE FROM contacts WHERE id = " . $id);					
=======
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
>>>>>>> origin/daniel16.02
=======
			// *** Foreign Keys
			$db->query("DELETE FROM contacts WHERE id = " . $id);					
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}

<<<<<<< HEAD
<<<<<<< HEAD
	public function m_getContact($id){
=======
	public function m_getContact($contactID, $deptID){

>>>>>>> origin/daniel16.02
=======
	public function m_getContact($id){
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName, cat.id AS catID, dept.id AS deptID
<<<<<<< HEAD
<<<<<<< HEAD
									FROM contacts con, contact_categories cat, departments dept
									WHERE con.id = $id AND con.category_id = cat.id AND con.department_id = dept.id");
=======
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

	public function m_getContactDepts($contactID){
		try{
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			
			$result = $db->query("SELECT * FROM contacts_mm_departments WHERE contact_id = $contactID");

			$resultSet = null;
>>>>>>> origin/daniel16.02
=======
									FROM contacts con, contact_categories cat, departments dept
									WHERE con.id = $id AND con.category_id = cat.id AND con.department_id = dept.id");
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			while($row = $result->fetch_assoc()){
				$resultSet[] = $row;
			}
			return $resultSet;
<<<<<<< HEAD
<<<<<<< HEAD
										
=======
>>>>>>> origin/daniel16.02
=======
										
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
<<<<<<< HEAD
<<<<<<< HEAD
=======

	public function m_alterOneContact($contactID, $deptID){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);

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

			$query1 = "INSERT INTO contacts (title, category_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
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
														.$_POST['contactPhoneOfficehours'] . "');";

			$db->query("DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $deptID");

			$query2 = "DELETE FROM contacts_mm_departments WHERE contact_id = $contactID AND department_id = $deptID";

			$query3 = "INSERT INTO contacts_mm_departments (contact_id, department_id)
									VALUES ($contactID," . $_POST['deptID'];

			echo '<br / >' . $query1 . '<br />' . $query2 . '<br />' . $query3;

			$db->query("INSERT INTO contacts_mm_departments (contact_id, department_id)
									VALUES ($contactID," . $_POST['deptID']);

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
}