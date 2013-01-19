<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

// include layout
require_once '../../layout/backend/header.php';

require_once '../../controllers/mensaController.php';
$MensaController = new MensaController();

$plans = $MensaController->callGetAllPlans();

?>

<link href="../../sources/css/mensa.css" rel="stylesheet" type="text/css" media="screen" />

       	  <h2>Mensapl&auml;ne</h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th>Kalenderwoche</th>
                <th>Startdatum</th>
                <th>Enddatum</th>
                <th>Optionen</th>
              </tr>

              <?php foreach($plans as $plan): ?>

              <tr>
                <td><?php echo $plan['calenderweek']<10? "0".$plan['calenderweek'] : $plan['calenderweek']; ?></td>
                <td><?php echo date("d.m.Y", strtotime($plan['start_date'])); ?></td>
                <td><?php echo date("d.m.Y", strtotime($plan['start_date'])+345600); ?></td>
                <td><a class="button" href="edit.php?category=canteen&mode=edit&cw=<?php echo $plan['calenderweek']; ?>">bearbeiten</a> <a class="button" href="choose.php?category=canteen&mode=delete&cw=<?php echo $plan['calenderweek']; ?>"  onclick="return confirm('Plan der Kalenderwoche <?php echo $plan['calenderweek']; ?> wird gelöscht.')">löschen</a></td>
              </tr>

            <?php endforeach; ?>

            </table>
            <p><a class="button" href="edit.php?category=canteen&mode=add">neue Woche hinzufügen</a></p>


<?php
    require_once '../../layout/backend/footer.php';

    if(isset($_GET['category']) && $_GET['category'] == 'canteen'){
      if(isset($_GET['mode']) && $_GET['mode'] == 'delete'){
        $MensaController->callDeletePlan($_GET['cw']);
        header("Location: choose.php");
      }
    }


/* End of file choose.php */
/* Location: ./views/mensa/choose.php */