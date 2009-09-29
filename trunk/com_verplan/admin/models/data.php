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
class VerplanModelData extends JModel
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
	 * methode, zum speichern des planes in die datenbank
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store($data)
	{	
		//debug
		//print_r($data);
		
		//datenbankfunktionen
		$db =& JFactory::getDBO();

		return true;
	}
	
	/**
	 * 
	 * @return anzahl der neuen tabellenkoepfe
	 */
	function heads($tablehead){
		
		$new = 0;
		return $new;
	}
}