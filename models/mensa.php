<?php
/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM) <fabian.martinovic@fh-duesseldorf.de>, Tobias Emde (TE) <tobias.emde@gmx.de>
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
<<<<<<< HEAD
<<<<<<< HEAD
	 * Calenderweek
	 * @var int Calenderweek
=======
	 * Kalenderwoche
	 * @var int calenderweek
>>>>>>> origin/daniel16.02
=======
	 * Calenderweek
	 * @var int Calenderweek
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	 */
	private $calenderweek;

	/**
<<<<<<< HEAD
<<<<<<< HEAD
	 * Date of the day where the monday_meals is served
=======
	 * Datum des Tages an dem das Montagsessen serviert wird
>>>>>>> origin/daniel16.02
=======
	 * Date of the day where the monday_meals is served
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	 * @var Date
	 */
	private $mealdate;

	/**
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	 * Arrays with monday_mealss for each day
	 * @var Array
	 */
	private $monday_meals;
	private $tuesday_meals;
	private $wednesday_meals;
	private $thursday_meals;
	private $friday_meals;
<<<<<<< HEAD

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
=======

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
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	private $monday_att_prices;
	private $tuesday_att_prices;
	private $wednesday_att_prices;
	private $thursday_att_prices;
	private $friday_att_prices;
<<<<<<< HEAD
=======
	 * Startdatum aus dem Formular
	 * @var String Date
	 */
	private $start;


	/**
	 * Feiertagsvariablen
	 * @var String Holiday
	 */
	private $mon_holiday;
	private $tue_holiday;
	private $wed_holiday;
	private $thu_holiday;
	private $fri_holiday;

	/**
	 * Arrays mit den Mahlzeiten
	 * @var Array
	 */
	private $monday_meals;
	private $tuesday_meals;
	private $wednesday_meals;
	private $thursday_meals;
	private $friday_meals;

	/**
	 * Arrays mit den Studentenpreisen
	 * @var Array
	 */
	private $monday_prices;
	private $tuesday_prices;
	private $wednesday_prices;
	private $thursday_prices;
	private $friday_prices;
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7



	/**
	 * Constructor
	 */
	public function __construct(){
		// database-connection öffnen
		$this->DbCon = new mysqli();
		$this->DbCon->connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);
	}

	// ================================================ Frontend-Methods =========================================================

	/**
	 * Pläne für die nächsten 5 Wochen abgefragt
	 * @return Array $plans
	 */
	public function getCanteenPlans(){
		try{

			// Datenbankabfrage
			$query = $this->DbCon->query("SELECT * 
										FROM meals AS m
										INNER JOIN days AS d ON m.day_id = d.id
										WHERE m.calenderweek
										BETWEEN DATE_FORMAT(NOW(), '%v')
										AND DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP( )+2419200 ), '%v')
										ORDER BY m.mealdate ASC");

			// Ergebnisse verarbeiten
			while($row = $query->fetch_assoc()){
                $plans[$row['calenderweek']][$row['day_id']] = array(
                	'Calenderweek'		=> $row['calenderweek'],
                	'mealdate'			=> $row['mealdate'],
                	'holiday'			=> $row['holiday'],
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
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
=======
	 * Zusatzstoffe abfragen
=======
	 * Zusatzstoffe werden abgefragt
>>>>>>> parent of 2f031bb... Mensakommentare angepasst + Erklärungen
	 * @return Array $additives
	 */
	public function getAdditives(){
		try{
			// Datenbankabfrage
			$query = $this->DbCon->query("SELECT * FROM additives");

			// Verarbeitung der Ergebnisse
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
	 * Öffnungszeiten werden abgefragt
	 * @return Array $openHour
	 */
	public function getOpeningHours(){
		try{
			// Datenbankabfrage
			$query = $this->DbCon->query("SELECT * FROM canteens");

			// Verarbeitung der Ergebnisse
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
	 * Berechnung der Kalenderwoche
	 * @param Date $date
	 */
	private function calculateCalenderweek($date){
		$this->calenderweek = date("W", strtotime($date));
	}


	/**
	 * Abfrage aller Pläne für die Auswahlseite
	 * @return Array $plan
	 */
	public function getAllPlans(){
		try{
			// Datenbankabfrage
			$query = $this->DbCon->query("SELECT calenderweek, mealdate FROM meals GROUP BY calenderweek ORDER BY mealdate DESC");

			// Verarbeitung der Ergebnisse
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
>>>>>>> origin/daniel16.02

		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
<<<<<<< HEAD
	 * Query all existing canteens
	 */
	/*public function getCanteens(){
=======
	 * Queries all plans for the choosing-site
	 */
	public function getAllPlans(){
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
	}*/


<<<<<<< HEAD
=======
	 * Verarbeitung der POST-Daten
	 * @param Array $_POST
	 */
>>>>>>> origin/daniel16.02
=======
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


>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	public function proceedPost($post){

		foreach($post as $key => $value){

			switch($key){

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
				case strstr($key, 'start_date'):
					$this->calculateCalenderweek($value);
					$this->start = mysql_real_escape_string($value);
				break;

				// Holiday-Handling
				case strstr($key, 'mon_hol'):
					$this->mon_holiday = mysql_real_escape_string($value);
				break;

				case strstr($key, 'tue_hol'):
					$this->tue_holiday = mysql_real_escape_string($value);
				break;

				case strstr($key, 'wed_hol'):
					$this->wed_holiday = mysql_real_escape_string($value);
				break;

				case strstr($key, 'thu_hol'):
					$this->thu_holiday = mysql_real_escape_string($value);
				break;

				case strstr($key, 'fri_hol'):
					$this->fri_holiday = mysql_real_escape_string($value);
				break;

				// Monday
				case strstr($key, 'mon_'):
					empty($value) ? $this->monday_meals[] = null : $this->monday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_mon_'):
					$this->monday_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Tuesday
				case strstr($key, 'tue_'):
					empty($value) ? $this->tuesday_meals[] = null : $this->tuesday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_tue_'):
					$this->tuesday_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Wednesday
				case strstr($key, 'wed_'):
					empty($value) ? $this->wednesday_meals[] = null : $this->wednesday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_wed_'):
					$this->wednesday_prices[] = mysql_real_escape_string($this->checkComma($value));
				break;

				// Thursday
				case strstr($key, 'thu_'):
					empty($value) ? $this->thursday_meals[] = null : $this->thursday_meals[] = nl2br($value);
				break;

				case strstr($key, 'price_thu_'):
					$this->thursday_prices[] = mysql_real_escape_string($this->checkComma($value));
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
				break;

				// Friday
				case strstr($key, 'fri_'):
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
					$this->friday_meals[] = $value;
				break;

				case strstr($key, 'price_stud_fri_'):
					$this->friday_stud_prices[] = $value;
<<<<<<< HEAD
=======
					empty($value) ? $this->friday_meals[] = null : $this->friday_meals[] = nl2br($value);
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
				break;

				case strstr($key, 'price_fri_'):$this->friday_prices[] = mysql_real_escape_string($this->checkComma($value));
>>>>>>> origin/daniel16.02
				break;
			}
		}

<<<<<<< HEAD
<<<<<<< HEAD
				case strstr($key, 'price_att_fri_'):
					$this->friday_att_prices[] = $value;
				break;
=======
		// Daten der übrigen Tage berechnen
=======
		// Daten der übrigen tage berechnen
>>>>>>> parent of 2f031bb... Mensakommentare angepasst + Erklärungen
		$start = strtotime($this->start);
		for($i = 0; $i<=4; $i++){
			$this->mealdate[$i] = date("Y-m-d", $start+($i*86400));
		}
	}



	/**
	 * Preise auf Komma oder Punkt checken
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
	 * Plan in Datenbank einfügen
	 * @param Array $get
	 */
	public function insertPlan($get){

		if($this->calenderweek>0 && $this->calenderweek<=52 && !empty($this->mealdate)){

			try{
			// alte Einträge löschen
			if(isset($get) && $get['mode'] == 'edit'){
				$this->DbCon->query("DELETE FROM meals WHERE calenderweek = ".$get['cw']);
			}

			// neuen Plan komplett einfügen
			$this->DbCon->query("INSERT INTO meals (calenderweek, mealdate, holiday, day_id, 
														meal_one, meal_two, side, hotpot,
														bbq, price_bbq,
														pan, price_pan,
														action, price_action,
														wok, price_wok,
														gratin, price_gratin,
														mensavital, price_mensavital,
														green_corner, price_green_corner) 
			VALUES ('".$this->calenderweek."', '".$this->mealdate[0]."','".$this->mon_holiday."', '1',
					'".$this->monday_meals[0]."', '".$this->monday_meals[1]."', '".$this->monday_meals[2]."', '".$this->monday_meals[3]."', 
					'".$this->monday_meals[4]."', '".$this->monday_prices[0]."',
					'".$this->monday_meals[5]."', '".$this->monday_prices[1]."',
					'".$this->monday_meals[6]."', '".$this->monday_prices[2]."',
					'".$this->monday_meals[7]."', '".$this->monday_prices[3]."',
					'".$this->monday_meals[8]."', '".$this->monday_prices[4]."',
					'".$this->monday_meals[9]."', '".$this->monday_prices[5]."',
					'".$this->monday_meals[10]."', '".$this->monday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[1]."','".$this->tue_holiday."', '2',
					'".$this->tuesday_meals[0]."', '".$this->tuesday_meals[1]."', '".$this->tuesday_meals[2]."', '".$this->tuesday_meals[3]."', 
					'".$this->tuesday_meals[4]."', '".$this->tuesday_prices[0]."',
					'".$this->tuesday_meals[5]."', '".$this->tuesday_prices[1]."',
					'".$this->tuesday_meals[6]."', '".$this->tuesday_prices[2]."',
					'".$this->tuesday_meals[7]."', '".$this->tuesday_prices[3]."',
					'".$this->tuesday_meals[8]."', '".$this->tuesday_prices[4]."',
					'".$this->tuesday_meals[9]."', '".$this->tuesday_prices[5]."',
					'".$this->tuesday_meals[10]."', '".$this->tuesday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[2]."','".$this->wed_holiday."', '3',
					'".$this->wednesday_meals[0]."', '".$this->wednesday_meals[1]."', '".$this->wednesday_meals[2]."', '".$this->wednesday_meals[3]."', 
					'".$this->wednesday_meals[4]."', '".$this->wednesday_prices[0]."',
					'".$this->wednesday_meals[5]."', '".$this->wednesday_prices[1]."',
					'".$this->wednesday_meals[6]."', '".$this->wednesday_prices[2]."',
					'".$this->wednesday_meals[7]."', '".$this->wednesday_prices[3]."',
					'".$this->wednesday_meals[8]."', '".$this->wednesday_prices[4]."',
					'".$this->wednesday_meals[9]."', '".$this->wednesday_prices[5]."',
					'".$this->wednesday_meals[10]."', '".$this->wednesday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[3]."','".$this->thu_holiday."', '4',
					'".$this->thursday_meals[0]."', '".$this->thursday_meals[1]."', '".$this->thursday_meals[2]."', '".$this->thursday_meals[3]."', 
					'".$this->thursday_meals[4]."', '".$this->thursday_prices[0]."',
					'".$this->thursday_meals[5]."', '".$this->thursday_prices[1]."',
					'".$this->thursday_meals[6]."', '".$this->thursday_prices[2]."',
					'".$this->thursday_meals[7]."', '".$this->thursday_prices[3]."',
					'".$this->thursday_meals[8]."', '".$this->thursday_prices[4]."',
					'".$this->thursday_meals[9]."', '".$this->thursday_prices[5]."',
					'".$this->thursday_meals[10]."', '".$this->thursday_prices[6]."'),
					('".$this->calenderweek."', '".$this->mealdate[4]."','".$this->fri_holiday."', '5',
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
>>>>>>> origin/daniel16.02
			}
		}
	}

<<<<<<< HEAD


	/**
<<<<<<< HEAD
=======


	/**
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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

<<<<<<< HEAD
=======
	 * Einen Plan löschen
	 * @param int $calenderweek
	 */
	public function deletePlan($calenderweek){
		try{
			$cw = $_GET['cw'];
			$this->DbCon->query("DELETE FROM meals WHERE calenderweek = ".$calenderweek);
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}



	/**
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
	 * br-Tags durch Leerzeichen ersetzen
	 * @param String $text
	 * @return String 
	 */
	public function replaceBR($text){
		return str_replace("<br />", "", $text);
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	}



	/**
<<<<<<< HEAD
<<<<<<< HEAD
	 * Edit a plan
	 * @param int $calenderweek
=======
	 * Einen Plan editieren
	 * @param int $calenderweek
	 * @return Array Data
>>>>>>> origin/daniel16.02
=======
	 * Edit a plan
	 * @param int $calenderweek
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
	 */
	public function editPlan($calenderweek){
		try{

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
			// Kalenderwoche herausfinden anhand des Montags der Woche
			$query = $this->DbCon->query("SELECT mealdate FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['start_date'] = $row['mealdate'];
			}

			// Monday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 1");
			while($row = $query->fetch_assoc()){
				$post['mon_holiday'] = $row['holiday'];
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
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			}

			// Tuesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 2");
			while($row = $query->fetch_assoc()){
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
				$post['tue_holiday'] = $row['holiday'];
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
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			}

			// Wednesday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 3");
			while($row = $query->fetch_assoc()){
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
				$post['wed_holiday'] = $row['holiday'];
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
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			}

			// Thursday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 4");
			while($row = $query->fetch_assoc()){
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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
<<<<<<< HEAD
=======
				$post['thu_holiday'] = $row['holiday'];
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
>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
			}

			// Friday
			$query = $this->DbCon->query("SELECT * FROM meals WHERE calenderweek = ".$calenderweek." AND day_id = 5");
			while($row = $query->fetch_assoc()){
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
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

<<<<<<< HEAD
=======
				$post['fri_holiday'] = $row['holiday'];
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

>>>>>>> origin/daniel16.02
=======
>>>>>>> f9553293b59511910e04ea3b3db00b1d87a108c7
		} catch (Exception $e){
			echo $e->getMessage();
		}
	}
}

 
/* End of file mensa.php */
/* Location: ./models/mensa.php */