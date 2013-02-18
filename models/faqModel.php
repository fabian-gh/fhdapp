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
	
	//Globale Variable zur UeberprUefung ob alle SQL Abfragen bgeschickt wurden
	public $checkDBInsert = 0;

	 /**
     * Kontrolliert Daten auf vollstaendigkeit und richtige eingabewerte(neueintrag/ändern/löschen)
     *
	 * @param Array $data  Data Array mit eingegebenen Werten aus dem Formular
     */
    public function controllInput($data){
		// check ob eingabe und UeberprUefung
		if($data['inputArt'] == 1){
			$checkOverall = true;
			for ($i = 1; $i <= $data['anzahl']; $i++) {
				// UeberprUefung ob die Sortierung eine Zahl ist
				$checkSort = filter_var($data['sort'.$i], FILTER_VALIDATE_INT);
				if ($checkSort === false) 
				{ 
					// invalide
					echo "Sortierung muss eine Zahl sein<br />"; 
					$checkOverall = false;
				} 
				// UeberprUefung ob die Sprach ID eine Zahl ist
				$checkLang = filter_var($data['lang'.$i], FILTER_VALIDATE_INT);
				if ($checkLang === false) 
				{ 
					// invalide
					echo "Sprach ID muss eine Zahl sein<br />"; 
					$checkOverall = false;
				} 
				// UeberprUefung ob Frage eingegeben wurde
				if (empty($data['question'.$i])) {
					echo 'Es muss eine Frage eingegeben werden<br />';
					$checkOverall = false;
				}
				// UeberprUefung ob Antwort eingegeben wurde
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
		
		// check ob update und UeberprUefung
		if($data['inputArt'] == 2){
			$checkOverall = true;
			// UeberprUefung ob die Sortierung eine Zahl ist
			$checkSort = filter_var($data['sort'], FILTER_VALIDATE_INT);
			if ($checkSort === false) 
			{ 
				// invalide
				echo "Sortierung muss eine Zahl sein<br />"; 
				$checkOverall = false;
			} 
			// UeberprUefung ob die Sprach ID eine Zahl ist
			$checkLang = filter_var($data['lang'], FILTER_VALIDATE_INT);
			if ($checkLang === false) 
			{ 
				// invalide
				echo "Sprach ID muss eine Zahl sein<br />"; 
				$checkOverall = false;
			} 
			// UeberprUefung ob Frage eingegeben wurde
			if (empty($data['question'])) {
				echo 'Es muss eine Frage eingegeben werden<br />';
				$checkOverall = false;
			}
			// UeberprUefung ob Antwort eingegeben wurde
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
     * Statement zum einfuegen einer FAQ in die Datenbank erstellen
	 * Echo Ausgabe ob Einträge gespeichert wurden
     *
	 * @param Array $data  Data Array mit eingegebenen und kontrollierten Werten aus dem Formular
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
				
				// Fertige SQL-Abfrage an Methode zum speichern Uebergeben return wert ID des eintrags
				$faqID = $this->intoDB($insert, true);

				//SQL Abfrage fUer FAQ_mm_Departments erstellen und ausfUehren
				$this->createInsertStatementFaq_Dept($faqID, $dept);
				
				//SQL Abfrage fUer FAQ_mm_Usertypes erstellen und ausfUehren
				$this->createInsertStatementFaq_User($faqID, $user);
				
				// UeberprUefung ob alles in Datenbank gespeichert wurde
				if($this->checkDBInsert == 3){
					echo "<br /> Ihre Eingaben wurden erfolgreich gespeichert.";
				}else{
					echo "<br/> Fehler!!!";
				}
				//RUecksetzen der Variable
				$this->checkDBInsert = 0;
			}
        } catch(Exception $e){
            echo $e->getMessage();
        }
	}
	
	/**
     * Statement zum einfuegen einer beziehung zwischen FAQ und Departments in der Datenbank erstellen
	 * Unterscheidung durch Fachbereich ID ob die FAQ nur für einen Fachbereich oder für alle Fachbereiche gilt
     *
	 * @param int $faqID  FAQ Id der zuletzt eingetragenen FAQ um die passenden Beziehungen mit den Fachbereichen herzustellen
	 * @param int $dept  Id des Fachbereiches oder 100 wenn FAQ für alle Fachbereiche gilt
     */
	public function createInsertStatementFaq_Dept($faqID, $dept){
		// Abfrage erstellen
		// Unterscheidung ob FAQ für alle Fachbereiche gilt
		if($dept == 100){
			$resultSetDepartments = $this->createReadStatementDepartments();
			$insert = "INSERT INTO faq_mm_departments (faq_id, department_id) VALUES ";
			//Alle Fachbereiche durchlaufen
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
		// Fertige SQL-Abfrage an Methode zum speichern Uebergeben
		$this->intoDB($insert, true);
	}
	
	/**
     * Statement zum einfuegen einer beziehung zwischen FAQ und Usertypes in der Datenbank erstellen
     *
	 * @param int $faqID  FAQ Id der zuletzt eingetragenen FAQ um die passenden Beziehungen mit dem Usertyp herzustellen
	 * @param int $user  Id des Usertypes für den die FAQ gilt
     */
	public function createInsertStatementFaq_User($faqID, $user){
		// Abfrage erstellen
		$insert = "INSERT INTO faq_mm_usertype (faq_id, usertype_id) VALUES ('$faqID', '$user')";
		// Fertige SQL-Abfrage an Methode zum speichern Uebergeben
		$this->intoDB($insert, true);
	}
	
//DELETE Befehle Erstellen	
	
	/**
     * LOeschen einer FAQ inclusive beziehungen
     *
     */
	public function deleteFAQ($id, $checkIfChange){
		
		//Beziehung Departments lOeschen
		$this->createDeleteStatementDepartment($id);
		//Beziehung Usertyp lOeschen
		$this->createDeleteStatementUsertyp($id);
		//FAQ lOeschen
		$this->createDeleteStatementFaq($id);
		// UeberprUefung ob alles in Datenbank gelOescht wurde
		if($checkIfChange == false){
			if($this->checkDBInsert == 3 ){
				echo "<br/> Die FAQ wurde erfolgreich gelöscht. <br/> <br/>";
			}else{
				echo "<br/> Fehler!!!";
			}
		}
		//RUecksetzen der Variable
		$this->checkDBInsert = 0;
		
	}
	/**
     * Statement zum lOeschen einer FAQ
     *
     */
	public function createDeleteStatementFaq($id){
		// Abfrage fUer FAQ erstellen
		$insert = "DELETE FROM faq WHERE id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern Uebergeben
		$this->intoDB($insert, false);
		
	}
	
	/**
     * Statement zum lOeschen einer beziehung zwischen FAQ und Department
     *
     */
	public function createDeleteStatementDepartment($id){
		// Abfrage fUer FAQ erstellen
		$insert = "DELETE FROM faq_mm_departments WHERE faq_id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern Uebergeben
		$this->intoDB($insert, false);
		
	}
	
	/**
     * Statement zum lOeschen einer beziehung zwischen FAQ und Usertypes
     *
     */
	public function createDeleteStatementUsertyp($id){
		// Abfrage fUer FAQ erstellen
		$insert = "DELETE FROM faq_mm_usertype WHERE faq_id = ".$id."";
		// Fertige SQL-Abfrage an Methode zum speichern Uebergeben
		$this->intoDB($insert, false);
		
	}
	
//UPDATE Befehle Erstellen	
	
	/**
     * Aendern einer FAQ inclusive beziehungen
     *
     */
	public function updateFAQ($data){
		try{
			// Werte aneinanderreihen 
			$lang = $data['lang'];
			$question = $data['question'];
			$answer = $data['answer'];
			$sort = $data['sort'];
			$dept = $data['departmentID'];
			$user = $data['usertypeID'];
			
			// Abfrage erstellen
			$insert = "INSERT INTO faq (language_id, question, answer, sorting) VALUES ('$lang', '$question', '$answer', '$sort')";
			
			// Fertige SQL-Abfrage an Methode zum speichern Uebergeben return wert ID des eintrags
			$faqID = $this->intoDB($insert, true);

			//SQL Abfrage fUer FAQ_mm_Departments erstellen und ausfUehren
			$this->createInsertStatementFaq_Dept($faqID, $dept);
			
			//SQL Abfrage fUer FAQ_mm_Usertypes erstellen und ausfUehren
			$this->createInsertStatementFaq_User($faqID, $user);
			
			// UeberprUefung ob alles in Datenbank gespeichert wurde
			if($this->checkDBInsert == 3){
				echo "<br /> Ihre Eingaben wurden erfolgreich geändert.";
			}else{
				echo "<br/> Fehler!!!";
			}
			//RUecksetzen der Variable
			$this->checkDBInsert = 0;
			
        } catch(Exception $e){
            echo $e->getMessage();
		}
		
	}
	
//DATENBANK verbindung und INSERT ausfUehrung
	
	/**
     * Datenbank conection erstellen und SQL Statement ausfUehren
	 * @param $insert= SQL Befehl der ausgefUehrt werden soll
	 * @param $bool= true = speichern in DB, false = lOeschen aus DB oder Aendern(kein insert_id mOeglich)
     * @return Letzte gespeicherte ID
     */
	public function intoDB($insert, $bool){
		 try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
			$db = new mysqli($_SESSION['host'], $_SESSION['user'],$_SESSION['pwd'],$_SESSION['db']);
			
			// Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
			
            //$db = new mysqli('localhost', 'root', '', 'fhdapp');
            
			
            // Abfrage ausfUehren
			$result = $db->query($insert);
			
			
			//Abfrage ob eingefUegt wurde um id zu ermitteln
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
		
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id 
					  FROM faq, faq_mm_usertype, faq_mm_departments 
					  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id =".$eis." 
					  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =".$dept."";
		/*
		else
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id 
					 FROM faq, faq_mm_usertype 
					 WHERE faq.id = faq_mm_usertype.faq_id 
					 AND faq_mm_usertype.usertype_id=".$eis."";
		**/
		
		// An Methode
		return $this->getData($read);
	}
	
	public function createReadStatementBackend($department){
		// Select Statement erstellen(bei 0 alle ausgeben, ansonsten nur fUer Fachbereich)
		if($department == 0){
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid, departments.id AS deptid
						  FROM faq, faq_mm_usertype, faq_mm_departments, usertypes, departments 
						  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id = usertypes.id
						  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =departments.id;";
			$read = "
					SELECT DISTINCT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid
					FROM faq, faq_mm_usertype, faq_mm_departments, usertypes
					WHERE faq.id = faq_mm_usertype.faq_id 
					AND faq_mm_usertype.usertype_id = usertypes.id
					AND faq.id = faq_mm_departments.faq_id
					AND faq.id IN
					(
					SELECT faq_id
					FROM faq_mm_departments
					group by faq_id
					HAVING count(faq_id)=7
					)";
		}else{
			$read = "SELECT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid, departments.id AS deptid
						  FROM faq, faq_mm_usertype, faq_mm_departments, usertypes, departments 
						  WHERE faq.id = faq_mm_usertype.faq_id AND faq_mm_usertype.usertype_id = usertypes.id
						  AND faq.id = faq_mm_departments.faq_id AND faq_mm_departments.department_id =departments.id AND departments.id =$department"; 
			$read = '
					SELECT DISTINCT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid, departments.id AS deptid
					FROM faq, faq_mm_usertype, faq_mm_departments, usertypes, departments
					WHERE faq.id = faq_mm_usertype.faq_id
					AND faq_mm_usertype.usertype_id = usertypes.id
					AND faq.id = faq_mm_departments.faq_id
					AND departments.id = faq_mm_departments.department_id
					AND departments.id ='.$department.'
					AND faq.id NOT IN
					(
					SELECT faq_id
					FROM faq_mm_departments
					GROUP BY faq_id
					HAVING count( faq_id ) =7
					)';
		}
			
		// An Methode
		return $this->getData($read);
	}
	
	public function createStatementAllDepartments()
	{
		$temp =
			'
			SELECT DISTINCT faq.id, faq.question, faq.answer, faq.sorting, faq.language_id, usertypes.id AS userid
			FROM faq, faq_mm_usertype, faq_mm_departments, usertypes
			WHERE faq.id = faq_mm_usertype.faq_id 
			AND faq_mm_usertype.usertype_id = usertypes.id
			AND faq.id = faq_mm_departments.faq_id
			AND faq.id IN
			(
			SELECT faq_id
			FROM faq_mm_departments
			group by faq_id
			HAVING count(faq_id)=7
			)
		';
		$this->getData($temp);
		
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
	
	/**
	* SQL-Statment zum Auslesen des Fachbereichs anhand des Studiengangs
	* @return Array mit Datenbankwerten
	*/
	public function DepartmentFromCourse($course){
		//Select Statement erstellen
		$read = "SELECT department_id
				 FROM studycourses
				 WHERE name = '$course'
				 LIMIT 1";
		
		//Abfrage an Datenbank
		return $this->getData($read);
	}
	
	//DATENBANK verbindung und READ ausfUehrung
	
	
	/**
     * Holt Daten aus Datenbank
     * @return Array mit Datenbank werten
     */
	public function getData($read){
        try{
            // Verbindung aufbauen, Zugangsdaten kommmen aus dem Data-Objekt
            $db = new mysqli($this->getHostname(), $this->getUsername(), $this->getPassword(), $this->getDatabase());
            
            //$db = new mysqli('localhost', 'root', '', 'fhdapp');
			
            // Abfrage ausfUehren
            $result = $db->query($read);
			
			//UeberprUefen ob die Abfrage ein Ergebnis hat
			if( $result->num_rows > 0){
				// Ergebnis der Abfrage "durchwandern" und in Array schreiben
				while($row = $result->fetch_assoc()){
					$resultSet[] = $row;
				}
				return $resultSet;
			}else{
				echo "Keine FAQ zu ihrer Auswahl vorhanden. <br/> <br />";
			}
			
			//RUeckgabe
            
            
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

/* End of file faq.php */
/* Location: ./models/faq.php */