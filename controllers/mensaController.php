<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012/2013
 * @link http://www.fh-duesseldorf.de
 * @author Fabian Martinovic (FM), <fabian.martinovic@fh-duesseldorf.de>
 */

class MensaController{

	/**
	 * Contains a Mensa object
	 * @var Object
	 */
	private $MensaModel;

<<<<<<< HEAD


	/**
	 * Constructor
	 */
	public function __construct(){
		require_once '../../models/mensa.php';
		$this->MensaModel = new Mensa();
			
		/*if(isset($_GET['category']) && $_GET['category'] == 'canteen'){

			if(isset($_GET['mode'])){

				switch($_GET['mode']){
					case 'add':
						require_once 'edit.php';
					break;

					case 'edit':
						$this->callEditPlan($_GET['cw']);
						require_once 'edit.php';
					break;

					case 'delete':
						$this->callDeletePlan($_GET['cw']);
					break;
				}
			}
		}*/
	}



	/**
	 * Call the getAllPlans()-Method
	 * @param Array $post
	 */
	public function callGetAllPlans(){
		return $this->MensaModel->getAllPlans();
	}


	/**
	 * Call the editPlan()-Method
	 * @param Array $post
	 */
	public function callEditPlan($calenderweek){
		$this->MensaModel->editPlan($calenderweek);
	}


	/**
	 * Call the deletePlan()-Method
	 * @param Array $post
	 */
	public function callDeletePlan($calenderweek){
		$this->MensaModel->deletePlan($calenderweek);
	}


	/**
	 * Call the proceedPost()-Method
	 * @param Array $post
	 */
=======


	/**
	 * Constructor
	 */
	public function __construct(){
		require_once __DIR__.'../../models/mensa.php';
		$this->MensaModel = new Mensa();
	}



	/**
	 * Call the getCanteenPlans()-Method
	 */
	public function callGetCanteenPlans(){
		return $this->MensaModel->getCanteenPlans();
	}


	/**
	 * Call the getAdditives()-Method
	 */
	public function callGetAdditives(){
		return $this->MensaModel->getAdditives();
	}


	/**
	 * Call the getAdditives()-Method
	 */
	public function callGetOpeningHours(){
		return $this->MensaModel->getOpeningHours();
	}


	/**
	 * Call the getAllPlans()-Method
	 * @param Array $post
	 */
	public function callGetAllPlans(){
		return $this->MensaModel->getAllPlans();
	}


	/**
	 * Call the editPlan()-Method
	 * @param Array $post
	 */
	public function callEditPlan($calenderweek){
		return $this->MensaModel->editPlan($calenderweek);
	}


	/**
	 * Call the deletePlan()-Method
	 * @param Array $post
	 */
	public function callDeletePlan($calenderweek){
		$this->MensaModel->deletePlan($calenderweek);
	}


	/**
	 * Call the proceedPost()-Method
	 * @param Array $post
	 */
>>>>>>> origin/daniel16.02
	public function callProceedPost($post){
		$this->MensaModel->proceedPost($post);
	}


	/**
	 * Insert the canteen plan into the database
<<<<<<< HEAD
<<<<<<< HEAD
	 */
	public function callInsertPlan(){
		$this->MensaModel->insertPlan();
=======
	 * @param Array $get
=======
>>>>>>> parent of 2f031bb... Mensakommentare angepasst + Erklärungen
	 */
	public function callInsertPlan($get){
		$this->MensaModel->insertPlan($get);
>>>>>>> origin/daniel16.02
	}
}

/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */