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

		$this->heads($data);
		
		for ($i = 1; $i < count($data); $i++) {
			print_r($data[$i]);
			
		}
		

		//$row =& $this->getTable();
		//print_r($row);

		//datenbankfunktionen

		return true;
	}

	/**
	 * methode zum vervollstaendigen der tabellekoepfe der
	 * plantabelle und der spaltentabellen
	 *
	 * @return anzahl der neuen tabellenkoepfe
	 */
	function heads($data){
		//datenbankfunktionen
		global $db;
		$db =& JFactory::getDBO();

		/*SPALTENTABELLE*/
		//laedt die namen der spalten
		$query = 'SELECT name FROM #__com_verplan_columns ORDER BY `id`';
		$db->setQuery( $query );
		$columns_names = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		//debug
		//print_r($columns_names);

		//jede spalte (als zeile) wird ueberprueft und gegebenenfalls hinzugefuegt
		foreach ($data[0] AS $column_name) {
			if (!in_array($column_name,$columns_names)) {
				$query = 'INSERT INTO `#__com_verplan_columns` (`name`) VALUES(\''.$column_name.'\');';
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					$msg = $db->getErrorMsg();
					JError::raiseWarning(0,$msg);
				}
			}
		}

		/*PLANTABELLE*/
		//laedt die namen der spalten
		$query = 'SHOW COLUMNS FROM #__com_verplan_plan';
		$db->setQuery( $query );
		$columns_names = $db->loadResultArray();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		//debug
		//print_r($columns_names);

		//jede spalte wird ueberprueft und gegebenenfalls hinzugefuegt
		foreach ($data[0] AS $column_name) {
			if (!in_array($column_name,$columns_names)) {
				$query = 'ALTER TABLE `jos_com_verplan_plan` ADD `'.$column_name.'` TEXT NULL';
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum()) {
					$msg = $db->getErrorMsg();
					JError::raiseWarning(0,$msg);
				}
			}
		}		

		return true;
	}
}