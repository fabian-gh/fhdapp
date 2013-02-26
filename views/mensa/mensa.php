<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Tobias Emde (TE), <tobias.emde@gmx.de>
 */

?>
<link href="sources/css/mensa.css" rel="stylesheet" type="text/css" media="screen" />
<script src="sources/customjs/mensa.js" type="text/javascript"></script>

<?php
    // Controller einbinden und erstellen
    require_once 'controllers/mensaController.php';
    $MensaController = new MensaController();
    // Pläne, Öffnungszeiten und Zusatzstoffe abfragen
    $plans = $MensaController->callGetCanteenPlans();
    $additives = $MensaController->callGetAdditives();
    $openHours = $MensaController->callGetOpeningHours();
	
	echo "<h1>Mensa</h1>";

?>

<!-- Horizontal Radio Button Group -->
<div data-role="fieldcontain">
    <fieldset data-role="controlgroup" data-type="horizontal">
        <h3>Campus w&auml;hlen:</h3>
            <input type="radio" name="radio-canteen" id="radio-north" value="1" checked="checked" />
            <label for="radio-north">Nord</label>

            <input type="radio" name="radio-canteen" id="radio-south" value="2" />
            <label for="radio-south">S&uuml;d</label>
    </fieldset>
</div>
<br />

<!-- Collapsible Öffnungszeiten -->
<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >
    <div data-role='collapsible' data-collapsed='true'>
        <h3>Öffnungszeiten</h3>
        <?php if(!empty($openHours)): ?>
        <table class="openHours">
            <tr><th class="openHours">Semester</th><th class="openHours">Vorlesungsfrei</th></tr>
            <?php foreach($openHours as $open): ?>
                <tr>
					<td><?php echo '<b>'.utf8_encode($open['name']).':</b><br />'.utf8_encode($open['hoursDuring']); ?></td>
					<td class="openHours canteen"><?php echo '<b>'.utf8_encode($open['name']).':</b><br />'.utf8_encode($open['hoursOutOf']); ?></td>
				</tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<br />

<?php

// Plan einer Woche
if(!empty($plans)):

foreach($plans as $plankey => $planvalue):  ?>

<h4>KW <?php echo $plankey<10? "0".$plankey.":" : $plankey.":"; ?> <?php echo date("d.m.", strtotime($planvalue[1]['mealdate'])).' - '.date("d.m.Y", strtotime($planvalue[5]['mealdate'])); ?></h4>
<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >

    <?php foreach($planvalue as $day): ?>
    <div data-role='collapsible' data-collapsed='true'>
        <h3><?php echo $day['dayname']; ?></h3>

        <?php if($day['holiday'] != null) echo $day['holiday']; ?>

        <?php if($day['holiday'] == null): ?>

        <table class="meals" width='100%'>
            <?php if(!empty($day['meal_one'])): ?>
            <tr class="both">
                <td><span class="heading">Essen 1:</span><br /><?php echo $day['meal_one']; ?></td>
                <td>1.00€</td>
            </tr>
            <?php endif; if(!empty($day['meal_two'])): ?>
            <tr class="both">
                <td><span class="heading">Essen 2:</span><br /><?php echo $day['meal_two']; ?></td>
                <td>1.20€</td>
            </tr>
            <?php endif; if(!empty($day['side'])): ?>
            <tr class="both">
                <td><span class="heading">Beilagen:</span><br /><?php echo $day['side']; ?></td>
                <td>0.40€ - 0.60€</td>
            </tr>
            <?php endif; if(!empty($day['hotpot'])): ?>
            <tr class="both">
                <td><span class="heading">Eintopf:</span><br /><?php echo $day['hotpot']; ?></td>
                <td>1.10€</td>
            </tr>
            <?php endif; if(!empty($day['bbq'])): ?>
            <tr class="south">
                <td><span class="heading">Grill:</span><br /><?php echo $day['bbq']; ?></td>
                <td><?php echo $day['price_bbq']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['pan'])): ?>
            <tr class="south">
                <td><span class="heading">Pfanne:</span><br /><?php echo $day['pan']; ?></td>
                <td><?php echo $day['price_pan']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['action'])): ?>
            <tr class="south">
                <td><span class="heading">Aktion:</span><br /><?php echo $day['action']; ?></td>
                <td><?php echo $day['price_action']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['wok'])): ?>
            <tr class="south">
                <td><span class="heading">Wok:</span><br /><?php echo $day['wok']; ?></td>
                <td><?php echo $day['price_wok']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['gratin'])): ?>
            <tr class="south">
                <td><span class="heading">Gratin:</span><br /><?php echo $day['gratin']; ?></td>
                <td><?php echo $day['price_gratin']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['mensavital'])): ?>
            <tr class="south">
                <td><span class="heading">mensavital:</span><br /><?php echo $day['mensavital']; ?></td>
                <td><?php echo $day['price_mensavital']; ?>€</td>
            </tr>
            <?php endif; if(!empty($day['green_corner'])): ?>
            <tr class="south">
                <td><span class="heading">Green Corner:</span><br /><?php echo $day['green_corner']; ?></td>
                <td><?php echo $day['price_green_corner']; ?>€</td>
            </tr>
            <?php endif;?>
        </table>
    <?php  endif; ?>
    </div> <!-- Ende collapsible -->
 <?php endforeach; ?>
</div> <!-- Ende collapsible-set -->
<br />

<?php endforeach; endif;?>

<!-- Collapsible Zusatzstoffe -->
<div data-role='collapsible-set' data-iconpos="right" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" data-theme="a" >
    <div data-role='collapsible' data-collapsed='true'>
        <h3>Zeichenerklärung</h3>
        <table id="abb" class="abbreviations">
            <tr><th class="abbreviations">Zeichen</th><th class="abbreviations">Beschreibung</th></tr>
            <?php if(!empty($additives)):
                    foreach($additives as $add): ?>
						<tr>
							<td class="abbreviations"><?php echo $add['abbreviation']; ?></td>
							<td class="abbreviations"><?php echo utf8_encode($add['name']); ?></td>
						</tr>
            <?php endforeach; endif; ?>
        </table>
    </div>
</div>