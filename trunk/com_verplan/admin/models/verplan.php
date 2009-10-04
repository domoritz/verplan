<?php
/**
 * 
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author		Created on 14-Sep-2009
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
	function getDescription(){
		return 'Komponente zum Einstellen des Vertretungsplanes auf die Website des MCG (<a href="http://www.marie-curie-gymnasium-dallgow.de/">http://www.marie-curie-gymnasium-dallgow.de/</a>).';
	}// function
	
	function getLinkFrontpage(){
		return 'Bitte gehe auf die <a target="_blank" href="../index.php?option=com_verplan" target="_blank">Frontpage</a>.';
	}// function
	
	/**
	 * gibt ein assoziatives array mit allen einstellungen in der form
	 * key=>value zurueck
	 * @return array
	 */
	function getSettings(){		
		$db =& JFactory::getDBO();
 
		//zweidimensionales array laden
	    $query = 'SELECT * FROM `#__com_verplan_settings`';
	    $db->setQuery( $query );
	    $extended_settingsarray = $db->loadObjectList ();
	    
	    //array in eindimensionales umwandeln
	    $settingsarray = array();
		foreach ($extended_settingsarray as $row) {
			$key=$row->key;
			$value=$row->value;
			$settingsarray[$key] = $value;
		}
		
		return $settingsarray;
	}// function
	
}// class