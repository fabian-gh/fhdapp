<?php

	if($_GET['eis'] == 'i')
		echo "hier stehen alle unterkategorien von interessenten<br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Info' data-role='button'>Info</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte' data-role='button'>Kontakte</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>";

	else if($_GET['eis'] == 'e')
		echo "hier stehen alle unterkategorien von erstis<br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Info' data-role='button'>Info</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte' data-role='button'>Kontakte</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>";

	else if($_GET['eis'] == 's')
		echo "hier stehen alle unterkategorien von studenten
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Info' data-role='button'>Info</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=FAQ' data-role='button'>FAQ</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Kontakte' data-role='button'>Kontakte</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Termine' data-role='button'>Termine</a><br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&grade={$_GET['grade']}&page=Veranstaltungen' data-role='button'>Veranstaltungen</a>";

?>