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

	public function __construct(){}

	/**
	 * Insert the canteen plan into the database
	 * 
	 * @param Array $post
	 */
	public function callInsertPlan($post){
		require_once '../../models/mensa.php';
		$MensaModel = new Mensa();
		$MensaModel->insertPlan($post);
	}
}

 
/* End of file mensaController.php */
/* Location: ./controllers/mensaController.php */