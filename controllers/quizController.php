<?php
	
	/**
	 * Logik für's Quiz
	**/
	class QuizController
	{
		private $quizModel;

		/**
		 * Erstellt den Controller und bindet das Model für's Quiz ein
		**/
		public function __construct()
		{
			//quizModel instanziieren
			require_once __DIR__.'../../models/quizModel.php';
			$this->quizModel = new QuizModel();
		}

		/**
		 * @return array Gibt ein Array mit allen Tags zurück.
		**/
		public function getTags()
		{
			return $this->quizModel->getTags();
		}

		/**
		 * @return int Gibt die Anzahl der vorhandenen Studiengängen zurück (unabhängig des Abschlusses).
		**/
		public function countStudycourses()
		{
			return $this->quizModel->countStudycourses();
		}

		/**
		 * @param string $params String zusammengesetzt aus den Tags, welche angewählt sind (Bsp.: AND (b.tag_id = 7 OR b.tag_id = 1 OR b.tag_id = 2))
		 *
		 * @return array Gibt ein Array mit den Studiengängen, die zu den Tags passen, zurück. Sortiert nach der Relevanz.
		**/
		public function getList($params)
		{
			return $this->quizModel->getList($params);
		}
	}

?>