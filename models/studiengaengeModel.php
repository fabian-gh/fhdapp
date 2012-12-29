<?php

	class StudycoursesModel{
	
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			//Instanz der Datenbankverbindung in connection abspeichern
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	
		}
		
		//Gibt den zugeh?rigen Namen (Datentyp: Array) der graduate id zur?ck.
		//?bergabeparameter: $id - graduate id, dessen namen man wissen will
		public function graduateIdToName($id){
			return $this->connection->query("SELECT name FROM graduates WHERE id=".$id.";")->fetch_assoc();
		}
		
		//Gibt den zugeh?rigen Namen (Datentyp: Array) der language id zur?ck.
		//?bergabeparameter: $id - language id, dessen namen man wissen will
		public function languageIdToName($id){
			return $this->connection->query("SELECT name FROM languages WHERE id=".$id.";")->fetch_assoc();;
		}
		
		//Gibt den zugeh?rigen Namen (Datentyp: Array) der department id zur?ck.
		//?bergabeparameter: $id - department id, dessen namen man wissen will
		public function departmentIdToName($id){
			return $this->connection->query("SELECT name FROM departments WHERE id=".$id.";")->fetch_assoc();;
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzuf�gen. 
		public function insertStudycourse($post){
			try{
				//Einf�gen der Werte in die "studicourses" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES(".$post["language_id"].", '".$post["name"]."', '".$post["description"]."', ".$post["department_id"].", ".$post["semestercount"].", ".$post["graduate_id"].", '".$post["link"]."')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzuf�gen. 
		//Dabei muss die ID von der Categorie (id_cat) �bergeben werden und die ID vom Studiengang($studID)
		public function insertStudCat($studID, $id_cat){
			try{
				//Einf�gen der Werte in die "studycourses_mm_categories" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses_mm_categories(studycourse_id, category_id) VALUES($studID, $id_cat)");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//R�ckgabe der zuletzt erstellten ID durch AUTO_INCREMENT
		public function insert_id(){
			return $this->connection->insert_id;
		}
		
		//Liefert alle Studieng�nge alphabetisch geordnet nach dem Studiengangsnamen zur�ck
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbk�rzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
			$result = $this->connection->query("SELECT s.id AS id, s.name AS studyName, g.name AS graduateName, c.category AS categoryName
												FROM `studycourses` s
												JOIN `graduates` g 
												ON s.graduate_id = g.id
												JOIN `studycourses_mm_categories` sm
												ON s.id = sm.studycourse_id
												JOIN `categories` c
												ON c.id = sm.category_id
												WHERE c.id = 4 OR c.id = 3
												ORDER BY s.name ASC, g.name ASC, c.category DESC;");
			$retVal = array();
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das hei�t, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzuf�gen
			}
			return $retVal;
		}
		
		//Liefert ein Studiengan mit allen Informationen zur?ck
		//?bergabeparameter: $id - id des Studiengangs
		public function selectStudicourse($id){
			$result = $this->connection->query("SELECT s.name AS studycourseName, g.name AS graduateName FROM studycourses s JOIN graduates g ON s.graduate_id=g.id WHERE s.id=".$id.";");
			return $result->fetch_assoc();
		}
		

		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zur�ck
		//R�ckgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			try{
				switch($type){
					case "graduates":	//Liefert Fachbereiche zur�ck (departments)
						$query = "SELECT id, CONCAT(abbreviation,' - ',name) AS name FROM graduates ORDER BY 'id' ASC;";
						break;
					case "languages":	//Liefert Sprachen zur�ck (languages)
						$query = "SELECT id, name FROM languages ORDER BY 'id' ASC;";
						break;
					case "departments":	//Liefert Fachbereiche zur�ck (departments)
						$query = "SELECT id, CONCAT(id,' - ',name) AS name FROM departments ORDER BY 'id' ASC;";
						break;	
				}
				
				//Selectieren der Werte und einspeichern in $result
				$result = $this->connection->query($query);
				while($row = $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das hei�t, solange zeilen da sind
					$retVal[] = $row;	//dem array $retVal die Zeile $row hinzuf�gen
				}
				return $retVal;
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Liefert abbreviation einer bestimmten ID zur�ck
		public function selectGradAbb($id){
			try{		
				//Selectieren des Wertes und einspeichern in $retVal
				$retVal = $this->connection->query("SELECT abbreviation FROM graduates WHERE id=".$id." ORDER BY 'id' ASC;");
				return $retVal->fetch_assoc();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//L?scht einen Studiengang
		//?bergabeparameter: $id - des zu l?schenden Studiengangs
		public function deleteStudicourse($id){
			try{
				//L?sche den Studiengang aus der Zwischentabelle "studycourses_mm_categories"
				$this->connection->query("DELETE FROM studycourses_mm_categories WHERE studycourse_id=".$id."");
				//L?sche den Studiengang aus der Zwischentabelle "studycourses_mm_tags"
				$this->connection->query("DELETE FROM studycourses_mm_tags WHERE studycourse_id=".$id."");
				//L?sche den Studiengang aus der Tabelle "studycourses"
				$this->connection->query("DELETE FROM studycourses_mm_tags WHERE id=".$id."");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
	}
	
?>