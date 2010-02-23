<?php
/**
 * hauptdatei für das einstellen des vertretungsplanes
 * die funktion send() wird direkt aufgerufen, wenn ein vertretungsplan
 * abgesendet wurde. hier wird dann entschieden, wie weiter verfahren wird.
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
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
		
		/*
		 * Es gibt drei mögliche scenarien:
		 * 1. kein vertretungsplan (nur geltungsdatum und stand angegeben)
		 * 2. alternative datei (datei, die nicht geparst werden kann+ geltungsdatum und stand) 
		 * 3. parsbare datei (geltunsdatum und stand ignoriert)
		 */
		
		if (empty($file[name])) {

			//keine Vertretungen

			//array mit den infos für die tabelle uploads
			$upload_arr = array();
			$upload_arr['Geltungsdatum'] = JRequest::getVar('date', null); //geltungsdatum
			$upload_arr['Stand'] = JRequest::getVar('stand', null).' '.JRequest::getVar('stand_time', null);//stand
			$upload_arr['type'] = 'none'; //typ
			$upload_arr['url'] = '';

			$stand_date = JRequest::getVar('stand', null);

			if (empty($upload_arr['Geltungsdatum'])) {
				$notice = "Bitte Geltungsdatum angeben oder eine Datei wählen";
				JError::raiseNotice( 100, $notice);
				//$this->setRedirect( 'index.php?option=com_verplan', $msg );
			} elseif (empty($stand_date)) {
				$notice = "Bitte Stand angeben oder eine Datei wählen";
				JError::raiseNotice( 100, $notice);
				//$this->setRedirect( 'index.php?option=com_verplan', $msg );
			} else {

				///*debug
				echo '<br>==========<br>';
				echo 'Infos wenn ohne DB<br>';
				var_dump($upload_arr);
				//*/

				$model = $this->getModel('data');
				$model->log_in_uploads($upload_arr);

				if (!JERROR::getError()) {
					$msg = "Senden erfolgreich, keine Vertretungen";
					$msg = $msg. ' <br><a href="'.JURI::root().'?option=com_verplan#'.$upload_arr['Geltungsdatum'].'" style="margin-left: 30px;">zum Plan</a>';
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}
			}
				
		} else {
			//normal parsen

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
			if (strpos($inhalt, "Untis") && ($file['type'] == 'text/html')) {

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

				
				// noch die informationen über den upload speichern
				$model = $this->getModel('data');
				$controller->id = $model->log_in_uploads($controller->upload_arr);
				
				///*debug
				echo '<br>==========<br>';
				echo 'Daten zum Upload<br>';
				var_dump($controller->upload_arr);
				//*/
				
				//id_upload an geparste daten anhängen
				$controller->execute('append_id');
				
				///*debug
				echo '<br>==========<br>';
				echo 'id_upload<br>';
				var_dump($controller->id);
				//*/
				
				//und dann werden die daten noch gespeichert
				$controller->execute('store');
				
				
				//datei löschen, wenn aktiviert
				$settingsmodel = $this->getModel('settings');
				$keep = $settingsmodel->getSetting('keep_files');
				if ($keep == 'false') {
					//datei löschen
					$success = $controller->execute('remove');
					
					
					///*debug
					echo '<br>==========<br>';
					echo 'Datei vom Server entfernen: ';
					print($success ? 'erfolgreich': 'Fehler');
					echo '<br>';

					//*/

				}

				if (!JERROR::getError()) {
					//Erfolg melden
					//zu bebuggzwecken kann man dies auskommentieren und kann sich dann den ablauf ansehen
					$msg = "Senden und Parsen erfolgreich";					
					$date = date('Y-m-d',$controller->date);
					$msg = $msg. ' <br><a href="'.JURI::root().'?option=com_verplan#'.$date.'" style="margin-left: 30px;">zum Plan</a>';
					
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}

			} elseif ($file['type'] == 'text/xml') {
				//xml parsen
				//noch nicht implementiert/ programmiert
				
			} else {
				//falls es sich nicht um eine parsbare datei handelt

				//var_dump(JURI::base(true));
				$path = JURI::base(true)."/components/com_verplan/uploads/".JFile::makeSafe($file['name']);

				//array mit den infos für die tabelle uploads
				$upload_arr = array();
				$upload_arr['Geltungsdatum'] = JRequest::getVar('date', null); //geltungsdatum
				$upload_arr['Stand'] = JRequest::getVar('stand', null).' '.JRequest::getVar('stand_time', null);//stand
				$upload_arr['type'] = $file['type']; //typ
				$upload_arr['url'] = $path; //url zur hochgeladenen datei

				$stand_date = JRequest::getVar('stand', null);

				if (empty($upload_arr['Geltungsdatum'])) {
					$notice = "Bitte Geltungsdatum angeben";
					JError::raiseNotice( 100, $notice);
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} elseif (empty($stand_date)) {
					$notice = "Bitte Stand angeben";
					JError::raiseNotice( 100, $notice);
					//$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} else {

					///*debug
					echo '<br>==========<br>';
					echo 'Infos wenn ohne DB<br>';
					var_dump($upload_arr);
					//*/

					//speichere infos zum upload
					$model = $this->getModel('data');
					$model->log_in_uploads($upload_arr);

					if (!JERROR::getError()) {
						$msg = "Senden erfolgreich, ohne DB";
						$msg = $msg. ' <br><a href="'.JURI::root().'?option=com_verplan#'.$upload_arr['Geltungsdatum'].'" style="margin-left: 30px;">zum Plan</a>';
						//$this->setRedirect( 'index.php?option=com_verplan', $msg );
					}
				}
			}


		}
		
		echo '<br>==========<br>';
		echo "<strong>Nachricht:</strong> ".$msg;
		echo '<br><a href="?option=com_verplan">OK</a>';
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( "index.php?option=com_verplan", $msg);
		}

	}
}
