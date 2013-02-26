<?php

	require_once 'controllers/abschlussController.php';
	$gradeController = new GradeController();

	//abschlussarten auslesen
	$grades = $gradeController->getGrades($_GET['course']);

	$bachelor = false;
	$master = false;
        $count=0;
        
        if(isset($_SESSION["stc_graduate"]))
        {
            if($_SESSION["stc_graduate"]=='bachelor')
                $bachelor=true;
            else
                $master=true;
        }
        else
        {
        
	//überprüfen, ob bachelor und / oder master vorhanden
	foreach($grades as $grade)
	{
		if(strpos($grade['graduate'], 'Bachelor') !== false)
			$bachelor = true;
		if(strpos($grade['graduate'], 'Master') !== false)
			$master = true;
                
                $count++;
                
	}
        }

         $_SESSION["stc_graduate"]=null;
	//falls es bachelor und master gibt
	if($count==2)
	{
                $count=0;
		echo "<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade=Bachelor' data-role='button' style='text-align: center;'>Bachelor</a>
		<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade=Master' data-role='button' style='text-align: center;'>Master</a>";
	}
	//sonst direkt zum entsprechenden weiterleiten
	else if($bachelor)
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Bachelor");
	else
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Master");
?>