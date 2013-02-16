<?php

	if($_GET['eis'] == 'i') //liste oder quiz auswählen
		echo "<a href='index.php?eis=i&selector=Studieng%C3%A4nge' data-role='button'>Studiengänge</a>
		<a href='index.php?eis=i&selector=Quiz' data-role='button'>Quiz</a>";

	else //direkt zur liste weiterleiten
		header("Location: index.php?eis={$_GET['eis']}&selector=Studieng%C3%A4nge");

?>