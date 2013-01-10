<?php

	class StudycoursesModel{
	
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			//Instanz der Datenbankverbindung in connection abspeichern
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	
		}
		
		//Gibt den zugehörigen Namen (Datentyp: Array) der graduate id zurück.
		//Übergabeparameter: $id - graduate id, dessen namen man wissen will
		public function graduateIdToName($id){
			return $this->connection->query("SELECT name FROM graduates WHERE id=".$id.";")->fetch_assoc();
		}
		
		//Gibt den zugehörigen Namen (Datentyp: Array) der language id zurück.
		//Übergabeparameter: $id - language id, dessen namen man wissen will
		public function languageIdToName($id){
			return $this->connection->query("SELECT name FROM languages WHERE id=".$id.";")->fetch_assoc();;
		}
		
		//Gibt den zugehörigen Namen (Datentyp: Array) der department id zurück.
		//Übergabeparameter: $id - department id, dessen namen man wissen will
		public function departmentIdToName($id){
			return $this->connection->query("SELECT name FROM departments WHERE id=".$id.";")->fetch_assoc();;
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen. 
		public function insertStudycourse($post){
			try{
				$post["description"] = mysql_real_escape_string($post["description"]);	//Injections ausschließen durch escape von Zeichen
				//Einfügen der Werte in die "studicourses" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES(".$post["language_id"].", '".$post["name"]."', '".$post["description"]."', ".$post["department_id"].", ".$post["semestercount"].", ".$post["graduate_id"].", '".$post["link"]."')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//Funktion um Werte in die Relation 'studycourses_mm_categories' einzufügen. 
		//Dabei muss die ID von der Categorie (id_cat) übergeben werden und die ID vom Studiengang($studID)
		public function insertStudCat($studID, $id_cat){
			try{
				//Einfügen der Werte in die "studycourses_mm_categories" Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses_mm_categories(studycourse_id, category_id) VALUES($studID, $id_cat)");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		//Rückgabe der zuletzt erstellten ID durch AUTO_INCREMENT
		public function insert_id(){
			return $this->connection->insert_id;
		}
		
		//Liefert alle Studiengänge alphabetisch geordnet nach dem Studiengangsnamen zurück
		//mit den Attributen: StudiengangsId, StudiengangsName, AbschlussartAbkürzung und ob es Teil-oder Vollzeit ist
		public function selectStudicourses(){
			$result = $this->connection->query("SELECT s.id AS id, s.name AS study_name, g.name AS graduate_name, c.category AS category_name, l.name AS language_name
												FROM `studycourses` s
												JOIN `graduates` g 
												ON s.graduate_id = g.id
												JOIN `languages` l 
												ON s.language_id = l.id
												JOIN `studycourses_mm_categories` sm
												ON s.id = sm.studycourse_id
												JOIN `categories` c
												ON c.id = sm.category_id
												WHERE c.id = 4 OR c.id = 3
												ORDER BY s.name ASC, g.name ASC, c.category DESC, l.id ASC;");
			$retVal = array();
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
			}
			return $retVal;
		}
		
		//Liefert mehrere Zeilen zurück. Die Zeilen untescheiden sich nur in der "categoryID", der rest ist immer der selbe Studiengang
		//Übergabeparameter: $id - id des Studiengangs
		public function selectStudicourse($id){
			$result = $this->connection->query("SELECT g.name AS graduate_name, s.id AS id ,s.graduate_id AS graduate_id, s.name AS name, s.department_id AS department_id, s.semestercount AS semestercount, s.description AS description, s.language_id AS language_id ,s.link AS link, c.id AS category_id
												FROM studycourses s 
												JOIN graduates g ON g.id = s.graduate_id
												JOIN studycourses_mm_categories smmc ON s.id = smmc.studycourse_id
												JOIN categories c ON smmc.category_id = c.id
												WHERE s.id=".$id.";");		
			while($row= $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
				$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
			}
			return $retVal;
		}
		

		//Liefert Daten der Tabelle "graduates", "languages" oder "departments" zurück
		//Rückgabe ist ein zweidimensionales assoziatoves Array mit [["id"],["name"]]
		public function selectDropDownData($type){
			try{
				switch($type){
					case "graduates":	//Liefert Fachbereiche zurück (departments)
						$query = "SELECT id, CONCAT(abbreviation,' - ',name) AS name FROM graduates ORDER BY 'id' ASC;";
						break;
					case "languages":	//Liefert Sprachen zurück (languages)
						$query = "SELECT id, name FROM languages ORDER BY 'id' ASC;";
						break;
					case "departments":	//Liefert Fachbereiche zurück (departments)
						$query = "SELECT id, CONCAT(id,' - ',name) AS name FROM departments ORDER BY 'id' ASC;";
						break;	
				}
				
				//Selectieren der Werte und einspeichern in $result
				$result = $this->connection->query($query);
				while($row = $result->fetch_assoc()){	//eine Zeile in $row speichern und solange $row existiert, das heißt, solange zeilen da sind
					$retVal[] = $row;	//dem array $retVal die Zeile $row hinzufügen
				}
				return $retVal;
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Liefert abbreviation einer bestimmten ID zurück
		public function selectGradAbb($id){
			try{		
				//Selectieren des Wertes und einspeichern in $retVal
				$retVal = $this->connection->query("SELECT abbreviation FROM graduates WHERE id=".$id.";");
				return $retVal->fetch_assoc();
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
				
		//Lösche einen Studiengang aus der Zwischentabelle "studycourses_mm_categories"
		//Übergabeparameter: $id - des zu löschenden Studiengangs
		public function deleteFromStudicourseCategories($id){
			try{
				//Lösche den Studiengang aus der Zwischentabelle "studycourses_mm_categories"
				$this->connection->query("DELETE FROM studycourses_mm_categories WHERE studycourse_id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Lösche einen Studiengang aus der Zwischentabelle "studycourses_mm_tags"
		//Übergabeparameter: $id - des zu löschenden Studiengangs
		public function deleteFromStudicourseTags($id){
			try{
				//Lösche den Studiengang aus der Zwischentabelle "studycourses_mm_tags"
				$this->connection->query("DELETE FROM studycourses_mm_tags WHERE studycourse_id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		//Lösche einen Studiengang aus der Tabelle "studycourses"
		//Übergabeparameter: $id - des zu löschenden Studiengangs
		public function deleteFromStudicourse($id){
			try{
				//Lösche den Studiengang aus der Tabelle "studycourses"
				$this->connection->query("DELETE FROM studycourses WHERE id=".$id.";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
		
		
		//Updatet einen Studiengang
		//Übergabeparameter: $post - das $post array muss folgende felder enthalten: "id", "language_id", "name", "description", department_id", "semestercount", "graduate_id", "link"
		public function updateStudycourse($post){
			try{
				$post["description"] = mysql_real_escape_string($post["description"]);	//Injections ausschließen durch escape von Zeichen
				$this->connection->query("UPDATE studycourses
										SET language_id = ".$post["language_id"].", 
											name = '".$post["name"]."', 
											description = '".$post["description"]."', 
											department_id = ".$post["department_id"].", 
											semestercount = ".$post["semestercount"].", 
											graduate_id = ".$post["graduate_id"].", 
											link = '".$post["link"]."' 
										WHERE id = ".$post["id"].";");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
	}
	
?>