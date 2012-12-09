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
                        <li><a href="">Studiengänge</a></li>
                        <li><a href="">Veranstaltungen</a></li>
                        <li><a class ="active" href="">Termine</a></li>
                        <li><a href="">Mensa</a></li>
                        <li><a href="">FAQ</a></li>
                        <li><a href="">Kontakt</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>';
        }

        ?>
        
        <div id ="content">