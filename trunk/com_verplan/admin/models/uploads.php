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
	 * key=> zurueck
	 * @return array
	 */
	function getUploads(){
		$db =& JFactory::getDBO();

		//zweidimensionales array laden
		$query = 'SELECT `name`,`value`,`default` FROM `#__com_verplan_uploads`';
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
	function getUpload($name){
		$table =& $this->getUploads('settings');
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
	function setUpload($data){
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
	function setUploads($data){
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