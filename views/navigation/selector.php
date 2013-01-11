<?php

	if($_GET['eis'] == 'i') //liste oder quiz auswählen
		echo "<a href='index.php?eis=i&selector=Studiengaenge' data-role='button'>Studiengänge</a><br>
		<a href='index.php?eis=i&selector=Quiz' data-role='button'>Quiz</a>";

	else //direkt zur liste weiterleiten
		header("Location: index.php?eis={$_GET['eis']}&selector=Studiengaenge");

?>