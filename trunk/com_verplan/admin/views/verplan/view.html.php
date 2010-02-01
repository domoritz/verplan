<?php
/**
 * Viewcontroller für das admin backend
 * von hier aus werden die daten an das template übergeben
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */
class verplanViewVerplan extends JView
{
	function display($tpl = null)
	{
		//model laden
		$model =& $this->getModel();

		//lade Settings
		$newmodel = JModel::getInstance('Settings', 'VerplanModel');
		$settings =& $newmodel->getSettings();
		$this->assignRef('settings', $settings);

		//lade columns
		$newmodel = JModel::getInstance('Columns', 'VerplanModel');
		$columns =& $newmodel->getColumns();
		$this->assignRef('columns', $columns);

		//sortierung übergeben, standard ist ordering
		$sort = JRequest::getVar('sort','ordering');
		$this->assignRef( 'sort', $sort);

		//setzt die versionsnummer
		$this->updateVersion();

		parent::display($tpl);
	}// function

	/**
	 * Funktion zum updaten der versionsnummer. 
	 * dies geschieht automatisch, wenn die adminseite aufgerufen wird
	 * @return unknown_type
	 */
	function updateVersion(){
		/*
		 * Update der versionsnummer, falls diese nicht bei der isntallation erkannt wurde
		 */

		$path = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_verplan'.DS.'com_verplan.xml';
		//echo $path;
		$dataxml = JApplicationHelper::parseXMLInstallFile($path);
		//var_dump($data);
		//echo $data[version];

		//daten für jtable
		$data = array(
			'id' => 1,
			'name' => 'version',
			'value' => $dataxml[version],
			'default' => $dataxml[version],
		);

		//var_dump($data);

		//jtable laden
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_verplan'.DS.'tables');
		$table = JTable::getInstance('settings', 'Table');

		//var_dump($table);

		if (!$table->save($data)){
			JError::raiseWarning( 500, $table->getError() );
		}
	}
}// class