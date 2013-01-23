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
    			<th>Essen 1</th>
    			<td><?php echo $day['meal_one']; ?></td>
    			<td>Stud.: 1,00€<br />Bed.: 2,60€</td>
    		</tr>
            <tr class="both">
                <th>Essen 2</th>
                <td><?php echo $day['meal_two']; ?></td>
                <td>Stud.: 1,00€<br />Bed.: 2,60€</td>
            </tr>
            <tr class="both">
                <th>Beilagen</th>
                <td><?php echo $day['side']; ?></td>
                <td>Stud.: 0,40€ - 0,60€</td>
            </tr>
            <tr class="both">
                <th>Eintopf</th>
                <td><?php echo $day['hotpot']; ?></td>
                <td>Stud.: 1,10€<br />Bed.: 1,20€</td>
            </tr>
            <tr class="south">
                <th>Grill</th>
                <td><?php echo $day['bbq']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_bbq']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_bbq']; ?>€</td>
            </tr>
            <tr class="south">
                <th>Pfanne</th>
                <td><?php echo $day['pan']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_pan']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_pan']; ?>€</td>
            </tr>
            <tr class="south">
                <th>Aktion</th>
                <td><?php echo $day['action']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_action']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_action']; ?>€</td>
            </tr>
            <tr class="south">
                <th>Wok</th>
                <td><?php echo $day['bbq']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_wok']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_wok']; ?>€</td>
            </tr>
            <tr class="south">
                <th>Gratin</th>
                <td><?php echo $day['gratin']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_gratin']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_gratin']; ?>€</td>
            </tr>
            <tr class="south">
                <th>mensavital</th>
                <td><?php echo $day['mensavital']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_mensavital']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_mensavital']; ?>€</td>
            </tr>
            <tr class="south">
                <th>Green Corner</th>
                <td><?php echo $day['green_corner']; ?></td>
                <td>Stud.:&nbsp;<?php echo $day['price_stud_green_corner']; ?>€<br />Bed.:&nbsp;<?php echo $day['price_att_green_corner']; ?>€</td>
            </tr>
		</table>
    </div> <!-- Ende collapsible -->
 <?php endforeach; ?>
</div> <!-- Ende collapsible-set -->
<br />

<?php endforeach; endif;?>