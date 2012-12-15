<?php

session_start();

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */



// Falls über Deeplink zugegriffen wird und Session noch nicht gestartet, diese starten
if(!isset($_SESSION['session_id'])){
    $_SESSION['session_id'] = session_id();
}

// include layout
require_once '../../layout/backend/header.php';

?>

       	  <h2>Mensapl&auml;ne</h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th>ID</th>
                <th>Kalenderwoche</th>
                <th>Startdatum</th>
                <th>Enddatum</th>
                <th>Optionen</th>
              </tr>
              <tr>
                <td>1</td>
                <td>45</td>
                <td>24.12.2012</td>
                <td>04.01.2013</td>
                <td><a class="button" href="?category=canteen&mode=edit&id=1">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&id=1">löschen</a></td>
              </tr>
              <tr>
                <td>2</td>
                <td>46</td>
                <td>28.01.2013</td>
                <td>08.02.2013</td>
                <td><a class="button" href="?category=canteen&mode=edit&id=2">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&id=2">löschen</a></td>
              </tr>
              <tr>
                <td>3</td>
                <td>47</td>
                <td>25.02.2013</td>
                <td>08.03.2013</td>
                <td><a class="button" href="?category=canteen&mode=edit&id=3">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&id=2">löschen</a></td>
              </tr>
            </table>
            <p><a class="button" href="?category=canteen&mode=add">neue Woche hinzufügen</a></p>


<?php
    require_once '../../layout/backend/footer.php';


/* End of file backend.php */
/* Location: ./views/mensa/backend.php */