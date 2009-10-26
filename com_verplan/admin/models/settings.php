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
		$query = 'SELECT name,value FROM `#__com_verplan_settings`';
		$db->setQuery( $query );
		$settingsarray_ext = $db->loadAssocList('name');
		
		//debug
		//var_dump($settingsarray_ext);
		
		$settingsarray = array();
		
		foreach ($settingsarray_ext as $key => $subarray) {
			$settingsarray[$subarray[name]] = $subarray[value];
		}
		
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

	/**
	 *
	 * @return
	 */
	function setSetting($data){
		$table =& $this->getTable();
		if (!$table->save($data)){
			JError::raiseWarning( 500, $table->getError() );
		}

	}// function


	/**
	 * methode, zum speichern der einstellungen in die datenbank
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function setSettings($data){
		//var_dump($data);

		foreach ($data as $id => $subarray) {
			$table =& $this->getTable();
			if (!$table->save($subarray)){
				JError::raiseWarning( 500, $table->getError() );
			}
		}
		
		return true;

	}
}