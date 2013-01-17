<?php

	require_once 'controllers/infoController.php';
	$controller = new controller();  
	
	$row = $controller->load_view();  

	echo "<ul data-role='listview' data-dividertheme='a' data-inset='true'>
	        <li data-role='list-divider'><h3> Name: ".$row['name']."</h3><p>Abschluss: ".$row['graduate']."</p></li>
	        <li><div style='font-size: 12pt'>Fachbereich: ".$row['department']."</div></li>                    
	        <li><div style='font-size: 12pt'>Semesteranzahl: ".$row['semestercount']."</div></li> 
	        <li data-theme='c'><div><h3>Über uns:</h3><a style='color:black; font-size: 10pt'>".$row['description']."</a></div></li>
	        <li><a style='font-size: 12pt' href='".$row['link']."'>URL: zur Studiengangsseite</a></li>
	        </ul>
	    </div>";

?>