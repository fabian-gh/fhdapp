<?php

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
    public function __construct()
    {
        require_once 'models/studiengaenge.php';
        require_once 'views/studiengaenge/info.php';
        $this->db = new db_connector;
    }

    // load a needed view
    function load_view()
    {
        return $this->db->get_course_information($_GET['course'], $_GET['grade']);
    }
}

/* End of file studiengaengeController.php */
/* Location: ./controllers/studiengaengeController.php */

?>