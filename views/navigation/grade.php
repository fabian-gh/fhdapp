<?php

	require_once 'controllers/abschlussController.php';
	$gradeController = new GradeController();

	$grades = $gradeController->getGrades($_GET['course']);

	$bachelor = false;
	$master = false;

	foreach($grades as $grade)
	{
		if(strpos($grade['name'], 'Bachelor') !== false)
			$bachelor = true;
		if(strpos($grade['name'], 'Master') !== false)
			$master = true;
	}

	//falls es bachelor und master gibt
	if($bachelor && $master)
	{
		echo "<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Bachelor' data-role='button'>Bachelor</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Master' data-role='button'>Master</a>";
	}
	//sonst direkt zum entsprechenden weiterleiten
	else if($bachelor)
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Bachelor");
	else
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Master");
?>