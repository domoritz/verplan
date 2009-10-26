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
		$this->registerTask('test','test');
	}

	/**
	 * speichert die einstellungen
	 * @return void
	 */
	function setSettings() {
		//debug
		var_dump(JRequest::get('settings'));	
		
		$arr_in = JRequest::get('settings');
		
		/*$db =& JFactory::getDBO();
		$key = $db->nameQuote('key');
		$arr_out[0][name] = 'max_file_size';
		$arr_out[0][value] = $arr_in['max_file_size'];
		
		$arr_out[1]['key'] = 'allowed_filetypes';
		$arr_out[1]['value'] = $arr_in['allowed_filetypes'];*/
		
		$i = 0;
		foreach ($arr_in as $setting => $value) {
			$arr_out[$i][name] = $setting;
			$arr_out[$i][value] = $value;
			$i++;
		}
		
		$model = $this->getModel('settings');
		$model->setSettings($arr_out);
		echo "speichern";
		return true;
	}
	
	function test(){
		echo 'controller settings';
		$model = $this->getModel('settings');
		$model->getSetting('max_file_size');
	}

}
