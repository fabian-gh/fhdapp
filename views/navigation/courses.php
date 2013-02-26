<?php

    echo showpage();

 /**
 * Eine Seite wird gebildet und zurückgegeben
 * @return eine entsprechende Seite als String (generierter html code)
 */
    function showpage()
    {
        require_once 'models/studiengaenge.php';
        require_once 'controllers/coursesController.php';
        $controller = new controller();  
        return $controller->load_view();  
    }

     // View of the first page where all studycourses are shown
    // + filter functions
    /**
    * Seitenklasse für die Stg.-Seite mit Liste von Studiengängen und Filteroptionen (checkboxes)
    */
    class courses_list_page
    {
        function _construct()
        {}
        
        /**
 * Anzeige eines Studienganges in der Liste.
 * @param Name/Bezeichnung des Studiengangs
 * @param entsprechnde Icons als String (html code)
 * @return ein Studiegang als String (html code)
 */
       private function course($name,$bmt_icons)
        {
            $str="<li data-icon='false'>
                <a href='index.php?eis=".$_GET['eis']."&selector=".urlencode($_GET['selector'])."&course=".$name."' method='get'>
                    <h6 style=' font-size: 11pt; margin-top: 8px; margin-left: 10px;'>".$name."</h6>
                    <h6 class='ui-li-aside' style='display: inline; margin-top: 5px;'>".$bmt_icons."</h6>
                </a>
            </li>";
            return $str;
        }
      
        // calculate a filter and return as string
        /**
        * Berechnung bzw. Zusammenstellung der Filter-Abfrage für SQL-Datenbank
        * @return SQL - (teil-)Abfrage als String
        */
      private  function calculate_filter_options()
        {
         
           $_SESSION["stc_graduate"] = null;
           $_SESSION["stc_dual"] = null;
           $_SESSION["stc_teilzeit"] = null;  
          
            // list of orientations
            $orientation_arr= array('design','ingenieur','informatik','medien','sozial','kultur','wirtschaft');
            $arr= array('bachelor','master','teilzeit','dual');
            
            $filter="";
            $time_checked_flag=false;
            $orientation_checked_flag=false;
            $graduate_filter="";
            $time_filter="";
            $orientation_filter="";
            
            // calculate filter request
            for($x=0;$x<11;$x++)
            {
            if(isset($_GET[$x]))
            {
                if($_GET[0]=='bachelor')
                {
                    if(isset($_GET[1]) && $_GET[1]=='master')
                    {
                    $_SESSION["stc_graduate"]=null;
                    }
                    else{
                    $graduate_filter=$graduate_filter."and graduate='bachelor'";
                    $_SESSION["stc_graduate"]='bachelor';
                    }
                }
                else if($_GET[0]=='master'){
                $graduate_filter=$graduate_filter."and graduate='master'";
                $_SESSION["stc_graduate"] = 'master';
                }
                
                    if($_GET[$x]=='teilzeit'){
                    $time_filter=$time_filter."time ='teilzeit'";
                    $time_checked_flag=true;
                    $_SESSION["stc_teilzeit"]='teilzeit';
                    }
                
                if($_GET[$x]=='dual')
                {
                    if(isset($_GET[$x-1]))
                        if ($_GET[$x-1]=='teilzeit'){
                        $time_filter=$time_filter."or time ='dual'";
                        $_SESSION["stc_dual"]='dual';
                        }
                        else{
                        $time_filter=$time_filter."time ='dual'";  
                        $time_checked_flag=true;
                        $_SESSION["stc_dual"]='dual';
                        }
                      
                    else{
                    $time_filter=$time_filter."time ='dual'";
                    $time_checked_flag=true;
                    $_SESSION["stc_dual"]='dual';
                    }
                }
                
                    // if one of the orientations is selected
                    if (in_array($_GET[$x],$orientation_arr))
                    {
                        if($orientation_checked_flag)
                        $orientation_filter=$orientation_filter." or orientation ='".$_GET[$x]."'";
                        else
                        {
                        $orientation_filter=$orientation_filter." orientation ='".$_GET[$x]."'";
                        $orientation_checked_flag=true;
                        }
                    }
                }
            }
            
            if($time_checked_flag)
            $filter = $graduate_filter."and (".$time_filter.")";
            else
            $filter = $graduate_filter;
            if($orientation_checked_flag)
            $filter = $filter." and (".$orientation_filter.")";
      
            return $filter;
        }

        
   //build a studycourses_list with needed icons and names
  /**
 * Zusammenstellung der gesamten Liste als 1 Element
 * @return Liste von Studiengängen als String (html code)
 */
     private   function courses_list()
        {
            $b="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/b.png'>";
            $m="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/m.png'>";
            $t="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/t.png'>";
            $d="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/d.png'>";
            $dummy = "<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/dummy_bmt.png'>"; 
            
            $b_icon=$dummy;
            $m_icon=$dummy;
            $t_icon=$dummy;
            $d_icon=$dummy;
            $bmt_icons="";
            $li="";
            
            $filter=$this->calculate_filter_options() ;
            $db = new db_connector;            
            $rs = $db->all_courses($filter);

            $clist = new courses_list_page();
            $list = array();
            if($rs != null)
            while($row = mysql_fetch_array($rs))
            {
            array_push($list,$row);
            }
                
            $x=0;
            while($x < count($list))
            {
             
             if($list[$x]['graduate']=='Bachelor')
             $b_icon=$b;
             else
             $m_icon=$m;
             if($list[$x]['time']=='Teilzeit')
             $t_icon=$t;
             if($list[$x]['time']=='Dual')
             $d_icon=$d;
             
             if(isset($list[$x+1])){
             if($list[$x]['name']!=$list[$x+1]['name']){
             $bmt_icons = $b_icon.$m_icon.$t_icon.$d_icon;
             $li = $li.$clist->course($list[$x]['name'],$bmt_icons);
             
            $bmt_icons="";
            $b_icon=$dummy;
            $m_icon=$dummy;
            $t_icon=$dummy;
            $d_icon=$dummy;
                }
             }
             else
             {
             $bmt_icons = $b_icon.$m_icon.$t_icon.$d_icon;
             $li = $li.$clist->course($list[$x]['name'],$bmt_icons);   
             }
            $x++;
            }
            return $li;
        }

  /**
 * Seite mit allen Elementen wird gebildet
 * @param Liste (Array) von Filteroptionen (checkboxes)
 * @return gesamte Seite als String (html code)
 */
        function content($arr)
        {
            $j_arr = json_encode($arr);
            $cl = $this->courses_list();
            $eis = json_encode($_GET['eis']);

            // build a page
            $html="<div id='filter_options' data-role='collapsible-set' data-theme='a' data-collapsed-icon='gear' data-expanded-icon='gear' data-iconpos='right'>
            <div data-role='collapsible' data-collapsed='false'>
            <h3>Studiengänge filtern<div class='subtitle'>Durch die Filter kannst du bestimmte Studiengänge anzeigen oder verbergen.</div></h3>".$this->filter()."</div></div>
            <ul data-role='listview' data-inset='true'>".$cl."</ul>            
            <script src='views/studiengaenge/data/scripts/checkboxes_control.js'></script>
            <script>filter($j_arr)</script>
            <script src='views/studiengaenge/data/scripts/filter_control.js'></script>
            <script>fcontrol($eis)</script>";
            
            return $html;
        }

  /**
 * Filteroptionen (checkboxes) mit Bezeichnung und Icons
 * @return Filteroptionen als String (html code)
 */
        private function filter()
        {
            return "<div data-role='controlgroup' data-mini='true'> 
            <input type='checkbox' name='bachelor' id='bachelor' class='custom'/>
            <label for='bachelor'><h6 class='ui-li-icon' style='display: inline;'><img src='views/studiengaenge/data/images/b.png'/></h6> Bachelor</label>
            <input type='checkbox' name='master' id='master' class='custom'/>
            <label for='master'><h6 class='ui-li-icon' style='display: inline;'><img src='views/studiengaenge/data/images/m.png'/></h6> Master</label>
            <input type='checkbox' name='teilzeit' id='teilzeit' class='custom'/>
            <label for='teilzeit'><h6 class='ui-li-icon' style='display: inline;'><img src='views/studiengaenge/data/images/t.png'/></h6> Teilzeit</label>
            <input type='checkbox' name='dual' id='dual' class='custom'/>
            <label for='dual'><h6 class='ui-li-icon' style='display: inline;'><img src='views/studiengaenge/data/images/d.png'/></h6> Dual</label></div>
            <div data-role='controlgroup' data-mini='true' style='margin-top: 10px'>
            <input type='checkbox' name='design' id='design' class='custom' />
            <label for='design'>Design</label>
            <input type='checkbox' name='ingenieur' id='ingenieur' class='custom'  />
            <label for='ingenieur'>Ingenieur</label>
            <input type='checkbox' name='informatik' id='informatik' class='custom' />
            <label for='informatik'>Informatik</label>
            <input type='checkbox' name='medien' id='medien' class='custom' />
            <label for='medien'>Medien</label>
            <input type='checkbox' name='sozial' id='sozial' class='custom' />
            <label for='sozial'>Sozial</label>
            <input type='checkbox' name='kultur' id='kultur' class='custom' />
            <label for='kultur'>Kultur</label>
            <input type='checkbox' name='wirtschaft' id='wirtschaft' class='custom' />
            <label for='wirtschaft'>Wirtschaft</label>
            </div>";
        }
    }

?>