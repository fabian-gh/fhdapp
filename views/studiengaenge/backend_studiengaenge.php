<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
       "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="sources/css/style_backend.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="sources/js/jquery-1.8.2.min.js"></script>
	<title>FHD App - Redaktion</title>
</head>

<body>

	<div id="wrapper">
		<div id="header">	<!-- Header -->
			<h1> FHD-App Redaktion </h1>
		</div>
		<div id="nav">	<!-- Navi -->
			<ul>
				<a href="views/studiengaenge/backend_studiengaenge.php"><li>Studieng&auml;nge</li></a>
				<a href="views/mensa/backend_mensa.php"><li>Mensa</li></a>
				<a href="views/termine/backend_termine.php"><li>Termine</li></a>
				<a href="views/kontakte/backend_kontakte.php"><li>Kontakte</li></a>
				<a href="views/faq/backend_faq.php"><li>FAQ</li></a>
				<a href="views/veranstaltungen/backend_veranstaltungen.php"><li>Veranstaltungen</li></a>
			</ul>
		</div>
		
		<div id="content">	<!-- Inhalt -->
			<h1>Studieng&auml;nge</h1>
			
			<?php
				require_once 'controllers/studiengaengeController.php';
    			$studycoursesController = new StudycoursesController();
				require_once 'insertFormular.php';	//Formular zum einfügen der Studiengänge
				if(isset($_POST["insert"])){
					$studycoursesController->insertStudycourse($_POST["language_id"], $_POST["name"], $_POST["description"], $_POST["department_id"], $_POST["semestercount"], $_POST["graduate_id"], $_POST["link"]);
				}
			?>
			
		</div>
		
		<div class="clearBoth"></div>
	</div>	

</body>

</html>