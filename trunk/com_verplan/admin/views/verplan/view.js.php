<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the verplan Component
 *
 * @package    verplan
 */
class verplanViewVerplan extends JView
{
	function display($tpl = null)
	{
		/*$id = JRequest::getVar('id');
		$name = JRequest::getVar('name');
		$order = JRequest::getVar('order');
		$published = JRequest::getVar('published');
		$label = JRequest::getVar('label');*/
		
		echo "test";

		//parent::display($tpl);
	}// function
}// class