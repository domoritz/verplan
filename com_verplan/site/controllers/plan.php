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
		$this->registerTask('getUniques','getUniques');
	}


	/**
	 * methode, zum laden des planes aus der datenbank
	 * in ein assoziatives array der form
	 *
	 * Array
	 * (
	 * 		[infos] => Array ()
	 * 		[cols] => Array ()
	 * 		([rows] => Array ())
	 * )
	 *
	 * @access	public
	 * @param $date		Geltungsdatum
	 * @param $stand	Stand
	 * @param $options	Optionen was angezeigt werden soll
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
		$infosarray = $controller->getInfos($date);
		

		/*debug
		 echo "query für infos";
		 echo $query;
		 var_dump($infosarray);
		 //*/

		/*ROWS*/
		
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


		/*COLUMNS*/

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
			$order[$key] = $row['ordering'];
			$id[$key] = $row['id'];
		}
		//sortiert nach mehreren spalten
		array_multisort($order, SORT_ASC, $id, SORT_ASC, $assozArray_cols);

		/*debug
		 echo "nach sortierung";
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
					if ($subarray[published] == 1) {
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
	 * weiterreichung an model
	 * 
	 * @param $lookForMe spalte, die zurückgegeben werden soll
	 * @return array
	 */
	function getUniques($lookForMe){		
		$model =& $this->getModel('plan');
		$uniques = $model->getUniques($lookForMe);
		return $uniques;
	}

	
}