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

require_once '../../controllers/mensaController.php';
$MensaController = new MensaController();

$plans = $MensaController->callGetAllPlans();

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

              <?php foreach($plans as $plan): ?>

              <tr>
                <td><?php echo $plan['id']; ?></td>
                <td><?php echo $plan['calenderweek']; ?></td>
                <td><?php echo $plan['start_date']; ?></td>
                <td><?php echo $plan['end_date']; ?></td>
                <td><a class="button" href="edit.php?category=canteen&mode=edit&cw=<?php echo $plan['calenderweek']; ?>">bearbeiten</a> <a class="button" href="?category=canteen&mode=delete&cw=<?php echo $plan['calenderweek']; ?>">löschen</a></td>
              </tr>

            <?php endforeach; ?>

            </table>
            <p><a class="button" href="edit.php?category=canteen&mode=add">neue Woche hinzufügen</a></p>


<?php
    require_once '../../layout/backend/footer.php';


/* End of file backend.php */
/* Location: ./views/mensa/backend.php */