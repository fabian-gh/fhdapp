<?php
require_once 'models/studiengaenge.php';
require_once 'views/navigation/courses.php';

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
        $page = new courses_list_page();
        
        $model = new db_connector();
        $arr = array();
            for($x=0;$x<8;$x++)
            {
                if(isset($_GET[$x]))
                {
                array_push($arr, $_GET[$x]);
                }
            }
         return $page->content($arr); 
    }
}

/* End of file studiengaengeController.php */
/* Location: ./controllers/studiengaengeController.php */

?>