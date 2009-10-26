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
	 *
	 * @return void
	 */
	function send() {

		//holt die dateiinfos
		$file = JRequest::getVar('file', null, 'files', 'array');
			
		//debug
		//var_dump($file);

		if (empty($file[name])) {
			$msg = "keine Datei ausgewählt";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		} else {

			// upload controller laden
			$name = 'upload';
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');

			$controllerName = verplanController.ucfirst($name);
			$controller = new $controllerName();

			//datei hochladen (methode upload in controller upload)
			$file = $controller->execute('upload');

			//debug
			var_dump($file);

			//Dateiinhalt der plandatei aus temp laden
			$FileHandle = fopen($file[dest], "r" ) ;
			$n = $file[size];
			$inhalt = fread( $FileHandle , $n ) ;
			fclose( $FileHandle ) ;

			//falls es sich um eine datei handelt, die in die DB eigelesen werden kann
			if (strpos($inhalt, "Untis")) {

				//nun kann die datei geparst werden
				$data = $controller->parse_file_to_array($file);

				//debug
				var_dump($data);


				//und dann werden die daten noch gespeichert
				/*
				* an dieser stelle wird das model data aufgerufen und die methode
				* store mit dem array des vertretungsplanes als uebergabewert aufgerufen
				*
				* das array enthält alle daten, des planes inklusive einer id für datum und stand
				*/
				$model = $this->getModel('data');
				$model->store($data);

				if (!JERROR::getError()) {
					//Erfolg melden
					//zu bebuggzwecken kann man dies auskommentieren und kann sich dann den ablauf ansehen
					$msg = 'Senden und parsen erfolgreich';
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				}

			} else {
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
					$msg = "Bitte Geltungsdatum angeben";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} elseif (empty($stand_date)) {
					$msg = "Bitte Stand angeben";
					$this->setRedirect( 'index.php?option=com_verplan', $msg );
				} else {

					//debug
					//var_dump($upload_arr);

					$model = $this->getModel('data');
					$model->log_in_uploads($upload_arr);

					if (!JERROR::getError()) {
						$msg = "Senden erfolgreich, ohne DB";
						$this->setRedirect( 'index.php?option=com_verplan', $msg );
					}
				}
			}


		}
	}
}
