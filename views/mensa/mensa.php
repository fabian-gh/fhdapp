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
require_once '../../layout/frontend/header.php';
?>
<link href="../../sources/css/mensa.css" rel="stylesheet" type="text/css" media="screen" />
<?php

require_once '../../controllers/mensaController.php';
$MensaController = new MensaController();
$plans = $MensaController->callGetCanteenPlans();

?>

<?php  foreach($plans as $plankey => $planvalue): ?>

<h1>KW <?php echo $plankey<10? "0".$plankey.":" : $plankey.":"; ?></h1>
<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >
	<div data-role='collapsible' data-collapsed='false'>
    	<h3>Montag</h3>
        <table width='90%'>
    		<tr>
    			<th>Essen 1</th>
    			<td>Hähnchenbrust, natur<br />andalusische Sauce</td>
    			<td>Stud.: 1,00€<br />Bed.: 2,60€</td>
    		</tr>
    		<tr>
    			<th>Essen 2</th>
    			<td>Vollkornspaghetti (V) Tomatenmus </td>
    			<td>Stud.: 1,00€<br />Bed.: 2,50€</td>
    		</tr>
    		<tr>
    			<th>Beilagen</th>
    			<td>Sättigungsbeilagen<br />Gemüsebeilagen<br />Salatbeilagen </td>
    			<td>Stud.: 1,00€<br />Bed.: 2,60€</td>
    		</tr>
		</table>
    </div> <!-- Ende collapsible -->
    <div data-role='collapsible' data-collapsed='true'>
    	<h3>Dienstag</h3>
        <table width='90%'>
		</table>
    </div> <!-- Ende collapsible -->
</div> <!-- Ende collapsible-set -->

<?php endforeach; ?>


<?php
require_once '../../layout/frontend/footer.php';
?>