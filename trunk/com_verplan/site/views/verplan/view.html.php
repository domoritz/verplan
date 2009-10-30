<?php
/**
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
 *
 * @package    verplan
 */

class verplanViewverplan extends JView
{
	function display($tpl = null)
	{
		//ohne Model
		$nojs = '<p><strong>Achtung:</strong><br>Bitte aktiviere JavaScript um den vollen Funktionsumfang nutzen zu können! </p>';
		$this->assignRef('nojs',$nojs);

		//variablen, falls js deaktiviert
		$date = JRequest::getVar('date','none');
		$stand = JRequest::getVar('stand','latest');
		$options = JRequest::getVar('options',',min');
		$format = JRequest::getVar('format','html');

		/*
		 * verschiedene optionen möglich
		 * 0. : optionen für das controller
		 * 1. : optionen für den view
		 */
		$optionsarray = explode(',',$options);

		//Standardmodel laden
		$model =& $this->getModel();

		//stand und datum und options aus get
		$this->assignRef( 'date', $date);
		$this->assignRef( 'stand', $stand);
		$this->assignRef( 'options', $options);

		//controller uploads laden
		$name = 'uploads';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();
			
		//alle geltungsdaten als array
		
		//holt sich das array mit daten und ständen
		$datesandstands = $controller->getDatesAndStands();
		
		foreach ($datesandstands as $key => $value) {
			$dates[] = $key;
		}
		
		//jeden wert nur einmal
		array_unique($dates);
		//array sortieren
		rsort($dates);
		
		//dates an template übergeben
		$this->assignRef( 'dates', $dates);

		//controller plan laden
		$name = 'plan';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();

		//array des vertretungsplanes und der spalten
		$array = $controller->getVerplanarray($date,$stand,$optionsarray[0]);
		$this->assignRef( 'verplanArray', $array);

		$this->assignRef( 'format', $format);

		//template laden
		parent::display($tpl);
	}// function
}// class