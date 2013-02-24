<?php

	require_once 'controllers/infoController.php';
	$controller = new controller();  
	
	$row = $controller->load_view();  

	echo "<ul data-role='listview' data-dividertheme='a' data-inset='true'>
	        <li data-role='list-divider'><h3>".utf8_decode($row['name'])."</h3><p>".utf8_decode($row['graduate'])."</p></li>
	        <li><div style='font-size: 12pt'>Fachbereich: ".utf8_decode($row['department'])."</div></li>                    
	        <li><div style='font-size: 12pt'>".$row['semestercount']." Semester</div></li> 
	        <li data-theme='c'><div><a style='color:black; font-size: 10pt'>".utf8_decode($row['description'])."</a></div></li>
	        <li><a style='font-size: 12pt' href='".$row['link']."'>weitere Informationen</a></li>
	    </ul>";

?>