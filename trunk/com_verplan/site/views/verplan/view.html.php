<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */

class verplanViewverplan extends JView
{
	function display($tpl = null)
	{
		//Standardmodel laden
		$model =& $this->getModel();
		
		//alle stände und geltungsdaten als arrays
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		$stands = $datamodel->getUniques('Stand');
		$dates = $datamodel->getUniques('Geltungsdatum');
		$this->assignRef( 'stands', $stands);
		$this->assignRef( 'dates', $dates);
		
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		$both = $datamodel->getDatesAndStands();
		$this->assignRef( 'datesAndStands', $both);
		
		$array = $datamodel->getVerplanarray(2009,newest);
		$this->assignRef( 'verplanArray', $array);
		
		//debug
		//print_r($dates);
		
		parent::display($tpl);
	}// function
}// class