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
	 * Startdate ftom the form
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

	// ================================================ Frontend-Methods =========================================================

	public function getCanteenPlans(){
		try{

			$query = $this->DbCon->query("SELECT * 
										FROM meals AS m
										INNER JOIN days AS d 
										ON m.day_id = d.id
										WHERE m.mealdate BETWEEN CURDATE( ) AND CURDATE( )+21
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
                	'price_stud_bbq'	=> $row['price_stud_bbq'],
                	'price_att_bbq'		=> $row['price_att_bbq'],
                	'pan'				=> $row['pan'],
                	'price_stud_pan'	=> $row['price_stud_pan'],
                	'price_att_pan'		=> $row['price_att_pan'],
                	'action'			=> $row['action'],
                	'price_stud_action'	=> $row['price_stud_action'],
                	'price_att_action'	=> $row['price_att_action'],
                	'wok'				=> $row['wok'],
                	'price_stud_wok'	=> $row['price_stud_wok'],
                	'price_att_wok'		=> $row['price_att_wok'],
                	'gratin'			=> $row['gratin'],
                	'price_stud_gratin'	=> $row['price_stud_gratin'],
                	'price_att_gratin'	=> $row['price_att_gratin'],
                	'mensavital'		=> $row['mensavital'],
                	'price_stud_mensavital'	=> $row['price_stud_mensavital'],
                	'price_att_mensavital'	=> $row['price_att_mensavital'],
                	'green_corner'		=> $row['green_corner'],
                	'price_stud_green_corner'=> $row['price_stud_green_corner'],
                	'price_att_green_corner' => $row['price_att_green_corner'],
            	);
             }
             
             // Return the reversed array with the original keys
             //return array_reverse($plans, true);
             return $plans;

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	// ================================================ Backend-Methods ==========================================================

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
             	echo '<span>Es sind keine Einträge vorhanden.</span>'
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

				case strstr($key, 'calenderweek'):
					$this->calenderweek = mysql_real_escape_string($value);
				break;

				case strstr($key, 'start_date'):
					$this->start = mysql_real_escape_string($value);
				break;

				// Monday
				case strstr($key, 'mon_'):
					$this->monday_meals[] = mysql_real_escape_string($value);
				break;

				case strstr($key, 'price_stud_mon_'):
					$this->monday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				case strstr($key, 'price_att_mon_'):
					$this->monday_att_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Tuesday
				case strstr($key, 'tue_'):
					$this->tuesday_meals[] = mysql_real_escape_string($value);
				break;

				case strstr($key, 'price_stud_tue_'):
					$this->tuesday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				case strstr($key, 'price_att_tue_'):
					$this->tuesday_att_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Wednesday
				case strstr($key, 'wed_'):
					$this->wednesday_meals[] = mysql_real_escape_string($value);
				break;

				case strstr($key, 'price_stud_wed_'):
					$this->wednesday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				case strstr($key, 'price_att_wed_'):
					$this->wednesday_att_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Thursday
				case strstr($key, 'thu_'):
					$this->thursday_meals[] = mysql_real_escape_string($value);
				break;

				case strstr($key, 'price_stud_thu_'):
					$this->thursday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				case strstr($key, 'price_att_thu_'):
					$this->thursday_att_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Friday
				case strstr($key, 'fri_'):
					$this->friday_meals[] = mysql_real_escape_string($value);
				break;

				case strstr($key, 'price_stud_fri_'):
					$this->friday_stud_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				case strstr($key, 'price_att_fri_'):
					$this->friday_att_prices[] = mysql_real_escape_string($this->checkComma($value));
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

			// insert Monday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														action, price_stud_action, price_att_action,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														mensavital, price_stud_mensavital, price_att_mensavital,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[0]."', '1',
					'".$this->monday_meals[0]."', '".$this->monday_meals[1]."', '".$this->monday_meals[2]."', '".$this->monday_meals[3]."', 
					'".$this->monday_meals[4]."', '".$this->monday_stud_prices[0]."', '".$this->monday_att_prices[0]."',
					'".$this->monday_meals[5]."', '".$this->monday_stud_prices[1]."', '".$this->monday_att_prices[1]."',
					'".$this->monday_meals[6]."', '".$this->monday_stud_prices[2]."', '".$this->monday_att_prices[2]."',
					'".$this->monday_meals[7]."', '".$this->monday_stud_prices[3]."', '".$this->monday_att_prices[3]."',
					'".$this->monday_meals[8]."', '".$this->monday_stud_prices[4]."', '".$this->monday_att_prices[4]."',
					'".$this->monday_meals[9]."', '".$this->monday_stud_prices[5]."', '".$this->monday_att_prices[5]."',
					'".$this->monday_meals[10]."', '".$this->monday_stud_prices[6]."', '".$this->monday_att_prices[6]."')");

			// insert tuesday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														action, price_stud_action, price_att_action,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														mensavital, price_stud_mensavital, price_att_mensavital,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[1]."', '2',
					'".$this->tuesday_meals[0]."', '".$this->tuesday_meals[1]."', '".$this->tuesday_meals[2]."', '".$this->tuesday_meals[3]."', 
					'".$this->tuesday_meals[4]."', '".$this->tuesday_stud_prices[0]."', '".$this->tuesday_att_prices[0]."',
					'".$this->tuesday_meals[5]."', '".$this->tuesday_stud_prices[1]."', '".$this->tuesday_att_prices[1]."',
					'".$this->tuesday_meals[6]."', '".$this->tuesday_stud_prices[2]."', '".$this->tuesday_att_prices[2]."',
					'".$this->tuesday_meals[7]."', '".$this->tuesday_stud_prices[3]."', '".$this->tuesday_att_prices[3]."',
					'".$this->tuesday_meals[8]."', '".$this->tuesday_stud_prices[4]."', '".$this->tuesday_att_prices[4]."',
					'".$this->tuesday_meals[9]."', '".$this->tuesday_stud_prices[5]."', '".$this->tuesday_att_prices[5]."',
					'".$this->tuesday_meals[10]."', '".$this->tuesday_stud_prices[6]."', '".$this->tuesday_att_prices[6]."')");

			// insert wednesday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														action, price_stud_action, price_att_action,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														mensavital, price_stud_mensavital, price_att_mensavital,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[2]."', '3',
					'".$this->wednesday_meals[0]."', '".$this->wednesday_meals[1]."', '".$this->wednesday_meals[2]."', '".$this->wednesday_meals[3]."', 
					'".$this->wednesday_meals[4]."', '".$this->wednesday_stud_prices[0]."', '".$this->wednesday_att_prices[0]."',
					'".$this->wednesday_meals[5]."', '".$this->wednesday_stud_prices[1]."', '".$this->wednesday_att_prices[1]."',
					'".$this->wednesday_meals[6]."', '".$this->wednesday_stud_prices[2]."', '".$this->wednesday_att_prices[2]."',
					'".$this->wednesday_meals[7]."', '".$this->wednesday_stud_prices[3]."', '".$this->wednesday_att_prices[3]."',
					'".$this->wednesday_meals[8]."', '".$this->wednesday_stud_prices[4]."', '".$this->wednesday_att_prices[4]."',
					'".$this->wednesday_meals[9]."', '".$this->wednesday_stud_prices[5]."', '".$this->wednesday_att_prices[5]."',
					'".$this->wednesday_meals[10]."', '".$this->wednesday_stud_prices[6]."', '".$this->wednesday_att_prices[6]."')");

			// insert thursday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														action, price_stud_action, price_att_action,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														mensavital, price_stud_mensavital, price_att_mensavital,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[3]."', '4',
					'".$this->thursday_meals[0]."', '".$this->thursday_meals[1]."', '".$this->thursday_meals[2]."', '".$this->thursday_meals[3]."', 
					'".$this->thursday_meals[4]."', '".$this->thursday_stud_prices[0]."', '".$this->thursday_att_prices[0]."',
					'".$this->thursday_meals[5]."', '".$this->thursday_stud_prices[1]."', '".$this->thursday_att_prices[1]."',
					'".$this->thursday_meals[6]."', '".$this->thursday_stud_prices[2]."', '".$this->thursday_att_prices[2]."',
					'".$this->thursday_meals[7]."', '".$this->thursday_stud_prices[3]."', '".$this->thursday_att_prices[3]."',
					'".$this->thursday_meals[8]."', '".$this->thursday_stud_prices[4]."', '".$this->thursday_att_prices[4]."',
					'".$this->thursday_meals[9]."', '".$this->thursday_stud_prices[5]."', '".$this->thursday_att_prices[5]."',
					'".$this->thursday_meals[10]."', '".$this->thursday_stud_prices[6]."', '".$this->thursday_att_prices[6]."')");

			// insert friday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														action, price_stud_action, price_att_action,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														mensavital, price_stud_mensavital, price_att_mensavital,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[4]."', '5',
					'".$this->friday_meals[0]."', '".$this->friday_meals[1]."', '".$this->friday_meals[2]."', '".$this->friday_meals[3]."', 
					'".$this->friday_meals[4]."', '".$this->friday_stud_prices[0]."', '".$this->friday_att_prices[0]."',
					'".$this->friday_meals[5]."', '".$this->friday_stud_prices[1]."', '".$this->friday_att_prices[1]."',
					'".$this->friday_meals[6]."', '".$this->friday_stud_prices[2]."', '".$this->friday_att_prices[2]."',
					'".$this->friday_meals[7]."', '".$this->friday_stud_prices[3]."', '".$this->friday_att_prices[3]."',
					'".$this->friday_meals[8]."', '".$this->friday_stud_prices[4]."', '".$this->friday_att_prices[4]."',
					'".$this->friday_meals[9]."', '".$this->friday_stud_prices[5]."', '".$this->friday_att_prices[5]."',
					'".$this->friday_meals[10]."', '".$this->friday_stud_prices[6]."', '".$this->friday_att_prices[6]."')");

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
	 * Edit a plan
	 * @param int $calenderweek
	 * @return Array Data
	 */
	public function editPlan($calenderweek){
		try{

			// dates
			$query = $this->DbCon->query("SELECT calenderweek, mealdate FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['calenderweek'] = $row['calenderweek'];
				$post['start_date'] = $row['mealdate'];
			}

			// Monday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['mon_meal_one'] = $row['meal_one'];
				$post['mon_meal_two'] = $row['meal_two'];
				$post['mon_side'] = $row['side'];
				$post['mon_hotpot'] = $row['hotpot'];
				$post['mon_bbq'] = $row['bbq'];
				$post['price_stud_mon_bbq'] = $row['price_stud_bbq'];
				$post['price_att_mon_bbq'] = $row['price_att_bbq'];
				$post['mon_pan'] = $row['pan'];
				$post['price_stud_mon_pan'] = $row['price_stud_pan'];
				$post['price_att_mon_pan'] = $row['price_att_pan'];
				$post['mon_action'] = $row['action'];
				$post['price_stud_mon_action'] = $row['price_stud_action'];
				$post['price_att_mon_action'] = $row['price_att_action'];
				$post['mon_wok'] = $row['wok'];
				$post['price_stud_mon_wok'] = $row['price_stud_wok'];
				$post['price_att_mon_wok'] = $row['price_att_wok'];
				$post['mon_gratin'] = $row['gratin'];
				$post['price_stud_mon_gratin'] = $row['price_stud_gratin'];
				$post['price_att_mon_gratin'] = $row['price_att_gratin'];
				$post['mon_mensavital'] = $row['mensavital'];
				$post['price_stud_mon_mensavital'] = $row['price_stud_mensavital'];
				$post['price_att_mon_mensavital'] = $row['price_att_mensavital'];
				$post['mon_green_corner'] = $row['green_corner'];
				$post['price_stud_mon_green_corner'] = $row['price_stud_green_corner'];
				$post['price_att_mon_green_corner'] = $row['price_att_green_corner'];
			}

			// Tuesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 2");
			while($row = $query->fetch_assoc()){
				$post['tue_meal_one'] = $row['meal_one'];
				$post['tue_meal_two'] = $row['meal_two'];
				$post['tue_side'] = $row['side'];
				$post['tue_hotpot'] = $row['hotpot'];
				$post['tue_bbq'] = $row['bbq'];
				$post['price_stud_tue_bbq'] = $row['price_stud_bbq'];
				$post['price_att_tue_bbq'] = $row['price_att_bbq'];
				$post['tue_pan'] = $row['pan'];
				$post['price_stud_tue_pan'] = $row['price_stud_pan'];
				$post['price_att_tue_pan'] = $row['price_att_pan'];
				$post['tue_action'] = $row['action'];
				$post['price_stud_tue_action'] = $row['price_stud_action'];
				$post['price_att_tue_action'] = $row['price_att_action'];
				$post['tue_wok'] = $row['wok'];
				$post['price_stud_tue_wok'] = $row['price_stud_wok'];
				$post['price_att_tue_wok'] = $row['price_att_wok'];
				$post['tue_gratin'] = $row['gratin'];
				$post['price_stud_tue_gratin'] = $row['price_stud_gratin'];
				$post['price_att_tue_gratin'] = $row['price_att_gratin'];
				$post['tue_mensavital'] = $row['mensavital'];
				$post['price_stud_tue_mensavital'] = $row['price_stud_mensavital'];
				$post['price_att_tue_mensavital'] = $row['price_att_mensavital'];
				$post['tue_green_corner'] = $row['green_corner'];
				$post['price_stud_tue_green_corner'] = $row['price_stud_green_corner'];
				$post['price_att_tue_green_corner'] = $row['price_att_green_corner'];
			}

			// Wednesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 3");
			while($row = $query->fetch_assoc()){
				$post['wed_meal_one'] = $row['meal_one'];
				$post['wed_meal_two'] = $row['meal_two'];
				$post['wed_side'] = $row['side'];
				$post['wed_hotpot'] = $row['hotpot'];
				$post['wed_bbq'] = $row['bbq'];
				$post['price_stud_wed_bbq'] = $row['price_stud_bbq'];
				$post['price_att_wed_bbq'] = $row['price_att_bbq'];
				$post['wed_pan'] = $row['pan'];
				$post['price_stud_wed_pan'] = $row['price_stud_pan'];
				$post['price_att_wed_pan'] = $row['price_att_pan'];
				$post['wed_action'] = $row['action'];
				$post['price_stud_wed_action'] = $row['price_stud_action'];
				$post['price_att_wed_action'] = $row['price_att_action'];
				$post['wed_wok'] = $row['wok'];
				$post['price_stud_wed_wok'] = $row['price_stud_wok'];
				$post['price_att_wed_wok'] = $row['price_att_wok'];
				$post['wed_gratin'] = $row['gratin'];
				$post['price_stud_wed_gratin'] = $row['price_stud_gratin'];
				$post['price_att_wed_gratin'] = $row['price_att_gratin'];
				$post['wed_mensavital'] = $row['mensavital'];
				$post['price_stud_wed_mensavital'] = $row['price_stud_mensavital'];
				$post['price_att_wed_mensavital'] = $row['price_att_mensavital'];
				$post['wed_green_corner'] = $row['green_corner'];
				$post['price_stud_wed_green_corner'] = $row['price_stud_green_corner'];
				$post['price_att_wed_green_corner'] = $row['price_att_green_corner'];
			}

			// Thursday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 4");
			while($row = $query->fetch_assoc()){
				$post['thu_meal_one'] = $row['meal_one'];
				$post['thu_meal_two'] = $row['meal_two'];
				$post['thu_side'] = $row['side'];
				$post['thu_hotpot'] = $row['hotpot'];
				$post['thu_bbq'] = $row['bbq'];
				$post['price_stud_thu_bbq'] = $row['price_stud_bbq'];
				$post['price_att_thu_bbq'] = $row['price_att_bbq'];
				$post['thu_pan'] = $row['pan'];
				$post['price_stud_thu_pan'] = $row['price_stud_pan'];
				$post['price_att_thu_pan'] = $row['price_att_pan'];
				$post['thu_action'] = $row['action'];
				$post['price_stud_thu_action'] = $row['price_stud_action'];
				$post['price_att_thu_action'] = $row['price_att_action'];
				$post['thu_wok'] = $row['wok'];
				$post['price_stud_thu_wok'] = $row['price_stud_wok'];
				$post['price_att_thu_wok'] = $row['price_att_wok'];
				$post['thu_gratin'] = $row['gratin'];
				$post['price_stud_thu_gratin'] = $row['price_stud_gratin'];
				$post['price_att_thu_gratin'] = $row['price_att_gratin'];
				$post['thu_mensavital'] = $row['mensavital'];
				$post['price_stud_thu_mensavital'] = $row['price_stud_mensavital'];
				$post['price_att_thu_mensavital'] = $row['price_att_mensavital'];
				$post['thu_green_corner'] = $row['green_corner'];
				$post['price_stud_thu_green_corner'] = $row['price_stud_green_corner'];
				$post['price_att_thu_green_corner'] = $row['price_att_green_corner'];
			}

			// Friday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 5");
			while($row = $query->fetch_assoc()){
				$post['fri_meal_one'] = $row['meal_one'];
				$post['fri_meal_two'] = $row['meal_two'];
				$post['fri_side'] = $row['side'];
				$post['fri_hotpot'] = $row['hotpot'];
				$post['fri_bbq'] = $row['bbq'];
				$post['price_stud_fri_bbq'] = $row['price_stud_bbq'];
				$post['price_att_fri_bbq'] = $row['price_att_bbq'];
				$post['fri_pan'] = $row['pan'];
				$post['price_stud_fri_pan'] = $row['price_stud_pan'];
				$post['price_att_fri_pan'] = $row['price_att_pan'];
				$post['fri_action'] = $row['action'];
				$post['price_stud_fri_action'] = $row['price_stud_action'];
				$post['price_att_fri_action'] = $row['price_att_action'];
				$post['fri_wok'] = $row['wok'];
				$post['price_stud_fri_wok'] = $row['price_stud_wok'];
				$post['price_att_fri_wok'] = $row['price_att_wok'];
				$post['fri_gratin'] = $row['gratin'];
				$post['price_stud_fri_gratin'] = $row['price_stud_gratin'];
				$post['price_att_fri_gratin'] = $row['price_att_gratin'];
				$post['fri_mensavital'] = $row['mensavital'];
				$post['price_stud_fri_mensavital'] = $row['price_stud_mensavital'];
				$post['price_att_fri_mensavital'] = $row['price_att_mensavital'];
				$post['fri_green_corner'] = $row['green_corner'];
				$post['price_stud_fri_green_corner'] = $row['price_stud_green_corner'];
				$post['price_att_fri_green_corner'] = $row['price_att_green_corner'];
			}

			return $post;

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
}

 
/* End of file mensa.php */
/* Location: ./models/mensa.php */