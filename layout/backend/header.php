<?php session_start();

    if(!isset($_SESSION['user_id']))
        header('Location: ../login/login.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../sources/css/style_backend.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="../../sources/jqueryui/css/fhdapp/jquery-ui-1.10.0.custom.min.css" />
<script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="../../sources/jqueryui/js/jquery-ui-1.10.0.custom.min.js" type="text/javascript"></script>
<title>FHD App - CMS</title>
</head>

<body>

	<div id ="header">
    	<div id ="headline">
        	<h1>CMS Web-App</h1>
        </div>
    </div>
    
    <div id ="wrapper">
    
            <div id ="nav">
                    <h3>Seiteninhalt bearbeiten:</h3>
                    <ul>
                        <li><a id="liStudyCourses" href="../../views/studiengaenge/backend_studiengaenge.php?page=Studiengaenge">Studieng&auml;nge</a></li>
                        <?php
                            //Wenn man im Navigationspunkt "Studieng�nge" ist
                            if(@$_GET["page"]=="Studiengaenge"){
                                //Dann 2 Unterpunkte ausgeben, einmal "Einf�gen" und einmal "Bearbeiten/L�schen"
                                echo "<ul><li><a id='liInsertUpdateStudycourse' href=\"?page=Studiengaenge&action=einfuegen\">Einf&uuml;gen</a></li>
                                <li><a id='liEditDeleteStudycourse' href=\"?page=Studiengaenge&action=bearbeitenLoeschen\">Bearbeiten/L&ouml;schen</a></li></ul>";
                            }
                        ?>
                        <li><a id="liEvents" href="../../views/veranstaltungen/backend_veranstaltungen.php">Veranstaltungen</a></li>
                        <li><a id="liAppointments" href="../../views/termine/backend_termine.php">Termine</a></li>
                        <li><a id="liMensa" href="../../views/mensa/choose.php">Mensa</a></li>
                        <li><a id="liFaq" href="../../views/faq/backend_faq.php">FAQ</a></li>
                        <li><a id="liContacts" href="../../views/kontakte/backend_kontakte.php">Kontakt</a></li>
                        <li><a id="liLogout" href="../login/logout.php">Logout</a></li>
                    </ul>
                </div>
        
        <div id ="content">