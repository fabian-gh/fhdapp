<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class LoginController{
    
    /**
     * Konstruktor des Login-Controllers
     * @param Object $Data
     */
    public function __construct($post){

        // Neue Verbindung aufbauen
        $Connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);

        // Login-Modell einbinden
        require_once '../../models/login.php';
        // und Objekt erstellen
        new Login($Connection, $post);
    }
}

 
/* End of file lognController.php */
/* Location: ./controllers/loginController.php */