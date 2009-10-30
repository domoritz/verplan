<?php
/**
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 4-Okt-2009

 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * verplan Upload Controller
 *
 * @package    verplan
 * @subpackage controller
 */
class VerplanControllerUploads extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('getDatesAndStands','getDatesAndStands');
	}

	/**
	 * array mit geltungstagen und ständen,
	 * wobei immer die stände den daten zugeordnet werden
	 *
	 * diese daten werden aus der tabelle uploads geholt
	 *
	 * @return array
	 */
	function getDatesAndStands(){

		//erste ebene laden /daten
		$model = $this->getModel('uploads');
		$datearray = $model->getDistinct('Geltungsdatum','id','%');

		//zweite ebene laden /stände
		for($i = 0; $i < count($datearray); $i++) {
			
			$subarray = $model->getDistinct('Stand','Geltungsdatum',$datearray[$i]);
				
			/*
			 * assoziatives array ($array) wird zusammen gebaut
			 * aus $datearay und $subarray
			 */

			$array[$datearray[$i]]= $subarray;
		}

		/*debug
		 echo "dates and stands";
		 echo "<pre>";
		 var_dump($array);
		 echo "<pre>";
		 //*/

		return $array;
	}

	/**
	 * weiterreichen an model
	 * 
	 * @param $date Geltungsdatum, für das die infos gesucht werden
	 * @return array
	 */
	function getInfos($date) {
		$model = $this->getModel('uploads');
		$infos = $model->getInfos($date);
		return $infos;
	}


}
