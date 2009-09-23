<?php
/**
 * @version $Id$
 * @package    verplan
 * @subpackage _ECR_SUBPACKAGE_
 * @author     EasyJoomla {@link http://www.easy-joomla.org Easy-Joomla.org}
 * @author     Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @author     Created on 14-Sep-2009
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
	
	/**
	 * speichert array des planes in der datenbank ab,
	 * bei erfolg wird true zurueck gegeben
	 * @return boolean
	 */
	function plan_to_database() {
		
		return true;
	}// function
	
}// class