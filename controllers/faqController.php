<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Marc Fl�ren (MF), <marc.floeren@fh-duesseldorf.de>
 */

class FaqController{
    
	function __construct() {
		// Model einbinden
       require_once __DIR__.'../../models/faq.php';
   }
    /**
     * �bergibt neue Daten an Model
     *
     */
    public function setFaq($data){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST �bergeben
        $faqModel->controllInput($data);
    }
	
	/**
     * �bergibt ID zum l�schen an Modell
     *
     */
	 public function deleteFaq($id){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST �bergeben
        $faqModel->DeleteFaq($id);
    }
	
	/**
     * F�hrt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsFrontend($dept, $eis){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementAllFrontend($dept, $eis);
    }
	
	/**
     * F�hrt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsBackend($department){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementBackend($department);
    }
	
	/**
     * F�hrt die Abfragemethode aus um alle Fachbereiche zu erhalten
     * @return Array
     */
    public function getDepartments(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementDepartments();
    }
	
	/**
     * F�hrt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getUsertypes(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementUsertypes();
    }
	
	/**
     * F�hrt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getLang(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementLang();
    }



//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
/* Location: ./controllers/faqController.php */