<?php

/**
 * FHD-App
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

 
 class VeranstaltungenController{
    /**
     * Model
     */
    private $Model;

	private $DEPARTMENTS;
	private $USERTYPES;


    /**
     * Konstruktor des VeranstaltungsController
     * @param Object $Data
     */
    public function __construct(){
        // Veranstaltung-Modell einbinden
        
		if (!@include ('models/veranstaltungenModel.php'))
			include ('../../models/veranstaltungenModel.php');
        
		// und Objekt erstellen
        $this->Model = new Veranstaltungen();

		$this->getInformationDepartments();
		$this->getInformationUsertypes();
    }


	public function getInformation($usertype,$department)
	{		
		return $this->Model->createStatement($usertype,$department);
	}

	public function getDepartmentFromStudycourse($course)
	{
		return $this->Model->getStudycourseInformation($course)[0]['department_id'];
	}

	//Backend
	//Methode um Veranstaltungen nur nach Fachbereichen ohne Rücksicht auf Usertype auszulesen
	//@param String $department Fachbereichs-ID
	//@return SQL-Ergebnis-Relation
	public function getInformationEventsWithDepartmentsWihoutUsertype($department)
	{
		return  $this->Model->createStatementEventsWithDepartmentsWihoutUsertype($department);
	}

	//Backend
	//Methode die alle Fachbereiche zu einem Event auszulesen
	//@param String $event_id Veranstaltungs-ID
	//@return SQL-Ergebnis-Relation
	public function getInformationDepartmentsFromEvents($event_id)
	{
		return $this->Model->createStatementDepartmentsFromEvents($event_id);
	}

	//Backend
	//Methode die alle Benutzer zu einem Event auszulesen
	//@param String $event_id Veranstaltungs-ID
	//@return SQL-Ergebnis-Relation
	public function getInformationUsertypesFromEvents($event_id)
	{
		return $this->Model->createStatementUsertypesFromEvents($event_id);
	}

	//Backend
	//Methode die eine neue Veranstaltung mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	//@return boolean True hat funktioniert, false hat nicht funktioniert
	public function addEvent()
	{
		return $this->Model->addEvent('');
	}

	//Backend
	//Methode die eine neue Veranstaltung mit ID mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	//@return boolean True hat funktioniert, false hat nicht funktioniert
	public function addEventID($event_id)
	{
		return $this->Model->addEvent($event_id);
	}

	//Backend
	//Methode die eine Veranstaltung komplett aus der Datenbank mit allen Beziehungen löscht
	//@return boolean True hat funktioniert, false hat nicht funktioniert
	public function deleteEvent($event_id)
	{		
		return $this->Model->deleteEvent($event_id);
	}

	//Backend
	//Methode die alle Veranstaltungen löscht, die älter vorm heutigen Datum liegen
	//@return boolean True hat funktioniert, false hat nicht funktioniert
	public function deleteOldEvent()
	{
		$ERGEBNIS = $this->Model->getOldEvents();

		if($ERGEBNIS != null)
		{
			//Veranstaltungen durchlaufen und darstellen
			for($i=0; $i<count($ERGEBNIS); $i++) 
			{
				if($this->deleteEvent($ERGEBNIS[$i]['id']) == false)
					return false;
			}
		}
		return true;
	}

	//Backend
	//Methode die alle Benutzer ausliest
	//@return SQL-Ergebnis-Relation
	private function getInformationDepartments()
	{
		$this->DEPARTMENTS = $this->Model->createStatementDepartments();	
	}

	//Backend
	//Methode die alle Benutzer ausliest
	//@return SQL-Ergebnis-Relation
	private function getInformationUsertypes()
	{
		$this->USERTYPES = $this->Model->createStatementUsertypes();
	}

	//Backend
	//Methode die alle Fachbereiche
	//@return Array
	public function getDepartments()
	{
		return $this->DEPARTMENTS;	
	}

	//Backend
	//Methode die alle Fachbereiche
	//@return Array
	public function getUsertypes()
	{
		return $this->USERTYPES;
	}
}
 
/* End of file veranstaltungenController.php */
/* Location: ./controllers/veranstaltungenController.php */
?>