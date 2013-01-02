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
	 * Queries all plans for the choosing-site
	 */
	public function getAllPlans(){
		try{

			$query = $this->DbCon->query("SELECT id, calenderweek FROM meals");
			while($row = $query->fetch_assoc()){

                $plans[] = array(
                	'id'			=> $row['id'],
                	'calenderweek' 	=> $row['calenderweek'],
                	'start_date'	=> '24.12.2012',
                	'end_date'		=> '28.12.2012'
            	);
             }

             return $plans;

		} catch (Exception $e){
			echo $e->getMessage();
		}
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
					$this->calenderweek = $value;
				break;

				case strstr($key, 'mealdate'):
					$this->mealdate = $value;
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
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate."', '1',
					'".$this->monday_meals[0]."', '".$this->monday_meals[1]."', '".$this->monday_meals[2]."', '".$this->monday_meals[3]."', 
					'".$this->monday_meals[4]."', '".$this->monday_stud_prices[0]."', '".$this->monday_att_prices[0]."',
					'".$this->monday_meals[5]."', '".$this->monday_stud_prices[1]."', '".$this->monday_att_prices[1]."',
					'".$this->monday_meals[6]."', '".$this->monday_stud_prices[2]."', '".$this->monday_att_prices[2]."',
					'".$this->monday_meals[7]."', '".$this->monday_stud_prices[3]."', '".$this->monday_att_prices[3]."',
					'".$this->monday_meals[8]."', '".$this->monday_stud_prices[4]."', '".$this->monday_att_prices[4]."',
					'".$this->monday_meals[9]."', '".$this->monday_stud_prices[5]."', '".$this->monday_att_prices[5]."',
					'".$this->monday_meals[10]."', '".$this->monday_stud_prices[6]."', '".$this->monday_att_prices[6]."',
					'".$this->monday_meals[11]."', '".$this->monday_stud_prices[7]."', '".$this->monday_att_prices[7]."')");

			// insert tuesday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate."', '1',
					'".$this->tuesday_meals[0]."', '".$this->tuesday_meals[1]."', '".$this->tuesday_meals[2]."', '".$this->tuesday_meals[3]."', 
					'".$this->tuesday_meals[4]."', '".$this->tuesday_stud_prices[0]."', '".$this->tuesday_att_prices[0]."',
					'".$this->tuesday_meals[5]."', '".$this->tuesday_stud_prices[1]."', '".$this->tuesday_att_prices[1]."',
					'".$this->tuesday_meals[6]."', '".$this->tuesday_stud_prices[2]."', '".$this->tuesday_att_prices[2]."',
					'".$this->tuesday_meals[7]."', '".$this->tuesday_stud_prices[3]."', '".$this->tuesday_att_prices[3]."',
					'".$this->tuesday_meals[8]."', '".$this->tuesday_stud_prices[4]."', '".$this->tuesday_att_prices[4]."',
					'".$this->tuesday_meals[9]."', '".$this->tuesday_stud_prices[5]."', '".$this->tuesday_att_prices[5]."',
					'".$this->tuesday_meals[10]."', '".$this->tuesday_stud_prices[6]."', '".$this->tuesday_att_prices[6]."',
					'".$this->tuesday_meals[11]."', '".$this->tuesday_stud_prices[7]."', '".$this->tuesday_att_prices[7]."')");

			// insert wednesday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate."', '1',
					'".$this->wednesday_meals[0]."', '".$this->wednesday_meals[1]."', '".$this->wednesday_meals[2]."', '".$this->wednesday_meals[3]."', 
					'".$this->wednesday_meals[4]."', '".$this->wednesday_stud_prices[0]."', '".$this->wednesday_att_prices[0]."',
					'".$this->wednesday_meals[5]."', '".$this->wednesday_stud_prices[1]."', '".$this->wednesday_att_prices[1]."',
					'".$this->wednesday_meals[6]."', '".$this->wednesday_stud_prices[2]."', '".$this->wednesday_att_prices[2]."',
					'".$this->wednesday_meals[7]."', '".$this->wednesday_stud_prices[3]."', '".$this->wednesday_att_prices[3]."',
					'".$this->wednesday_meals[8]."', '".$this->wednesday_stud_prices[4]."', '".$this->wednesday_att_prices[4]."',
					'".$this->wednesday_meals[9]."', '".$this->wednesday_stud_prices[5]."', '".$this->wednesday_att_prices[5]."',
					'".$this->wednesday_meals[10]."', '".$this->wednesday_stud_prices[6]."', '".$this->wednesday_att_prices[6]."',
					'".$this->wednesday_meals[11]."', '".$this->wednesday_stud_prices[7]."', '".$this->wednesday_att_prices[7]."')");

			// insert thursday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate."', '1',
					'".$this->thursday_meals[0]."', '".$this->thursday_meals[1]."', '".$this->thursday_meals[2]."', '".$this->thursday_meals[3]."', 
					'".$this->thursday_meals[4]."', '".$this->thursday_stud_prices[0]."', '".$this->thursday_att_prices[0]."',
					'".$this->thursday_meals[5]."', '".$this->thursday_stud_prices[1]."', '".$this->thursday_att_prices[1]."',
					'".$this->thursday_meals[6]."', '".$this->thursday_stud_prices[2]."', '".$this->thursday_att_prices[2]."',
					'".$this->thursday_meals[7]."', '".$this->thursday_stud_prices[3]."', '".$this->thursday_att_prices[3]."',
					'".$this->thursday_meals[8]."', '".$this->thursday_stud_prices[4]."', '".$this->thursday_att_prices[4]."',
					'".$this->thursday_meals[9]."', '".$this->thursday_stud_prices[5]."', '".$this->thursday_att_prices[5]."',
					'".$this->thursday_meals[10]."', '".$this->thursday_stud_prices[6]."', '".$this->thursday_att_prices[6]."',
					'".$this->thursday_meals[11]."', '".$this->thursday_stud_prices[7]."', '".$this->thursday_att_prices[7]."')");

			// insert friday
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_stud_bbq, price_att_bbq,
														pan, price_stud_pan, price_att_pan,
														wok, price_stud_wok, price_att_wok,
														gratin, price_stud_gratin, price_att_gratin,
														weekoffer, price_stud_weekoffer, price_att_weekoffer,
														special, price_stud_special, price_att_special,
														action, price_stud_action, price_att_action,
														green_corner, price_stud_green_corner, price_att_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate."', '1',
					'".$this->friday_meals[0]."', '".$this->friday_meals[1]."', '".$this->friday_meals[2]."', '".$this->friday_meals[3]."', 
					'".$this->friday_meals[4]."', '".$this->friday_stud_prices[0]."', '".$this->friday_att_prices[0]."',
					'".$this->friday_meals[5]."', '".$this->friday_stud_prices[1]."', '".$this->friday_att_prices[1]."',
					'".$this->friday_meals[6]."', '".$this->friday_stud_prices[2]."', '".$this->friday_att_prices[2]."',
					'".$this->friday_meals[7]."', '".$this->friday_stud_prices[3]."', '".$this->friday_att_prices[3]."',
					'".$this->friday_meals[8]."', '".$this->friday_stud_prices[4]."', '".$this->friday_att_prices[4]."',
					'".$this->friday_meals[9]."', '".$this->friday_stud_prices[5]."', '".$this->friday_att_prices[5]."',
					'".$this->friday_meals[10]."', '".$this->friday_stud_prices[6]."', '".$this->friday_att_prices[6]."',
					'".$this->friday_meals[11]."', '".$this->friday_stud_prices[7]."', '".$this->friday_att_prices[7]."')");

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Delete a plan
	 * @param int $calenderweek
	 */
	public function deletePlan($calenderweek){
		try{
			$this->DbCon->query("DELETE FROM meals WHERE calenderweek = '".$calenderweek."'");
			echo 'Plan der Kalenderwoche'.$calenderweek.'gelöscht';
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
	 * Edit a plan
	 * @param int $calenderweek
	 */
	public function editPlan($calenderweek){
		try{

			// Monday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
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
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 2");
			while($row = $query->fetch_assoc()){
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
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 3");
			while($row = $query->fetch_assoc()){
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
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 4");
			while($row = $query->fetch_assoc()){
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
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 5");
			while($row = $query->fetch_assoc()){
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
}

 
/* End of file mensa.php */
/* Location: ./models/mensa.php */