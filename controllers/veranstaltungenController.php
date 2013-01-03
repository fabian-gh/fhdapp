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
        require_once '../../models/veranstaltungen.php';
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

 
 
/* End of file veranstaltungenController.php */
/* Location: ./controllers/veranstaltungenController.php */
?>