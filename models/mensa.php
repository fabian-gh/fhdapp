<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
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
	 * Startdate from the form
	 * @var String Date
	 */
	private $start;

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
	private $monday_prices;
	private $tuesday_prices;
	private $wednesday_prices;
	private $thursday_prices;
	private $friday_prices;



	/**
	 * Constructor
	 */
	public function __construct(){
		// open database-connection
		$this->DbCon = new mysqli();
		$this->DbCon->connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
	}

	// ================================================ Frontend-Methods =========================================================

	/**
	 * Queries the current plan + the plans for the next three weeks
	 * in the whole 4 or less weeks will be listed
	 * @return Array $plans
	 */
	public function getCanteenPlans(){
		try{

			$query = $this->DbCon->query("SELECT * 
										FROM meals AS m
										INNER JOIN days AS d ON m.day_id = d.id
										WHERE m.calenderweek
										BETWEEN DATE_FORMAT(NOW(), '%v')
										AND DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP( )+2419200 ), '%v')
										ORDER BY m.mealdate ASC");

			while($row = $query->fetch_assoc()){
                $plans[$row['calenderweek']][$row['day_id']] = array(
                	'Calenderweek'		=> $row['calenderweek'],
                	'mealdate'			=> $row['mealdate'],
                	'dayname'			=> $row['day'],
                	'meal_one'			=> $row['meal_one'],
                	'meal_two'			=> $row['meal_two'],
                	'side'				=> $row['side'],
                	'hotpot'			=> $row['hotpot'],
                	'bbq'				=> $row['bbq'],
                	'price_bbq'			=> $row['price_bbq'],
                	'pan'				=> $row['pan'],
                	'price_pan'			=> $row['price_pan'],
                	'action'			=> $row['action'],
                	'price_action'		=> $row['price_action'],
                	'wok'				=> $row['wok'],
                	'price_wok'			=> $row['price_wok'],
                	'gratin'			=> $row['gratin'],
                	'price_gratin'		=> $row['price_gratin'],
                	'mensavital'		=> $row['mensavital'],
                	'price_mensavital'	=> $row['price_mensavital'],
                	'green_corner'		=> $row['green_corner'],
                	'price_green_corner'=> $row['price_green_corner']
            	);
             }
             
             if(!empty($plans)){
             	return $plans;
             } else {
             	return null;
             }
             
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Queries all possible additives from the DB
	 * @return Array $additives
	 */
	public function getAdditives(){
		try{
			$query = $this->DbCon->query("SELECT * FROM additives");

			while($row = $query->fetch_assoc()){
				$additives[] = array(
					'abbreviation' 	=> $row['abbreviation'],
					'name'			=> $row['name']
				);
			}

			return $additives;

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}


	/**
	 * Queries opening hours
	 * @return Array $openHour
	 */
	public function getOpeningHours(){
		try{
			$query = $this->DbCon->query("SELECT * FROM canteens");

			while($row = $query->fetch_assoc()){
				$openHour[] = array(
					'name' 			=> $row['name'],
					'hoursDuring'	=> $row['hours_during_semester'],
					'hoursOutOf'	=> $row['hours_out_of_semester']
				);
			}

			return $openHour;

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	// ================================================ Backend-Methods ==========================================================

	/**
	 * Calculates the Calenderweek out of the Startdate
	 */
	private function calculateCalenderweek($date){
		$this->calenderweek = date("W", strtotime($date));
	}


	/**
	 * Queries all plans for the choosing-site
	 * @return Array $plan
	 */
	public function getAllPlans(){
		try{

			$query = $this->DbCon->query("SELECT calenderweek, mealdate FROM meals GROUP BY calenderweek ORDER BY mealdate DESC");
			while($row = $query->fetch_assoc()){

                $plans[] = array(
                	'calenderweek' 	=> $row['calenderweek'],
                	'start_date'	=> $row['mealdate']
            	);
             }

             if(!empty($plans)){
             	return $plans;
             } else {
             	echo '<span>Es sind keine Einträge vorhanden.</span>';
             }

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Proceeds the post-data
	 * @param Array $_POST
	 */
	public function proceedPost($post){

		// Verarbeitung der POST-Daten
		foreach($post as $key => $value){

			switch($key){

				case strstr($key, 'start_date'):
					$this->calculateCalenderweek($value);
					$this->start = mysql_real_escape_string($value);
				break;

				// Monday
				case strstr($key, 'mon_'):
					$this->monday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_mon_'):
					$this->monday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Tuesday
				case strstr($key, 'tue_'):
					$this->tuesday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_tue_'):
					$this->tuesday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Wednesday
				case strstr($key, 'wed_'):
					$this->wednesday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_wed_'):
					$this->wednesday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Thursday
				case strstr($key, 'thu_'):
					$this->thursday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_thu_'):
					$this->thursday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Friday
				case strstr($key, 'fri_'):
					$this->friday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_fri_'):
					$this->friday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;
			}
		}

		// calculate the dates of the week
		$start = strtotime($this->start);
		for($i = 0; $i<=4; $i++){
			$this->mealdate[$i] = date("Y-m-d", $start+($i*86400));
		}
	}



	/**
	 * Check if the price has a comma or a dot
	 * @param float $price
	 */
	public function checkComma($price){
		if(strstr($price, ',')){
			return str_replace(',', '.', $price);
		} else if(strstr($price, '.')){
			return $price;
		}
	}



	/**
	 * Insert the Plan into the database
	 * @param Array $post Post-Data
	 */
	public function insertPlan($get){

		if($this->calenderweek>0 && $this->calenderweek<=52 && !empty($this->mealdate)){

			try{
			// delete old entries
			if(isset($get) && $get['mode'] == 'edit'){
				$this->DbCon->query("DELETE FROM meals WHERE calenderweek = ".$get['cw']);
			}

			// insert whole week with one INSERT
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_bbq,
														pan, price_pan,
														action, price_action,
														wok, price_wok,
														gratin, price_gratin,
														mensavital, price_mensavital,
														green_corner, price_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[0]."', '1',
					'".$this->monday_meals[0]."', '".$this->monday_meals[1]."', '".$this->monday_meals[2]."', '".$this->monday_meals[3]."', 
					'".$this->monday_meals[4]."', '".$this->monday_prices[0]."',
					'".$this->monday_meals[5]."', '".$this->monday_prices[1]."',
					'".$this->monday_meals[6]."', '".$this->monday_prices[2]."',
					'".$this->monday_meals[7]."', '".$this->monday_prices[3]."',
					'".$this->monday_meals[8]."', '".$this->monday_prices[4]."',
					'".$this->monday_meals[9]."', '".$this->monday_prices[5]."',
					'".$this->monday_meals[10]."', '".$this->monday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[1]."', '2',
					'".$this->tuesday_meals[0]."', '".$this->tuesday_meals[1]."', '".$this->tuesday_meals[2]."', '".$this->tuesday_meals[3]."', 
					'".$this->tuesday_meals[4]."', '".$this->tuesday_prices[0]."',
					'".$this->tuesday_meals[5]."', '".$this->tuesday_prices[1]."',
					'".$this->tuesday_meals[6]."', '".$this->tuesday_prices[2]."',
					'".$this->tuesday_meals[7]."', '".$this->tuesday_prices[3]."',
					'".$this->tuesday_meals[8]."', '".$this->tuesday_prices[4]."',
					'".$this->tuesday_meals[9]."', '".$this->tuesday_prices[5]."',
					'".$this->tuesday_meals[10]."', '".$this->tuesday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[2]."', '3',
					'".$this->wednesday_meals[0]."', '".$this->wednesday_meals[1]."', '".$this->wednesday_meals[2]."', '".$this->wednesday_meals[3]."', 
					'".$this->wednesday_meals[4]."', '".$this->wednesday_prices[0]."',
					'".$this->wednesday_meals[5]."', '".$this->wednesday_prices[1]."',
					'".$this->wednesday_meals[6]."', '".$this->wednesday_prices[2]."',
					'".$this->wednesday_meals[7]."', '".$this->wednesday_prices[3]."',
					'".$this->wednesday_meals[8]."', '".$this->wednesday_prices[4]."',
					'".$this->wednesday_meals[9]."', '".$this->wednesday_prices[5]."',
					'".$this->wednesday_meals[10]."', '".$this->wednesday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[3]."', '4',
					'".$this->thursday_meals[0]."', '".$this->thursday_meals[1]."', '".$this->thursday_meals[2]."', '".$this->thursday_meals[3]."', 
					'".$this->thursday_meals[4]."', '".$this->thursday_prices[0]."',
					'".$this->thursday_meals[5]."', '".$this->thursday_prices[1]."',
					'".$this->thursday_meals[6]."', '".$this->thursday_prices[2]."',
					'".$this->thursday_meals[7]."', '".$this->thursday_prices[3]."',
					'".$this->thursday_meals[8]."', '".$this->thursday_prices[4]."',
					'".$this->thursday_meals[9]."', '".$this->thursday_prices[5]."',
					'".$this->thursday_meals[10]."', '".$this->thursday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[4]."', '5',
					'".$this->friday_meals[0]."', '".$this->friday_meals[1]."', '".$this->friday_meals[2]."', '".$this->friday_meals[3]."', 
					'".$this->friday_meals[4]."', '".$this->friday_prices[0]."',
					'".$this->friday_meals[5]."', '".$this->friday_prices[1]."',
					'".$this->friday_meals[6]."', '".$this->friday_prices[2]."',
					'".$this->friday_meals[7]."', '".$this->friday_prices[3]."',
					'".$this->friday_meals[8]."', '".$this->friday_prices[4]."',
					'".$this->friday_meals[9]."', '".$this->friday_prices[5]."',
					'".$this->friday_meals[10]."', '".$this->friday_prices[6]."')");

			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
	}



	/**
	 * Delete a plan
	 * @param int $calenderweek
	 */
	public function deletePlan($calenderweek){
		try{
			$cw = $_GET['cw'];
			$this->DbCon->query("DELETE FROM meals WHERE calenderweek = ".$calenderweek);
			echo 'Plan der Kalenderwoche'.$calenderweek.'gelöscht';
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Replayces the <br />-Tag with whitespace
	 * @param String $text
	 * @return String 
	 */
	public function replaceBR($text){
		return str_replace("<br />", "", $text);
	}



	/**
	 * Edit a plan
	 * @param int $calenderweek
	 * @return Array Data
	 */
	public function editPlan($calenderweek){
		try{

			// Query the calenderweek of the first day of a week
			$query = $this->DbCon->query("SELECT mealdate FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['start_date'] = $row['mealdate'];
			}

			// Monday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['mon_meal_one'] = $this->replaceBR($row['meal_one']);
				$post['mon_meal_two'] = $this->replaceBR($row['meal_two']);
				$post['mon_side'] = $this->replaceBR($row['side']);
				$post['mon_hotpot'] = $this->replaceBR($row['hotpot']);
				$post['mon_bbq'] = $this->replaceBR($row['bbq']);
				$post['price_mon_bbq'] = $row['price_bbq'];
				$post['mon_pan'] = $this->replaceBR($row['pan']);
				$post['price_mon_pan'] = $row['price_pan'];
				$post['mon_action'] = $this->replaceBR($row['action']);
				$post['price_mon_action'] = $row['price_action'];
				$post['mon_wok'] = $this->replaceBR($row['wok']);
				$post['price_mon_wok'] = $row['price_wok'];
				$post['mon_gratin'] = $this->replaceBR($row['gratin']);
				$post['price_mon_gratin'] = $row['price_gratin'];
				$post['mon_mensavital'] = $this->replaceBR($row['mensavital']);
				$post['price_mon_mensavital'] = $row['price_mensavital'];
				$post['mon_green_corner'] = $this->replaceBR($row['green_corner']);
				$post['price_mon_green_corner'] = $row['price_green_corner'];
			}

			// Tuesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 2");
			while($row = $query->fetch_assoc()){
				$post['tue_meal_one'] = $this->replaceBR($row['meal_one']);
				$post['tue_meal_two'] = $this->replaceBR($row['meal_two']);
				$post['tue_side'] = $this->replaceBR($row['side']);
				$post['tue_hotpot'] = $this->replaceBR($row['hotpot']);
				$post['tue_bbq'] = $this->replaceBR($row['bbq']);
				$post['price_tue_bbq'] = $row['price_bbq'];
				$post['tue_pan'] = $this->replaceBR($row['pan']);
				$post['price_tue_pan'] = $row['price_pan'];
				$post['tue_action'] = $this->replaceBR($row['action']);
				$post['price_tue_action'] = $row['price_action'];
				$post['tue_wok'] = $this->replaceBR($row['wok']);
				$post['price_tue_wok'] = $row['price_wok'];
				$post['tue_gratin'] = $this->replaceBR($row['gratin']);
				$post['price_tue_gratin'] = $row['price_gratin'];
				$post['tue_mensavital'] = $this->replaceBR($row['mensavital']);
				$post['price_tue_mensavital'] = $row['price_mensavital'];
				$post['tue_green_corner'] = $this->replaceBR($row['green_corner']);
				$post['price_tue_green_corner'] = $row['price_green_corner'];
			}

			// Wednesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 3");
			while($row = $query->fetch_assoc()){
				$post['wed_meal_one'] = $this->replaceBR($row['meal_one']);
				$post['wed_meal_two'] = $this->replaceBR($row['meal_two']);
				$post['wed_side'] = $this->replaceBR($row['side']);
				$post['wed_hotpot'] = $this->replaceBR($row['hotpot']);
				$post['wed_bbq'] = $this->replaceBR($row['bbq']);
				$post['price_wed_bbq'] = $row['price_bbq'];
				$post['wed_pan'] = $this->replaceBR($row['pan']);
				$post['price_wed_pan'] = $row['price_pan'];
				$post['wed_action'] = $this->replaceBR($row['action']);
				$post['price_wed_action'] = $row['price_action'];
				$post['wed_wok'] = $this->replaceBR($row['wok']);
				$post['price_wed_wok'] = $row['price_wok'];
				$post['wed_gratin'] = $this->replaceBR($row['gratin']);
				$post['price_wed_gratin'] = $row['price_gratin'];
				$post['wed_mensavital'] = $this->replaceBR($row['mensavital']);
				$post['price_wed_mensavital'] = $row['price_mensavital'];
				$post['wed_green_corner'] = $this->replaceBR($row['green_corner']);
				$post['price_wed_green_corner'] = $row['price_green_corner'];
			}

			// Thursday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 4");
			while($row = $query->fetch_assoc()){
				$post['thu_meal_one'] = $this->replaceBR($row['meal_one']);
				$post['thu_meal_two'] = $this->replaceBR($row['meal_two']);
				$post['thu_side'] = $this->replaceBR($row['side']);
				$post['thu_hotpot'] = $this->replaceBR($row['hotpot']);
				$post['thu_bbq'] = $this->replaceBR($row['bbq']);
				$post['price_thu_bbq'] = $row['price_bbq'];
				$post['thu_pan'] = $this->replaceBR($row['pan']);
				$post['price_thu_pan'] = $row['price_pan'];
				$post['thu_action'] = $this->replaceBR($row['action']);
				$post['price_thu_action'] = $row['price_action'];
				$post['thu_wok'] = $this->replaceBR($row['wok']);
				$post['price_thu_wok'] = $row['price_wok'];
				$post['thu_gratin'] = $this->replaceBR($row['gratin']);
				$post['price_thu_gratin'] = $row['price_gratin'];
				$post['thu_mensavital'] = $this->replaceBR($row['mensavital']);
				$post['price_thu_mensavital'] = $row['price_mensavital'];
				$post['thu_green_corner'] = $this->replaceBR($row['green_corner']);
				$post['price_thu_green_corner'] = $row['price_green_corner'];
			}

			// Friday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 5");
			while($row = $query->fetch_assoc()){
				$post['fri_meal_one'] = $this->replaceBR($row['meal_one']);
				$post['fri_meal_two'] = $this->replaceBR($row['meal_two']);
				$post['fri_side'] = $this->replaceBR($row['side']);
				$post['fri_hotpot'] = $this->replaceBR($row['hotpot']);
				$post['fri_bbq'] = $this->replaceBR($row['bbq']);
				$post['price_fri_bbq'] = $row['price_bbq'];
				$post['fri_pan'] = $this->replaceBR($row['pan']);
				$post['price_fri_pan'] = $row['price_pan'];
				$post['fri_action'] = $this->replaceBR($row['action']);
				$post['price_fri_action'] = $row['price_action'];
				$post['fri_wok'] = $this->replaceBR($row['wok']);
				$post['price_fri_wok'] = $row['price_wok'];
				$post['fri_gratin'] = $this->replaceBR($row['gratin']);
				$post['price_fri_gratin'] = $row['price_gratin'];
				$post['fri_mensavital'] = $this->replaceBR($row['mensavital']);
				$post['price_fri_mensavital'] = $row['price_mensavital'];
				$post['fri_green_corner'] = $this->replaceBR($row['green_corner']);
				$post['price_fri_green_corner'] = $row['price_green_corner'];
			}

			return $post;

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
}

 
/* End of file mensa.php */
/* Location: ./models/mensa.php */