<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 29-Sep-2009
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Data verplan Model
 *
 * @package    verplan
 * @subpackage models
 */
class VerplanModelData extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
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

		//holt sich das array mit daten und ständen
		$dates_stands = $this->getDatesAndStands();

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

		/*
		 * übersetzt datum und stand in id, wobei die
		 * daten aus der datenbank kommen müssen, weil
		 * der platzhalter % möglich sein soll
		 *
		 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich,
		 * z.b. alle daten von 2009 zu bekommen
		 * bei fehlern wird eine meldung ausgegeben
		 *
		 * sonst könnte man einfach das nehmen:
		 * $id = $dates_stands[$date][$stand];
		 */
		$query = 'SELECT '.$db->nameQuote('id').'
				FROM '.$db->nameQuote('#__com_verplan_uploads').' 
				WHERE Geltungsdatum LIKE '.$db->quote($date."%").' AND `Stand` LIKE'.$db->quote($stand."%");
		$db->setQuery($query);
		$ids = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		/*debug
		echo "query für ids";
		echo $query;
		var_dump($assozArray_ids);
		//*/

		/*
		 * lädt die passenden daten als assoziatives array aus der datenbank, dabei werden
		 * nur die entsprechenden zeilen mit den richtigen ids gezeigt
		 */
		//ids in string
		foreach($ids as $key => $id) {
			$in.=",".$id;
		}
		//(0,*) da sonst probeleme mit leerem ids array
		$query = 'SELECT uploads.*, plan.* 
					FROM '.$db->nameQuote('#__com_verplan_plan').' AS plan,
						'.$db->nameQuote('#__com_verplan_uploads').' AS uploads
					WHERE plan.id_upload IN (0'.substr($in,0).') 
						AND plan.id_upload = uploads.id';
																
		$db->setQuery($query);
		$assozArray_rows = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		/*debug
		echo "query für rows";
		echo $query;
		var_dump($assozArray_rows);
		//*/



		//lädt die spalten, aus der tabelle columns
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_columns');
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		$assozArray_cols = $db->loadAssocList('name');

		/*SORT*/
		/*
		 * sortieren - schnelle/einfache lösung
		 * http://php.net/manual/en/array.sorting.php
		 * 
		 * http://www.php.net/manual/en/function.array-multisort.php
		 * example 3
		 */
		$sort = array();
		$id = array();
		foreach ($assozArray_cols as $key => $row) {
			$sort[$key] = $row['sort'];
			$id[$key] = $row['id'];
		}
		//sortiert nach mehreren spalten
		array_multisort($sort, SORT_ASC, $id, SORT_ASC, $assozArray_cols);
		
		/*debug		
		var_dump($sort);
		echo "==================";
		var_dump($id);
		echo "==================";
		var_dump($assozArray_cols);
		echo "==================";
		//*/

		/*OPTIONS*/
		switch ($options) {
			case all:
				$array[cols] = $assozArray_cols;
				$array[rows] = $assozArray_rows;
				break;

			case none:
				$array[cols] = $assozArray_cols;
				break;
					
			default:
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
	 * methode, zum laden des planes aus der datenbank
	 * in ein array für das dataTable plugin
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function getVerplanarrayForDataTable($date,$stand){
		$db =& JFactory::getDBO();

		$array = array();

		//falls nur der neueste stand zurückgegeben werden soll
		if ($stand == "newest") {
			//holt sich das array mit daten und ständen
			$stands = $this->getDatesAndStands();
			//nimmt nur das passende subarray
			$stands = $stands[$date];
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

		/*
		 * lädt die passenden daten als assoziatives array aus der datenbank
		 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich,
		 * z.b. alle daten von 2009 zu bekommen
		 * bei fehlern wird eine meldung ausgegeben
		 *
		 */
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_plan').' WHERE Geltungsdatum LIKE '.$db->quote($date."%").' AND Stand LIKE '.$db->quote($stand."%");
		$db->setQuery($query);
		$assoz_array = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		//debug
		//echo $query;

		//nicht assoziativ
		$i = 0;
		$o = 0;
		foreach ($assoz_array as $subarray){
			foreach ($subarray as $value) {
				$array[aaData][$i][$o] = $value;
				$o++;
			}
			$i++;
		}

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
		$db =& JFactory::getDBO();
		$query = 'SELECT DISTINCT '.$db->nameQuote($lookForMe).' FROM '.$db->nameQuote('#__com_verplan_plan').' WHERE 1';
		$db->setQuery($query);
		$array = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		return $array;
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
		$db =& JFactory::getDBO();

		//erste ebene laden /daten
		$query = 'SELECT DISTINCT '.$db->nameQuote('Geltungsdatum').' FROM '.$db->nameQuote('#__com_verplan_uploads').' WHERE 1';
		$db->setQuery($query);
		$datearray = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		//zweite ebene laden /stände
		for($i = 0; $i < count($datearray); $i++) {
			$query = 'SELECT DISTINCT '.$db->nameQuote('Stand').'
						FROM '.$db->nameQuote('#__com_verplan_uploads').' 
						WHERE '.$db->nameQuote('Geltungsdatum').' LIKE '.$db->quote($datearray[$i]);
			$db->setQuery($query);
			$subarray = $db->loadResultArray();
			if ($db->getErrorNum()) {
				$msg = $db->getErrorMsg();
				JError::raiseWarning(0,$msg);
			}
			/*
			 * assoziatives array ($array) wird zusammen gebaut
			 * aus $datearay und $subarray
			 */

			$array[$datearray[$i]]= $subarray;
		}

		//debug
		//		echo "dates and stands";
		//		echo "<pre>";
		//		var_dump($array);
		//		echo "<pre>";

		return $array;
	}
}