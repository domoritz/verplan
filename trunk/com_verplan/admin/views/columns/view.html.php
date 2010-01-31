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
 * @author      Created on 31-Jan-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */
class VerplanViewColumns extends JView
{
	function display($tpl = null)
	{
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

		parent::display($tpl);
	}// function
}// class