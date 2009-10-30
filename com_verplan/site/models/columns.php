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
class VerplanModelColumns extends JModel
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
	 * gibt ein assoziatives array mit allen spalten zurück
	 * der parameter legt fest, welche spalte als index benutzt werden soll
	 * 
	 * @param index
	 * @return array
	 */
	function getColumns($index){
		$db =& JFactory::getDBO();

		//array laden
		$query = 'SELECT * FROM '.$db->nameQuote('#__com_verplan_columns');
		$db->setQuery($query);
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		$assozArray_cols = $db->loadAssocList($index);
		
		//debug
		//var_dump($assozArray_cols);
			
		return $assozArray_cols;
	}// function
}