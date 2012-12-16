<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

/**
 * Mensaklasse
 */
class Mensa{

	/**
	 * DB-Connection
	 * @var Object Database-Connection
	 */
	private $DbCon;

	/**
	 * Calenderweek
	 * @var int Calenderweek
	 */
	private $calenderweek;

	/**
	 * Date of the day where the monday_meals is served
	 * @var Date
	 */
	private $mealdate;

	/**
	 * Arrays with monday_mealss for each day
	 * @var Array
	 */
	private $monday_meals;
	private $tuesday_meals;
	private $wednesday_meals;
	private $thursday_meals;
	private $friday_meals;

	/**
	 * Arrays with studendprices for each day
	 * @var Array
	 */
	private $monday_stud_prices;
	private $tuesday_stud_prices;
	private $wednesday_stud_prices;
	private $thursday_stud_prices;
	private $friday_stud_prices;

	/**
	 * Arrays with attendentprices for each day
	 * @var Array
	 */
	private $monday_att_prices;
	private $tuesday_att_prices;
	private $wednesday_att_prices;
	private $thursday_att_prices;
	private $friday_att_prices;



	/**
	 * Constructor
	 */
	public function __construct(){
		// open database-connection
		$this->DbCon = new mysqli();
        $this->DbCon->connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
	}



	/**
	 * Query all existing canteens
	 */
	/*public function getCanteens(){
		try{
			$query = $this->DbCon->query("SELECT id, name FROM canteens");

			while($row = $query->fetch_assoc()){
                $canteens[$row['id']] = $row['name'];
            }

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}*/


	public function proceedPost($post){

		// Verarbeitung der POST-Daten
		foreach($post as $key => $value){

			switch($key){

				case strstr($key, 'calenderweek');
					$this->calenderweek;
				break;

				case strstr($key, 'mealdate'):
					$this->mealdate;
				break;

				// Monday
				case strstr($key, 'mon_'):
					$this->monday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_mon_'):
					$this->monday_stud_prices[] = $value;
				break;

				case strstr($key, 'price_att_mon_'):
					$this->monday_att_prices[] = $value;
				break;

				// Tuesday
				case strstr($key, 'tue_'):
					$this->tuesday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_tue_'):
					$this->tuesday_stud_prices[] = $value;
				break;

				case strstr($key, 'price_att_tue_'):
					$this->tuesday_att_prices[] = $value;
				break;

				// Wednesday
				case strstr($key, 'wed_'):
					$this->wednesday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_wed_'):
					$this->wednesday_stud_prices[] = $value;
				break;

				case strstr($key, 'price_att_wed_'):
					$this->wednesday_att_prices[] = $value;
				break;

				// Thursday
				case strstr($key, 'thu_'):
					$this->thursday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_thu_'):
					$this->thursday_stud_prices[] = $value;
				break;

				case strstr($key, 'price_att_thu_'):
					$this->thursday_att_prices[] = $value;
				break;

				// Friday
				case strstr($key, 'fri_'):
					$this->friday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_fri_'):
					$this->friday_stud_prices[] = $value;
				break;

				case strstr($key, 'price_att_fri_'):
					$this->friday_att_prices[] = $value;
				break;
			}
		}
	}



	/**
	 * Insert the Plan into the database
	 *
	 * @param Array $post Post-Data
	 */
	public function insertPlan(){
		try{
			// insert Monday
			$this->DbCon->real_query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek.", ".$this->mealdate."', '1',
					'".$this->monday_meals[0]."', '".$this->monday_meals[1]."', '".$this->monday_meals[2]."', '".$this->monday_meals[3]."', 
					'".$this->monday_meals[4]."', '".$this->monday_stud_prices[0]."', '".$this->monday_att_prices[0]."',
					'".$this->monday_meals[5]."', '".$this->monday_stud_prices[1]."', '".$this->monday_att_prices[1]."',
					'".$this->monday_meals[6]."', '".$this->monday_stud_prices[2]."', '".$this->monday_att_prices[2]."',
					'".$this->monday_meals[7]."', '".$this->monday_stud_prices[3]."', '".$this->monday_att_prices[3]."',
					'".$this->monday_meals[8]."', '".$this->monday_stud_prices[4]."', '".$this->monday_att_prices[4]."',
					'".$this->monday_meals[9]."', '".$this->monday_stud_prices[5]."', '".$this->monday_att_prices[5]."',
					'".$this->monday_meals[10]."', '".$this->monday_stud_prices[6]."', '".$this->monday_att_prices[6]."',
					'".$this->monday_meals[11]."', '".$this->monday_stud_prices[7]."', '".$this->monday_att_prices[7]."')");

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Delete a plan
	 * @param int $id
	 */
	public function deletePlan($calenderweek){
		try{
			$this->DbCon->real_query("DELETE FROM meals WHERE calenderweek = '".$calenderweek."'");
			echo 'Plan der Kalenderwoche'.$calenderweek.'gelöscht';
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}


	/**
	 * Edit a plan
	 * @param int $id
	 */
	public function editPlan($calenderweek){
		try{

			// Monday
			$query = $this->DbCon->real_query("SELECT * FROM meals WHERE calenderweek ='".$calenderweek."' AND day_id = 1");
			while($row = $query->fetch_assoc){
				$_POST['mon_meal_one'] = $row['meal_one'];
				$_POST['mon_meal_two'] = $row['meal_two'];
				$_POST['mon_side'] = $row['side'];
				$_POST['mon_hotpot'] = $row['hotpot'];
				$_POST['mon_bbq'] = $row['bbq'];
				$_POST['price_stud_mon_bbq'] = $row['price_stud_bbq'];
				$_POST['price_att_mon_bbq'] = $row['price_att_bbq'];
				$_POST['mon_pan'] = $row['pan'];
				$_POST['price_stud_mon_pan'] = $row['price_stud_pan'];
				$_POST['price_att_mon_pan'] = $row['price_att_pan'];
				$_POST['mon_wok'] = $row['wok'];
				$_POST['price_stud_mon_wok'] = $row['price_stud_wok'];
				$_POST['price_att_mon_wok'] = $row['price_att_wok'];
				$_POST['mon_gratin'] = $row['gratin'];
				$_POST['price_stud_mon_gratin'] = $row['price_stud_gratin'];
				$_POST['price_att_mon_gratin'] = $row['price_att_gratin'];
				$_POST['mon_weekoffer'] = $row['weekoffer'];
				$_POST['price_stud_mon_weekoffer'] = $row['price_stud_weekoffer'];
				$_POST['price_att_mon_weekoffer'] = $row['price_att_weekoffer'];
				$_POST['mon_special'] = $row['special'];
				$_POST['price_stud_mon_special'] = $row['price_stud_special'];
				$_POST['price_att_mon_special'] = $row['price_att_special'];
				$_POST['mon_action'] = $row['action'];
				$_POST['price_stud_mon_action'] = $row['price_stud_action'];
				$_POST['price_att_mon_action'] = $row['price_att_action'];
				$_POST['mon_green_corner'] = $row['green_corner'];
				$_POST['price_stud_mon_green_corner'] = $row['price_stud_green_corner'];
				$_POST['price_att_mon_green_corner'] = $row['price_att_green_corner'];
			}

			// Tuesday
			$query = $this->DbCon->real_query("SELECT * FROM meals WHERE calenderweek ='".$calenderweek."' AND day_id = 2");
			while($row = $query->fetch_assoc){
				$_POST['tue_meal_one'] = $row['meal_one'];
				$_POST['tue_meal_two'] = $row['meal_two'];
				$_POST['tue_side'] = $row['side'];
				$_POST['tue_hotpot'] = $row['hotpot'];
				$_POST['tue_bbq'] = $row['bbq'];
				$_POST['price_stud_tue_bbq'] = $row['price_stud_bbq'];
				$_POST['price_att_tue_bbq'] = $row['price_att_bbq'];
				$_POST['tue_pan'] = $row['pan'];
				$_POST['price_stud_tue_pan'] = $row['price_stud_pan'];
				$_POST['price_att_tue_pan'] = $row['price_att_pan'];
				$_POST['tue_wok'] = $row['wok'];
				$_POST['price_stud_tue_wok'] = $row['price_stud_wok'];
				$_POST['price_att_tue_wok'] = $row['price_att_wok'];
				$_POST['tue_gratin'] = $row['gratin'];
				$_POST['price_stud_tue_gratin'] = $row['price_stud_gratin'];
				$_POST['price_att_tue_gratin'] = $row['price_att_gratin'];
				$_POST['tue_weekoffer'] = $row['weekoffer'];
				$_POST['price_stud_tue_weekoffer'] = $row['price_stud_weekoffer'];
				$_POST['price_att_tue_weekoffer'] = $row['price_att_weekoffer'];
				$_POST['tue_special'] = $row['special'];
				$_POST['price_stud_tue_special'] = $row['price_stud_special'];
				$_POST['price_att_tue_special'] = $row['price_att_special'];
				$_POST['tue_action'] = $row['action'];
				$_POST['price_stud_tue_action'] = $row['price_stud_action'];
				$_POST['price_att_tue_action'] = $row['price_att_action'];
				$_POST['tue_green_corner'] = $row['green_corner'];
				$_POST['price_stud_tue_green_corner'] = $row['price_stud_green_corner'];
				$_POST['price_att_tue_green_corner'] = $row['price_att_green_corner'];
			}

			// Wednesday
			$query = $this->DbCon->real_query("SELECT * FROM meals WHERE calenderweek ='".$calenderweek."' AND day_id = 3");
			while($row = $query->fetch_assoc){
				$_POST['wed_meal_one'] = $row['meal_one'];
				$_POST['wed_meal_two'] = $row['meal_two'];
				$_POST['wed_side'] = $row['side'];
				$_POST['wed_hotpot'] = $row['hotpot'];
				$_POST['wed_bbq'] = $row['bbq'];
				$_POST['price_stud_wed_bbq'] = $row['price_stud_bbq'];
				$_POST['price_att_wed_bbq'] = $row['price_att_bbq'];
				$_POST['wed_pan'] = $row['pan'];
				$_POST['price_stud_wed_pan'] = $row['price_stud_pan'];
				$_POST['price_att_wed_pan'] = $row['price_att_pan'];
				$_POST['wed_wok'] = $row['wok'];
				$_POST['price_stud_wed_wok'] = $row['price_stud_wok'];
				$_POST['price_att_wed_wok'] = $row['price_att_wok'];
				$_POST['wed_gratin'] = $row['gratin'];
				$_POST['price_stud_wed_gratin'] = $row['price_stud_gratin'];
				$_POST['price_att_wed_gratin'] = $row['price_att_gratin'];
				$_POST['wed_weekoffer'] = $row['weekoffer'];
				$_POST['price_stud_wed_weekoffer'] = $row['price_stud_weekoffer'];
				$_POST['price_att_wed_weekoffer'] = $row['price_att_weekoffer'];
				$_POST['wed_special'] = $row['special'];
				$_POST['price_stud_wed_special'] = $row['price_stud_special'];
				$_POST['price_att_wed_special'] = $row['price_att_special'];
				$_POST['wed_action'] = $row['action'];
				$_POST['price_stud_wed_action'] = $row['price_stud_action'];
				$_POST['price_att_wed_action'] = $row['price_att_action'];
				$_POST['wed_green_corner'] = $row['green_corner'];
				$_POST['price_stud_wed_green_corner'] = $row['price_stud_green_corner'];
				$_POST['price_att_wed_green_corner'] = $row['price_att_green_corner'];
			}

			// Thursday
			$query = $this->DbCon->real_query("SELECT * FROM meals WHERE calenderweek ='".$calenderweek."' AND day_id = 4");
			while($row = $query->fetch_assoc){
				$_POST['thu_meal_one'] = $row['meal_one'];
				$_POST['thu_meal_two'] = $row['meal_two'];
				$_POST['thu_side'] = $row['side'];
				$_POST['thu_hotpot'] = $row['hotpot'];
				$_POST['thu_bbq'] = $row['bbq'];
				$_POST['price_stud_thu_bbq'] = $row['price_stud_bbq'];
				$_POST['price_att_thu_bbq'] = $row['price_att_bbq'];
				$_POST['thu_pan'] = $row['pan'];
				$_POST['price_stud_thu_pan'] = $row['price_stud_pan'];
				$_POST['price_att_thu_pan'] = $row['price_att_pan'];
				$_POST['thu_wok'] = $row['wok'];
				$_POST['price_stud_thu_wok'] = $row['price_stud_wok'];
				$_POST['price_att_thu_wok'] = $row['price_att_wok'];
				$_POST['thu_gratin'] = $row['gratin'];
				$_POST['price_stud_thu_gratin'] = $row['price_stud_gratin'];
				$_POST['price_att_thu_gratin'] = $row['price_att_gratin'];
				$_POST['thu_weekoffer'] = $row['weekoffer'];
				$_POST['price_stud_thu_weekoffer'] = $row['price_stud_weekoffer'];
				$_POST['price_att_thu_weekoffer'] = $row['price_att_weekoffer'];
				$_POST['thu_special'] = $row['special'];
				$_POST['price_stud_thu_special'] = $row['price_stud_special'];
				$_POST['price_att_thu_special'] = $row['price_att_special'];
				$_POST['thu_action'] = $row['action'];
				$_POST['price_stud_thu_action'] = $row['price_stud_action'];
				$_POST['price_att_thu_action'] = $row['price_att_action'];
				$_POST['thu_green_corner'] = $row['green_corner'];
				$_POST['price_stud_thu_green_corner'] = $row['price_stud_green_corner'];
				$_POST['price_att_thu_green_corner'] = $row['price_att_green_corner'];
			}

			// Friday
			$query = $this->DbCon->real_query("SELECT * FROM meals WHERE calenderweek ='".$calenderweek."' AND day_id = 5");
			while($row = $query->fetch_assoc){
				$_POST['fri_meal_one'] = $row['meal_one'];
				$_POST['fri_meal_two'] = $row['meal_two'];
				$_POST['fri_side'] = $row['side'];
				$_POST['fri_hotpot'] = $row['hotpot'];
				$_POST['fri_bbq'] = $row['bbq'];
				$_POST['price_stud_fri_bbq'] = $row['price_stud_bbq'];
				$_POST['price_att_fri_bbq'] = $row['price_att_bbq'];
				$_POST['fri_pan'] = $row['pan'];
				$_POST['price_stud_fri_pan'] = $row['price_stud_pan'];
				$_POST['price_att_fri_pan'] = $row['price_att_pan'];
				$_POST['fri_wok'] = $row['wok'];
				$_POST['price_stud_fri_wok'] = $row['price_stud_wok'];
				$_POST['price_att_fri_wok'] = $row['price_att_wok'];
				$_POST['fri_gratin'] = $row['gratin'];
				$_POST['price_stud_fri_gratin'] = $row['price_stud_gratin'];
				$_POST['price_att_fri_gratin'] = $row['price_att_gratin'];
				$_POST['fri_weekoffer'] = $row['weekoffer'];
				$_POST['price_stud_fri_weekoffer'] = $row['price_stud_weekoffer'];
				$_POST['price_att_fri_weekoffer'] = $row['price_att_weekoffer'];
				$_POST['fri_special'] = $row['special'];
				$_POST['price_stud_fri_special'] = $row['price_stud_special'];
				$_POST['price_att_fri_special'] = $row['price_att_special'];
				$_POST['fri_action'] = $row['action'];
				$_POST['price_stud_fri_action'] = $row['price_stud_action'];
				$_POST['price_att_fri_action'] = $row['price_att_action'];
				$_POST['fri_green_corner'] = $row['green_corner'];
				$_POST['price_stud_fri_green_corner'] = $row['price_stud_green_corner'];
				$_POST['price_att_fri_green_corner'] = $row['price_att_green_corner'];
			}

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}


	/**
	 * Set the first four counts of the array to null
	 * @param Array $originalarray
	 */
	/*private function setFirstFourCounts($originalarray = array()){
		for($i=0; $i<4; $i++){
			$array[$i] = null;
		}
		return $array;
	}*/

}


/* 
 POST-Array:

calenderweek:45
canteens:1
mon_meal_one:
tue_meal_one:
wed_meal_one:
thu_meal_one:
fri_meal_one:
mon_meal_two:
tue_meal_two:
wed_meal_two:
thu_meal_two:
fri_meal_two:
mon_side:
tue_side:
wed_side:
thu_side:
fri_side:
mon_hotpot:
tue_hotpot:
wed_hotpot:
thu_hotpot:
fri_hotpot:
mon_bbq:
price_stud_mon_bbq:
price_att_mon_bbq:
tue_bbq:
price_stud_tue_bbq:
price_att_tue_bbq:
wed_bbq:
price_stud_wed_bbq:
price_att_wed_bq:
thu_bbq:
price_stud_thu_bbq:
price_att_thu_bbq:
fri_bbq:
price_stud_fri_bbq:
price_att_fri_bbq:
mon_pan:
price_stud_mon_pan:
price_att_mon_pan:
tue_pan:
price_stud_tue_pan:
price_att_tue_pan:
wed_pan:
price_stud_wed_pan:
price_att_wed_pan:
thu_pan:
price_stud_thu_pan:
price_att_thu_pan:
fri_pan:
price_stud_fri_pan:
price_att_fri_pan:
mon_wok:
price_stud_mon_wok:
price_att_mon_wok:
tue_wok:
price_stud_tue_wok:
price_att_tue_wok:
wed_wok:
price_stud_wed_wok:
price_att_wed_wok:
thu_wok:
price_stud_thu_wok:
price_att_thu_wok:
fri_wok:
price_stud_fri_wok:
price_att_fri_wok:
mon_gratin:
price_stud_mon_gratin:
price_att_mon_gratin:
tue_gratin:
price_stud_tue_gratin:
price_att_tue_gratin:
wed_gratin:
price_stud_wed_gratin:
price_att_wed_gratin:
thu_gratin:
price_stud_thu_gratin:
price_att_thu_gratin:
fri_gratin:
price_stud_fri_gratin:
price_att_fri_gratin:
mon_weekoffer:
price_stud_mon_weekoffer:
price_att_mon_weekoffer:
tue_weekoffer:
price_stud_tue_weekoffer:
price_att_tue_weekoffer:
wed_weekoffer:
price_stud_wed_weekoffer:
price_att_wed_weekoffer:
thu_weekoffer:
price_stud_thu_weekoffer:
price_att_thu_weekoffer:
fri_weekoffer:
price_stud_fri_weekoffer:
price_att_fri_weekoffer:
mon_special:
price_stud_mon_special:
price_att_mon_special:
tue_special:
price_stud_tue_special:
price_att_tue_special:
wed_special:
price_stud_wed_special:
price_att_wed_special:
thu_special:
price_stud_thu_special:
price_att_thu_special:
fri_special:
price_stud_fri_special:
price_att_fri_special:
mon_action:
price_stud_mon_action:
price_att_mon_action:
tue_action:
price_stud_tue_action:
price_att_tue_action:
wed_action:
price_stud_wed_action:
price_att_wed_action:
thu_action:
price_stud_thu_action:
price_att_thu_action:
fri_action:
price_stud_fri_action:
price_att_fri_action:
mon_green_corner:
price_stud_mon_green_corner:
price_att_mon_green_corner:
tue_green_corner:
price_stud_tue_green_corner:
price_att_tue_green_corner:
wed_green_corner:
price_stud_wed_green_corner:
price_att_wed_green_corner:
thu_green_corner:
price_stud_thu_green_corner:
price_att_thu_green_corner:
fri_green_corner:
price_stud_fri_green_corner:
price_att_fri_green_corner:
*/

 
/* End of file mensa.php */
/* Location: ./models/mensa.php */