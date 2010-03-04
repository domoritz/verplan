<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 30-Oct-2009
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
class VerplanModelPlan extends JModel
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
	 * lädt die daten der zeilen als assoziatives array aus der datenbank,
	 * dabei werden nur die zeilen geladen, in denen der richtige stand und
	 * das richtige datum sind. das wird erreicht, indem die tabellen uploads und
	 * plan in beziehung gesetzt werden. datum und stand werden sehr liberal behandelt.
	 * so heißt "2009-02", dass alle stände aus dem februar 2009 geladen werden
	 *
	 *
	 * % ist ein platzhalter für beliebige zeichen. dadurch ist es möglich,
	 * z.b. alle daten von 2009 zu bekommen
	 * bei fehlern wird eine meldung ausgegeben
	 * 
	 * @param $date Geltungsdatum
	 * @param $stand Stand
	 * @return array mit zeilen
	 *
	 */
	function getRows($date, $stand){
		$db =& JFactory::getDBO();
		
		//führe abfrage aus
		$query = 'SELECT uploads.*, plan.*
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
		}

		return $assozArray_rows;
	}

	/**
	 * array mit allen allen möglichkeiten von daten einer
	 * spalte aus der verplatabelle
	 * 
	 * @param $lookForMe spalte, die zurückgegeben werden soll
	 * @return array
	 */
	function getUniques ($lookForMe) {
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
}