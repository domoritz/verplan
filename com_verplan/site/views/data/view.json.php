<?php
/**
 * versorgt das template für die JSON Datei mit Daten (Vertretungsplan API)
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Jan-2010
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');
jimport( 'joomla.factory' );

/**
 * HTML View class for the verplan Component
 * view: mobile
 * @package    verplan
 */

class verplanViewData extends JView
{
	function display($tpl = null)
	{		
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
		
		
		
		//Benutzerrechte überprüfen
		//settingsmodel
		$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');
		$public = $settingsmodel->getSetting('public');
		
		//zugang gewährt
		$access = true;
		
		//wenn nicht öffentlich, dann überprüfen
		if ($public == "false") {
			$user =& JFactory::getUser();		
			if ($user->guest) {    
			     $access = false;
			}
		}	

		$this->assignRef( 'access', $access);
		$this->assignRef( 'public', $public);
		
		//lädt das template json, welches dann den vertretungsplan als json anzeigt
		parent::display($tpl);
	}// function
}// class