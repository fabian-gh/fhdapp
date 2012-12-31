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

require_once '../../controllers/mensaController.php';
$MensaController = new MensaController();

if(isset($_GET['category']) && $_GET['category'] == 'canteen'){
	if(isset($_GET['mode']) && $_GET['mode'] == 'edit'){
		$post = $MensaController->callEditPlan($_GET['cw']);
	}
}

?>

<script type="text/javascript" src="../../sources/customjs/mensa.js"></script>

<form name="mensa" id="mensaform" method="post" action="">
	<table>
		<tr><td>Kalenderwoche:</td><td><input type="textfield" id="calenderweek" name="calenderweek" value="<?php echo (!empty($post['calenderweek'])) ? $post['calenderweek'] : ""; ?>" /><span id="cw_error"></span></td></tr>
		<tr><td>Startdatum:</td><td><input type="textfield" id="start_date" name="start_date" value="<?php echo (!empty($post['start_date'])) ? date("d.m.Y", strtotime($post['start_date'])) : ""; ?>" /><span id="date_error"></span></td></tr>
	</table>
	<table>
		<tr>
			<th>&nbsp;</th>
			<th class="weekday">Montag</th>
			<th class="weekday">Dienstag</th>
			<th class="weekday">Mittwoch</th>
			<th class="weekday">Donnerstag</th>
			<th class="weekday">Freitag</th>
		</tr>
		<tr id="meal_one">
			<td class="mealdescription">Essen 1</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_meal_one" ><?php echo (!empty($post['mon_meal_one'])) ? $post['mon_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_meal_one" ><?php echo (!empty($post['tue_meal_one'])) ? $post['tue_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_meal_one" ><?php echo (!empty($post['wed_meal_one'])) ? $post['wed_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_meal_one" ><?php echo (!empty($post['thu_meal_one'])) ? $post['thu_meal_one'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_meal_one" ><?php echo (!empty($post['fri_meal_one'])) ? $post['fri_meal_one'] : ""; ?></textarea></td>
		</tr>
		<tr id="meal_two">
			<td class="mealdescription">Essen 2</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_meal_two" ><?php echo (!empty($post['mon_meal_two'])) ? $post['mon_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_meal_two" ><?php echo (!empty($post['tue_meal_two'])) ? $post['tue_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_meal_two" ><?php echo (!empty($post['wed_meal_two'])) ? $post['wed_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_meal_two" ><?php echo (!empty($post['thu_meal_two'])) ? $post['thu_meal_two'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_meal_two" ><?php echo (!empty($post['fri_meal_two'])) ? $post['fri_meal_two'] : ""; ?></textarea></td>
		</tr>
		<tr id="side">
			<td class="mealdescription">Beilagen</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_side" ><?php echo (!empty($post['mon_side'])) ? $post['mon_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_side" ><?php echo (!empty($post['tue_side'])) ? $post['tue_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_side" ><?php echo (!empty($post['wed_side'])) ? $post['wed_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_side" ><?php echo (!empty($post['thu_side'])) ? $post['thu_side'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_side" ><?php echo (!empty($post['fri_side'])) ? $post['fri_side'] : ""; ?></textarea></td>
		</tr>
		<tr id="hotpot">
			<td class="mealdescription">Eint&ouml;pfe</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_hotpot" ><?php echo (!empty($post['mon_hotpot'])) ? $post['mon_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_hotpot" ><?php echo (!empty($post['tue_hotpot'])) ? $post['tue_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_hotpot" ><?php echo (!empty($post['wed_hotpot'])) ? $post['wed_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_hotpot" ><?php echo (!empty($post['thu_hotpot'])) ? $post['thu_hotpot'] : ""; ?></textarea></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_hotpot" ><?php echo (!empty($post['fri_hotpot'])) ? $post['fri_hotpot'] : ""; ?></textarea></td>
		</tr>
		<tr id="bbq">
			<td class="mealdescription">Grill</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_bbq" ><?php echo (!empty($post['mon_bbq'])) ? $post['mon_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_bbq" value="<?php echo (!empty($post['price_stud_mon_bbq'])) ? $post['price_stud_mon_bbq'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_bbq" value="<?php echo (!empty($post['price_att_mon_bbq'])) ? $post['price_att_mon_bbq'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_bbq" ><?php echo (!empty($post['tue_bbq'])) ? $post['tue_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_bbq" value="<?php echo (!empty($post['price_stud_tue_bbq'])) ? $post['price_stud_tue_bbq'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_bbq" value="<?php echo (!empty($post['price_att_tue_bbq'])) ? $post['price_att_tue_bbq'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_bbq" ><?php echo (!empty($post['wed_bbq'])) ? $post['wed_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_bbq" value="<?php echo (!empty($post['price_stud_wed_bbq'])) ? $post['price_stud_wed_bbq'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_bbq" value="<?php echo (!empty($post['price_att_wed_bbq'])) ? $post['price_att_wed_bbq'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_bbq" ><?php echo (!empty($post['thu_bbq'])) ? $post['thu_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_bbq" value="<?php echo (!empty($post['price_stud_thu_bbq'])) ? $post['price_stud_thu_bbq'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_bbq" value="<?php echo (!empty($post['price_att_thu_bbq'])) ? $post['price_att_thu_bbq'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_bbq" ><?php echo (!empty($post['fri_bbq'])) ? $post['fri_bbq'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_bbq" value="<?php echo (!empty($post['price_stud_fri_bbq'])) ? $post['price_stud_fri_bbq'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_bbq" value="<?php echo (!empty($post['price_att_fri_bbq'])) ? $post['price_att_fri_bbq'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="pan">
			<td class="mealdescription">Pfanne</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_pan" ><?php echo (!empty($post['mon_pan'])) ? $post['mon_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_pan" value="<?php echo (!empty($post['price_stud_mon_pan'])) ? $post['price_stud_mon_pan'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_pan" value="<?php echo (!empty($post['price_att_mon_pan'])) ? $post['price_att_mon_pan'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_pan" ><?php echo (!empty($post['tue_pan'])) ? $post['tue_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_pan" value="<?php echo (!empty($post['price_stud_tue_pan'])) ? $post['price_stud_tue_pan'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_pan" value="<?php echo (!empty($post['price_att_tue_pan'])) ? $post['price_att_tue_pan'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_pan" ><?php echo (!empty($post['wed_pan'])) ? $post['wed_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_pan" value="<?php echo (!empty($post['price_stud_wed_pan'])) ? $post['price_stud_wed_pan'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_pan" value="<?php echo (!empty($post['price_att_wed_pan'])) ? $post['price_att_wed_pan'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_pan" ><?php echo (!empty($post['thu_pan'])) ? $post['thu_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_pan" value="<?php echo (!empty($post['price_stud_thu_pan'])) ? $post['price_stud_thu_pan'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_pan" value="<?php echo (!empty($post['price_att_thu_pan'])) ? $post['price_att_thu_pan'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_pan" ><?php echo (!empty($post['fri_pan'])) ? $post['fri_pan'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_pan" value="<?php echo (!empty($post['price_stud_fri_pan'])) ? $post['price_stud_fri_pan'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_pan" value="<?php echo (!empty($post['price_att_fri_pan'])) ? $post['price_att_fri_pan'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="action">
			<td class="mealdescription">Aktionsstand</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_action" ><?php echo (!empty($post['mon_action'])) ? $post['mon_action'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_action" value="<?php echo (!empty($post['price_stud_mon_action'])) ? $post['price_stud_mon_action'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_action" value="<?php echo (!empty($post['price_att_mon_action'])) ? $post['price_att_mon_action'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_action" ><?php echo (!empty($post['tue_action'])) ? $post['tue_action'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_action" value="<?php echo (!empty($post['price_stud_tue_action'])) ? $post['price_stud_tue_action'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_action" value="<?php echo (!empty($post['price_att_tue_action'])) ? $post['price_att_tue_action'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_action" ><?php echo (!empty($post['wed_action'])) ? $post['wed_action'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_action" value="<?php echo (!empty($post['price_stud_wed_action'])) ? $post['price_stud_wed_action'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_action" value="<?php echo (!empty($post['price_att_wed_action'])) ? $post['price_att_wed_action'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_action" ><?php echo (!empty($post['thu_action'])) ? $post['thu_action'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_action" value="<?php echo (!empty($post['price_stud_thu_action'])) ? $post['price_stud_thu_action'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_action" value="<?php echo (!empty($post['price_att_thu_action'])) ? $post['price_att_thu_action'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_action" ><?php echo (!empty($post['fri_action'])) ? $post['fri_action'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_action" value="<?php echo (!empty($post['price_stud_fri_action'])) ? $post['price_stud_fri_action'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_action" value="<?php echo (!empty($post['price_att_fri_action'])) ? $post['price_att_fri_action'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="wok">
			<td class="mealdescription">Wok</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_wok" ><?php echo (!empty($post['mon_wok'])) ? $post['mon_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_wok" value="<?php echo (!empty($post['price_stud_mon_wok'])) ? $post['price_stud_mon_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_wok" value="<?php echo (!empty($post['price_att_mon_wok'])) ? $post['price_att_mon_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_wok" ><?php echo (!empty($post['tue_wok'])) ? $post['tue_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_wok" value="<?php echo (!empty($post['price_stud_tue_wok'])) ? $post['price_stud_tue_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_wok" value="<?php echo (!empty($post['price_att_tue_wok'])) ? $post['price_att_tue_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_wok" ><?php echo (!empty($post['wed_wok'])) ? $post['wed_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_wok" value="<?php echo (!empty($post['price_stud_wed_wok'])) ? $post['price_stud_wed_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_wok" value="<?php echo (!empty($post['price_att_wed_wok'])) ? $post['price_att_wed_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_wok" ><?php echo (!empty($post['thu_wok'])) ? $post['thu_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_wok" value="<?php echo (!empty($post['price_stud_thu_wok'])) ? $post['price_stud_thu_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_wok" value="<?php echo (!empty($post['price_att_thu_wok'])) ? $post['price_att_thu_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_wok" ><?php echo (!empty($post['fri_wok'])) ? $post['fri_wok'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_wok" value="<?php echo (!empty($post['price_stud_fri_wok'])) ? $post['price_stud_fri_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_wok" value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="gratin">
			<td class="mealdescription">Gratin</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_gratin" ><?php echo (!empty($post['mon_gratin'])) ? $post['mon_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_gratin" value="<?php echo (!empty($post['price_stud_mon_gratin'])) ? $post['price_stud_mon_gratin'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_gratin" value="<?php echo (!empty($post['price_att_mon_gratin'])) ? $post['price_att_mon_gratin'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_gratin" ><?php echo (!empty($post['tue_gratin'])) ? $post['tue_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_gratin" value="<?php echo (!empty($post['price_stud_tue_gratin'])) ? $post['price_stud_tue_gratin'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_gratin" value="<?php echo (!empty($post['price_att_tue_gratin'])) ? $post['price_att_tue_gratin'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_gratin" ><?php echo (!empty($post['wed_gratin'])) ? $post['wed_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_gratin" value="<?php echo (!empty($post['price_stud_wed_gratin'])) ? $post['price_stud_wed_gratin'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_gratin" value="<?php echo (!empty($post['price_att_wed_gratin'])) ? $post['price_att_wed_gratin'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_gratin" ><?php echo (!empty($post['thu_gratin'])) ? $post['thu_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_gratin" value="<?php echo (!empty($post['price_stud_thu_gratin'])) ? $post['price_stud_thu_gratin'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_gratin" value="<?php echo (!empty($post['price_att_thu_gratin'])) ? $post['price_att_thu_gratin'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_gratin" ><?php echo (!empty($post['fri_gratin'])) ? $post['fri_gratin'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_gratin" value="<?php echo (!empty($post['price_stud_fri_gratin'])) ? $post['price_stud_fri_gratin'] : ""; ?>"  value="<?php echo (!empty($post['price_att_fri_wok'])) ? $post['price_att_fri_wok'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_gratin" value="<?php echo (!empty($post['price_att_fri_gratin'])) ? $post['price_att_fri_gratin'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="mensavital">
			<td class="mealdescription">mensa vital</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_mensavital" ><?php echo (!empty($post['mon_mensavital'])) ? $post['mon_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_mensavital" value="<?php echo (!empty($post['price_stud_mon_mensavital'])) ? $post['price_stud_mon_mensavital'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_mensavital"  value="<?php echo (!empty($post['price_att_mon_mensavital'])) ? $post['price_att_mon_mensavital'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_mensavital" ><?php echo (!empty($post['tue_mensavital'])) ? $post['tue_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_mensavital" value="<?php echo (!empty($post['price_stud_tue_mensavital'])) ? $post['price_stud_tue_mensavital'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_mensavital" value="<?php echo (!empty($post['price_att_tue_mensavital'])) ? $post['price_att_tue_mensavital'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_mensavital" ><?php echo (!empty($post['wed_mensavital'])) ? $post['wed_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_mensavital" value="<?php echo (!empty($post['price_stud_wed_mensavital'])) ? $post['price_stud_wed_mensavital'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_mensavital" value="<?php echo (!empty($post['price_att_wed_mensavital'])) ? $post['price_att_wed_mensavital'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_mensavital" ><?php echo (!empty($post['thu_mensavital'])) ? $post['thu_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_mensavital" value="<?php echo (!empty($post['price_stud_thu_mensavital'])) ? $post['price_stud_thu_mensavital'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_mensavital" value="<?php echo (!empty($post['price_att_thu_mensavital'])) ? $post['price_att_thu_mensavital'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_mensavital" ><?php echo (!empty($post['fri_mensavital'])) ? $post['fri_mensavital'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_mensavital" value="<?php echo (!empty($post['price_stud_fri_mensavital'])) ? $post['price_stud_fri_mensavital'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_mensavital" value="<?php echo (!empty($post['price_att_fri_mensavital'])) ? $post['price_att_fri_mensavital'] : ""; ?>" /> €</td></tr>
				</table></td>
		</tr>
		<tr id="green_corner">
			<td class="mealdescription">Green Corner</td>
			<td><textarea rows="3" cols="20" class="mealinput" name="mon_green_corner" ><?php echo (!empty($post['mon_green_corner'])) ? $post['mon_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_mon_green_corner" value="<?php echo (!empty($post['price_stud_mon_green_corner'])) ? $post['price_stud_mon_green_corner'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_mon_green_corner" value="<?php echo (!empty($post['price_att_mon_green_corner'])) ? $post['price_att_mon_green_corner'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="tue_green_corner" ><?php echo (!empty($post['tue_green_corner'])) ? $post['tue_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_tue_green_corner" value="<?php echo (!empty($post['price_stud_tue_green_corner'])) ? $post['price_stud_tue_green_corner'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_tue_green_corner" value="<?php echo (!empty($post['price_att_tue_green_corner'])) ? $post['price_att_tue_green_corner'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="wed_green_corner" ><?php echo (!empty($post['wed_green_corner'])) ? $post['wed_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_wed_green_corner" value="<?php echo (!empty($post['price_stud_wed_green_corner'])) ? $post['price_stud_wed_green_corner'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_wed_green_corner" value="<?php echo (!empty($post['price_att_wed_green_corner'])) ? $post['price_att_wed_green_corner'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="thu_green_corner" ><?php echo (!empty($post['thu_green_corner'])) ? $post['thu_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_thu_green_corner" value="<?php echo (!empty($post['price_stud_thu_green_corner'])) ? $post['price_stud_thu_green_corner'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_thu_green_corner" value="<?php echo (!empty($post['price_att_thu_green_corner'])) ? $post['price_att_thu_green_corner'] : ""; ?>" /> €</td></tr>
				</table></td>
			<td><textarea rows="3" cols="20" class="mealinput" name="fri_green_corner" ><?php echo (!empty($post['fri_green_corner'])) ? $post['fri_green_corner'] : ""; ?></textarea>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_stud_fri_green_corner" value="<?php echo (!empty($post['price_stud_fri_green_corner'])) ? $post['price_stud_fri_green_corner'] : ""; ?>" /> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" class="price" size="5" maxlength="5" name="price_att_fri_green_corner" value="<?php echo (!empty($post['price_att_fri_green_corner'])) ? $post['price_att_fri_green_corner'] : ""; ?>" /> €</td></tr>
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