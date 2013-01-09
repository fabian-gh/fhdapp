<?php

class kontakteController {

	public function __construct(){
		//create new contact Model
		require_once '../../models/kontakteModel.php';
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

	public function c_deleteContact($id){

		$contactID = $id['contactID'];
		$deptID = $id['deptID'];

		$this->contactsModel->m_deleteContact($contactID, $deptID);
	}

	public function c_getContact($id){

		$contactID = $id['contactID']; 
		$deptID = $id['deptID'];

		return $this->contactsModel->m_getContact($contactID, $deptID);
	}

	public function c_alterContact($id){

		$contactID = $id['id'];
		$deptID = $id['deptID'];

		$this->contactsModel->m_alterContact($contactID, $deptID);
	}
}