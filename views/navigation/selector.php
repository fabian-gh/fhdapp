<?php
	if($_GET['eis'] == 'w')
		require_once 'views/navigation/webapp.php';
	
	else if($_GET['eis'] == 'i') //liste oder quiz auswählen
		echo "<a href='index.php?eis=i&selector=Studieng%C3%A4nge' data-role='button'>Studiengänge<div class='subtitle'>Hier werden alle Studiengänge aufgelistet.</div></a>
		<a href='index.php?eis=i&selector=Quiz' data-role='button'>Quiz<div class='subtitle'>Falls du dir nicht sicher bist, was du studieren möchtest.</div></a>";

	else //direkt zur liste weiterleiten
		header("Location: index.php?eis={$_GET['eis']}&selector=Studieng%C3%A4nge");

?>