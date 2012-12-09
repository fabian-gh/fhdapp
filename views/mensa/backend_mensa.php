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



<form name="mensa" method="post" action="">
	<table>
		<tr>
			<td>Kalenderwoche:</td><td><input type="textfield" id="calenderweek" name="calenderweek" value="" /></td>
			<td>
				<input type="radio" id="canteen_north" name="canteens" value="1"/>Mensa Nord
				<input type="radio" id="canteen_south" name="canteens" value="2"/>Mensa Universit&auml;tsstrasse
			</td>
		</tr>
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
		<tr id="meal_one" class="both_campus">
			<td>Essen 1</td>
			<td><input type="textarea" name="mon_meal_one"/></td>
			<td><input type="textarea" name="tue_meal_one"/></td>
			<td><input type="textarea" name="wed_meal_one"/></td>
			<td><input type="textarea" name="thu_meal_one"/></td>
			<td><input type="textarea" name="fri_meal_one"/></td>
		</tr>
		<tr id="meal_two" class="both_campus">
			<td>Essen 2</td>
			<td><input type="textarea" name="mon_meal_two"/></td>
			<td><input type="textarea" name="tue_meal_two"/></td>
			<td><input type="textarea" name="wed_meal_two"/></td>
			<td><input type="textarea" name="thu_meal_two"/></td>
			<td><input type="textarea" name="fri_meal_two"/></td>
		</tr>
		<tr id="side" class="both_campus">
			<td>Beilagen</td>
			<td><input type="textarea" name="mon_side"/></td>
			<td><input type="textarea" name="tue_side"/></td>
			<td><input type="textarea" name="wed_side"/></td>
			<td><input type="textarea" name="thu_side"/></td>
			<td><input type="textarea" name="fri_side"/></td>
		</tr>
		<tr id="hotpot" class="both_campus">
			<td>Eint&ouml;pfe</td>
			<td><input type="textarea" name="mon_hotpot"/></td>
			<td><input type="textarea" name="tue_hotpot"/></td>
			<td><input type="textarea" name="wed_hotpot"/></td>
			<td><input type="textarea" name="thu_hotpot"/></td>
			<td><input type="textarea" name="fri_hotpot"/></td>
		</tr>
		<tr id="bbq" class="uni_campus">
			<td>Grill</td>
			<td><input type="textarea" name="mon_bbq"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_bbq"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_bbq"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_bbq"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_bbq"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_bbq"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_bbq"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_bbq"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_bq"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_bbq"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_bbq"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_bbq"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_bbq"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_bbq"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_bbq"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="pan" class="uni_campus">
			<td>Pfanne</td>
			<td><input type="textarea" name="mon_pan"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_pan"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_pan"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_pan"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_pan"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_pan"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_pan"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_pan"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_pan"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_pan"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_pan"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_pan"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_pan"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_pan"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_pan"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="wok" class="uni_campus">
			<td>Wok</td>
			<td><input type="textarea" name="mon_wok"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_wok"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_wok"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_wok"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_wok"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_wok"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_wok"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_wok"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_wok"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_wok"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_wok"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_wok"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_wok"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_wok"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_wok"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="gratin" class="uni_campus">
			<td>Gratin</td>
			<td><input type="textarea" name="mon_gratin"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_gratin"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_gratin"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_gratin"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_gratin"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_gratin"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_gratin"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_gratin"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_gratin"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_gratin"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_gratin"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_gratin"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_gratin"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_gratin"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_gratin"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="weekoffer" class="uni_campus">
			<td>Wochenangebot</td>
			<td><input type="textarea" name="mon_weekoffer"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_weekoffer"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_weekoffer"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_weekoffer"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_weekoffer"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_weekoffer"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_weekoffer"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_weekoffer"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_weekoffer"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_weekoffer"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_weekoffer"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_weekoffer"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_weekoffer"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_weekoffer"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_weekoffer"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="special" class="both_campus">
			<td>Spezial</td>
			<td><input type="textarea" name="mon_special"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_special"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_special"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_special"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_special"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_special"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_special"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_special"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_special"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_special"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_special"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_special"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_special"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_special"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_special"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="action" class="uni_campus">
			<td>Aktion</td>
			<td><input type="textarea" name="mon_action"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_action"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_action"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_action"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_action"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_action"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_action"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_action"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_action"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_action"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_action"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_action"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_action"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_action"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_action"/> €</td></tr>
				</table></td>
		</tr>
		<tr id="green_corner" class="uni_campus">
			<td>Green Corner</td>
			<td><input type="textarea" name="mon_green_corner"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_mon_green_corner"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_mon_green_corner"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="tue_green_corner"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_tue_green_corner"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_tue_green_corner"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="wed_green_corner"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_wed_green_corner"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_wed_green_corner"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="thu_green_corner"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_thu_green_corner"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_thu_green_corner"/> €</td></tr>
				</table></td>
			<td><input type="textarea" name="fri_green_corner"/>
				<table>
					<tr><td>Stud.: </td><td><input type="textfield" length="5" name="price_stud_fri_green_corner"/> €</td></tr>
					<tr><td>Bed.: </td><td><input type="textfield" length="5" name="price_att_fri_green_corner"/> €</td></tr>
				</table></td>
		</tr>
		<tr><td><input type="submit" name="speichern" value="Speichern"/></td></tr>
	</table>
</form>


<?php
	require_once '../../layout/backend/footer.php';


// Überprüfung ob Formular abgeschickt
if(isset($_POST['speichern'])){
	require_once '../../controllers/mensaController.php';
	$Mensa = new MensaController();
	$Mensa->callInsertPlan($_POST);
}

?>


<script href="../../sources/customjs/mensa.js"></script>


<?php
/* End of file backend_mensa.php */
/* Location: ./views/mensa/backend_mensa.php */