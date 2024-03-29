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
class VerplanModelUploads extends JModel
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
	 * holt aus der db eine liste mit allen werten einer spalte
	 * dabei taucht jeder wert nur einmal auf (distinct)
	 * 
	 * @param $column	welche spalte
	 * @param $where, $like	 	bedingungen
	 * @return array
	 */
	function getDistinct($column, $where, $like) {
		$db =& JFactory::getDBO();

		//erste ebene laden /daten
		$query = 'SELECT DISTINCT '.$db->nameQuote($column).'
				FROM '.$db->nameQuote('#__com_verplan_uploads').' 
				WHERE '.$db->nameQuote($where).' 
				LIKE '.$db->quote($like);
		$db->setQuery($query);
		$distarray = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		return $distarray;
	}

	/**
	 * holt die infos wie typ, stand, datum usw für ein datum aus der db
	 * 
	 * @param $date Geltungsdatum, für das die infos gesucht werden
	 * @return array
	 */
	function getInfos($date, $stand){
		$db =& JFactory::getDBO();
		
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_uploads').'WHERE `Geltungsdatum` LIKE '.$db->quote($date."%").'AND `Stand` LIKE '.$db->quote($stand."%");
		$db->setQuery($query);
		$infosarray = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		
		/*debug
		echo $query;
		var_dump($infosarray);
		//*/
		
		return $infosarray;
	}

}