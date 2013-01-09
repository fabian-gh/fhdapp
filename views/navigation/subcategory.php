<?php

	if($_GET['eis'] == 'i')
		echo "hier stehen alle unterkategorien von interessenten<br>
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&page=Termine'>Termine</a>";

	else if($_GET['eis'] == 'e')
		echo "hier stehen alle unterkategorien von erstis
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&page=Termine'>Termine</a>";
	
	else if($_GET['eis'] == 's')
		echo "hier stehen alle unterkategorien von studenten
		<a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}&page=Termine'>Termine</a>";

?>