<?php

	require_once 'controllers/abschlussController.php';
	$gradeController = new GradeController();

	//abschlussarten auslesen
	$grades = $gradeController->getGrades($_GET['course']);

	$bachelor = false;
	$master = false;

	//überprüfen, ob bachelor und / oder master vorhanden
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
		echo "<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade=Bachelor' data-role='button'>Bachelor<div class='subtitle'>Hier stehen Informationen zum Bachelor-Studiengang.</div></a>
		<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade=Master' data-role='button'>Master<div class='subtitle'>Hier stehen Informationen zum Master-Studiengang.</div></a>";
	}
	//sonst direkt zum entsprechenden weiterleiten
	else if($bachelor)
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Bachelor");
	else
		header("Location: index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade=Master");
?>