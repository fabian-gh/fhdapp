<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class Faq extends Data{

    /**
     * Kontrolliert Daten auf vollständigkeit
     *
     */
    public function controlInput($_POST){
        
		//TODO Kontrolle der Daten
		$this->intoDB($_POST);
    }
	
	/**
     * Speichert Daten in Datenbank
     *
     */
	public function intoDB($_POST){
		 try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
            $db = new mysqli($this->getHostname(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
            
			// Abfrage erstellen
			$insert = "INSERT INTO faq (question, answer, sorting) VALUES ('".$_POST['frage']."', '".$_POST['antwort']."', '".$_POST['sort']."')";
			
            // Abfrage ausführen
            $result = $db->query($insert);
            
            // Ergebnis der Abfrage ausgeben
            echo $result;
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
	}
	
	
	/**
     * Holt Daten aus Datenbank
     * @return Array
     */
	public function getFaq(){
        try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
            $db = new mysqli($this->getHostname(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
            
            // Abfrage ausführen
            $result = $db->query("SELECT question, answer, sorting FROM faq");
            
            // Ergebnis der Abfrage "durchwandern" und in Array schreiben
            while($row = $result->fetch_assoc()){
                $resultSet[] = $row;
            }
            
            return $resultSet;
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

/* End of file faq.php */
/* Location: ./models/faq.php */