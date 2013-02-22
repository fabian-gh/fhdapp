<?php

class kontakteController {

	public function __construct(){
		//create new contact Model
		require_once __DIR__.'../../models/kontakteModel.php';
		$this->contactsModel = new kontakteModel();
	}

	/**
	*	Transmitting the data sent by the backend_view to the model
	*
	*/
	public function c_insertContact(){
		//call function which proceeds with the insert
		$this->contactsModel->m_insertContact();
	}

	/**
	*	Calls the model to return the categories which affect the contacts section (names only)
	*	@return Array of Strings
	*/
	public function c_getCategories(){
		return $this->contactsModel->m_getCategories();
	}

	/**
	*	Calls the model and returns all the departments (names only)
	*	@return Array of Strings
	*/
	public function c_getDepartments(){
		return $this->contactsModel->m_getDepartments();
	}

	/**
	*	Calls the model and returns all the contacts with all attributes
	*	@return Array of Strings 
	*/
	public function c_getContacts(){
		return $this->contactsModel->m_getContacts();
	}

	/**
	*	Calls the model and returns all the departmentID of a specific course name
	*	@return Array of Strings 
	*/
	public function c_getDeptByCourse($courseName){
		$array = $this->contactsModel->m_getDeptByCourse($courseName);
		return $array[0]['department_id'];
	}

	/**
	*	Deletes a contact with specific id
	*	@param $id ID of contact to delete
	*/	
	public function c_deleteContact($id){

		$contactID = $id['contactID'];
		$deptID = $id['deptID'];

		$this->contactsModel->m_deleteContact($contactID, $deptID);
	}

	/**
	*	Gets contact with specific id and all its attributes
	*	@param $id ID of contact to get
	*	@return Array of String
	*/
	public function c_getContact($id){

		$contactID = $id['contactID']; 
		$deptID = $id['deptID'];

		return $this->contactsModel->m_getContact($contactID, $deptID);
	}

	/**
	*	Gets the department(s) a specific contact is allocated to
	*
	*	@param $id $_POST object
	*	@return Array of Strings 
	*/
	public function c_getContactDepts($id){

		$contactID = $id['contactID'];
		return $this->contactsModel->m_getContactDepts($contactID);
	}

	/**
	*	Changes departmentID of a contact with specific id
	*	@param $id ID of contact to change
	*/
	public function c_alterContact($id){
		$contactID = $id['contactID'];
		$deptID = $id['alterContactDepartment'];

		$this->contactsModel->m_alterContact($contactID, $deptID);
	}

	/**
	*	Alters a contact associated to multiple departments. alters the contact for all departments.
	*
	*	@param $id $_POST object
	*/
	public function c_alterAllContacts($id){

		$contactID = $id['contactID'];

		$this->contactsModel->m_alterAllContacts($contactID);
	}

	/**
	* Alters a contact associated to multiple departments. Alters the contact for the selected department only.
	*
	* @param $post $_POST object
	*/
	public function c_alterOneContact($post){

		$this->contactsModel->m_alterOneContact($post);
	}
}