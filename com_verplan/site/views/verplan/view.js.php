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

class verplanViewverplan extends JView
{
	function display($tpl = json)
	{
		//Model laden
		$model =& $this->getModel();
		
		
		$date = JRequest::getVar('date');
		$stand = JRequest::getVar('stand');
		$options = JRequest::getVar('options');
		
		/*
		 * verschiedene optionen möglich
		 * 0. : optionen für das model 
		 * 1. : optionen für den view
		 */
		$optionsarray = explode(',',$options);

		/*
		 * Timestamps
		 * 
		 * PHP -> MySQL
		 * $date = date( 'Y-m-d H:i:s', $date );
		 * 
		 * MySQL -> PHP
		 * $date = strtotime($date);
		 * 
		 */
		
		//stand und datum aus get options für view
		$this->assignRef( 'date', $date);
		$this->assignRef( 'stand', $stand);
		$this->assignRef( 'options', $optionsarray[1]);
		
		//verplanarray laden und an template übergeben
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		$array = $datamodel->getVerplanarray($date,$stand,$optionsarray[0]);
		$this->assignRef( 'verplanarray', $array);
		
		//laedt das template json, welches dann den vertretungsplan als json anzeigt
		parent::display($tpl);
	}// function
}// class