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
     * Benutzername
     * @var String 
     */
    private $Model;
	
	
    /**
     * Konstruktor des VeranstaltungsController
     * @param Object $Data
     */
    public function __construct(){
        // Veranstaltung-Modell einbinden
        
		 if (!@include ('models/veranstaltungenModel.php'))
			include ('../../models/veranstaltungenModel.php');
        // und Objekt erstellen
        //$Model = new Veranstaltungen();
    }
	

	public function getInformation($usertype,$department)
	{		
		$Model = new Veranstaltungen();
		return $Model->createStatement($usertype,$department);
	}
	
	//Backend
	//Methode um Veranstaltungen nur nach Fachbereichen ohne R�cksicht auf Usertype auszulesen
	public function getInformationEventsWithDepartmentsWihoutUsertype($department)
	{
		$Model = new Veranstaltungen();
		return $Model->createStatementEventsWithDepartmentsWihoutUsertype($department);
	}
	
	//Backend
	//Methode die alle Fachbereiche zu einem Event auszulesen
	public function getInformationDepartmentsFromEvents($event_id)
	{
		$Model = new Veranstaltungen();
		return $Model->createStatementDepartmentsFromEvents($event_id);
	}
	
	//Backend
	//Methode die alle Benutzer zu einem Event auszulesen
	public function getInformationUsertypesFromEvents($event_id)
	{
		$Model = new Veranstaltungen();
		return $Model->createStatementUsertypesFromEvents($event_id);
	}
	
	//Backend
	//Methode die eine neue Veranstaltung mit allen Beziehungen zu Fachbereichen und Benutzern erstellt
	public function addEvent()
	{		
		$Model = new Veranstaltungen();
		return $Model->addEvent();
	}

	//Backend
	//Methode die eine Veranstaltung komplett aus der Datenbank mit allen Beziehungen l�scht
	public function deleteEvent($event_id)
	{		
		$Model = new Veranstaltungen();
		return $Model->deleteEvent($event_id);
	}	
}

 
 
/* End of file veranstaltungenController.php */
/* Location: ./controllers/veranstaltungenController.php */
?>