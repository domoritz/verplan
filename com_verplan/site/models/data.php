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
	 * in ein assoziatives array
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function getVerplanarray($date,$stand){
		$db =& JFactory::getDBO();

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
			sort($stands,1);
			
			//debug
			//print_r($stands);
			
			//weist den stand zu
			$stand = $stands[0];
		}

		/*
		 * lädt die passenden daten als assoziatives array aus der datenbank
		 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich,
		 *   z.b. alle daten von 2009 zu bekommen
		 * bei fehlern wird eine meldung ausgegeben
		 *
		 */
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_plan').' WHERE Geltungsdatum LIKE '.$db->quote($date."%").' AND Stand LIKE '.$db->quote($stand."%");
		$db->setQuery($query);
		$array = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		//debug
		//echo $query;

		//debug
		//print_r($array);

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
	 * @return array
	 */
	function getDatesAndStands(){
		$db =& JFactory::getDBO();

		//erste ebene laden /daten
		$query = 'SELECT DISTINCT '.$db->nameQuote('Geltungsdatum').' FROM '.$db->nameQuote('#__com_verplan_plan').' WHERE 1';
		$db->setQuery($query);
		$datearray = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		//zweite ebene laden /stände
		for($i = 0; $i < count($datearray); $i++) {
			$query = 'SELECT DISTINCT '.$db->nameQuote('Stand').'
						FROM '.$db->nameQuote('#__com_verplan_plan').' 
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
		//echo "<pre>";
		//print_r($array);
		//echo "<pre>";

		return $array;
	}
}