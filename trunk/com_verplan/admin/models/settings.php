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
class VerplanModelSettings extends JModel
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
	 * gibt ein assoziatives array mit allen einstellungen in der form
	 * key=>value zurueck
	 * @return array
	 */
	function getSettings(){		
		$db =& JFactory::getDBO();
 
		//zweidimensionales array laden
	    $query = 'SELECT * FROM `#__com_verplan_settings`';
	    $db->setQuery( $query );
	    $extended_settingsarray = $db->loadObjectList ();
	    
	    //array in eindimensionales umwandeln
	    $settingsarray = array();
		foreach ($extended_settingsarray as $row) {
			$key=$row->key;
			$value=$row->value;
			$settingsarray[$key] = $value;
		}
		
		return $settingsarray;
	}// function
	

	/**
	 * methode, zum speichern des planes in die datenbank
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function setSettings(){
		return true;
	}
}