<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Okt-2009
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
	function display($tpl = "array")
	{
		//Model laden
		$model =& $this->getModel();
		
		
		$date = JRequest::getVar('date');
		$stand = JRequest::getVar('stand');
		
		//verplanarray laden und an template übergeben
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		$array = $datamodel->getVerplanarray($date,$stand);
		$this->assignRef( 'verplanarray', $array);
		
		//laedt das template json, welches dann den vertretungsplan als json anzeigt
		parent::display($tpl);
	}// function
}// class