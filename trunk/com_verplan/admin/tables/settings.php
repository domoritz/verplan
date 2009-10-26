<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 26-Oct-2009
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Plan Table class
 *
 *
 * @package    verplan
 * @subpackage table
 */
class TableSettings extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	/**
	 * 
	 *
	 * @var string
	 */
	var $key = null;
	
	/**
	 * 
	 *
	 * @var string
	 */
	var $value = null;
	
	/**
	 * 
	 *
	 * @var boolean (short int)
	 */
	var $editable = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSettings(& $db) {
		parent::__construct('#__com_verplan_settings', 'id', $db);
	}
}