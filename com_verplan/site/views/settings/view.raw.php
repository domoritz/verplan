<?php
/**
 * versorgt das template des frontends mit den nötigen daten
 * für mobile geräte
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
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
		
		$options = JRequest::getVar('options');
		$this->assignRef( 'options', $options);

		//template laden
		parent::display($tpl);
	}// function
}// class