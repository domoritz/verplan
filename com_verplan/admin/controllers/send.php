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
		//var_dump($this->getTasks());
	  
		//holt die dateiinfos
		$file = JRequest::getVar('file', null, 'files', 'array');
		//debug
		//var_dump($file);

		//Dateiinhalt der plandatei aus temp laden
		$FileHandle = fopen($file[tmp_name], "r" ) ;
		$n = $file[size];
		$inhalt = fread( $FileHandle , $n ) ;
		fclose( $FileHandle ) ;

		//falls es sich um eine datei handelt, die in die DB eigelesen werden kann
		if (strpos($inhalt, "Untis")) {
			// upload controller laden
			$name = 'upload';
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
				
			$controllerName = verplanController.ucfirst($name);
			$controller = new $controllerName();
				
			//rückgabewert der methode upload aus upload
			$dest = $controller->execute('upload');
			
			//debug
			var_dump($dest);
				
			//nun kann die datei geparst werden
			$data = $controller->parse_file_to_array($dest);
			
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
			//$model->store($data);

			if (!JERROR::getError()) {
				//Erfolg melden
				//zu bebuggzwecken kann man dies auskommentieren und kann sich dann den ablauf ansehen
				$msg = 'Parsen und Senden erfolgreich';
				//$this->setRedirect( 'index.php?option=com_verplan', $msg );
			}

		} else {
			$msg = "Datei eingestellt, ohne DB";
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}


	}
}
