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
		$query = 'SELECT * FROM `#__com_verplan_settings`';
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

	/**
	 *
	 * @return
	 */
	function setSetting($data){
		$table =& $this->getTable();
		if (!$table->save($data)){
			JError::raiseWarning( 500, $table->getError() );
		}

		return true;

	}// function


	/**
	 * methode, zum speichern der einstellungen in die datenbank
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function setSettings($data){
		//var_dump($data);

		//$data = $this->array_htmlentities($data);
		
		//var_dump($data);

		foreach ($data as $id => $subarray) {
			$table =& $this->getTable();
			if (!$table->save($subarray)){
				JError::raiseWarning( 500, $table->getError() );
			}
		}

		return true;

	}

	/**
	 * wandelt alle values eines arrays mit htmlentities um
	 * 
	 * @param $elem
	 * @return unknown_type
	 */
	function array_htmlentities(&$elem)
	{
		if (!is_array($elem))
		{
			$elem=htmlentities($elem);
		}
		else
		{
			foreach ($elem as $key=>$value)
			$elem[$key]=$this->array_htmlentities($value);
		}
		return $elem;
	} // array_htmlentities()
}