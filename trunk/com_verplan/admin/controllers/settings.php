<?php
/**
 * verwaltet die einstellungen
 *
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
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
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}
				
		$arr_in = JRequest::get('settings');
		
		//Probleme mit getVar, weil html entfernt beheben
		$arr_in['message'] = JRequest::getVar('message', '', '' , 'STRING', JREQUEST_ALLOWRAW);
		$arr_in['head_text'] = JRequest::getVar('head_text', '', '' , 'STRING', JREQUEST_ALLOWRAW);
		//echo htmlentities($arr_in['head_text']);
		
		//debug
		var_dump($arr_in);
		
		$i = 0;
		foreach ($arr_in as $setting => $value) {
			$arr_out[$i][name] = $setting;
			$arr_out[$i][value] = $value;
			$i++;
		}
		
		$model = $this->getModel('settings');
		
		
				

		if ($model->setSettings($arr_out)) {
			$msg = 'Einstellungen gespeichert';
		} else {
			$msg = 'Fehler beim Speichern';
		}
		
		echo $msg;
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( 'index.php?option=com_verplan&view=settings', $msg );
		}

	}
}
