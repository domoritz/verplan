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
	 * methode, die die tabelle uploads berschreibt
	 * hierin befinden sich die daten:
	 * stand, geltungsdatum, (dtaen/datei)typ, 
	 * url zur hochgeladenen datei und ein timestamp
	 * 
	 * in die plantabelle kommen dann nur noch die ids
	 * 
	 * @param $data
	 * @return id für den stand, das geltungsdatum und den timestamp
	 */
	function log_in_uploads($data){
		$id = 0;
		return $id;
	}

	/**
	 * methode, zum speichern des planes in die datenbank
	 * es werden nur die plandaten gespeichert
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store($data)
	{
		//debug
		//print_r($data);

		$this->heads($data);

		//datenbankfunktionen
		global $db;
		$db =& JFactory::getDBO();

		/*
		 * läuft durch alle zeilen durch und schreibt jede einzeln
		 */
		$query = 'INSERT INTO '.$db->nameQuote('#__com_verplan_plan');
		$query .= " (";
		//fuegt die spalten ein, in die eingefuegt wird
		foreach ($data[0] AS $column_name){
			$query.=$db->nameQuote($column_name).",";
		}
		//entfernt das letzte komma, damit die sql syntax valide ist
		$query = substr($query, 0, -1);
		$query.=")\n VALUES";
		for ($i = 1; $i < count($data); $i++) {
			print_r($data[$i]);
			$query.="\n(";

			//die daten
			foreach ($data[$i] AS $column_name){
				$query.= $db->quote($column_name).",";
			}
				
			//entfernt das letzte komma, damit die sql syntay valide ist
			$query = substr($query, 0, -1);
			$query.="),";
		}
		//entfernt das letzte komma, damit die sql syntay valide ist
		$query = substr($query, 0, -1);
		$query.=";";

		//debug
		echo $query."\n";

		//fuehrt befehl aus
		$db->setQuery($query);
		$db->query();
		if ($db->getErrorNum()) {
		$msg = $db->getErrorMsg();
		JError::raiseWarning(0,$msg);
		}

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
		//bei fehlern
		if ($db->getErrorNum()) {
			//errornachricht
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