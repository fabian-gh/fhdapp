<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

// activate output Buffer, needed for header-redirection 
ob_start();

// include layout
require_once '../../layout/backend/header.php';
// include controller
require_once '../../controllers/mensaController.php';
$MensaController = new MensaController();

// wenn Plan editieren gewählt wurde dann Plan der entsprechenden Woche laden
if(isset($_GET['category']) && $_GET['category'] == 'canteen'){
	if(isset($_GET['mode']) && $_GET['mode'] == 'edit'){
		$post = $MensaController->callEditPlan($_GET['cw']);
	}
} else{
	header("Location: choose.php");
}

?>
<!-- Mensa-CSS einbinden -->
<link href="../../sources/css/mensa.css" rel="stylesheet" type="text/css" media="screen" />
<!-- Javascript für Mensa einbinden -->
<script type="text/javascript" src="../../sources/customjs/mensa.js"></script>

<!-- Mensa-Formular einbinden -->
<form name="mensa" id="mensaform" method="post" action="">
	<table>
		<!-- Startdatumsfeld -->
		<tr><td>Startdatum:</td><td><input type="textfield" id="start_date" name="start_date" value="<?php echo (!empty($post['start_date'])) ? date("d.m.Y", strtotime($post['start_date'])) : ""; ?>" /><span id="date_error"></span></td></tr>
	</table>
	<table>
		<!-- Überschirften -->
		<tr>
			<th>&nbsp;</th>
			<th class="weekday">Montag</th>
			<th class="weekday">Dienstag</th>
			<th class="weekday">Mittwoch</th>
			<th class="weekday">Donnerstag</th>
			<th class="weekday">Freitag</th>
		</tr>
		<tr>
			<!-- Feiertage -->
			<td>&nbsp;</td>
			<td><input type="checkbox" id="mon_hol" name="mon_hol" <?php echo (isset($post['mon_holiday']) && $post['mon_holiday'] != null) ? "checked='checked'" : ""; ?> />&nbsp;Feiertag<br />
				<span class="hol_text mon_hol_text"><br />Bezeichnung:<br /></span><input type="textfield" class="hol_text mon_hol_text" id="mon_hol_name" name="mon_hol_name" value="<?php echo (isset($post['mon_holiday']) && $post['mon_holiday'] != null) ? $post['mon_holiday'] : ""; ?>" /></td>
			<td><input type="checkbox" id="tue_hol" name="tue_hol" <?php echo (isset($post['tue_holiday']) && $post['tue_holiday'] != null) ? "checked='checked'" : ""; ?> />&nbsp;Feiertag<br />
				<span class="hol_text tue_hol_text"><br />Bezeichnung:<br /></span><input type="textfield" class="hol_text tue_hol_text" id="tue_hol_name" name="tue_hol_name" value="<?php echo (isset($post['tue_holiday']) && $post['tue_holiday'] != null) ? $post['tue_holiday'] : ""; ?>" /></td>
			<td><input type="checkbox" id="wed_hol" name="wed_hol" <?php echo (isset($post['wed_holiday']) && $post['wed_holiday'] != null) ? "checked='checked'" : ""; ?> />&nbsp;Feiertag<br />
				<span class="hol_text wed_hol_text"><br />Bezeichnung:<br /></span><input type="textfield" class="hol_text wed_hol_text" id="wed_hol_name" name="wed_hol_name" value="<?php echo (isset($post['wed_holiday']) && $post['wed_holiday'] != null) ? $post['wed_holiday'] : ""; ?>" /></td>
			<td><input type="checkbox" id="thu_hol" name="thu_hol" <?php echo (isset($post['thu_holiday']) && $post['thu_holiday'] != null) ? "checked='checked'" : ""; ?> />&nbsp;Feiertag<br />
				<span class="hol_text thu_hol_text"><br />Bezeichnung:<br /></span><input type="textfield" class="hol_text thu_hol_text" id="thu_hol_name" name="thu_hol_name" value="<?php echo (isset($post['thu_holiday']) && $post['thu_holiday'] != null) ? $post['thu_holiday'] : ""; ?>" /></td>
			<td><input type="checkbox" id="fri_hol" name="fri_hol" <?php echo (isset($post['fri_holiday']) && $post['fri_holiday'] != null) ? "checked='checked'" : ""; ?> />&nbsp;Feiertag<br />
				<span class="hol_text fri_hol_text"><br />Bezeichnung:<br /></span><input type="textfield" class="hol_text fri_hol_text" id="fri_hol_name" name="fri_hol_name" value="<?php echo (isset($post['fri_holiday']) && $post['fri_holiday'] != null) ? $post['fri_holiday'] : ""; ?>" /></td>

		</tr>
		<!-- Mahlzeiten -->
		<tr id="meal_one">
			<td class="mealdescription">Essen 1</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_meal_one" tabindex="1"><?php echo (!empty($post['mon_meal_one'])) ? $post['mon_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_meal_one" tabindex="2"><?php echo (!empty($post['tue_meal_one'])) ? $post['tue_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_meal_one" tabindex="3"><?php echo (!empty($post['wed_meal_one'])) ? $post['wed_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_meal_one" tabindex="4"><?php echo (!empty($post['thu_meal_one'])) ? $post['thu_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_meal_one" tabindex="5"><?php echo (!empty($post['fri_meal_one'])) ? $post['fri_meal_one'] : ""; ?></textarea></td>
		</tr>
		<tr id="meal_two">
			<td class="mealdescription">Essen 2</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_meal_two" tabindex="6"><?php echo (!empty($post['mon_meal_two'])) ? $post['mon_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_meal_two" tabindex="7"><?php echo (!empty($post['tue_meal_two'])) ? $post['tue_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_meal_two" tabindex="8"><?php echo (!empty($post['wed_meal_two'])) ? $post['wed_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_meal_two" tabindex="9"><?php echo (!empty($post['thu_meal_two'])) ? $post['thu_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_meal_two" tabindex="10"><?php echo (!empty($post['fri_meal_two'])) ? $post['fri_meal_two'] : ""; ?></textarea></td>
		</tr>
		<tr id="side">
			<td class="mealdescription">Beilagen</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_side" tabindex="11"><?php echo (!empty($post['mon_side'])) ? $post['mon_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_side" tabindex="12"><?php echo (!empty($post['tue_side'])) ? $post['tue_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_side" tabindex="13"><?php echo (!empty($post['wed_side'])) ? $post['wed_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_side" tabindex="14"><?php echo (!empty($post['thu_side'])) ? $post['thu_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_side" tabindex="15"><?php echo (!empty($post['fri_side'])) ? $post['fri_side'] : ""; ?></textarea></td>
		</tr>
		<tr id="hotpot">
			<td class="mealdescription">Eint&ouml;pfe</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_hotpot" tabindex="16"><?php echo (!empty($post['mon_hotpot'])) ? $post['mon_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_hotpot" tabindex="17"><?php echo (!empty($post['tue_hotpot'])) ? $post['tue_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_hotpot" tabindex="18"><?php echo (!empty($post['wed_hotpot'])) ? $post['wed_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_hotpot" tabindex="19"><?php echo (!empty($post['thu_hotpot'])) ? $post['thu_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_hotpot" tabindex="20"><?php echo (!empty($post['fri_hotpot'])) ? $post['fri_hotpot'] : ""; ?></textarea></td>
		</tr>
		<tr id="bbq">
			<td class="mealdescription">Grill</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_bbq" tabindex="21"><?php echo (!empty($post['mon_bbq'])) ? $post['mon_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="26" maxlength="5" name="price_mon_bbq" value="<?php echo (empty($post['price_mon_bbq']) || $post['price_mon_bbq'] == '0.00') ? "" : $post['price_mon_bbq']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_bbq" tabindex="22"><?php echo (!empty($post['tue_bbq'])) ? $post['tue_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="27" maxlength="5" name="price_tue_bbq" value="<?php echo (empty($post['price_tue_bbq']) || $post['price_tue_bbq'] == '0.00') ? "" : $post['price_tue_bbq']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_bbq" tabindex="23"><?php echo (!empty($post['wed_bbq'])) ? $post['wed_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="28" maxlength="5" name="price_wed_bbq" value="<?php echo (empty($post['price_wed_bbq']) || $post['price_wed_bbq'] == '0.00') ? "" : $post['price_wed_bbq']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_bbq" tabindex="24"><?php echo (!empty($post['thu_bbq'])) ? $post['thu_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="29" maxlength="5" name="price_thu_bbq" value="<?php echo (empty($post['price_thu_bbq']) || $post['price_thu_bbq'] == '0.00') ? "" : $post['price_thu_bbq']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_bbq" tabindex="25"><?php echo (!empty($post['fri_bbq'])) ? $post['fri_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="30" maxlength="5" name="price_fri_bbq" value="<?php echo (empty($post['price_fri_bbq']) || $post['price_fri_bbq'] == '0.00') ? "" : $post['price_fri_bbq']; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="pan">
			<td class="mealdescription">Pfanne</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_pan" tabindex="31"><?php echo (!empty($post['mon_pan'])) ? $post['mon_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="36" maxlength="5" name="price_mon_pan" value="<?php echo (empty($post['price_mon_pan']) || $post['price_mon_pan'] == '0.00') ? "" : $post['price_mon_pan']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_pan" tabindex="32"><?php echo (!empty($post['tue_pan'])) ? $post['tue_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="37" maxlength="5" name="price_tue_pan" value="<?php echo (empty($post['price_tue_pan']) || $post['price_tue_pan'] == '0.00') ? "" : $post['price_tue_pan']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_pan" tabindex="33"><?php echo (!empty($post['wed_pan'])) ? $post['wed_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="38" maxlength="5" name="price_wed_pan" value="<?php echo (empty($post['price_wed_pan']) || $post['price_wed_pan'] == '0.00') ? "" : $post['price_wed_pan']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_pan" tabindex="34"><?php echo (!empty($post['thu_pan'])) ? $post['thu_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="39" maxlength="5" name="price_thu_pan" value="<?php echo (empty($post['price_thu_pan']) || $post['price_thu_pan'] == '0.00') ? "" : $post['price_thu_pan']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_pan" tabindex="35"><?php echo (!empty($post['fri_pan'])) ? $post['fri_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="40" maxlength="5" name="price_fri_pan" value="<?php echo (empty($post['price_fri_pan']) || $post['price_fri_pan'] == '0.00') ? "" : $post['price_fri_pan']; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="action">
			<td class="mealdescription">Aktionsstand</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_action" tabindex="41"><?php echo (!empty($post['mon_action'])) ? $post['mon_action'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="46" maxlength="5" name="price_mon_action" value="<?php echo (empty($post['price_mon_action']) || $post['price_mon_action'] == '0.00') ? "" : $post['price_mon_action']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_action" tabindex="42"><?php echo (!empty($post['tue_action'])) ? $post['tue_action'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="47" maxlength="5" name="price_tue_action" value="<?php echo (empty($post['price_tue_action']) || $post['price_tue_action'] == '0.00') ? "" : $post['price_tue_action']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_action" tabindex="43"><?php echo (!empty($post['wed_action'])) ? $post['wed_action'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="48" maxlength="5" name="price_wed_action" value="<?php echo (empty($post['price_wed_action']) || $post['price_wed_action'] == '0.00') ? "" : $post['price_wed_action']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_action" tabindex="44"><?php echo (!empty($post['thu_action'])) ? $post['thu_action'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="49" maxlength="5" name="price_thu_action" value="<?php echo (empty($post['price_thu_action']) || $post['price_thu_action'] == '0.00') ? "" : $post['price_thu_action']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_action" tabindex="45"><?php echo (!empty($post['fri_action'])) ? $post['fri_action'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="50" maxlength="5" name="price_fri_action" value="<?php echo (empty($post['price_fri_action']) || $post['price_fri_action'] == '0.00') ? "" : $post['price_fri_action']; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="wok">
			<td class="mealdescription">Wok</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_wok" tabindex="51"><?php echo (!empty($post['mon_wok'])) ? $post['mon_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="56" maxlength="5" name="price_mon_wok" value="<?php echo (empty($post['price_mon_wok']) || $post['price_mon_wok'] == '0.00') ? "" : $post['price_mon_wok']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_wok" tabindex="52"><?php echo (!empty($post['tue_wok'])) ? $post['tue_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="57" maxlength="5" name="price_tue_wok" value="<?php echo (empty($post['price_tue_wok']) || $post['price_tue_wok'] == '0.00') ? "" : $post['price_tue_wok']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_wok" tabindex="53"><?php echo (!empty($post['wed_wok'])) ? $post['wed_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="58" maxlength="5" name="price_wed_wok" value="<?php echo (empty($post['price_wed_wok']) || $post['price_wed_wok'] == '0.00') ? "" : $post['price_wed_wok']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_wok" tabindex="54"><?php echo (!empty($post['thu_wok'])) ? $post['thu_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="59" maxlength="5" name="price_thu_wok" value="<?php echo (empty($post['price_thu_wok']) || $post['price_thu_wok'] == '0.00') ? "" : $post['price_thu_wok']; ?>" /> €</td></tr>					
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_wok" tabindex="55"><?php echo (!empty($post['fri_wok'])) ? $post['fri_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="60" maxlength="5" name="price_fri_wok" value="<?php echo (empty($post['price_fri_wok']) || $post['price_fri_wok'] == '0.00') ? "" : $post['price_fri_wok']; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="gratin">
			<td class="mealdescription">Gratin</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_gratin" tabindex="61"><?php echo (!empty($post['mon_gratin'])) ? $post['mon_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="66" maxlength="5" name="price_mon_gratin" value="<?php echo (empty($post['price_mon_gratin']) || $post['price_mon_gratin'] == '0.00') ? "" : $post['price_mon_gratin']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_gratin" tabindex="62"><?php echo (!empty($post['tue_gratin'])) ? $post['tue_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="67" maxlength="5" name="price_tue_gratin" value="<?php echo (empty($post['price_tue_gratin']) || $post['price_tue_gratin'] == '0.00') ? "" : $post['price_tue_gratin']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_gratin" tabindex="63"><?php echo (!empty($post['wed_gratin'])) ? $post['wed_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="68" maxlength="5" name="price_wed_gratin" value="<?php echo (empty($post['price_wed_gratin']) || $post['price_wed_gratin'] == '0.00') ? "" : $post['price_wed_gratin']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_gratin" tabindex="64"><?php echo (!empty($post['thu_gratin'])) ? $post['thu_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="69" maxlength="5" name="price_thu_gratin" value="<?php echo (empty($post['price_thu_gratin']) || $post['price_thu_gratin'] == '0.00') ? "" : $post['price_thu_gratin']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_gratin" tabindex="65"><?php echo (!empty($post['fri_gratin'])) ? $post['fri_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="70" maxlength="5" name="price_fri_gratin" value="<?php echo (empty($post['price_fri_gratin']) || $post['price_fri_gratin'] == '0.00') ? "" : $post['price_fri_gratin']; ?>"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="mensavital">
			<td class="mealdescription">mensa vital</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_mensavital" tabindex="71"><?php echo (!empty($post['mon_mensavital'])) ? $post['mon_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="76" maxlength="5" name="price_mon_mensavital" value="<?php echo (empty($post['price_mon_mensavital']) || $post['price_mon_mensavital'] == '0.00') ? "" : $post['price_mon_mensavital']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_mensavital" tabindex="72"><?php echo (!empty($post['tue_mensavital'])) ? $post['tue_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="77" maxlength="5" name="price_tue_mensavital" value="<?php echo (empty($post['price_tue_mensavital']) || $post['price_tue_mensavital'] == '0.00') ? "" : $post['price_tue_mensavital']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_mensavital" tabindex="73"><?php echo (!empty($post['wed_mensavital'])) ? $post['wed_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="78" maxlength="5" name="price_wed_mensavital" value="<?php echo (empty($post['price_wed_mensavital']) || $post['price_wed_mensavital'] == '0.00') ? "" : $post['price_wed_mensavital']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_mensavital" tabindex="74"><?php echo (!empty($post['thu_mensavital'])) ? $post['thu_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="79" maxlength="5" name="price_thu_mensavital" value="<?php echo (empty($post['price_thu_mensavital']) || $post['price_thu_mensavital'] == '0.00') ? "" : $post['price_thu_mensavital']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_mensavital" tabindex="75"><?php echo (!empty($post['fri_mensavital'])) ? $post['fri_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="80" maxlength="5" name="price_fri_mensavital" value="<?php echo (empty($post['price_fri_mensavital']) || $post['price_fri_mensavital'] == '0.00') ? "" : $post['price_fri_mensavital']; ?>" /> €</td></tr>					
				</table></td>
		</tr>
		<tr id="green_corner">
			<td class="mealdescription">Green Corner</td>
			<td><textarea rows="3" cols="20" class="mealinput mon_col" name="mon_green_corner" tabindex="81"><?php echo (!empty($post['mon_green_corner'])) ? $post['mon_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price mon_col" size="5" tabindex="86" maxlength="5" name="price_mon_green_corner" value="<?php echo (empty($post['price_mon_green_corner']) || $post['price_mon_green_corner'] == '0.00') ? "" : $post['price_mon_green_corner']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput tue_col" name="tue_green_corner" tabindex="82"><?php echo (!empty($post['tue_green_corner'])) ? $post['tue_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price tue_col" size="5" tabindex="87" maxlength="5" name="price_tue_green_corner" value="<?php echo (empty($post['price_tue_green_corner']) || $post['price_tue_green_corner'] == '0.00') ? "" : $post['price_tue_green_corner']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput wed_col" name="wed_green_corner" tabindex="83"><?php echo (!empty($post['wed_green_corner'])) ? $post['wed_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price wed_col" size="5" tabindex="88" maxlength="5" name="price_wed_green_corner" value="<?php echo (empty($post['price_wed_green_corner']) || $post['price_wed_green_corner'] == '0.00') ? "" : $post['price_wed_green_corner']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput thu_col" name="thu_green_corner" tabindex="84"><?php echo (!empty($post['thu_green_corner'])) ? $post['thu_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price thu_col" size="5" tabindex="89" maxlength="5" name="price_thu_green_corner" value="<?php echo (empty($post['price_thu_green_corner']) || $post['price_thu_green_corner'] == '0.00') ? "" : $post['price_thu_green_corner']; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput fri_col" name="fri_green_corner" tabindex="85"><?php echo (!empty($post['fri_green_corner'])) ? $post['fri_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Preis: </td><td><input type="textfield" class="price fri_col" size="5" tabindex="90" maxlength="5" name="price_fri_green_corner" value="<?php echo (empty($post['price_fri_green_corner']) || $post['price_fri_green_corner'] == '0.00') ? "" : $post['price_fri_green_corner']; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr><td><input type="submit" id="mensasubmit" name="speichern" value="Speichern"/></td></tr>
	</table>
</form>

<?php
	require_once '../../layout/backend/footer.php';


// Überprüfung ob Formular abgeschickt
if(isset($_POST['speichern'])){
	unset($post);
	$MensaController->callProceedPost($_POST);
	$MensaController->callInsertPlan($_GET);

	unset($_POST);
	unset($_GET);
	header("Location: choose.php");

	// Close the output buffer
	ob_end_flush();
}

/* End of file edit.php */
/* Location: ./views/mensa/edit.php */