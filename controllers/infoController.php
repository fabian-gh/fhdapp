<?php
require_once 'models/studiengaenge.php';
require_once 'views/studiengaenge/info.php';

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Ewest Paul - Kristian 
 */


class controller
{
    function _construct()
    {
    }
    
    // load a needed view
    function load_view()
    {
        $page = new info_page();
        
        $model = new db_connector();

        return $page->content($_GET['course'],$_GET['grade']);
    }
}

/* End of file studiengaengeController.php */
/* Location: ./controllers/studiengaengeController.php */

?>