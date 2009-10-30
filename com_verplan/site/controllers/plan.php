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
class VerplanControllerPlan extends verplanController
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
	 * methode, zum laden des planes aus der datenbank
	 * in ein assoziatives array der form
	 *
	 * Array
	 * (
	 * 		[cols] => Array ()
	 * 		[rows] => Array ()
	 * )
	 *
	 * @access	public
	 * @return	array
	 */
	function getVerplanarray($date,$stand,$options){
		$db =& JFactory::getDBO();

		//leeres array
		$array = array();

		//coltroller uploads
		$name = 'uploads';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');

		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();
			
		//holt sich das array mit daten und ständen
		$dates_stands = $controller->getDatesAndStands();

		//falls nur der neueste stand zurückgegeben werden soll
		if ($stand == "latest") {
			//nimmt nur das passende subarray
			$stands = $dates_stands[$date];
			/*
			 * sortiert
			 * 0 = DESC nach oben hin
			 * 1 = ASC nach oben hin
			 */
			if (is_array($stands)) {
				sort($stands,1);
				//weist den stand zu
				$stand = $stands[0];
			} else {
				$stand = $stands;
			}
			//debug
			//var_dump($stands);
		}

		/*INFOS*/
		/*$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_uploads').'WHERE `Geltungsdatum` LIKE '.$db->quote($date."%");
		$db->setQuery($query);
		$infosarray = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}*/
		
		$infosarray = $controller->getInfos($date);
		

		/*debug
		 echo "query für infos";
		 echo $query;
		 var_dump($infosarray);
		 //*/

		/*
		 * lädt die daten der zeilen als assoziatives array aus der datenbank,
		 * dabei werden nur die zeilen geladen, in denen der richtige stand und
		 * das richtige datum sind. das wird erreicht, indem die tabellen uploads und
		 * plan in beziehung gesetzt werden. datum und stand werden sehr liberal beahndelt.
		 * so heißt "2009-02", dass alle stände aus dem februar 2009 geladen werden
		 *
		 *
		 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich,
		 * z.b. alle daten von 2009 zu bekommen
		 * bei fehlern wird eine meldung ausgegeben
		 *
		 */
		//(0,*) da sonst probeleme mit leerem ids array
		/*$query = 'SELECT uploads.*, plan.*
					FROM '.$db->nameQuote('#__com_verplan_plan').' AS plan,
						'.$db->nameQuote('#__com_verplan_uploads').' AS uploads
					WHERE plan.id_upload = uploads.id 
						AND uploads.`Geltungsdatum` LIKE '.$db->quote($date."%").' 
						AND uploads.`Stand` LIKE'.$db->quote($stand."%");

		$db->setQuery($query);
		$assozArray_rows = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}*/
		
		$model = $this->getModel('plan');
		$assozArray_rows = $model->getRows($date, $stand);

		/*
		 * zum debuggen einfach einmal // vor die zeile mit
		 * debug setzten -> kommentar wird aufgehoben
		 */

		/*debug
		 echo "query für rows";
		 echo $query;
		 var_dump($assozArray_rows);
		 //*/



		//lädt die spalten, aus der tabelle columns durch das model columns
		$model =& $this->getModel('columns');
		$assozArray_cols = $model->getColumns('name');


		/*SORT*/
		/*
		 * sortieren - schnelle/einfache lösung
		 * http://php.net/manual/en/array.sorting.php
		 *
		 * http://www.php.net/manual/en/function.array-multisort.php
		 * example 3
		 */
		$order = array();
		$id = array();
		foreach ($assozArray_cols as $key => $row) {
			$order[$key] = $row['order'];
			$id[$key] = $row['id'];
		}
		//sortiert nach mehreren spalten
		array_multisort($order, SORT_ASC, $id, SORT_ASC, $assozArray_cols);

		/*debug
		 var_dump($order);
		 echo "==================";
		 var_dump($id);
		 echo "==================";
		 var_dump($assozArray_cols);
		 echo "==================";
		 //*/

		/*OPTIONS*/
		switch ($options) {
			case all:
				$array[infos] = $infosarray;
				$array[cols] = $assozArray_cols;
				$array[rows] = $assozArray_rows;
				break;

			case none:
				$array[infos] = $infosarray;
				$array[cols] = $assozArray_cols;
				break;
					
			default:
				$array[infos] = $infosarray;
				//nur bestimmte spalten sollen angezeigt werden
				//erzeugt ein array mit den spaltennamen, die richtig sind
				$richtigeSpaltenArray = array();
				foreach ($assozArray_cols as $key => $subarray) {
					if ($subarray[show] == 1) {
						$richtigeSpaltenArray[] = $subarray[name];
					}
				}

				//sort($richtigeSpaltenArray);

				//läuft durch alle spalten durch
				foreach ($richtigeSpaltenArray as $key => $colname) {
					$array[cols][$colname] = $assozArray_cols[$colname];
					for ($i = 0; $i < count($assozArray_rows); $i++) {
						$array[rows][$i][$colname] = $assozArray_rows[$i][$colname];
					}
				}
				break;
		}

		//debug
		//var_dump($array);

		//testarray zum debuggen
		//$array = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);

		/* gibt den vertretungsplan als array zurueck
		 * (nur die zeilen mit passendem datum und stand)
		 */
		return $array;
	}


	/**
	 * array mit allen allen möglichkeiten einer
	 * spalte aus der verplatabelle
	 * @return array
	 */
	function getUniques($lookForMe){
		/*$db =& JFactory::getDBO();
		$query = 'SELECT DISTINCT '.$db->nameQuote($lookForMe).' FROM '.$db->nameQuote('#__com_verplan_plan').' WHERE 1';
		$db->setQuery($query);
		$array = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		return $array;*/
		
		$model =& $this->getModel('plan');
		return $model->getUniques($lookForMe);
	}

	
}
