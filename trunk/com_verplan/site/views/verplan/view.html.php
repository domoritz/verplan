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
		 * 0. : optionen für das model
		 * 1. : optionen für den view
		 */
		$optionsarray = explode(',',$options);

		//debug
		//echo "date: ".$date;
		//echo "stand: ".$stand;

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


		//Standardmodel laden
		$model =& $this->getModel();

		//stand und datum und options aus get
		$this->assignRef( 'date', $date);
		$this->assignRef( 'stand', $stand);
		$this->assignRef( 'options', $options);

		//alle geltungsdaten als array
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		$datesandstands = $datamodel->getDatesAndStands();
		foreach ($datesandstands as $key => $value) {
			$dates[] = $key;
		}
		
		//jeden wert nur einmal
		array_unique($dates);
		//array sortieren
		rsort($dates);		
		
		//debug
//		echo "<pre>";
//		var_dump($dates);
//		echo "</pre>";
		
		$this->assignRef( 'dates', $dates);

		//array mit daten und zugeordneten ständen
		$datamodel = JModel::getInstance('Data', 'VerplanModel');
		//$both = $datamodel->getDatesAndStands();
		//$this->assignRef( 'datesAndStands', $both);

		//array des vertretungsplanes und der spalten
		$array = $datamodel->getVerplanarray($date,$stand,$optionsarray[0]);
		$this->assignRef( 'verplanArray', $array);

		$this->assignRef( 'format', $format);

		//debug
		//var_dump($dates);

		parent::display($tpl);
	}// function
}// class