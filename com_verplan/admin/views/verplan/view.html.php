<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 14-Sep-2009
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

		//Link zu Frontpage laden
		$link = $model->getLinkFrontpage();
		$this->assignRef('link', $link);
		
		//Link zu Frontpage laden
		$description = $model->getDescription();
		$this->assignRef('description', $description);
		
		//lade Settings
		$newmodel = JModel::getInstance('Settings', 'VerplanModel');
		$settings =& $newmodel->get('Settings');
		$this->assignRef('settings', $settings);
		

		parent::display($tpl);
	}// function
}// class