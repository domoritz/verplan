<?php
/**
 * Viewcontroller für das admin backend
 * von hier aus werden die daten an das template übergeben
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-01-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */
class VerplanViewAbout extends JView
{
	function display($tpl = null)
	{
		//lade Settings
		$newmodel = JModel::getInstance('Settings', 'VerplanModel');
		$settings =& $newmodel->getSettings();
		$this->assignRef('settings', $settings);

		parent::display($tpl);
	}// function
}// class