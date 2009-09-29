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

/**
 * Plan Table class
 *
 *
 * @package    verplan
 * @subpackage table
 */
class TablePlan extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $greeting = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableHello(& $db) {
		parent::__construct('#__plan', 'id', $db);
	}
}