<?php
/**
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 25-Okt-2009

 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * verplan Upload Controller
 *
 * @package    verplan
 * @subpackage controller
 */
class VerplanControllerSend extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('send','send');
	}

	/**
	 * funktion, die den upload verarbeitet
	 * hier werden die methoden des vertretungsplanes aufgerufen und 
	 *
	 * @return void
	 */
	function send() {
		
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}

		//holt die dateiinfos
		$file = JRequest::getVar('file', null, 'files', 'array');
			
		///*debug
		echo '<br>==========<br>';
		echo 'Fileinfos aus getVar<br>';
		var_dump($file);
		//*/

		if (empty($file[name])) {
			$msg .= "keine Datei ausgewählt";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		} else {

			// upload controller laden
			$name = 'upload';
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');

			//instanz des controllers wird erzeugt
			$controllerName = verplanController.ucfirst($name);
			$controller = new $controllerName();

			//datei hochladen (methode upload in controller upload)
			$controller->execute('upload');
			$file = $controller->file;

			///*debug
			echo '<br>==========<br>';
			echo 'Fileinfos nach upload und vor einlesen<br>';
			var_dump($controller->file);
			//*/
			
			//inhalt einlesen
			$controller->execute('einlesen');
			$inhalt = $controller->inhalt;

			//falls es sich um eine datei handelt, die in die DB eigelesen werden kann
			if (strpos($inhalt, "Untis")) {
				
				//umlaute austauschen (auf string, auskommentiert)
				//$controller->execute('umlaute');

				//nun kann die datei geparst werden
				$controller->execute('parse_file_to_array');

				///*debug
				echo '<br>==========<br>';
				echo 'nach Parsen<br>';
				var_dump($controller->data);
				//*/
				
				//codiert datei richtig
				$controller->execute('charset');
				
				//umlaute austauschen (htmlentities auf array)
				//$controller->execute('umlaute');

				//und dann werden die daten noch gespeichert
				$controller->execute('store');

				if (!JERROR::getError()) {
					//Erfolg melden
					//zu bebuggzwecken kann man dies auskommentieren und kann sich dann den ablauf ansehen
					$msg .= "Senden und parsen erfolgreich";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}

			} else {
				//falls es sich nicht um eine parsbare datei handelt
				
				//var_dump(JURI::base(true));
				$path = JURI::base(true)."/components/com_verplan/uploads/".JFile::makeSafe($file['name']);

				//array mit den infos für die tabelle uploads
				$upload_arr = array();
				$upload_arr[Geltungsdatum] = JRequest::getVar('date', null); //geltungsdatum
				$upload_arr[Stand] = JRequest::getVar('stand', null).' '.JRequest::getVar('stand_time', null);//stand
				$upload_arr[type] = $file[type]; //typ
				$upload_arr[url] = $path; //url zur hochgeladenen datei

				$stand_date = JRequest::getVar('stand', null);

				if (empty($upload_arr[Geltungsdatum])) {
					$msg .= "Bitte Geltungsdatum angeben";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} elseif (empty($stand_date)) {
					$msg .= "Bitte Stand angeben";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} else {

					///*debug
					echo '<br>==========<br>';
					echo 'Infos wenn ohne DB<br>';
					var_dump($upload_arr);
					//*/

					$model = $this->getModel('data');
					$model->log_in_uploads($upload_arr);

					if (!JERROR::getError()) {
						$msg .= "Senden erfolgreich, ohne DB";
						$this->setRedirect( 'index.php?option=com_verplan', $msg );
					}
				}
			}


		}


		//für ajax
		$ajax = JRequest::getVar('ajax', false);		
		
		if ($debug == 'true') {
				echo $msg.'<br>==========<br>';
				$mainframe =& JFactory::getApplication();
				$mainframe->close();
		} elseif ($ajax == 'true') {
				//weiterreichen an ajax view/template
				$this->setRedirect( "index.php?option=com_verplan&format=js&msg=$msg", $msg);
		}

	}
}
