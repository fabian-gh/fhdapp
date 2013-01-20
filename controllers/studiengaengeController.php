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
        $page_2 = new select_graduate_page();
        $page_3 = new info_page();
        
        $model = new db_connector();
        if(isset($_GET['scourse'])&& !isset($_GET['graduate']))
        {
        if($model->get_graduate_amount($_GET['scourse'])>1)
        return $page_2->content($_GET['scourse']);
        else
        {
        header("Location: index.php?eis=".$_GET['eis']."&selector=Studiengaenge&scourse=".$_GET['scourse']."&graduate=".$model->get_graduate_info($_GET['scourse']));
        }
        }
        else if(isset($_GET['scourse']) && isset($_GET['graduate']))
        {
            if($_GET['graduate']=='Bachelor' || $_GET['graduate']=='Master' )
            return $page_3->content($_GET['scourse'],$_GET['graduate']);
        }
        else
        {
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
}

/* End of file studiengaengeController.php */
/* Location: ./controllers/studiengaengeController.php */

?>