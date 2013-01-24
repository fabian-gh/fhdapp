<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

?>
<link href="sources/css/mensa.css" rel="stylesheet" type="text/css" media="screen" />
<script src="sources/customjs/mensa.js" type="text/javascript"></script>

<?php

    require_once 'controllers/mensaController.php';
    $MensaController = new MensaController();
    $plans = $MensaController->callGetCanteenPlans();
    $additives = $MensaController->callGetAdditives();
    $openHours = $MensaController->callGetOpeningHours();

?>

<!-- ToggleSwitch-->
<div data-role="fieldcontain">
<label for="flip-2"><h4>Campus:</h4></label>
    <select name="flip-2" id="flip-2" data-role="slider" data-theme="a">
        <option value="north">Nord</option>
        <option value="south">S&uuml;d</option>
    </select> 
</div>
<br />

<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >
    <div data-role='collapsible' data-collapsed='true'>
        <h3>Öffnungszeiten</h3>
        <?php if(!empty($openHours)): ?>
        <table class="openHours">
            <tr><th class="openHours">Mensa</th><th class="openHours">während des Semester</th><th>in den Semesterferien</th></tr>
            <?php foreach($openHours as $open): ?>
                <tr><td class="openHours canteen"><?php echo utf8_encode($open['name']); ?></td><td><?php echo utf8_encode($open['hoursDuring']); ?></td></td><td><?php echo utf8_encode($open['hoursOutOf']); ?></td></tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<br />

<?php

if(!empty($plans)):

foreach($plans as $plankey => $planvalue):  ?>

<h4>KW <?php echo $plankey<10? "0".$plankey.":" : $plankey.":"; ?> <?php echo date("d.m.", strtotime($planvalue[1]['mealdate'])).' - '.date("d.m.Y", strtotime($planvalue[5]['mealdate'])); ?></h4>
<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >

    <?php foreach($planvalue as $day): ?>
	<div data-role='collapsible' data-collapsed='true'>
    	<h3><?php echo $day['dayname']; ?></h3>
        <table class="meals" width='100%'>
    		<tr class="both">
    			<td><span class="heading">Essen 1:</span><br /><?php echo $day['meal_one']; ?></td>
    			<td>1,00€</td>
    		</tr>
            <tr class="both">
                <td><span class="heading">Essen 2:</span><br /><?php echo $day['meal_two']; ?></td>
                <td>1,00€</td>
            </tr>
            <tr class="both">
                <td><span class="heading">Beilagen:</span><br /><?php echo $day['side']; ?></td>
                <td>0,40€ - 0,60€</td>
            </tr>
            <tr class="both">
                <td><span class="heading">Eintopf:</span><br /><?php echo $day['hotpot']; ?></td>
                <td>1,10€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Grill:</span><br /><?php echo $day['bbq']; ?></td>
                <td><?php echo $day['price_bbq']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Pfanne:</span><br /><?php echo $day['pan']; ?></td>
                <td><?php echo $day['price_pan']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Aktion:</span><br /><?php echo $day['action']; ?></td>
                <td><?php echo $day['price_action']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Wok:</span><br /><?php echo $day['wok']; ?></td>
                <td><?php echo $day['price_wok']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Gratin:</span><br /><?php echo $day['gratin']; ?></td>
                <td><?php echo $day['price_gratin']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">mensavital:</span><br /><?php echo $day['mensavital']; ?></td>
                <td><?php echo $day['price_mensavital']; ?>€</td>
            </tr>
            <tr class="south">
                <td><span class="heading">Green Corner:</span><br /><?php echo $day['green_corner']; ?></td>
                <td><?php echo $day['price_green_corner']; ?>€</td>
            </tr>
		</table>
    </div> <!-- Ende collapsible -->
 <?php endforeach; ?>
</div> <!-- Ende collapsible-set -->
<br />

<?php endforeach; endif;?>

<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >
    <div data-role='collapsible' data-collapsed='true'>
        <h3>Zeichenerklärung</h3>
        <table class="abbreviations">
            <tr><th class="abbreviations">Zeichen</th><th class="abbreviations">Beschreibung</th></tr>
            <?php if(!empty($additives)):
                    foreach($additives as $add): ?>

                <tr><td class="abbreviations"><?php echo $add['abbreviation']; ?></td><td class="abbreviations"><?php echo utf8_encode($add['name']); ?></td></tr>

            <?php endforeach; endif; ?>
        </table>
    </div>
</div>