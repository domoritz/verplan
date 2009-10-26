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
	 * key
	 *
	 * @var string
	 */
	var $name = null;
	
	/**
	 * wert der einstellung
	 *
	 * @var string
	 */
	var $value = null;
	
	/**
	 * default wert der einstellung
	 *
	 * @var string
	 */
	var $default = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSettings(& $db) {
		parent::__construct('#__com_verplan_settings', 'name', $db);
	}
}