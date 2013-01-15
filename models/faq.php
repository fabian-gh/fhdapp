<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class Faq {
	
	//Globale Variable zur �berpr�fung ob alle SQL Abfragen bgeschickt wurden
	public $checkDBInsert = 0;

	 /**
     * Kontrolliert Daten auf vollst�ndigkeit und richtige eingabewerte
     *
     */
    public function controllInput($data){
		// check ob eingabe und �berpr�fung
		if($data['inputArt'] == 1){
			$checkOverall = true;
			for ($i = 1; $i <= $data['anzahl']; $i++) {
				// �berpr�fung ob die Sortierung eine Zahl ist
				$checkSort = filter_var($data['sort'.$i], FILTER_VALIDATE_INT);
				if ($checkSort === false) 
				{ 
					// invalide
					echo "Sortierung muss eine Zahl sein<br />"; 
					$checkOverall = false;
				} 
				// �berpr�fung ob die Sprach ID eine Zahl ist
				$checkLang = filter_var($data['lang'.$i], FILTER_VALIDATE_INT);
				if ($checkLang === false) 
				{ 
					// invalide
					echo "Sprach ID muss eine Zahl sein<br />"; 
					$checkOverall = false;
				} 
				// �berpr�fung ob Frage eingegeben wurde
				if (empty($data['question'.$i])) {
					echo 'Es muss eine Frage eingegeben werden<br />';
					$checkOverall = false;
				}
				// �berpr�fung ob Antwort eingegeben wurde
				if (empty($data['answer'.$i])) {
					echo 'Es muss eine Antwort eingegeben werden <br />';
					$checkOverall = false;
				}
				//Wenn alles ok dann Insert Statement erstellen
				if($checkOverall === true){
					$this->createInsertStatementFaq($data);
				}
			}
		}
		
		// check ob update und �berpr�fung
		if($data['inputArt'] == 2){
			$checkOverall = true;
			// �berpr�fung ob die Sortierung eine Zahl ist
			$checkSort = filter_var($data['sort'], FILTER_VALIDATE_INT);
			if ($checkSort === false) 
			{ 
				// invalide
				echo "Sortierung muss eine Zahl sein<br />"; 
				$checkOverall = false;
			} 
			// �berpr�fung ob die Sprach ID eine Zahl ist
			$checkLang = filter_var($data['lang'], FILTER_VALIDATE_INT);
			if ($checkLang === false) 
			{ 
				// invalide
				echo "Sprach ID muss eine Zahl sein<br />"; 
				$checkOverall = false;
			} 
			// �berpr�fung ob Frage eingegeben wurde
			if (empty($data['question'])) {
				echo 'Es muss eine Frage eingegeben werden<br />';
				$checkOverall = false;
			}
			// �berpr�fung ob Antwort eingegeben wurde
			if (empty($data['answer'])) {
				echo 'Es muss eine Antwort eingegeben werden <br />';
				$checkOverall = false;
			}
			//Wenn alles ok dann Update Statement erstellen
			if($checkOverall === true){
				$this->updateFaq($data);
			}
		}
    }
	
//INSERT Befehle erstellen
	
	/**
     * Statement zum einf�gen einer FAQ in die Datenbank erstellen
     *
     */
	public function createInsertStatementFaq($data){
		 try{
			// Werte aneinanderreihen 
			$values = '';
			for ($i = 1; $i <= $data['anzahl']; $i++) {
			
				$lang = $data['lang'.$i];
				$question = $data['question'.$i];
				$answer = $data['answer'.$i];
				$sort = $data['sort'.$i];
				$dept = $data['departmentID'.$i];
				$user = $data['usertypeID'.$i];
				
				// Abfrage erstellen
				$insert = "INSERT INTO faq (language_id, question, answer, sorting) VALUES ('$lang', '$question', '$answer', '$sort')";
				
				// Fertige SQL-Abfrage an Methode zum speichern �bergeben return wert ID des eintrags
				$faqID = $this->intoDB($insert, true);

				//SQL Abfrage f�r FAQ_mm_Departments erstellen und ausf�hren
				$this->createInsertStatementFaq_Dept($faqID, $dept);
				
				//SQL Abfrage f�r FAQ_mm_Usertypes erstellen und ausf�hren
				$this->createInsertStatementFaq_User($faqID, $user);
				
				// �berpr�fung ob alles in Datenbank gespeichert wurde
				if($this->checkDBInsert == 3){
					echo "<br /> Ihre Eingaben wurden erfolgreich gespeichert.";
				}else{
					echo "<br/> Fehler!!!";
				}
				//R�cksetzen der Variable
				$this->checkDBInsert == 0;
			}
        } catch(Exception $e){
            echo $e->getMessage();
        }
	}
	
	/**
     * Statement zum einf�gen einer beziehung zwischen FAQ und Departments in die Datenbank erstellen
     *
     */
	public function createInsertStatementFaq_Dept($faqID, $dept){
		// Abfrage erstellen
		if($dept == 100){
			$resultSetDepartments = $this->createReadStatementDepartments();
			$insert = "INSERT INTO faq_mm_departments (faq_id, department_id) VALUES ";
			for($n=0; $n<count($resultSetDepartments); $n++) {
				$deptId = $resultSetDepartments[$n]['id'];
				if($n ==0){
					$insert .= "('$faqID', '$deptId')";
				}
				else{
					$insert .= ",('$faqID', '$deptId')";
				}
			}
		}else{
			$insert = "INSERT INTO faq_mm_departments (faq_id, department_id) VALUES ('$faqID', '$dept')";
		}
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, true);
	}
	
	/**
     * Statement zum einf�gen einer beziehung zwischen FAQ und Usertypes in die Datenbank erstellen
     *
     */
	public function createInsertStatementFaq_User($faqID, $user){
		// Abfrage erstellen
		$insert = "INSERT INTO faq_mm_usertype (faq_id, usertype_id) VALUES ('$faqID', '$user')";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, true);
	}
	
//DELETE Befehle Erstellen	
	
	/**
     * L�schen einer FAQ inclusive beziehungen
     *
     */
	public function deleteFAQ($id){
		
		//Beziehung Departments l�schen
		$this->createDeleteStatementDepartment($id);
		//Beziehung Usertyp l�schen
		$this->createDeleteStatementUsertyp($id);
		//FAQ l�schen
		$this->createDeleteStatementFaq($id);
		// �berpr�fung ob alles in Datenbank gel�scht wurde
		if($this->checkDBInsert == 3){
			echo "<br/> Die FAQ wurde erfolgreich gel�scht. <br/> <br/>";
		}else{
			echo "<br/> Fehler!!!";
		}
		//R�cksetzen der Variable
		$this->checkDBInsert == 0;
		
	}
	/**
     * Statement zum l�schen einer FAQ
     *
     */
	public function createDeleteStatementFaq($id){
		// Abfrage f�r FAQ erstellen
		$insert = "DELETE FROM faq WHERE id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, false);
		
	}
	
	/**
     * Statement zum l�schen einer beziehung zwischen FAQ und Department
     *
     */
	public function createDeleteStatementDepartment($id){
		// Abfrage f�r FAQ erstellen
		$insert = "DELETE FROM faq_mm_departments WHERE faq_id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, false);
		
	}
	
	/**
     * Statement zum l�schen einer beziehung zwischen FAQ und Usertypes
     *
     */
	public function createDeleteStatementUsertyp($id){
		// Abfrage f�r FAQ erstellen
		$insert = "DELETE FROM faq_mm_usertype WHERE faq_id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, false);
		
	}
	
//UPDATE Befehle Erstellen	
	
	/**
     * �ndern einer FAQ inclusive beziehungen
     *
     */
	public function updateFAQ($data){
		
		//Beziehung Departments l�schen
		$this->createUpdateStatementFaq($data);
		//Beziehung Usertyp l�schen
		$this->createUpdateStatementFaq_Dept($data['id'],$data['departmentID']);
		//FAQ l�schen
		$this->createUpdateStatementFaq_User($data['id'],$data['usertypeID']);
		// �berpr�fung ob alles in Datenbank ge�ndert wurde
		if($this->checkDBInsert == 3){
			echo "<br/> Ihre �nderungen wurden erfolgreich gespeichert. <br/><br/>";
		}else{
			echo "<br/> Fehler!!!";
		}
		//R�cksetzen der Variable
		$this->checkDBInsert == 0;
	}
	
	/**
     * Statement zum �ndern einer FAQ in der Datenbank
     *
     */
	public function createUpdateStatementFaq($data){
		 
		$id = $data['id'];
		$lang = $data['lang'];
		$question = $data['question'];
		$answer = $data['answer'];
		$sort = $data['sort'];
		
		// Abfrage erstellen
		$insert = "UPDATE faq SET language_id ='$lang', question = '$question', answer = '$answer', sorting = '$sort' WHERE id = '$id'";
		
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben return wert ID des eintrags
		$this->intoDB($insert, false);
	}
	
	/**
     * Statement zum �ndern einer beziehung zwischen FAQ und Departments in die Datenbank erstellen
     *
     */
	public function createUpdateStatementFaq_Dept($faqID, $dept){
		// Abfrage erstellen
		$insert = "UPDATE faq_mm_departments SET department_id = '$dept' WHERE faq_id = '$faqID'";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, false);
	}
	
	/**
     * Statement zum �ndern einer beziehung zwischen FAQ und Usertypes in die Datenbank erstellen
     *
     */
	public function createUpdateStatementFaq_User($faqID, $user){
		// Abfrage erstellen
		$insert = "UPDATE faq_mm_usertype SET usertype_id = '$user' WHERE faq_id = '$faqID'";
		// Fertige SQL-Abfrage an Methode zum speichern �bergeben
		$this->intoDB($insert, false);
	}
	
//DATENBANK verbindung und INSERT ausf�hrung
	
	/**
     * Datenbank conection erstellen und SQL Statement ausf�hren
	 * @param $insert= SQL Befehl der ausgef�hrt werden soll
	 * @param $bool= true = speichern in DB, false = l�schen aus DB oder �ndern(kein insert_id m�glich)
     * @return Letzte gespeicherte ID
     */
	public function intoDB($insert, $bool){
		 try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
           // $db = new mysqli($_SESSION['host'], $_SESSION['user'],$_SESSION['pwd'],$_SESSION['db']);
			
			// Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
			//Connection Minh
			//$db = new mysqli('localhost', 'root', 'krakau123','fhdapp');
			
			//Connection Marc
            $db = new mysqli('localhost', 'root', 'test', 'fhdapp');
            
			
            // Abfrage ausf�hren
			$result = $db->query($insert);
			
			
			//Abfrage ob eingef�gt wurde um id zu ermitteln
			if($bool){
				$returnID = $db->insert_id;
			}else{
				$returnID = null;
			}
            // Ergebnis der Abfrage ausgeben
			if($result == 1){
				//$this->setCheckDBInsert($this->getCheckDBInsert()+1);
				$this->checkDBInsert += 1;
			}else{
				echo "</br> !!! Eingaben der".($this->checkDBInsert + 1)." Abfrage wurden NICHT gespeichert.";
			}

        } catch(Exception $e){
            echo $e->getMessage();
        }
		return $returnID;
	}
	

//READ Befehle Erstellen
	
	/**
     * SQL-Statement zum auslesen der FAQ's aus der Datenbank selektiert nach Usertyp und Fachbereich aus der Datenbank erstellen
     * @return Array mit Datenbank werten
     */
	public function createReadStatementAllFrontend($dept, $eis){
		// Select Statement erstellen
		switch($eis)
		{
					case 'i': $eis = 1; break;
					case 'e': $eis = 2; break;
					case 's': $eis = 3; break;
		}
		
		if($dept != 0 || $eis != 1)
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id 
					  FROM faq, faq_mm_usertype, faq_mm_departments 
					  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id =".$eis." 
					  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =".$dept."";
		else
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id 
					 FROM faq, faq_mm_usertype 
					 WHERE faq.id = faq_mm_usertype.faq_id 
					 AND faq_mm_usertype.usertype_id=".$eis."";
		
		// An Methode
		return $this->getData($read);
	}
	public function createReadStatementBackend($department){
		// Select Statement erstellen(bei 0 alle ausgeben, ansonsten nur f�r Fachbereich)
		if($department == 0){
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid, departments.id AS deptid
						  FROM faq, faq_mm_usertype, faq_mm_departments, usertypes, departments 
						  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id = usertypes.id
						  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =departments.id;"; 
		}else{
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid, departments.id AS deptid
						  FROM faq, faq_mm_usertype, faq_mm_departments, usertypes, departments 
						  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id = usertypes.id
						  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =departments.id AND departments.id =$department"; 
		}
			
		// An Methode
		return $this->getData($read);
	}
	
	
	
	/**
     * SQL-Statement zum auslesen der Fachbereiche aus der Datenbank erstellen
     * @return Array mit Datenbank werten
     */
	public function createReadStatementDepartments(){
		// Select Statement erstellen
		$read = "SELECT id, name FROM departments"; 
		
		// An Methode
		return $this->getData($read);
	}
	
	/**
     * SQL-Statement zum auslesen der Usertypes aus der Datenbank erstellen
     * @return Array mit Datenbank werten
     */
	public function createReadStatementUsertypes(){
		// Select Statement erstellen
			$read = "SELECT id, name FROM usertypes"; 

		// Abfrage an Datenbank
		return $this->getData($read);
	}
	
	/**
     * SQL-Statement zum auslesen der Sprache aus der Datenbank erstellen
     * @return Array mit Datenbank werten
     */
	public function createReadStatementLang(){
		// Select Statement erstellen
			$read = "SELECT id, name FROM languages"; 

		// Abfrage an Datenbank
		return $this->getData($read);
	}

	
	
	//DATENBANK verbindung und READ ausf�hrung
	
	
	/**
     * Holt Daten aus Datenbank
     * @return Array mit Datenbank werten
     */
	public function getData($read){
        try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
            //$db = new mysqli($this->getHostname(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
            
			//Connection Minh
			//$db = new mysqli('localhost', 'root', 'krakau123','fhdapp');
			
			//Connection Marc
            $db = new mysqli('localhost', 'root', 'test', 'fhdapp');
			
            // Abfrage ausf�hren
            $result = $db->query($read);
			
			//�berpr�fen ob die Abfrage ein Ergebnis hat
			if( $result->num_rows > 0){
				// Ergebnis der Abfrage "durchwandern" und in Array schreiben
				while($row = $result->fetch_assoc()){
					$resultSet[] = $row;
				}
				return $resultSet;
			}else{
				echo "Keine FAQ zu ihrer Auswahl vorhanden <br/> <br />";
			}
			
			//R�ckgabe
            
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

/* End of file faq.php */
/* Location: ./models/faq.php */