<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Marc Flören (MF), <marc.floeren@fh-duesseldorf.de>
 */

class FaqController{
    
	function __construct() {
		// Model einbinden
       require_once __DIR__.'../../models/faq.php';
   }
    /**
     * Übergibt neue Daten an Model
     *
     */
    public function setFaq($data){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST übergeben
        $faqModel->controllInput($data);
    }
	
	/**
     * Übergibt ID zum löschen an Modell
     *
     */
	 public function deleteFaq($id){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST übergeben
        $faqModel->DeleteFaq($id);
    }
	
	/**
     * Führt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsFrontend($dept, $eis){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementAllFrontend($dept, $eis);
    }
	
	/**
     * Führt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsBackend($department){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementBackend($department);
    }
	
	/**
     * Führt die Abfragemethode aus um alle Fachbereiche zu erhalten
     * @return Array
     */
    public function getDepartments(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementDepartments();
    }
	
	/**
     * Führt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getUsertypes(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementUsertypes();
    }
	
	/**
     * Führt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getLang(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementLang();
    }



//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausführen und zurückgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
/* Location: ./controllers/faqController.php */