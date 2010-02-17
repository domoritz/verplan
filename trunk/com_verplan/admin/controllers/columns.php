<?php
/**
 * verwaltung der spalten vom backend aus
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
		
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}
		
		$columns = JRequest::get('columns');
		
		//debug
		var_dump($columns);
		
		$data = array();
		
		foreach ($columns as $name => $value) {
			$pair = explode('#',$name);
			if (count($pair) == 2) {
				$data[$pair[0]][$pair[1]] = $value;
			}
		}
		
		foreach ($data as $id => $subarray) {
			$data[$id]['id'] = $id;
			if (!$data[$id]['published']) {
				$data[$id]['published'] = 0;
			}
		}
		
		//var_dump($data);
		
		//an model weiterreichen
		$model = $this->getModel('columns');
		
		if ($model->setColumns($data)) {
			$msg = 'Spalten gespeichert';
		} else {
			$msg = 'Fehler beim Speichern';
		}
		
		echo $msg;
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( "index.php?option=com_verplan&view=columns", $msg);
		}
	}

	/**
	 * speichert eine spalte
	 * 
	 * @return void
	 */
	function setColumn() {
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}
		
		//get variable
		$column = JRequest::get('column');
		
		//debug
		var_dump($column);

		//an model weiterreichen
		$model = $this->getModel('columns');

		if ($model->setColumn($column)) {
			$msg = 'Spalte gespeichert';
		} else {
			$msg = 'Fehler beim Speichern';
		}
		
		echo $msg;
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( "index.php?option=com_verplan&view=columns", $msg);
		}			
	}
	
	/**
	 * weiterreichen an model
	 * @return unknown_type
	 */
	function reorder () {
		//für debug
		$debug = JRequest::getVar('debug', false);
		if ($debug == 'true') {
			echo 'Debug mode<br>==========<br>';
		}
		
		$model = $this->getModel('columns');
			
		if ($model->reorder()) {
			$msg = 'Sortierung neu aufgebaut';
		} else {
			$msg = 'Fehler beim Sortieren';
		}
		
		echo $msg;
		
		if ($debug == 'true') {
			echo '<br>==========<br>';
		} else {
			//weiterreichen an view/template
			$this->setRedirect( "index.php?option=com_verplan&view=columns", $msg);
		}			
	}
}
