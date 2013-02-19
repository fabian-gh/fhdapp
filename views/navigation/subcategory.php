<?php

	$temp = "<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade={$_GET['grade']}&page=";
	
	if($_GET['eis'] == 'i')
	{
		require_once "views/studiengaenge/info.php";

		echo $temp ."FAQ' data-role='button' style='text-align: center;'>FAQ</a>"
			.$temp ."Kontakte' data-role='button' style='text-align: center;'>Kontakte</a>"
			.$temp ."Termine' data-role='button' style='text-align: center;'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button' style='text-align: center;'>Veranstaltungen</a>";
	}

	else if($_GET['eis'] == 'e')
	{
		echo "<h1>{$_GET['course']}</h1>";
		echo $temp ."Info' data-role='button' style='text-align: center;'>Info</a>"
			.$temp ."FAQ' data-role='button' style='text-align: center;'>FAQ</a>"
			.$temp ."Kontakte' data-role='button' style='text-align: center;'>Kontakte</a>"
			.$temp ."Termine' data-role='button' style='text-align: center;'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button' style='text-align: center;'>Veranstaltungen</a>"
			.$temp ."Mensa' data-role='button' style='text-align: center;'>Mensa</a>";
	}

	else if($_GET['eis'] == 's')
	{
		echo "<h1>{$_GET['course']}</h1>";
		echo $temp ."Info' data-role='button' style='text-align: center;'>Info</a>"
			.$temp ."FAQ' data-role='button' style='text-align: center;'>FAQ</a>"
			.$temp ."Kontakte' data-role='button' style='text-align: center;'>Kontakte</a>"
			.$temp ."Termine' data-role='button' style='text-align: center;'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button' style='text-align: center;'>Veranstaltungen</a>"
			.$temp ."Mensa' data-role='button' style='text-align: center;'>Mensa</a>";
	}

?>