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

	function getRows($date, $stand){
		$db =& JFactory::getDBO();
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