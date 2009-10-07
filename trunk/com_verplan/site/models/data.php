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
		global $db;
		$db =& JFactory::getDBO();

		/*
		 * lädt die passenden daten als assoziatives array aus der datenbank
		 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich, 
		 *   z.b. alle daten von 2009 zu bekommen
		 * bei fehlern wird eine meldung ausgegeben
		 * 
		 */
		$query = 'SELECT * FROM #__com_verplan_plan WHERE Geltungsdatum LIKE \''.$date.'%\' AND Stand LIKE \''.$stand.'%\'';
		$db->setQuery($query);
		$array = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		//debug
		echo $query;
		
		//debug
		//print_r($array);

		//testarray zum debuggen
		//$array = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
		
		/* gibt den vertretungsplan als array zurueck
		 * (nur die zeilen mit passendem datum und stand)
		 */
		return $array;
	}
}