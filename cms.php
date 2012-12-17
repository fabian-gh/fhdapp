<?php session_start();

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

try
{
    
    if(!isset($_SESSION['connection']))
    {
        require_once 'system/database.php';
        new Database();
    }

    // Wenn noch nicht auf den Login-Button geklickt wurde dann
    /*if(!isset($_POST['login'])){  
        // Loginformular einbinden
        require_once 'views/login.php';
    } else {
        // den Controller einbinden
        require_once 'controllers/loginController.php';
        // Controller-Instanz erstellen
        new LoginController();
    }*/


    //get für deeplinks??
    if(isset($_GET['page']))
    {
        switch($_GET['page'])
        {
            case 'Studiengaenge': require_once 'views/studiengaenge/backend_studiengaenge.php'; break;
            case 'neuesSemester': require_once 'views/termine/neuesSemester.php'; break;
            case 'neuerTermin': require_once 'views/termine/neuerTermin.php'; break;
        }
    }
    else
    {
    	//linkliste
        echo "<a href='cms.php?page=Studiengaenge'>Studieng&auml;nge</a>";
    }
    
}
catch(Exception $error)
{
    // Errormessage ausgeben
    echo $error->getMessage();
}

/* End of file index.php */
/* Location: ./index.php */