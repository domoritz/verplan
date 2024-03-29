<?php
/**
 * versorgt das template des js settings views mit daten
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 * view: mobile
 * @package    verplan
 */

class verplanViewSettings extends JView
{
	function display($tpl = null)
	{
		/*Einstellungen*/

		//settingsmodel
		$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');
		
		$settingsarray = $settingsmodel->getSettings();
		$this->assignRef( 'settings', $settingsarray);

		//template laden
		parent::display($tpl);
	}// function
}// class