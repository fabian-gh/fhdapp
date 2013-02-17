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
<<<<<<< HEAD
     * Benutzername
     * @var String 
     */
    private $Model;
	
=======
     * Model
     */
    private $Model;
	
	private $DEPARTMENTS;
	private $USERTYPES;
	
>>>>>>> origin/daniel16.02
	
    /**
     * Konstruktor des VeranstaltungsController
     * @param Object $Data
     */
    public function __construct(){
        // Veranstaltung-Modell einbinden
<<<<<<< HEAD
        require_once 'models/veranstaltungen.php';
        // und Objekt erstellen
        $Model = new Veranstaltungen();
    }
	
	public function addDatensatz()
	{		
		$Model = new Veranstaltungen();
		$Model->addDatensatz();
	}
	
	public function getInformation($usertype, $fachbereich)
	{		
		$Model = new Veranstaltungen();
		return $Model->getInformation($usertype, $fachbereich);
	}
}

 
=======
        
		if (!@include ('models/veranstaltungenModel.php'))
			include ('../../models/veranstaltungenModel.php');
        
		// und Objekt erstellen
        $this->Model = new Veranstaltungen();
		
		$this->getInformationDepartments();
		$this->getInformationUsertypes();
    }
	

	public function getInformation($usertype,$department)
	{		
		$Model = new Veranstaltungen();
		return $Model->createStatement($usertype,$department);
	}
	
	//Backend
	//Methode um Veranstaltungen nur nach Fachbereichen ohne Rücksicht auf Usertype auszulesen
	public function getInformationEventsWithDepartmentsWihoutUsertype($department)
	{
		return  $this->Model->createStatementEventsWithDepartmentsWihoutUsertype($department);
	}
	
	//Backend
	//Methode die alle Fachbereiche zu einem Event auszulesen
	public function getInformationDepartmentsFromEvents($event_id)
	{
		return $this->Model->createStatementDepartmentsFromEvents($event_id);
	}
	
	//Backend
	//Methode die alle Benutzer zu einem Event auszulesen
	public function getInformationUsertypesFromEvents($event_id)
	{
		return $this->Model->createStatementUsertypesFromEvents($event_id);
	}
	
	//Backend
	//Methode die eine neue Veranstaltung mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	public function addEvent()
	{
		return $this->Model->addEvent('');
	}
	
	//Backend
	//Methode die eine neue Veranstaltung mit ID mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	public function addEventID($event_id)
	{
		return $this->Model->addEvent($event_id);
	}

	//Backend
	//Methode die eine Veranstaltung komplett aus der Datenbank mit allen Beziehungen löscht
	public function deleteEvent($event_id)
	{		
		return $this->Model->deleteEvent($event_id);
	}
	
	//Backend
	//Methode die alle Veranstaltungen löscht, die älter vorm heutigen Datum liegen
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
	private function getInformationDepartments()
	{
		$this->DEPARTMENTS = $this->Model->createStatementDepartments();	
	}
	
	//Backend
	//Methode die alle Fachbereiche
	private function getInformationUsertypes()
	{
		$this->USERTYPES = $this->Model->createStatementUsertypes();
	}
	
	//Backend
	//Methode die alle Benutzer ausliest
	public function getDepartments()
	{
		return $this->DEPARTMENTS;	
	}
	
	//Backend
	//Methode die alle Fachbereiche
	public function getUsertypes()
	{
		return $this->USERTYPES;
	}
}
>>>>>>> origin/daniel16.02
 
/* End of file veranstaltungenController.php */
/* Location: ./controllers/veranstaltungenController.php */
?>