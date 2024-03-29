<?php
/**
 * versorgt das template des frontends mit den nötigen daten
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
 *
 * @package    verplan
 */

class verplanViewverplan extends JView
{
	function display($tpl = null)
	{
		
		//prüfen, ob die Seite mit einem Mobilen Endgerät aufgerufen wurde
		//require(JPATH_COMPONENT.DS.'includes'.DS.'php'.DS.'check_mobile.php');
		require(JPATH_COMPONENT.DS.'includes'.DS.'php'.DS.'detect.php');
		
		//wenn get mobile true oder false, dann dass beachten, sonst automatisch
		$mobile = false;
		
		//$mobile_browser = check_mobile();
		$mobile_browser = $Browser != "OTHER";
		
		if (($mobile_browser || JRequest::getVar('mobile') == 'true') && JRequest::getVar('mobile') != 'false'){
			//$this->setRedirect( 'index.php?option=com_verplan&view=mobile', $msg );
			//header( JURI::base().'/index.php?option=com_verplan&view=mobile' );
			$mobile = true;					
		}			
		
		//direkt per php weiterleiten
		if ($mobile){
			header("Location: ".JURI::base()."?option=com_verplan&view=mobile&tmpl=component"); exit;
		}
		
		//oder mobil an template weitergeben
		$this->assignRef('mobile',$mobile);

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

		//jquery laden?
		$load_jquery = $settingsmodel->getSetting('load_jquery_frontend');
		$this->assignRef( 'load_jquery', $load_jquery);
		
		//jqueryUI laden?
		$load_jqueryui = $settingsmodel->getSetting('load_jqueryui_frontend');
		$this->assignRef( 'load_jqueryui', $load_jqueryui);
		
		//einleitungstext
		$einltext = $settingsmodel->getSetting('head_text'); 		
		$this->assignRef('einltext',$einltext);
		
		//versionsnummer
		//version number
		$version = $settingsmodel->getSetting('version');
		$this->assignRef( 'version', $version);

		//controller plan laden
		$name = 'plan';
		require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
		$controllerName = verplanController.ucfirst($name);
		$controller = new $controllerName();

		//array des vertretungsplanes und der spalten
		$array = $controller->getVerplanarray('','','cols');
		$this->assignRef( 'verplanArray', $array);

		$this->assignRef( 'format', $format);

		//template laden
		parent::display($tpl);
	}// function
}// class