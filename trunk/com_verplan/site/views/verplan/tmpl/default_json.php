<?php
/**
 * template zum anzeigen der daten als JSON
 * dise daten kann man natürlich auch in anderen programmen 
 * nutzen, indem man einfach die daten über die URL abruft.
 * die syntax ist
 * /index.php?option=com_verplan&view=verplan&format=js&date=<mySQL Timestamp>&stand=<mySQL Timestamp>
 * 
 * Timestamps
 * 
 * PHP -> MySQL
 * $date = date( 'Y-m-d H:i:s', $date );
 * 
 * MySQL -> PHP
 * $date = strtotime($date);
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Okt-2009
 */

//-- No direct access
defined('_JEXEC') or die('=;)');
?>

<?php
//holt das array
$arr = $this->verplanarray;

//debug
//echo "<pre>";
//print_r($arr);
//echo "</pre>";

//wandelt das assoziative array in json um
echo json_encode($arr);
?>
