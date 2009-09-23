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

jimport( 'joomla.application.component.model' );

/**
 * verplan Model
 *
 * @package    verplan
 * @subpackage Models
 */
class verplanModelverplan extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getGreeting()
	{
		return 'Hello World (model) !';
	}// function

	function getArray()
	{
		$array = array(0,2,5,4,3,7,3,5,4);
		return $array;
	}// function

	function getVerplan($date,$stand){
		$db =& JFactory::getDBO();
 		
		$where = 'date = '.$date.'and stand='.$stand;
	   	$query = 'SELECT greeting FROM #__verplan WHERE '.$where;
	   	$db->setQuery( $query );
	   	$array = $db->loadResult();
	   	return $array;
	}
}// class