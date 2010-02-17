<?php
/**
 * die funktionen in dieser datei sorgen dafür, dass datenbankeinträge 
 * und hochgeladene dateien gelöscht werden. 
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 24-Nov-2009

 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Verplan Clean Controller
 *
 * @package    verplan
 * @subpackage controller
 */
class VerplanControllerClean extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('clean','clean');
	}

	/**
	 * berinigt die datenbank von unnötigen einträgen um
	 * speicherplatz zu sparen
	 * @return boolean
	 */
	function clean() {
		
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}	
		
		
		//parameter für clean: anzahl der uploads, die behalten werden
		//uploads der zukunft bleiben immer erhalten
		$model = $this->getModel('clean');
		$anzGel = $model->clean(JRequest::getVar('keep'));
		
		
		$msg = 'Datenbank bereinigt '.$anzGel.' Einträge gelöscht';
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( "index.php?option=com_verplan", $msg);
		}			
	}
}
