<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

// Ausgabe des Logins
try{
    // Session starten
    session_start();

    // Text für Logout
    if(isset($_SESSION['logout'])){
	    echo '<div id="failure">'.$_SESSION['logout'].'</div>';
	    session_destroy();
	}

    require_once 'system/database.php';
    new Database();
	echo "Session started";
    
    
} catch(Exception $error){
    // Errormessage ausgeben
    echo $error->getMessage();
}

/* End of file index.php */
/* Location: ./index.php */