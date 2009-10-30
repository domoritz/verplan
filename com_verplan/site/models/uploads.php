<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
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

		return $distarray();
	}

	function getInfos ($date){
		$db =& JFactory::getDBO();
		
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_uploads').'WHERE `Geltungsdatum` LIKE '.$db->quote($date."%");
		$db->setQuery($query);
		$infosarray = $db->loadAssocList();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		
		return $infosarray;
	}

}