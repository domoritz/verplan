<?php
/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author     	Created on 24-Nov-2009
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Clean verplan Model
 *
 * @package    verplan
 * @subpackage models
 */
class VerplanModelClean extends JModel
{
	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * diese funktion bereinigt die datenbank und
	 * den ordner uploads
	 * 
	 * @param anzahl der uploads, die behalten werden
	 * uploads der zukunft bleiben immer erhalten
	 * 
	 * bei keep = -1 werden alle gelöscht
	 */
	function clean($anzahl){
		
		///*debug
		echo '<br>==========<br>';
		echo 'Anzahl (keep)<br>';
		var_dump($anzahl);
		//*/
		
		/*
		 * umwandeln der timestamps in mysql timestamps
		 * kann einfach entfernt werden, dann wird nicht umgewandelt
		 *
		 * Timestamps
		 *
		 * PHP -> MySQL
		 * $date = date( 'Y-m-d H:i:s', $date );
		 *
		 * MySQL -> PHP
		 * $date = strtotime($date);
		 *
		 */
		
		$gel = 0;
		
		$uploads = $this->getUploads();		
		
		if ($anzahl < 0) {
			//alle einträge löschen
			foreach ($uploads as $nummer => $subarray) {
				$this->remove($subarray);
			}
			$gel = "alle";
						
		} else {
			//nur bestimmte einträge löschen
			foreach ($uploads as $nummer => $subarray) {
				$geltungsdatum = strtotime($subarray[Geltungsdatum]);
				$now = time();			
				
				//falls das geltungsdatum größer ist, als jetzt, dann soll die löschung übersprungen werden
				if ($geltungsdatum > $now || $anzahl > 0) {
					if ($anzahl > 0) {
						$anzahl--;
					}
				} else {
					$gel += $this->remove($subarray);
					$anzahl--;
				}
			}
		}
		
		
		
		
		///*debug
		echo '<br>==========<br>';
		echo 'Gelöschte Einträge<br>';
		var_dump($gel);
		//*/
		
		return $gel;
		
	}// function
	
	function remove($subarray) {
		
		//var_dump($subarray);
		
		//holt das verzeichnis, in dem die dateien liegen aus der datenbank
		$name = 'settings';
		require_once(JPATH_COMPONENT.DS.'models'.DS.$name.'.php');

		$modelName = verplanModel.ucfirst($name);
		$model = new $modelName();
		
		$dir = JPATH_COMPONENT.DS.$model->getSetting('upload_dir_comp').DS.basename($subarray[url]);

		///*debug
		echo '<br>==========<br>';
		echo 'Verzeichnis<br>';
		var_dump($dir);
		//*/	
		
		//löscht die datei
		if (file_exists($dir)) { 
			unlink ($dir);
			echo  $dir."<br>";
		}

		
		//löscht die datenabnkeinträge
		$db =& JFactory::getDBO();
		
		$query = 'DELETE FROM '.$db->nameQuote('#__com_verplan_uploads').' 
				WHERE id = '.$db->quote($subarray[id]);
		echo $query;
		$db->setQuery($query);
		$result = $db->query();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		
		///*debug
		echo '<br>==========<br>';
		echo 'Ergebnis (uploads)<br>';
		var_dump($result);
		//*/
		
		echo "<br>";
		
		
		$query = 'DELETE FROM '.$db->nameQuote('#__com_verplan_plan').' 
				WHERE id_upload = '.$db->quote($subarray[id]);
		echo $query;
		$db->setQuery($query);
		$result = $db->query();
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}
		
		///*debug
		echo '<br>==========<br>';
		echo 'Ergebnis (plan)<br>';
		var_dump($result);
		//*/
		
		//anzahl der gelöschten einträge höher
		return 1;		
		
	}
	
	
	/**
	 * gibt ein assoziaives array mit den
	 * daten aus der tabelle uploads zurück.
	 * dise esnthält unter naderm die daten, ids und andere infos
	 * 
	 * @return unknown_type
	 */
	function getUploads() {
		$db =& JFactory::getDBO();

		//erste ebene laden /daten
		$query = 'SELECT *
				FROM '.$db->nameQuote('#__com_verplan_uploads').' 
				WHERE 1 ORDER BY `Geltungsdatum` DESC';
		$db->setQuery($query);
		$uploads = $db->loadAssocList('id');
		if ($db->getErrorNum()) {
			$msg = $db->getErrorMsg();
			JError::raiseWarning(0,$msg);
		}

		return $uploads;
	}
}