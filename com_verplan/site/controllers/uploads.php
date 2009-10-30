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
		/*$db =& JFactory::getDBO();

		//erste ebene laden /daten
		$query = 'SELECT DISTINCT '.$db->nameQuote('Geltungsdatum').' FROM '.$db->nameQuote('#__com_verplan_uploads').' WHERE 1';
		$db->setQuery($query);
		$datearray = $db->loadResultArray();
		if ($db->getErrorNum()) {
		$msg = $db->getErrorMsg();
		JError::raiseWarning(0,$msg);
		}*/

		$model = $this->getModel('uploads');
		$datearray = $model->getDistinct('Geltungsdatum','id','%');

		//zweite ebene laden /stände
		for($i = 0; $i < count($datearray); $i++) {
			/*$query = 'SELECT DISTINCT '.$db->nameQuote('Stand').'
			 FROM '.$db->nameQuote('#__com_verplan_uploads').'
			 WHERE '.$db->nameQuote('Geltungsdatum').' LIKE '.$db->quote($datearray[$i]);
			 $db->setQuery($query);
			 $subarray = $db->loadResultArray();
			 if ($db->getErrorNum()) {
				$msg = $db->getErrorMsg();
				JError::raiseWarning(0,$msg);
				}*/
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

	function getInfos($date) {
		$model = $this->getModel('uploads');
		$infos = $model->getInfos($date);
		return $infos;
	}


}
