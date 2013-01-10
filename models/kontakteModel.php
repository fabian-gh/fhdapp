<?php

class kontakteModel{
	
	public function m_insertContact(){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to insert the values
			// *** Foreign Keys
			$db->query("INSERT INTO contacts (title, category_id, department_id, language_id, description, contact, phone, fax, mail, room, address, office_hours, phone_office_hours) 
											VALUES ('". $_POST['contactTitle'] ."', "
														.$_POST['contactCategory'].", "
														.$_POST['contactDepartment'].", 
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

	public function m_alterContact($id){

		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("UPDATE contacts SET
										title = '" . $_POST['alterContactTitle'] . "',
										category_id = " . $_POST['alterContactCategory'] . ",
										department_id =" . $_POST['alterContactDepartment'] . ",
										description = '" . $_POST['alterContactDescription'] ."',
										contact = '" . $_POST['alterContactContact'] ."',
										phone = '" . $_POST['alterContactPhone'] ."',
										fax = '" . $_POST['alterContactFax'] ."',
										mail = '" . $_POST['alterContactMail'] ."',
										room = '" . $_POST['alterContactRoom'] ."',
										address = '" . $_POST['alterContactAddress'] ."',
										office_hours = '" . $_POST['alterContactOfficeHours'] ."',
										phone_office_hours = '" . $_POST['alterContactPhoneOfficeHours'] ."' 
									WHERE id = " . $id);


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
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName, con.category_id
									FROM contacts con, contact_categories cat, departments dept
									WHERE con.category_id = cat.id AND con.department_id = dept.id");
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

	public function m_deleteContact($id){
			
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to insert the values
			// *** Foreign Keys
			$db->query("DELETE FROM contacts WHERE id = " . $id);	

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

	public function m_getContact($id){
		try{
			//create DB connection
			$db = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
			//execute SQL Query to get all the Categories that affect contacts
			$result = $db->query("SELECT con.id AS contactID, con.title, con.description, con.contact, con.phone, con.fax, con.mail, con.room, con.address, con.office_hours, con.phone_office_hours, dept.name AS deptName, cat.Name AS catName, cat.id AS catID, dept.id AS deptID
									FROM contacts con, contact_categories cat, departments dept
									WHERE con.id = $id AND con.category_id = cat.id AND con.department_id = dept.id");
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