<?php

	if($_GET['eis'] == 'i')
	{
		require_once "views/studiengaenge/info.php";

		echo "<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte&cat=2' data-role='button'>Kontakte</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>";
	}

	else if($_GET['eis'] == 'e')
		echo "<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Info' data-role='button'>Info</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte&cat=2' data-role='button'>Kontakte</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Mensa' data-role='button'>Mensa</a>";

	else if($_GET['eis'] == 's')
		echo "<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Info' data-role='button'>Info</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte&cat=2' data-role='button'>Kontakte</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Mensa' data-role='button'>Mensa</a>";

?>