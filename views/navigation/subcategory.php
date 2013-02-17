<?php

	$temp = "<a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade={$_GET['grade']}&page=";
	
	if($_GET['eis'] == 'i')
	{
		require_once "views/studiengaenge/info.php";

		echo $temp ."FAQ' data-role='button'>FAQ</a>"
			.$temp ."Kontakte' data-role='button'>Kontakte</a>"
			.$temp ."Termine' data-role='button'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button'>Veranstaltungen</a>";
	}

	else if($_GET['eis'] == 'e')
	{
		echo $temp ."Info' data-role='button'>Info</a>"
			.$temp ."FAQ' data-role='button'>FAQ</a>"
			.$temp ."Kontakte' data-role='button'>Kontakte</a>"
			.$temp ."Termine' data-role='button'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button'>Veranstaltungen</a>"
			.$temp ."Mensa' data-role='button'>Mensa</a>";
	}

	else if($_GET['eis'] == 's')
	{
		echo $temp ."Info' data-role='button'>Info</a>"
			.$temp ."FAQ' data-role='button'>FAQ</a>"
			.$temp ."Kontakte' data-role='button'>Kontakte</a>"
			.$temp ."Termine' data-role='button'>Termine</a>"
			.$temp ."Veranstaltungen' data-role='button'>Veranstaltungen</a>"
			.$temp ."Mensa' data-role='button'>Mensa</a>";
	}

?>