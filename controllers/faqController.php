<?php
/**
 * FHD-App
 *
 * @version 0.9
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Marc Floeren (MF), <marc.floeren@fh-duesseldorf.de>
 * @author Anh Minh Nguyen (AMN), <anh.nguyen@fh-duesseldorf.de>
 */
class FaqController{
    
	/**
	* FAQ Controller Constructor.
	* Bindet das Model ein.
	*/
	function __construct() {
		// Model einbinden
       require_once __DIR__.'../../models/faqModel.php';
   }
   
    /**
     * Übergibt neue Daten an das Model.
     *
	 * @param Array $data  Data Array mit eingegebenen Werten aus dem Formular
     */
    public function setFaq($data){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST uebergeben
        $faqModel->controllInput($data);
    }
	
	/**
     * Übergabe von Daten an das Model zum Ändern.
     * Die zu ändernde FAQ wird erst gelöscht, danach die geänderte FAQ neu eingefügt.
	 * Aufruf und Übergabe der Parameter an die Methoden im Model.
	 * @param Array $data  Data Array mit eingegebenen Werten aus dem Formular
     */
    public function changeFaq($data){
       
         // Objekt erstellen
		$faqModel = new Faq();
		// POST uebergeben
		$faqModel->DeleteFaq($data['id'],true);
        $faqModel->controllInput($data);
    }
	
	/**
     * Übergibt ID der zu löschenden FAQ.
	 * Aufruf und Übergabe der Parameter an die Methoden im Model.
     * @param int $id ID derjenigen FAQ, die gelöscht werden soll
     */
	 public function deleteFaq($id){
       
         // Objekt erstellen
	   $faqModel = new Faq();
		// POST uebergeben
        $faqModel->DeleteFaq($id,false);
    }
	
	/**
     * Führt die Abfragemethode aus um nach Fachbereich und Usertype die FAQs zu selektieren.
	 * Für die Darstellung im Frontend.
	 * Aufruf und Übergabe der Parameter an die Methoden im Model.
	 * @param int $dept Fachbereich
	 * @param int $eis Usertype
     * @return Array mit den Datensätzen der FAQs
     */
    public function getFAQsFrontend($dept, $eis){
	
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementAllFrontend($dept, $eis);
    }
	
	/**
     * Führt die Abfragemethode aus um alle FAQs nach Fachbereich zu selektieren.
	 * Für die Darstellung im Backend.
	 * Aufruf und Übergabe der Parameter an die Methoden im Model.
	 *
     * @return Array mit den Datensätzen der FAQs
     */
    public function getFAQsBackend($department){     
		
	   // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausführen und zurückgeben
        return $faqModel->createReadStatementBackend($department);
    }
	
	/**
     * Führt die Abfragemethode aus um alle Fachbereiche zu erhalten.
	 * Aufruf der Methoden im Model.
	 *
     * @return Array mit den Fachbereichen
     */
    public function getDepartments(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementDepartments();
    }
	
	/**
     * Fuehrt die Abfragemethode aus um alle Usergruppen zu erhalten.
	 * Aufruf der Methoden im Model.
     * @return Array mit den Usertypes
     */
    public function getUsertypes(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementUsertypes();
    }
	
	/**
     * Führt die Abfragemethode aus um alle Sprach-IDs zu erhalten.
	 * Aufruf der Methoden im Model.
     * @return Array mit den Sprach-IDs
     */
    public function getLang(){
        
		 // Objekt erstellen
	   $faqModel = new Faq();
        // Methode ausfuehren und zurueckgeben
        return $faqModel->createReadStatementLang();
    }
	
	/**
	* Führt die Abfragemethode aus, um aus dem gewählten Studiengang den zugehörigen Fachbereich zu erhalten
	* Aufruf und Übergabe der Parameter an die Methoden im Model.
	*
	* @param $course Studiengang, zu dem der Fachbereich gesucht werden soll
	* @return Array mit den Fachbereich-IDs
	*/
	public function getDepartmentFromCourse($course){
	
	// Objekt erstellen
	$faqModel = new Faq();
	// Methode ausführen und zurückgeben
	$temp = $faqModel->DepartmentFromCourse($course);
	return $temp[0]['department_id'];
	}
}
/* End of file faqController.php */
/* Location: ./controllers/faqController.php */
?>