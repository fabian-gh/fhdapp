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
    
    /**
     * Übergibt Daten an Model
     *
     */
    public function forwarding($_POST){
        // Model einbinden
        require_once '../../models/faq.php';
        
        // Objekt erstellen
        $faqModel = new Faq();
        
		// POST übergeben
        $faqModel->controllInput($_POST);
    }
	
	/**
     * Führt die Abfragemethode aus
     * @return Array
     */
    public function getFAQs(){
        // Model einbinden
        require_once '/models/faq.php';
        
        // FAQ-Objekt erstellen
		$faqModel = new Faq();
		
        // Methode ausführen und zurückgeben
        return $faq->getFaq();
    }
}
 
/* End of file faqController.php */
/* Location: ./controllers/faqController.php */