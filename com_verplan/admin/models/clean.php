<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 24-Nov-2009
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Clean verplan Model
 *
 * @package    verplan
 * @subpackage models
 */
class VerplanModelClean extends JModel
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
	 * 
	 */
	function clean(){
		$db =& JFactory::getDBO();

		//zweidimensionales array laden
		$query = 'SELECT * FROM `#__com_verplan_columns`';
		$db->setQuery( $query );
		$anzGel = $db->loadAssocList('name');
		
		//debug
		//var_dump($settingsarray);
		
		return $anzGel;
	}// function
}