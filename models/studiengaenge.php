<?php
	class StudycoursesModel{
		//IV
		private $connection;
		
		//Construct
		public function __construct(){
			$this->connection = new mysqli($_SESSION['host'], $_SESSION['user'], $_SESSION['pwd'], $_SESSION['db']);	//Instanz der Datenbankverbindung in connection abspeichern
		}
		
		//IM
		public function insertStudycourse(){
			try{
//				$this->connection->query("INSERT INTO studycourses() VALUES()");
			}
			catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}


?>