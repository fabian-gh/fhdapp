<?php

    echo showpage();

    function showpage()
    {
        require_once '../../models/studiengaenge.php';
        require_once '../../controllers/coursesController.php';
        $controller = new coursesController();  
        return $controller->load_view();  
    }

    // View of the first page where all studycourses are shown
    // + filter functions
    class courses_list_page
    {
        
        function _construct()
        {

        }

        function course($name,$bmt_icons)
        {
            $str="<li data-icon='false'>
                <a href='index.php?eis=".$_GET['eis']."&selector=Studiengaenge&course=".$name."' method='get'>
                    <h6 style=' font-size: 11pt; margin-top: 8px; margin-left: 10px;'>".$name."</h6>
                    <h6 class='ui-li-aside' style='display: inline; margin-top: 5px;'>".$bmt_icons."</h6>
                </a>
            </li>";
            return $str;
        }

        // calculate a filter and return as string
        function calculate_filter_options()
        {
            $filter="";
            $orientation_checked_flag=false;
            $orientation_filter="";
            
            for($x=0;$x<8;$x++)
            {
            if(isset($_GET[$x]))
            {
                if(isset($_GET[0]))
                {
                if($_GET[0]=='bachelor')
                {
                 if(isset($_GET[1]) && $_GET[1]=='master')
                 {}
                 else
                 {
                 $filter=$filter."and e1.graduate='bachelor'";
                 }
                }
                else if($_GET[0]=='master')
                {
                 $filter=$filter."and e1.graduate='master'";
                }
                }
                
                
                if($_GET[$x]=='vollzeit')
                {
                  if (isset($_GET[$x+1]))
                  {
                      if ($_GET[$x+1]=='teilzeit')
                      {}
                      else
                      $filter=$filter."and e1.time='vollzeit'";
                  }
                  else
                  {
                      $filter=$filter."and e1.time='vollzeit'";
                  }
                }

                else if($_GET[$x]=='teilzeit')
                {
                    if (isset($_GET[$x-1]))
                    {   
                        if ($_GET[$x-1]=='vollzeit')
                        {}
                        else
                        $filter=$filter."and e1.time='teilzeit'";
                    }
                    else
                    $filter=$filter."and e1.time='teilzeit'";
                }
                
                
                    if ($_GET[$x]=='gestalterisch' || $_GET[$x]=='ingenieurwissenschaftlich' || $_GET[$x]=='gesellschaftlich' || $_GET[$x]=='wirtschaftlich')
                    {
                        if($orientation_checked_flag)
                        {
                        $orientation_filter=$orientation_filter." or e1.orientation='".$_GET[$x]."'";
                        }
                        else
                        {
                        $orientation_filter=$orientation_filter." e1.orientation='".$_GET[$x]."'";
                        $orientation_checked_flag=true;
                        }
                    }
                }
            }
            
            if($orientation_checked_flag)
            {
                $filter = $filter." and (".$orientation_filter.")";
            }
            return $filter;
        }

        //build a studycourses_list with needed icons and names
        function courses_list()
        {
            $b="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/b.png'>";
            $m="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/m.png'>";
            $t="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/t.png'>";
            $d="<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/d.png'>";
            $dummy = "<img style='margin-left:3px; margin-top: 5px;' src='views/studiengaenge/data/images/dummy_bmt.png'>"; 

            $bmt_icons="";

            $filter=$this->calculate_filter_options() ;


            $db = new db_connector;
            $rs = $db->all_courses($filter);

            $clist = new courses_list_page();
            $li="";
            if($rs != null)
                while($row = mysql_fetch_array($rs))
                {
                    if($row['grad1']=='Bachelor' || $row['grad2']=='Bachelor' )
                    {
                    $bmt_icons=$bmt_icons.$b;   
                    }
                    else
                    {
                    $bmt_icons=$bmt_icons.$dummy; 
                    }
                        if($row['grad1']=='Master' || $row['grad2']=='Master' )
                        {
                        $bmt_icons=$bmt_icons.$m;     
                        }
                        else
                        {
                        $bmt_icons=$bmt_icons.$dummy;    
                        }
                            if($row['time1']=='Teilzeit' || $row['time2']=='Teilzeit')
                            {
                            $bmt_icons=$bmt_icons.$t;     
                            }
                            else 
                            {
                            $bmt_icons=$bmt_icons.$dummy;   
                            }
                    
                $li = $li.$clist->course($row[0],$bmt_icons);
                $bmt_icons="";
                }
            return $li;
        }

        function content($arr)
        {
            $j_arr = json_encode($arr);
            $cl = $this->courses_list();
            $eis = json_encode($_GET['eis']);

            // build a page
            $html="<div id='filter_options' data-role='collapsible-set' data-theme='a' data-collapsed-icon='gear' data-expanded-icon='gear' data-iconpos='right'>
                <div data-role='collapsible' data-collapsed='false'>
                    <h3>Studiengänge filtern</h3>".$this->filter()."
                </div>
            </div>
            
            <ul data-role='listview' data-inset='true'>".$cl."</ul>
                
            <script src='views/studiengaenge/data/scripts/checkboxes_control.js'></script>
            <script>filter($j_arr)</script>
            <script src='views/studiengaenge/data/scripts/filter_control.js'></script>
            <script>fcontrol($eis)</script>";
            
            return $html;
        }

        function filter()
        {
            return "<div data-role='controlgroup' data-mini='true'> 
            <input type='checkbox' name='bachelor' id='bachelor' class='custom'/>
            <label for='bachelor'>Bachelor</label>
            <input type='checkbox' name='master' id='master' class='custom'/>
            <label for='master'>Master</label>
            <input type='checkbox' name='vollzeit' id='vollzeit' class='custom'/>
            <label for='vollzeit'>Vollzeit</label>
            <input type='checkbox' name='teilzeit' id='teilzeit' class='custom'/>
            <label for='teilzeit'>Teilzeit</label>
            </div>
            
            <div data-role='controlgroup' data-mini='true' style='margin-top: 10px'>
            <input type='checkbox' name='gestalterisch' id='gestalterisch' class='custom' />
            <label for='gestalterisch'>gestalterisch</label>
            <input type='checkbox' name='ingenieurwissenschaftlich' id='ingenieurwissenschaftlich' class='custom'  />
            <label for='ingenieurwissenschaftlich'>ingenieurwissenschaftlich</label>
            <input type='checkbox' name='gesellschaftlich' id='gesellschaftlich' class='custom' />
            <label for='gesellschaftlich'>gesellschaftlich</label>
            <input type='checkbox' name='wirtschaftlich' id='wirtschaftlich' class='custom'  />
            <label for='wirtschaftlich'>wirtschaftlich</label>
            </div>";
        }
    }

?>