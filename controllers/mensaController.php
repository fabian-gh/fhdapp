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
	public function callProceedPost($post){
		$this->MensaModel->proceedPost($post);
	}


	/**
	 * Insert the canteen plan into the database
	 */
	public function callInsertPlan($get){
		$this->MensaModel->insertPlan($get);
	}
}

/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */