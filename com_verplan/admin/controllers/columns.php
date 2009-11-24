<?php
/**
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
class VerplanControllerColumns extends verplanController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('setColumns','setColumns');
		$this->registerTask('setColumn','setColumn');
		$this->registerTask('reorder','reorder');
	}

	/**
	 * nicht unterstützt
	 * 
	 * @return void
	 */
	function setColumns() {
		//debug
		var_dump(JRequest::get('columns'));

		/*$arr_in = JRequest::get('columns');

		$i = 0;
		foreach ($arr_in as $setting => $value) {
		$arr_out[$i][name] = $setting;
		$arr_out[$i][value] = $value;
		$i++;
		}

		$model = $this->getModel('settings');
		$model->setSettings($arr_out);

		$msg = 'Einstellungen gespeichert';
		$this->setRedirect( 'index.php?option=com_verplan', $msg );*/
	}

	/**
	 * speichert eine spalte
	 * 
	 * @return void
	 */
	function setColumn() {
		//debug
		//var_dump(JRequest::get('columns'));

		//get variable
		$column = JRequest::get('columns');

		//an model weiterreichen
		$model = $this->getModel('columns');
		$model->setColumn($column);

		$msg = 'Spalte gespeichert';
		
		//für ajax
		$ajax = JRequest::getVar('ajax', false);
		if ($ajax == 'true') {
			//weiterreichen an ajax view/template
			$this->setRedirect( "index.php?option=com_verplan&format=js&msg=$msg", $msg);
		} else {
			$this->setRedirect( 'index.php?option=com_verplan', $msg );			
		}
	}
	
	/**
	 * weiterreichen an model
	 * @return unknown_type
	 */
	function reorder () {
		
		$model = $this->getModel('columns');
		$msg = $model->reorder();
		
		echo $msg;
			
		$this->setRedirect( 'index.php?option=com_verplan', $msg );			
	}
}
