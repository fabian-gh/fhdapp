<<<<<<< HEAD
<<<<<<< HEAD
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
       require_once '../../models/faq.php';
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
    public function getFAQsFrontend($user, $dept){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementAllFrontend($user, $dept);
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



//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
=======
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



//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
>>>>>>> origin/daniel16.02
=======
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
       require_once '../../models/faq.php';
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
    public function getFAQsFrontend($user, $dept){
        
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementAllFrontend($user, $dept);
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



//TEST METHODEN

	public function getTestData($test){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode die getestet werden soll ausf�hren und zur�ckgeben
        return $faqModel->createReadStatementFaqID($test);
    }
	
}
 
/* End of file faqController.php */
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
/* Location: ./controllers/faqController.php */