<?php
/**
 * verwaltet die einstellungen
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 4-Okt-2009

 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * verplan Upload Controller
 *
 * @package    verplan
 * @subpackage controller
 */
class VerplanControllerSettings extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('setSettings','setSettings');
	}

	/**
	 * speichert die einstellungen
	 * @return void
	 */
	function setSettings() {
		//debug
		//var_dump(JRequest::get('settings'));	
		
		$arr_in = JRequest::get('settings');
		
		$i = 0;
		foreach ($arr_in as $setting => $value) {
			$arr_out[$i][name] = $setting;
			$arr_out[$i][value] = $value;
			$i++;
		}
		
		$model = $this->getModel('settings');
		$model->setSettings($arr_out);
		
		$msg = 'Einstellungen gespeichert';
		
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
