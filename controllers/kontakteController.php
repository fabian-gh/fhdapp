<?php

/**
 * FHD-App
 * @copyright Fachhochschule Duesseldorf, 2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Schoendorff & Sascha Bardua
 **/

class kontakteController {

	public function __construct(){
		//create new contact Model
		require_once __DIR__.'../../models/kontakteModel.php';
		$this->contactsModel = new kontakteModel();
	}

	/**
	*	Übermittelt einen einzufügenden Kontakt an das Model
	*
	*/
	public function c_insertContact(){
		//call function which proceeds with the insert
		$this->contactsModel->m_insertContact();
	}

	/**
	*	Ruft eine Funktion im Model auf um die Kategorien zurückzugeben, die einen Datensatz betreffen
	*	@return Array of Strings
	*/
	public function c_getCategories(){
		return $this->contactsModel->m_getCategories();
	}

	/**
	*	Ruft eine Funktion im Model auf um die Namen aller Fachbereiche zurückzugeben
	*	@return Array of Strings
	*/
	public function c_getDepartments(){
		return $this->contactsModel->m_getDepartments();
	}

	/**
	*	Ruft eine Funktion im Model auf um die Daten aller Kontakte zurückzugeben
	*	@return Array of Strings 
	*/
	public function c_getContacts(){
		return $this->contactsModel->m_getContacts();
	}

	/**
	*	Ruft eine Funktion im Model auf um die Fachbereichs ID eines bestimmten Kontakts zurückzugeben
	*	@return Array of Strings 
	*/
	public function c_getDeptByCourse($courseName){
		$array = $this->contactsModel->m_getDeptByCourse($courseName);
		return $array[0]['department_id'];
	}

	/**
	*	Löscht einen bestimmten Kontakt
	*	@param $id ID des zu löschenden Kontakts
	*/	
	public function c_deleteContact($id){

		$contactID = $id['contactID'];
		$deptID = $id['deptID'];

		$this->contactsModel->m_deleteContact($contactID, $deptID);
	}

	/**
	*	Ruft eine Funktion im Model auf um die Daten eines Kontaktes zurückzugeben
	*	@param $id ID des Kontakts
	*	@return Array of String
	*/
	public function c_getContact($id){

		$contactID = $id['contactID']; 
		$deptID = $id['deptID'];

		return $this->contactsModel->m_getContact($contactID, $deptID);
	}

	/**
	*   Ruft eine Funktion im Model auf um die Fachbereich eines bestimmten Kontakts zurückzugeben
	*
	*	@param $id $_POST Objekt
	*	@return Array of Strings 
	*/
	public function c_getContactDepts($id){

		$contactID = $id['contactID'];
		return $this->contactsModel->m_getContactDepts($contactID);
	}

	/**
	*	Ruft eine Funktion im Model auf um die Fachbereichs ID eines bestimmten Kontakts zu ändern
	*	@param $id ID des zu ändernden Kontakts
	*/
	public function c_alterContact($id){
		$contactID = $id['contactID'];
		$deptID = $id['alterContactDepartment'];

		$this->contactsModel->m_alterContact($contactID, $deptID);
	}

	/**
	*	Ruft eine Funktion im Model auf um einen Kontakt zu ändern, der zu mehreren Fachbereichen gehört. Ändert den Kontakt für alle Fachbereiche
	*
	*	@param $id $_POST Objekt
	*/
	public function c_alterAllContacts($id){

		$contactID = $id['contactID'];

		$this->contactsModel->m_alterAllContacts($contactID);
	}

	/**
	*	Ruft eine Funktion im Model auf um einen Kontakt zu ändern, der zu mehreren Fachbereichen gehört. Ändert den Kontakt für einen Fachbereich
	*
	*
	* @param $post $_POST Objekt
	*/
	public function c_alterOneContact($post){

		$this->contactsModel->m_alterOneContact($post);
	}
}