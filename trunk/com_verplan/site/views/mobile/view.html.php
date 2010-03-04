<?php
/**
 * versorgt das template des frontends mit den nötigen daten
 * für mobile geräte
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
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

class verplanViewMobile extends JView
{
	function display($tpl = null)
	{		
		//variablen, wichtig falls js deaktiviert
		$date = JRequest::getVar('date','none');
		$stand = JRequest::getVar('stand','latest');
		$options = JRequest::getVar('options',',');
		$format = JRequest::getVar('format','html');
		$tmpl = JRequest::getVar('tmpl');

		/*
		 * verschiedene optionen möglich
		 * 0. : optionen für das controller
		 * 1. : optionen für den view
		 * die optionen sind mit komma getrennt
		 */
		$optionsarray = explode(',',$options);

		//stand und datum und options aus get
		$this->assignRef( 'date', $date);
		$this->assignRef( 'stand', $stand);
		$this->assignRef( 'options', $options);
		$this->assignRef( 'tmpl', $tmpl);

		//controller uploads laden
		$name = 'uploads';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();
			
		//alle geltungsdaten als array

		//holt sich das array mit daten und ständen
		$datesandstands = $controller->getDatesAndStands();

		/*DATEN*/

		//settingsmodel
		$settingsmodel = JModel::getInstance('Settings', 'VerplanModel');

		//falls noch keine daten vorhanden sind, wird dieser teil ignoriert
		if (isset($datesandstands)) {
			
			//erzeugt ein array, welches nur die daten (datums) enthält
			foreach ($datesandstands as $key => $value) {
				$dates[] = $key;
			}

			//jeden wert nur einmal
			array_unique($dates);
			//array sortieren
			rsort($dates);

			/* datum über url, der umweg wird gemacht,
			 * damit das datum wirklich richtig formatiert ist
			 */
			$url = $this->date;
			$url_date = date( 'Y-m-d', strtotime($url));

			//jetzt
			$now = time();
			$now_date = date( 'Y-m-d', $now);

			//morgen
			$tomorrow  = mktime(0, 0, 0, date("m",$now)  , date("d",$now)+1, date("Y",$now));
			$tomorrow_date = date( 'Y-m-d', $tomorrow);

			/*
			 * sorgt dafür, dass nur eine bestimmte anzahl
			 * an daten gezeigt wird.
			 * neuere, als heute werden zusätzlich angezeigt
			 *
			 * gleichzeitig wird das datum in das richtige format überführt
			 */
			$number_show = $settingsmodel->getSetting('number_show');
			$anzahl = $number_show;
			for ($i = 0, $o = 0; $i < count($dates) && $o < $anzahl; $i++, $o++) {
				$timestamp = strtotime($dates[$i]);
				if ($timestamp > $now) {
					$o--;
				}
				$dates_show[] = date('Y-m-d', $timestamp);
			}

			$dates = $dates_show;

			//sucht die option, die gewählt werden soll
			if (in_array($url_date,$dates)) {
				//echo "url";
				$which = array_search($url_date,$dates);
			} elseif (in_array($tomorrow_date,$dates)){
				//echo "tomorrow";
				$which = array_search($tomorrow_date,$dates);
			} elseif (in_array($now_date,$dates)){
				//echo "today";
				$which = array_search($now_date,$dates);
			}

			/*debug
			 var_dump($dates);
			 var_dump($url);
			 var_dump($now);
			 var_dump($now_date);
			 var_dump($tomorrow);
			 var_dump($tomorrow_date);
			 var_dump($which);
			 //*/

			//dates an template übergeben
			$this->assignRef( 'dates', $dates);
			//übegeben, welches datum ausgewählt werden soll
			$this->assignRef( 'which', $which);
		}
		
		//namen für klassenfilter
		$classname = $settingsmodel->getSetting('class_col');
		$this->assignRef( 'classname', $classname);
		$varname = $settingsmodel->getSetting('class_name');
		$this->assignRef( 'varname', $varname);
		
		//versionsnummer
		//version number
		$version = $settingsmodel->getSetting('version');
		$this->assignRef( 'version', $version);
		
		//Benutzerrechte überprüfen
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

		//controller plan laden
		$name = 'plan';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();

		//array des vertretungsplanes und der spalten
		$array = $controller->getVerplanarray($date,$stand,$optionsarray[0]);
		
		//vertretungsplan sortieren		
		//var_dump($array);		
		if ($array[rows]) {
			$klassen = array();
			foreach ($array[rows] as $key => $row) {
				$klassen[] = $row[$classname];
			}
			
			for ($i = 0; $i < count($klassen); $i++) {
				
				//echo $klassen[$i].'->';
				
				//wenn einstellig, dann 0 hinzufügen
				$matches = preg_match("/^([0-9])[a-z]{0,}$/", $klassen[$i]);
				//echo 'matches: '.$matches.' ';
				if ($matches > 0 ) {
					for ($o = 1; $o < 10; $o++) {
						$klassen[$i] = str_replace($o,'0'.$o,$klassen[$i]);
					}
				}				
				
				//buchstaben durch zahlen ersetzen
				$buchstaben = array('a','b','c','d','e','f','g','h','i');
				$zahlen = array('1','2','3','4','5','6','7','8','9');
				$klassen[$i] = str_replace($buchstaben,$zahlen,$klassen[$i]);

				//echo $klassen[$i].'<br>';
			}
			//var_dump($klassen);
			
			//sortiert nach mehreren spalten
			array_multisort($klassen, SORT_ASC, $array[rows]);
		
			//array_multisort($array['rows'][][$classname]);
		}
		$this->assignRef( 'verplanArray', $array);

		$this->assignRef( 'format', $format);

		//template laden
		parent::display($tpl);
	}// function
}// class