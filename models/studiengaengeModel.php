<?php

	class StudycoursesModel{
	
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			//Instanz der Datenbankverbindung in connection abspeichern
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	
		}
		
		//Funktion um Werte in die Relation 'studycourses' einzufügen. 
		public function insertStudycourse($language_id, $name, $description, $department_id, $semestercount, $graduate_id, $link){
			try{
				//Einfügen der Werte in die Tabelle. Das Attribut 'id' ist AUTO_INCREMENT
				$this->connection->query("INSERT INTO studycourses(language_id, name, description, department_id, semestercount, graduate_id, link) VALUES($language_id, '$name', '$description', $department_id, $semestercount, $graduate_id, '$link')");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
		
	}

?>