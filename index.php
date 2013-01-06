<?php

    //falls keine connection vorhanden, connection erstellen
    if(!isset($_SESSION['connection']))
    {
        session_start();
        require_once 'system/database.php';
        new Database();
    }
    //cookies lesen, damit beim ersten aufruf der seite der letzte kram geladen wird

	    //falls kein deeplink verwendet wird
        if(count($_GET) <= 0)
		
            if(isset($_COOKIE['get']))
            {
               $link = "index.php?";
            foreach($_COOKIE['get'] as $key => $value)
                    $link .= "$key=$value" . "&";//$link .= "{$_GET["$key"]}=$value";
                header("Location: $link");
            }
    
    //sonst cookies bei jedem seitenaufbau schreiben
    else
    {
        //alte cookies löschen
        if(isset($_COOKIE['get']))
            foreach($_COOKIE['get'] as $key => $value)
                setcookie("get[$key]", "", time() - 1);
        
        //neue cookies speichern
        foreach($_GET as $key => $value)
            setcookie("get[$key]", $value, 2000000000);
    }
?>

<!DOCTYPE html>
<html>

<head>
<title>FHD WebApp</title>
<!-- max. Breite u. Skalierung -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Zeichensatz -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- CSS -->
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
<link rel="stylesheet" href="sources/css/style.css" />
<!-- jQuery -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head>

<body>

    <div id ="header">
        <div id ="logo">
            <a href="index.php">FHD</a>
        </div>
        <div id ="breadcrumb">
            <a href="index.php">Start</a> 
		
            <?php
                if(isset($_GET['eis']))
					echo " » <a href='index.php?eis={$_GET['eis']}' class='nav-icon-{$_GET['eis']}'>Interessent</a>";
                if(isset($_GET['selector']))
                    echo "» <a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}'>{$_GET['selector']}</a>";

                if(isset($_GET['course']))
                    echo " » <a href='index.php?eis={$_GET['eis']}&selector={$_GET['selector']}&course={$_GET['course']}'>{$_GET['course']}</a>";

                if(isset($_GET['page']))
                    echo " » <a href=''>{$_GET['page']}</a>";
            ?>

        </div>
    </div>
    
    <div id ="content">

        <?php 
		
            if(isset($_GET['eis']))
            {
                if(isset($_GET['selector']))
                {
                    if(isset($_GET['course']))
                    {
                        if(isset($_GET['page']))
                        {
                            switch($_GET['page'])
                            {
								case 'Veranstaltungen': require_once 'views/veranstaltungen/veranstaltungen.php'; break;
								case 'Termine': require_once 'views/termine/termine.php'; break;
                            }
                        }
                        else //ebene3: "startseite", auswahl der unterkategorie
                        {
                            require_once 'views/navigation/subcategory.php';
                        }
                    }
                    else //ebene2: auswahl des studienganges in liste oder quiz
                    {
                        switch($_GET['selector'])
                        {
                            case 'Studiengänge': require_once 'views/navigation/courses.php'; break;
                            case 'Quiz': require_once 'views/navigation/quiz.php'; break;
                        }
                    }
                }
                else //ebene1: auswahl der vorgehensweise einen studiengang zu finden (liste, quiz)
                    require_once 'views/navigation/selector.php';
            }
            else //ebene0: auswahl von interessent, ersti, student
            {
                require_once 'views/navigation/start.php';
            }

        ?>

    </div>

</body>

</html>