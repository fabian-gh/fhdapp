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
	 * Beinhaltet ein Mensaobjekt
	 * @var Object
	 */
	private $MensaModel;


	/**
	 * Konstruktor
	 */
	public function __construct(){
		require_once __DIR__.'../../models/mensa.php';
		$this->MensaModel = new Mensa();
	}


	/**
	 * Ruft die getCanteenPlans()-Methode auf, um einen Plan zu erfragen
	 * @return Array $canteenPlans
	 */
	public function callGetCanteenPlans(){
		return $this->MensaModel->getCanteenPlans();
	}


	/**
	 * Ruft die getAdditives()-Methode auf, um die Zusatzstoffe abzufragen
	 * @return Array $additives
	 */
	public function callGetAdditives(){
		return $this->MensaModel->getAdditives();
	}


	/**
	 * Ruft die getOpeningHours()-Methode auf, um die Öffnungszeiten abzufragen
	 * @return Array $openingHours
	 */
	public function callGetOpeningHours(){
		return $this->MensaModel->getOpeningHours();
	}


	/**
	 * Ruft die getAllPlans()-Methode auf, um alle Pläne zu erfragen
	 * @return Array $canteenPlans
	 */
	public function callGetAllPlans(){
		return $this->MensaModel->getAllPlans();
	}


	/**
	 * Ruft die editPlan()-Methode auf, um einen plan zu bearbeiten
	 * @param Array $calenderweek
	 * @return Array $plan
	 */
	public function callEditPlan($calenderweek){
		return $this->MensaModel->editPlan($calenderweek);
	}


	/**
	 * Ruft die deletePlan()-Methode auf, um einen Plan zu löschen
	 * @param Array $calenderweek
	 */
	public function callDeletePlan($calenderweek){
		$this->MensaModel->deletePlan($calenderweek);
	}


	/**
	 * Ruft die proceedPost()-Methode auf, um die POST-Daten zu verarbeiten
	 * @param Array $post
	 */
	public function callProceedPost($post){
		$this->MensaModel->proceedPost($post);
	}


	/**
	 * Ruft die insertPlan()-Methode auf, um einen Plan in die Datenbank einzufügen
	 * @param Array $get
	 */
	public function callInsertPlan($get){
		$this->MensaModel->insertPlan($get);
	}
}

/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */