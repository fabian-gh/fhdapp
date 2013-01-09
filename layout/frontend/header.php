<?php 

session_start(); 

if(!isset($_SESSION['host'])){
    require_once '../../system/database.php';
    new Database();
}


?>

<!DOCTYPE html><!-- HTML 5 -->
<html>

    <head>
        <title>FHD WebApp</title>
        <!-- max. Breite u. Skalierung -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- Zeichensatz -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!-- CSS -->
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="../../sources/css/style.css" />
        <!-- jQuery -->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    </head>
    
    <body>
        <div id="header">
            <div id="logo">
                <a href="index.php">FHD</a>
            </div>
            <div id ="breadcrumb">
                <a href="index.php">Start</a> » 
                <a href='index.php?eis=i' class='nav-icon-i'>Student</a> » 
                <a href='index.php?eis=i&selector=mensa'>Mensa</a> » 
                <a href='index.php?eis=i&selector=mensa&location=north'>Nord</a> » 
            </div>
        </div> <!-- Ende header -->
        
        <div id ="content">