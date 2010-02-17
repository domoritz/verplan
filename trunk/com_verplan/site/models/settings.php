<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 8-Nov-2009
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
	 * name => value
	 * 		=> name
	 * 		=> ...
	 * zurueck
	 * 
	 * @return array
	 */
	function getSettings(){
		$db =& JFactory::getDBO();

		//zweidimensionales array laden
		$query = 'SELECT `name`,`value`,`default` FROM `#__com_verplan_settings`';
		$db->setQuery( $query );
		$settingsarray = $db->loadAssocList('name');
		
		//debug
		//var_dump($settingsarray);
			
		return $settingsarray;
	}// function


	/**
	 *
	 * @return
	 */
	function getSetting($name){
		$table =& $this->getTable('settings');
		$table->load($name);

		//debug
		//var_dump($table);
		//var_dump($table->value);

		return ($table->value);


	}// function
}