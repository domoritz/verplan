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

/**
 * Plan Table class
 *
 *
 * @package    verplan
 * @subpackage table
 */
class TableColumns extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	/**
	 * name der spalte in der db
	 *
	 * @var string
	 */
	var $name = null;
	
	/**
	 * 
	 *
	 * @var int
	 */
	var $ordering = null;
	
	/**
	 * spalte anzeigen
	 *
	 * @var string
	 */
	var $published = null;
	
	/**
	 * typ (optional für sortierung)
	 *
	 * @var string
	 */
	var $type = null;
	
	/**
	 * alternativer name
	 *
	 * @var string
	 */
	var $label = null;
	
	/**
	 * Beschreibung, die im Tooltip angezeigt wird
	 *
	 * @var string
	 */
	var $description = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableColumns(& $db) {
		parent::__construct('#__com_verplan_columns', 'id', $db);
	}
}