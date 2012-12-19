<?php

/**
 * FHD-App
 *
 * @version 0.0.1
 * @copyright Fachhochschule Duesseldorf, 2012
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
		require_once '../../models/mensa.php';
		$this->MensaModel = new Mensa();
			
		if(isset($_GET['category']) && $_GET['category'] == 'canteen'){

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
		}
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
	public function callProceedPost($post){
		$this->MensaModel->proceedPost($post);
	}


	/**
	 * Insert the canteen plan into the database
	 */
	public function callInsertPlan(){
		$this->MensaModel->insertPlan();
	}
}

 
/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */