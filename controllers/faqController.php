<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Marc Floeren (MF), <marc.floeren@fh-duesseldorf.de>
 */

class FaqController{
    
	function __construct() {
		// Model einbinden
       require_once __DIR__.'../../models/faq.php';
   }
    /**
     * uebergibt neue Daten an Model
     *
     */
    public function setFaq($data){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST uebergeben
        $faqModel->controllInput($data);
    }
	
	/**
     * Aendern von Daten an Model
     *
     */
    public function changeFaq($data){
       
         // Objekt erstellen
		$faqModel = new Faq();
		// POST uebergeben
		$faqModel->DeleteFaq($data['id'],true);
        $faqModel->controllInput($data);
    }
	
	/**
     * uebergibt ID zum loeschen an Modell
     *
     */
	 public function deleteFaq($id){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST uebergeben
        $faqModel->DeleteFaq($id,false);
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsFrontend($dept, $eis){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementAllFrontend($dept, $eis);
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Faqs zu erhalten
     * @return Array
     */
    public function getFAQsBackend($department){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementBackend($department);
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Fachbereiche zu erhalten
     * @return Array
     */
    public function getDepartments(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementDepartments();
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getUsertypes(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementUsertypes();
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Usergruppen zu erhalten
     * @return Array
     */
    public function getLang(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementLang();
    }
	
	/**
	* Führt die Abfragemethode aus, um aus dem gewählten Studiengang den zugehörigen Fachbereich zu erhalten
	* @return Array
	*/
	public function getDepartmentFromCourse($course){
	// Objekt erstellen
	$faqModel = new Faq();
	// Methode ausführen und zurückgeben
	return $faqModel->DepartmentFromCourse($course)[0]['department_id'];
	}




//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausfuehren und zurueckgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
/* Location: ./controllers/faqController.php */