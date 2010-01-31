<?php
/**
 * versorgt das template für die JSON Datei mit Daten (Vertretungsplan API)
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
 * view: mobile
 * @package    verplan
 */

class verplanViewData extends JView
{
	function display($tpl = null)
	{
		//Model laden
		$model =& $this->getModel();
		
		//daten aus POST/GET laden
		$date = JRequest::getVar('date');
		$stand = JRequest::getVar('stand');
		$options = JRequest::getVar('options');
		
		/*
		 * verschiedene optionen möglich
		 * 0. : optionen für das controller 
		 * 1. : optionen für den view
		 */
		$optionsarray = explode(',',$options);

		
		//stand und datum aus get options für view
		$this->assignRef( 'date', $date);
		$this->assignRef( 'stand', $stand);
		$this->assignRef( 'options', $optionsarray[1]);
		
		//controller plan laden
		$name = 'plan';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();
		
		//verplanarray laden und an template übergeben
		$array = $controller->getVerplanarray($date,$stand,$optionsarray[0]);
		$this->assignRef( 'verplanarray', $array);
		
		//lädt das template json, welches dann den vertretungsplan als json anzeigt
		parent::display($tpl);
	}// function
}// class