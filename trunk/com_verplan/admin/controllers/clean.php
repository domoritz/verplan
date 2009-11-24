<?php
/**
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
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
		//debug
		//var_dump(JRequest::get('settings'));	
		
		
		//parameter für clean: anzahl der uploads, die behalten werden
		//uploads der zukunft bleiben immer erhalten
		$model = $this->getModel('clean');
		$anzGel = $model->clean(JRequest::getVar('keep'));
		
		
		$msg = 'Datenbank bereinigt '.$anzGel.' Einträge gelöscht';
		
		//für ajax
		$ajax = JRequest::getVar('ajax', false);
		if ($ajax == 'true') {
			//weiterreichen an ajax view/template
			$this->setRedirect( "index.php?option=com_verplan&format=js&msg=$msg", $msg);
		} else {
			$this->setRedirect( 'index.php?option=com_verplan', $msg );			
		}
	}
}
