<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 06-Sep-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */

class verplanViewverplan extends JView
{
	function display($tpl = null)
	{
		//Model laden
		$model =& $this->getModel();
		
		$greeting_model = $model->getGreeting();
		$greeting_view = 'Hello World (view) !';
		
		$this->assignRef( 'greeting_model', $greeting_model );
		$this->assignRef( 'greeting_view', $greeting_view );

		parent::display($tpl);
	}// function
}// class