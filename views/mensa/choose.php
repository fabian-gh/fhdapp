<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

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
                <td><a class="button" href="?category=canteen&mode=edit&cw=1">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&cw=1">löschen</a></td>
              </tr>
              <tr>
                <td>2</td>
                <td>46</td>
                <td>28.01.2013</td>
                <td>08.02.2013</td>
                <td><a class="button" href="?category=canteen&mode=edit&cw=2">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&cw=2">löschen</a></td>
              </tr>
              <tr>
                <td>3</td>
                <td>47</td>
                <td>25.02.2013</td>
                <td>08.03.2013</td>
                <td><a class="button" href="?category=canteen&mode=edit&cw=3">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&cw=2">löschen</a></td>
              </tr>
            </table>
            <p><a class="button" href="?category=canteen&mode=add">neue Woche hinzufügen</a></p>


<?php
    require_once '../../layout/backend/footer.php';



if(isset($_GET['mode']) && $_GET['mode'] == 'edit'){
  require_once '../../controllers/mensaController.php';
  $Mensa = new MensaController();
}


/* End of file backend.php */
/* Location: ./views/mensa/backend.php */