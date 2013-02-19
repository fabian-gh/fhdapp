<?php session_start();ob_start();

    //beim ersten start der seite, connection erstellen und gegebenenfalls cookies laden
    if(!isset($_SESSION['user']))
    {
        require_once 'system/database.php';
        new Database();

        //falls kein deeplink verwendet wird
        if(count($_GET) <= 0)
            if(isset($_COOKIE['selection']))
            {
                $link = "index.php?{$_COOKIE['selection']}";
                header("Location: $link");
            }
    }
    //falls studiengang gewählt, hierarchie und auswahl in cookies speichern
    if(isset($_GET['eis']) && isset($_GET['selector']) && isset($_GET['course']) && isset($_GET['grade']))
    {
        //alten cookie löschen
        if(isset($_COOKIE['selection']))
            setcookie("selection", "", time() - 1);
        
        //neuen cookie speichern (21 jahre gültig)
        $selection = "eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade={$_GET['grade']}";
        setcookie("selection", $selection, 2000000000);
    }

    ob_clean();
    
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
    <div data-role='page' data-theme='c'>
        <div id ="header">
            <div id ="logo">
                <a href="index.php">FHD</a>
            </div>
            <div id ="breadcrumb">
                <a href="index.php">Start</a> 

                <?php

                    if(isset($_GET['eis']))
                        echo " » <a href='index.php?eis={$_GET['eis']}' class='nav-icon-{$_GET['eis']}'>Zielgruppe</a>";

                    if(isset($_GET['selector']))
                        echo "» <a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."'>{$_GET['selector']}</a>";

                    if(isset($_GET['course']))
                        echo " » <a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}'>{$_GET['course']}</a>";

                    if(isset($_GET['grade']))
                        echo " » <a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade={$_GET['grade']}'>{$_GET['grade']}</a>";

                    if(isset($_GET['page']))
                        echo " » <a href='index.php?eis={$_GET['eis']}&selector=".urlencode($_GET['selector'])."&course={$_GET['course']}&grade={$_GET['grade']}&page={$_GET['page']}'>{$_GET['page']}</a>";

                ?>

            </div>
        </div>
        
        <div id ="content" data-role='content'>

            <?php 

                if(isset($_GET['eis']))
                {
                    if(isset($_GET['selector']))
                    {
                        if(isset($_GET['course']))
                        {
                            if(isset($_GET['grade']))
                            {
                                if(isset($_GET['page']))
                                {
                                    switch($_GET['page'])
                                    {
                                        case 'Termine': require_once 'views/termine/termine.php'; break;
                                        case 'Mensa': require_once 'views/mensa/mensa.php'; break;
                                        case 'FAQ': require_once 'views/faq/faq.php'; break;
                                        case 'Kontakte': require_once 'views/kontakte/frontend_kontakte.php'; break;
                                        case 'Info': require_once 'views/studiengaenge/info.php'; break;
                                        case 'Veranstaltungen': require_once 'views/veranstaltungen/veranstaltungen.php'; break;
                                    }
                                }
                                else //ebene4: "startseite", auswahl der unterkategorie
                                {
                                    require_once 'views/navigation/subcategory.php';
                                }
                            }
                            else //ebene3: auswahl bachelor / master
                            {
                                require_once 'views/navigation/grade.php';
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
    </div>

</body>

</html>