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
		$this->registerTask('setColumnAjax','setColumnAjax');
	}

	/**
	 * speichert die einstellungen
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
	 * speichert die einstellungen
	 * @return void
	 */
	function setColumn() {
		//debug
		//var_dump(JRequest::get('columns'));

		$column = JRequest::get('columns');

		$model = $this->getModel('columns');
		$model->setColumn($column);

		$msg = 'Spalte gespeichert';
		$this->setRedirect( 'index.php?option=com_verplan', $msg );
	}

	function setColumnAjax() {
		//debug
		//var_dump(JRequest::get('columns'));

		$column = JRequest::get('columns');

		$model = $this->getModel('columns');
		$model->setColumn($column);
		
		echo "Spalte gespeichert";
	}
}
