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
		//var_dump($file);
		
		//Dateiinhalt der plandatei aus temp laden
		$FileHandle = fopen($file[tmp_name], "r" ) ;
		$n = $file[size];
		$inhalt = fread( $FileHandle , $n ) ;
		fclose( $FileHandle ) ;

		//falls es sich um eine datei handelt, die in die DB eigelesen werden kann
		if (strpos($inhalt, "Untis")) {
			echo "upload";
			// upload controller laden
			$name = 'upload';
			require_once(JPATH_COMPONENT.DS.'controllers'.DS.$name.'.php');
			
			$controllerName = verplanController.ucfirst($name);
			$controller = new $controllerName();		
			
	    	//$controller->execute('upload');
		} else {
			$msg = 'Datei kann nicht eingelesen werden';
			$this->setRedirect( 'index.php?option=com_verplan', $msg );
		}
		
		
	}
}
