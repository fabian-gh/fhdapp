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

		public function getList($params)
		{
			return $this->quizModel->getList($params);
		}
	}

?>