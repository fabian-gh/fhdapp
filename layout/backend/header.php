<?php session_start(); ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../sources/css/style_backend.css" rel="stylesheet" type="text/css" media="screen" />
<title>FHD App - CMS</title>
</head>

<body>

	<div id ="header">
    	<div id ="headline">
        	<h1>CMS Web-App</h1>
        </div>
    </div>
    
    <div id ="wrapper">
    
        <?php

        if(isset($_SESSION['user_id'])){

            echo '<div id ="nav">
                    <h3>Seiteninhalt bearbeiten:</h3>
                    <ul>
                        <li><a href="../../views/studiengaenge/backend_studiengaenge.php">Studiengänge</a></li>
                        <li><a href="../../views/veranstaltungen/backend_veranstaltungen.php">Veranstaltungen</a></li>
                        <li><a href="../../views/termine/backend_termine.php">Termine</a></li>
                        <li><a href="../../views/mensa/choose.php">Mensa</a></li>
                        <li><a href="../../views/faq/backend_faq.php">FAQ</a></li>
                        <li><a href="../../views/kontakte/backend_kontakte.php">Kontakt</a></li>
                        <li><a href="../login/logout.php">Logout</a></li>
                    </ul>
                </div>';
        } else {
            header('Location: ../login/login.php');
        }

        ?>
        
        <div id ="content">